<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Transfer;
use Illuminate\Http\Request;

class PublicTransferController extends Controller
{
    public function index() {
        return response()->json(
            Transfer::orderBy('price', 'asc')->get()
        );
    }


    public function store(Request $request) {
        $data = $request->validate([
            'from_city' => 'required|string',
            'to_city' => 'required|string',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        return Transfer::create($data);
    }

    public function update(Request $request, Transfer $transfer)
    {
        $data = $request->validate([
            'from_city' => 'required|string',
            'to_city' => 'required|string',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        $transfer->update($data);

        return $transfer;
    }

    public function destroy(Transfer $transfer)
    {
        $transfer->delete();
        return response()->json(null, 204);
    }
}
