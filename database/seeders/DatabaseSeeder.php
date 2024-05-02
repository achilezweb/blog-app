<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Tag;
use App\Models\Category;
use App\Models\Privacy;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        //create CategorySeeder
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

        //create TagSeeder
        $tags = [
            'Tags 1',
            'Tags 2',
            'Tags 3',
            'Tags 4',
            'UnTagged',
        ];

        foreach ($tags as $tag) {
            Tag::create(['name' => $tag]);
        }

        //create PrivacySeeder
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

        //add post
        // Post::factory(10)->has(Comment::factory(15))->for($user)->create(); //create 10 post, 150 comments, 150users
        // Post::factory(10)->has(Comment::factory(15))->has(Tag::factory(3))->for($user)->create(); //create 10 post, 150 comments, 30 tags, 150users
        // Post::factory(10)->has(Comment::factory(15))->has(Category::factory(1))->has(Tag::factory(3))->for($user)->create(); //create 10 post, 150 comments, 10 categories, 30 tags, 150users
        Post::factory(10)->has(Comment::factory(15))->for($user)->create(); //create 10 post, 150 comments, 0 categories, 0 tags, 0 privacy, 150users



    }
}
