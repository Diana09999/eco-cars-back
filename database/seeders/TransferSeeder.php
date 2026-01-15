<?php

namespace Database\Seeders;

use App\Models\Transfer;
use Illuminate\Database\Seeder;

class TransferSeeder extends Seeder
{
    public function run(): void
    {
        $transfers = [
            [
                'from_city' => 'Aéroport de Lyon-Saint-Exupéry',
                'to_city' => 'Courchevel',
                'price' => 175,
                'description' => 'Transfert privé avec chauffeur',
            ],
            [
                'from_city' => 'Aéroport de Nice',
                'to_city' => 'Cannes',
                'price' => 80,
                'description' => 'Transfert privé avec chauffeur',
            ],
            [
                'from_city' => 'Aéroport de Genève',
                'to_city' => 'Courchevel',
                'price' => 290,
                'description' => 'Transfert montagne premium',
            ],
            [
                'from_city' => 'Rome',
                'to_city' => 'Florence',
                'price' => 440,
                'description' => 'Transfert longue distance',
            ],
        ];

        foreach ($transfers as $transfer) {
            Transfer::firstOrCreate(
                ['from_city' => $transfer['from_city'], 'to_city' => $transfer['to_city']],
                $transfer
            );
        }

        $this->command->info('✅ Transfers créés');
    }
}
