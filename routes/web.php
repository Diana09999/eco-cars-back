<?php

use Illuminate\Support\Facades\Route;

Route::get('/seed-database/{token}', function ($token) {
    $secretToken = env('SEED_TOKEN', 'password123');

    if ($token !== $secretToken) {
        return response()->json(['error' => 'Unauthorized'], 403);
    }

    \Artisan::call('db:seed');

    return response()->json([
        'status' => 'success',
        'message' => 'Database seeded!',
        'output' => \Artisan::output()
    ]);
});
