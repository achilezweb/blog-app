<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Privacy;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'title' => $this->faker->sentence,
            'body' => $this->faker->paragraph,
            // 'category_id' => Category::inRandomOrder()->first()->id,
            // 'tag_id' => Tag::inRandomOrder()->first()->id,
            'privacy_id' => Privacy::inRandomOrder()->first()->id,
        ];
    }
}
