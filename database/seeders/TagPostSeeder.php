<?php

namespace Database\Seeders;

use App\Models\TagPost;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TagPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TagPost::factory()->count(10)->create();
    }
}
