<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['name' => 'user', 'description' => 'Description for user'],
            ['name' => 'admin', 'description' => 'Description for admin'],
            ['name' => 'superadmin', 'description' => 'Description for superadmin'],
        ];

        foreach ($roles as $role) {
            // Role::create($role); //no longer needed, seeded in the migration
        }
    }
}
