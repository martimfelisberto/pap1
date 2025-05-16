<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('favorites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                  ->constrained()
                  ->onDelete('cascade');
            $table->foreignId('produto_id')
                  ->constrained()
                  ->onDelete('cascade');
            $table->timestamps();

            // Add unique constraint to prevent duplicate favorites
            $table->unique(['user_id', 'produto_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('favorites');
    }
};