<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transfer;
use Illuminate\Http\Request;

class TransferController extends Controller
{
    public function index()
    {
        return Transfer::orderBy('price')->get();
    }

    public function store(Request $request)
    {
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
