<?php

namespace Database\Factories;

use App\Models\Tag;
use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TagPost>
 */
class TagPostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'post_id' => Post::factory(),
            'tag_id' => Tag::inRandomOrder()->first()->id,
        ];
    }
}
