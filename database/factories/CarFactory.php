<?php

namespace Database\Factories;

use App\Models\Car;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Car>
 */
class CarFactory extends Factory
{
    protected $model = Car::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $brands = [
            'Toyota' => ['Corolla', 'Camry', 'RAV4', 'Prius'],
            'Honda' => ['Civic', 'Accord', 'CR-V', 'HR-V'],
            'Tesla' => ['Model 3', 'Model S', 'Model X', 'Model Y'],
            'BMW' => ['i3', 'i4', 'iX', 'i7'],
            'Renault' => ['Zoe', 'Megane E-Tech', 'Twingo E-Tech'],
            'Nissan' => ['Leaf', 'Ariya'],
            'Hyundai' => ['Ioniq 5', 'Kona Electric'],
            'Volkswagen' => ['ID.3', 'ID.4', 'ID.5'],
        ];

        $brand = $this->faker->randomElement(array_keys($brands));
        $model = $this->faker->randomElement($brands[$brand]);

        return [
            'brand' => $brand,
            'model' => $model,
            'year' => $this->faker->numberBetween(2020, 2025),
            'price_per_day' => $this->faker->randomFloat(2, 50, 200),
            'description' => $this->faker->sentence(10),
            'image' => strtolower($brand) . '_' . strtolower(str_replace(' ', '_', $model)) . '.jpg',
            'available' => $this->faker->boolean(80), //80% de chance d'être disponible
        ];
    }
}
