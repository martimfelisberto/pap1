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
            $table->unsignedBigInteger('user_id'); // Relaciona com o usuário
            $table->unsignedBigInteger('produto_id'); // Relaciona com o produto
            $table->timestamps();
    
            // Chaves estrangeiras
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('produto_id')->references('id')->on('produtos')->onDelete('cascade');
    
            // Evitar duplicados
            $table->unique(['user_id', 'produto_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('favorites');
    }
};