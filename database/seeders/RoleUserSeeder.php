<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //RoleUser::factory()->count(10)->create();

        // Creating 10 users and assigning them to random roles
        User::factory()->count(10)->create()->each(function ($user) {
            $roles = Role::inRandomOrder()->first()->id;
            $user->roles()->attach($roles);
        });

    }
}
