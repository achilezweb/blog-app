<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Category1', 'description' => 'Description for Category1'],
            ['name' => 'Category2', 'description' => 'Description for Category2'],
            ['name' => 'Category3', 'description' => 'Description for Category3'],
            ['name' => 'Category4', 'description' => 'Description for Category4'],
            ['name' => 'Category5', 'description' => 'Description for Category5'],
            ['name' => 'Category6', 'description' => 'Description for Category6'],
            ['name' => 'Category7', 'description' => 'Description for Category7'],
            ['name' => 'Category8', 'description' => 'Description for Category8'],
            ['name' => 'Category9', 'description' => 'Description for Category9'],
            ['name' => 'Category10', 'description' => 'Description for Category10'],
            ['name' => 'Uncategorized', 'description' => 'Description for Uncategorized'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
