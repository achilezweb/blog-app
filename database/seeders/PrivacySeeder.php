<?php

namespace Database\Seeders;

use App\Models\Privacy;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PrivacySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $privacies = [
            'Public',
            'Friends',
            'Only Me',
            'Custom',
            'Others',
        ];

        foreach ($privacies as $privacy) {
            Privacy::create(['name' => $privacy]);
        }
    }
}
