<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produto_favorites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('produto_id')->constrained('produtos')->onDelete('cascade');
            $table->timestamps();

            // Ensure a user can only favorite a product once
            $table->unique(['user_id', 'produto_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produto_favorites');
    }
};