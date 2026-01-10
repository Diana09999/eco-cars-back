<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCarRequest;
use App\Http\Requests\UpdateCarRequest;
use App\Models\Car;
use Illuminate\Http\Request;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //avoir les voitures les plus récentes en premier
        //chaques utilisateurs ne voit que ses propres voitures
        return auth()->user()->cars()->latest()->get();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    //renvoi que les voitures du user
    public function store(StoreCarRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('cars', 'public');

            $data['image'] = asset('storage/' . $imagePath);
        }

        $car = $request->user()->cars()->create($data);

        return response()->json($car, 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(Request $request,Car $car)
    {
        //si user connecté n'est pas propriétaire de la voiture (id spécifique) -> 403 forbidden
        if ($request->user()->id !== $car->user_id) {
            return response()->json(['message' => 'Not authorized'], 403);
        }
        return response()->json($car);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Car $car)
    {
     //
    }

    /**
     * Update the specified resource in storage.
     */
    //si user connecté n'est pas propriétaire de la voiture (id spécifique) -> 403 forbidden
    public function update(UpdateCarRequest $request, Car $car)
    {
        if ($request->user()->id !== $car->user_id) {
            return response()->json(['message' => 'Not authorized'], 403);
        }

        $data = $request->validated();

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('cars', 'public');
            $data['image'] = asset('storage/' . $imagePath);
        }

        $car->update($data);

        return response()->json($car);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request,Car $car)
    {
        if ($request->user()->id !== $car->user_id) {
            return response()->json(['message' => 'Not authorized'], 403);
        }

        $car->delete();
        return response()->json(null, 204);
    }
}
