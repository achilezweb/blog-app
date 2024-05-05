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
            'Category 1',
            'Category 2',
            'Category 3',
            'Category 4',
            'Category 5',
            'Category 6',
            'Category 7',
            'Category 8',
            'Category 9',
            'UnCategorized',
        ];

        foreach ($categories as $category) {
            Category::create(['name' => $category]);
        }
    }
}
