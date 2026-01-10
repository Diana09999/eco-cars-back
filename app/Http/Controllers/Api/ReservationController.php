<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReservationRequest;
use App\Models\Car;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function store(StoreReservationRequest $request)
    {
        //si la voiture existe
        $car = Car::findOrFail($request->car_id);

        //verouille les reservations existantes de transfert
        return \DB::transaction(function () use ($request, $car) {
            $overlap = Reservation::where('car_id', $car->id)
                ->where(function ($query) use ($request) {
                    $query->where('start_date', '<', $request->end_date)
                        ->where('end_date', '>', $request->start_date);
                })
                ->lockForUpdate()
                ->exists();

            if ($overlap) {
                return response()->json(['message' =>
                    'La voiture est déja réserver pour cette date'
                ], 422);
            }

            //calcul les prix
            $start = new \DateTime($request->start_date);
            $end = new \DateTime($request->end_date);
            $days = $start->diff($end)->days;

            $totalPrice = $days * $car->price_per_day;

            $reservation = Reservation::create([
                'user_id' => $request->user()->id,
                'car_id' => $car->id,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'total_price' => $totalPrice,
                'status' => 'pending'
            ]);

            return response()->json($reservation, 201);
        });
    }
}
