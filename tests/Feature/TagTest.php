<?php

namespace Tests\Feature;

use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Database\Seeders\TagSeeder;

class TagTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_seeds_tags_correctly()
    {
        // Run the CategorySeeder
        $this->seed(TagSeeder::class);

        // Check if all categories are in the database
        $tags = Tag::all();
        $this->assertCount(5, $tags); // 10 categories in the seeder

        // Check if each category name matches the expected name
        $expectedTags = [
            'Tags 1',
            'Tags 2',
            'Tags 3',
            'Tags 4',
            'UnTagged',
        ];

        foreach ($expectedTags as $index => $expectedTag) {
            $this->assertEquals($expectedTag, $tags[$index]->name);
        }
    }
}

