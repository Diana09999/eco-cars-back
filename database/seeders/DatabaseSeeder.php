<?php

namespace Database\Seeders;

use App\Models\Transfer;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if (app()->environment('local')) {
            User::firstOrCreate(
                ['email' => 'test@example.com'],
                User::factory()->raw(['name' => 'Test User', 'email' => 'test@example.com'])
            );
        }

        $this->call([
            VehicleCategorySeeder::class,
            RealDataSeeder::class,
            TransferSeeder::class
        ]);
    }
}
