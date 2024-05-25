<?php


use App\Models\User;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Privacy;
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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->restrictOnDelete(); //associated w/users
            $table->string('title')->nullable();
            $table->longText('body')->nullable();
            $table->string('slug')->unique()->nullable();
            $table->boolean('active')->default(true);
            $table->boolean('archive')->default(false);
            $table->unsignedBigInteger('page_views')->default(0);
            $table->foreignIdFor(Privacy::class)->constrained()->cascadeOnDelete();
            $table->string('qrcodes')->nullable();
            $table->string('barcode')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
