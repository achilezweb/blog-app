<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            'tag1',
            'tag2',
            'tag3',
            'tag4',
            'UnTagged',
        ];

        foreach ($tags as $tag) {
            //Tag::create(['name' => $tag]); //no longer needed, seeded in the migration
        }
    }
}
