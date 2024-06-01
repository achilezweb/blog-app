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
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique()->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        //lets insert default tags in table
        DB::table('tags')->insert([
            [
                'name' => 'Tag1',
                'created_at' => now(),
                'updated_at' => now(),
            ],[
                'name' => 'Tag2',
                'created_at' => now(),
                'updated_at' => now(),
            ],[
                'name' => 'Tag3',
                'created_at' => now(),
                'updated_at' => now(),
            ],[
                'name' => 'UnTagged',
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
        Schema::dropIfExists('tags');
    }
};
