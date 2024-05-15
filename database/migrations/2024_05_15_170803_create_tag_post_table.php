<?php

use App\Models\Tag;
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
        Schema::create('tag_post', function (Blueprint $table) {
            $table->foreignIdFor(Tag::class)->constrained()->cascadeOnDelete(); //associated w/ tag_id
            $table->foreignIdFor(Post::class)->constrained()->cascadeOnDelete(); //associated w/ post_id
            $table->primary(['tag_id', 'post_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tag_post');
    }
};
