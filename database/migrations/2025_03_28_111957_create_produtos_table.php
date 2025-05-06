<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            
            // Foreign key for the product owner
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
            // Basic product information
            $table->string('nome');
            $table->text('descricao');
            $table->decimal('preco', 8, 2);
            $table->string('marca');
            
            // Product categorization
            $table->unsignedBigInteger('categoria_id');
            $table->foreign('categoria_id')->references('id')->on('categorias');
            $table->unsignedBigInteger('genero_id')->nullable();
            $table->foreign('genero_id')->references('id')->on('generos');
            
            // Product details
            $table->string('estado');
            $table->string('tamanho')->nullable();
            $table->string('cores')->nullable();
            $table->json('imagem')->nullable(); // Store multiple image paths
            
            // Additional features
            $table->boolean('destaque')->default(false);
            $table->boolean('disponivel')->default(true);
            $table->integer('visualizacoes')->default(0);
        });
       
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        
        Schema::dropIfExists('produtos');
    }
};