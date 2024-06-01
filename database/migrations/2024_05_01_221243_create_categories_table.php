<?php

use App\Models\Post;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique()->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        //lets insert default categories in table
        DB::table('categories')->insert([
            [
                'name' => 'Category1',
                'description' => 'Description1',
                'created_at' => now(),
                'updated_at' => now(),
            ],[
                'name' => 'Category2',
                'description' => 'Description2',
                'created_at' => now(),
                'updated_at' => now(),
            ],[
                'name' => 'Category3',
                'description' => 'Description3',
                'created_at' => now(),
                'updated_at' => now(),
            ],[
                'name' => 'Category4',
                'description' => 'Description4',
                'created_at' => now(),
                'updated_at' => now(),
            ],[
                'name' => 'UnCategorized',
                'description' => 'UnCategorized',
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
        Schema::dropIfExists('categories');
    }
};
