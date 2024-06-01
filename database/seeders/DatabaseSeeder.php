<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Role;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Call the RoleSeeder
        $this->call(RoleSeeder::class);

        $user = User::factory()->create([
            'name' => 'Test Superadmin',
            'email' => 'superadmin@example.com',
        ]);
        $roles = Role::where('name', 'superadmin')->first()->id;
        $user->roles()->attach($roles);

        $user = User::factory()->create([
            'name' => 'Test Adminsuper',
            'email' => 'adminsuper@example.com',
        ]);
        $rolesSuper = Role::where('name', 'superadmin')->first()->id;
        $rolesAdmin = Role::where('name', 'admin')->first()->id;
        $user->roles()->syncWithoutDetaching([$rolesSuper, $rolesAdmin]);

        $user = User::factory()->create([
            'name' => 'Test Admin',
            'email' => 'admin@example.com',
        ]);
        $roles = Role::where('name', 'admin')->first()->id;
        $user->roles()->attach($roles);

        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'user@example.com',
        ]);
        $roles = Role::where('name', 'user')->first()->id;
        $user->roles()->attach($roles);

        //refactor using this
        // $this->call([
        //     CategorySeeder::class,

        // ]);

        // Call the CategorySeeder
        $this->call(CategorySeeder::class);

        // Call the TagSeeder
        $this->call(TagSeeder::class);

        // Call the PrivacySeeder
        $this->call(PrivacySeeder::class);

        // Call the RoleUserSeeder
        $this->call(RoleUserSeeder::class);

        // Call the CategoryPostSeeder
        // $this->call(CategoryPostSeeder::class);

        // Call the TagPostSeeder
        // $this->call(TagPostSeeder::class);

        //add post
        // Post::factory(10)->has(Comment::factory(15))->for($user)->create(); //create 10 post, 150 comments, 150users
        // Post::factory(10)->has(Comment::factory(15))->has(Tag::factory(3))->for($user)->create(); //create 10 post, 150 comments, 30 tags, 150users
        // Post::factory(10)->has(Comment::factory(15))->has(Category::factory(1))->has(Tag::factory(3))->for($user)->create(); //create 10 post, 150 comments, 10 categories, 30 tags, 150users
        Post::factory(30)->has(Comment::factory(15))->for($user)->create(); //create 30 post, 450 comments, 10 categories, 5 tags, 5 privacy, 451 users



    }
}
