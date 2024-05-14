<?php

use App\Models\Category;
use App\Models\User;
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
        Schema::create('category_audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Category::class)->constrained()->cascadeOnDelete();
            // $table->foreignId('category_id')->references('id')->on('categories')->onDelete('cascade');

            $table->foreignId('updated_by')->constrained('users')->onDelete('cascade');
            // $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');

            $table->string('action', 50); // e.g., 'updated', 'created'
            $table->text('changes'); // JSON format or text describing the changes
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_audit_logs');
    }
};
