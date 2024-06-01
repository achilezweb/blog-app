<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique()->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        //lets insert default categories in table
        DB::table('roles')->insert([
            [
                'name' => 'user',
                'description' => 'user Description1',
                'created_at' => now(),
                'updated_at' => now(),
            ],[
                'name' => 'admin',
                'description' => 'admin Description2',
                'created_at' => now(),
                'updated_at' => now(),
            ],[
                'name' => 'superadmin',
                'description' => 'superadmin Description3',
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
