<?php

use App\Models\User;
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
        Schema::create('chatgpts', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->restrictOnDelete(); //associated w/users
            $table->text('prompt');
            $table->text('response');
            $table->string('model')->nullable();
            $table->string('role')->nullable();
            $table->foreignId('channel_id')->constrained()->onDelete('cascade'); // Channel owner
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chatgpts');
    }
};
