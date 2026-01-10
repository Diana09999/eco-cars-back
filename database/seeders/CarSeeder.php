<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\User;
use App\Models\VehicleCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CarSeeder extends Seeder
{
    public function run(): void
    {
        //recupere les catégories (elles existent déjà grâce à VehicleCategorySeeder)
        $economyCategory = VehicleCategory::where('name', 'economy')->first();
        $standardCategory = VehicleCategory::where('name', 'standard')->first();
        $premiumCategory = VehicleCategory::where('name', 'premium')->first();

        if (!$economyCategory || !$standardCategory || !$premiumCategory) {
            $this->command->error('❌ Catégories manquantes. Lance VehicleCategorySeeder.');
            return;
        }

        //pour le user de test
        $TestUser = User::firstOrCreate(
            ['email' => 'diana@example.com'],
            [
                'name' => 'Diana',
                'password' => Hash::make('Diana123'),
                'email_verified_at' => now(),
            ]
        );

        //créer 4 autres users aléatoires
        $randomUsers = User::factory()->count(4)->create();

        //créer les voitures pour le user de test
        $TestUser->cars()->createMany([
            [
                'brand' => 'Toyota',
                'model' => 'Camry',
                'year' => 2025,
                'price_per_day' => 120.00,
                'description' => 'Voiture avec 5 places',
                'image' => 'toyota.jpg',
                'available' => true,
                'category_id' => $standardCategory->id,
            ],
            [
                'brand' => 'BMW',
                'model' => 'i3',
                'year' => 2022,
                'price_per_day' => 90.00,
                'description' => 'Compacte électrique urbaine.',
                'image' => 'bmw_i3.jpg',
                'available' => true,
                'category_id' => $economyCategory->id,
            ],
            [
                'brand' => 'Tesla',
                'model' => 'Model 3',
                'year' => 2023,
                'price_per_day' => 120.00,
                'description' => 'Voiture électrique premium avec autopilot.',
                'image' => 'tesla_model_3.jpg',
                'available' => true,
                'category_id' => $premiumCategory->id,
            ],
        ]);

        // Les autres users ont des voitures aléatoires
        $randomUsers->skip(1)->each(function ($user) use ($economyCategory) {
            // factory utilise aussi une category_id valide
            $user->cars()->createMany(
                Car::factory()
                    ->count(3)
                    ->make(['category_id' => $economyCategory->id])
                    ->toArray()
            );
        });
    }
}
