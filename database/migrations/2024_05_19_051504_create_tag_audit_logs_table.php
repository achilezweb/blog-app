<?php

use App\Models\Tag;
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
        Schema::create('tag_audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Tag::class)->constrained()->cascadeOnDelete();

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
        Schema::dropIfExists('tag_audit_logs');
    }
};
