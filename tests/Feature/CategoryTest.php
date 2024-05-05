<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Database\Seeders\CategorySeeder;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_seeds_categories_correctly()
    {
        // Run the CategorySeeder
        $this->seed(CategorySeeder::class);

        // Check if all categories are in the database
        $categories = Category::all();
        $this->assertCount(10, $categories); // 10 categories in the seeder

        // Check if each category name matches the expected name
        $expectedCategories = [
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

        foreach ($expectedCategories as $index => $expectedCategory) {
            $this->assertEquals($expectedCategory, $categories[$index]->name);
        }
    }
}
