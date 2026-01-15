<?php

namespace Database\Seeders;

use App\Models\Car; // ou Vehicle selon ton modèle
use App\Models\User;
use App\Models\VehicleCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RealDataSeeder extends Seeder
{
    public function run()
    {
        $categories = [
            'premium' => VehicleCategory::where('name', 'premium')->first(),
        ];

        if (!$categories['premium']) {
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
                'price_per_day' => 320,
                'description' => 'Voiture Hybride',
                'image' => 'https://www.automobile-propre.com/wp-content/uploads/2022/06/pour-2019-la-familiale-electrique-de-hyundai-gagne-un-petit-restylage-photo-hyundai-1573749616-1200x675.jpeg',
                'available' => true,
                'category_id' => $categories['premium']->id,
                'user_id' => $user->id,
            ],
            [
                'brand' => 'BMW',
                'model' => 'X5 Hybride',
                'year' => 2019,
                'price_per_day' => 420,
                'description' => 'Confort avec 5 places',
                'image' => 'https://www.largus.fr/images/images/2019-bmw-x5-hyrbide-45e-iperformance-blanc-10.jpg',
                'available' => true,
                'category_id' => $categories['premium']->id,
                'user_id' => $user->id,
            ],
            [
                'brand' => 'Audi',
                'model' => 'e-tron GT',
                'year' => 2024,
                'price_per_day' => 200,
                'description' => 'GT électrique de luxe',
                'image' => 'https://images.unsplash.com/photo-1606664515524-ed2f786a0bd6?w=800',
                'available' => true,
                'category_id' => $categories['premium']->id,
                'user_id' => $user->id,
            ],
        ];

        foreach ($realCars as $carData) {
            // Utilise directement le modèle Car
            Car::updateOrCreate(
                ['model' => $carData['model'], 'brand' => $carData['brand']],
                $carData
            );
        }

        $this->command->info('✅ ' . count($realCars) . ' voitures ajoutées !');
    }
}
