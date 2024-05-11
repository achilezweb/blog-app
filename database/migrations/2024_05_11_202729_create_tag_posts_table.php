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
        Schema::create('tag_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Post::class)->constrained()->restrictOnDelete(); //associated w/ post_id
            $table->foreignIdFor(Tag::class)->constrained()->restrictOnDelete(); //associated w/ tag_id
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tag_posts');
    }
};
