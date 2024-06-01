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
            ['name' => 'Public', 'description' => 'Description for Public'],
            ['name' => 'Friends', 'description' => 'Description for Friends'],
            ['name' => 'Only Me', 'description' => 'Description for Only Me'],
            ['name' => 'Custom', 'description' => 'Description for Custom'],
            ['name' => 'Others', 'description' => 'Description for Others'],
        ];

        foreach ($privacies as $privacy) {
            //Privacy::create($privacy); //no longer needed, seeded in the migration
        }
    }
}
