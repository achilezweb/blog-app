<?php

use App\Models\Role;
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
        //recommended to use role_user instead of role_users
        Schema::create('role_user', function (Blueprint $table) {
            $table->foreignIdFor(Role::class)->constrained()->restrictOnDelete(); //associated w/ role_id
            $table->foreignIdFor(User::class)->constrained()->restrictOnDelete(); //associated w/ user_id
            $table->primary(['role_id', 'user_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_user');
    }
};
