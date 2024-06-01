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
        Schema::create('privacies', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique()->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        //lets insert default categories in table
        DB::table('privacies')->insert([
            [
                'name' => 'Public',
                'description' => 'Public Description1',
                'created_at' => now(),
                'updated_at' => now(),
            ],[
                'name' => 'Friends',
                'description' => 'Friends Description2',
                'created_at' => now(),
                'updated_at' => now(),
            ],[
                'name' => 'Only Me',
                'description' => 'Only Me Description3',
                'created_at' => now(),
                'updated_at' => now(),
            ],[
                'name' => 'Custom',
                'description' => 'Custom Description4',
                'created_at' => now(),
                'updated_at' => now(),
            ],[
                'name' => 'Others',
                'description' => 'Others Description',
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
        Schema::dropIfExists('privacies');
    }
};
