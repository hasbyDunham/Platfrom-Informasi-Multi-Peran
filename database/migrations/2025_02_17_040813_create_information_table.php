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
        Schema::create('information', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->text('content');
            $table->foreignId('category_id')->constrained(); // Relasi ke tabel categories
            $table->foreignId('user_id')->constrained(); // Relasi ke tabel users
            $table->string('image', 255)->nullable();
            $table->enum('approval_status', ['pending', 'approved', 'rejected'])->default('pending'); // Status approval

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('information');
    }
};
