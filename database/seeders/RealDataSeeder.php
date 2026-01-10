<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\VehicleCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RealDataSeeder extends Seeder
{
    public function run() {

        $categories = [
            'economy' => VehicleCategory::where('name', 'economy')->first(),
            'standard' => VehicleCategory::where('name', 'standard')->first(),
            'business' => VehicleCategory::where('name', 'business')->first(),
            'premium' => VehicleCategory::where('name', 'premium')->first(),
        ];

        if (
            !$categories['economy'] ||
            !$categories['standard'] ||
            !$categories['business'] ||
            !$categories['premium']
        ) {
            $this->command->error('❌ Catégories manquantes');
            return;
        }


        $user = User::firstOrCreate(
            ['email' => 'admin@ecocars.fr'],
            [
                'name' => 'Admin Eco Cars',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]
        );

        $realCars = [
            [
                'brand' => 'Hyundai',
                'model' => 'Ioniq',
                'year' => 2023,
                'price_per_day' => 320.00,
                'description' => 'Voiture Hybride',
                'image' => 'https://www.automobile-propre.com/wp-content/uploads/2022/06/pour-2019-la-familiale-electrique-de-hyundai-gagne-un-petit-restylage-photo-hyundai-1573749616-1200x675.jpeg',
                'available' => true,
                'category_id' => $categories['premium']->id,
            ],
            [
                'brand' => 'BMW',
                'model' => 'Model 3',
                'year' => 2019,
                'price_per_day' => 420.00,
                'description' => 'Confort avec 5 places',
                'image' => 'https://www.largus.fr/images/images/2019-bmw-x5-hyrbide-45e-iperformance-blanc-10.jpg',
                'available' => true,
                'category_id' => $categories['premium']->id,
            ],
            [
                'brand' => 'Audi',
                'model' => 'e-tron GT',
                'year' => 2024,
                'price_per_day' => 200.00,
                'description' => 'GT électrique de luxe avec performances exceptionnelles. Autonomie de 488 km.',
                'image' => 'https://images.unsplash.com/photo-1606664515524-ed2f786a0bd6?w=800',
                'available' => true,
                'category_id' => $categories['premium']->id,
            ],
        ];

        foreach ($realCars as $carData) {
            $user->cars()->create($carData);
        }

        $this->command->info('✅ ' . count($realCars) . ' voitures réelles ajoutées !');

    }

}
