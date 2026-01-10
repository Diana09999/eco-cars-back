<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\VehicleCategory;
use Illuminate\Http\Request;

class PublicVehicleController extends Controller
{
    public function index(Request $request)
    {
        //liste simple des véhicules (site vitrine)
        $query = Car::with('category');

        if ($request->has('max_price')) {
            $query->where('price_per_day', '<=', $request->max_price);
        }

        return response()->json($query->get());
    }

    public function show(Car $car) {
        //détail d'un véhicule
        $car->load('category');

        return response()->json($car);
    }

    //catégories + leurs véhicules
    public function catalog() {
        try {
        $categories = VehicleCategory::with([
            'cars' => function ($query) {
                $query->orderBy('price_per_day', 'asc');
            }
        ])
            ->has('cars') //seulement les catégories qui ont des voitures
            ->get()
            ->map(function ($category) {
                //calcule le prix minimum pour chaque catégorie
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'price_factor' => $category->price_factor,
                    'min_price' => $category->cars->min('price_per_day'),
                    'max_price' => $category->cars->max('price_per_day'),
                    'car_count' => $category->cars->count(),
                    'cars' => $category->cars,
                ];
            });
        return response()->json($categories);

    } catch (\Exception $e) {
       return response()->json([
           'error' => 'Erreur lors de la récupération du catalogue',
           'message' => $e->getMessage()
       ], 500);
        }
    }
}
