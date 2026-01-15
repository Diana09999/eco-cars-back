<?php

namespace Database\Seeders;

use App\Models\VehicleCategory;
use Illuminate\Database\Seeder;

class VehicleCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'economy', 'price_factor' => 1.0],
            ['name' => 'standard', 'price_factor' => 1.2],
            ['name' => 'business', 'price_factor' => 1.5],
            ['name' => 'premium', 'price_factor' => 2.0],
        ];

        foreach ($categories as $category) {
            VehicleCategory::firstOrCreate(
                ['name' => $category['name']],
                ['price_factor' => $category['price_factor']]
            );
        }

        $this->command->info('✅ Catégories créées');
    }
}
