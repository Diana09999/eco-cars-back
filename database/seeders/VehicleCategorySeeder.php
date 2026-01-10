<?php

namespace Database\Seeders;


use App\Models\User;
use App\Models\VehicleCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class VehicleCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        VehicleCategory::insert([
            ['name' => 'economy', 'price_factor' => 1.0],
            ['name' => 'standard', 'price_factor' => 1.2],
            ['name' => 'business', 'price_factor' => 1.5],
            ['name' => 'premium', 'price_factor' => 2.0],
        ]);

       $categories = [
           ['name' => 'economy', 'price_factor' => 1.0],
           ['name' => 'standard', 'price_factor' => 1.2],
           ['name' => 'business', 'price_factor' => 1.5],
           ['name' => 'premium',  'price_factor' => 2.0],
       ];

       foreach ($categories as $category) {
           VehicleCategory::firstOrCreate(
               ['name' => $category['name']],
               ['price_factor' => $category['price_factor']]
           );
       }
    }
}
