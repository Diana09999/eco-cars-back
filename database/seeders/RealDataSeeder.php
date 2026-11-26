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


        $adminPassword = config('app.admin_password');

        if (! $adminPassword && ! app()->environment('local')) {
            $this->command->error('❌ ADMIN_PASSWORD manquant : compte admin non créé');
            return;
        }

        $user = User::firstOrCreate(
            ['email' => config('app.admin_email')],
            [
                'name' => 'Admin Eco Cars',
                'password' => Hash::make($adminPassword ?: 'password123'),
                'email_verified_at' => now(),
            ]
        );
        $user->forceFill(['is_admin' => true])->save();

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
            $user->cars()->firstOrCreate(
                ['brand' => $carData['brand'], 'model' => $carData['model']],
                $carData
            );
        }

        $this->command->info('✅ ' . count($realCars) . ' voitures réelles ajoutées !');

    }

}
