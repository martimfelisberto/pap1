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
        Schema::dropIfExists('checkouts'); // Exclui a tabela antiga, se existir

        Schema::create('checkouts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('produto_id'); // Relaciona com o produto
            $table->unsignedBigInteger('user_id');    // Relaciona com o utilizador
            $table->string('nome_completo');         // Nome completo do cliente
            $table->string('morada');               // Morada do cliente
            $table->string('localidade');           // Localidade
            $table->string('cidade');               // Cidade
            $table->string('codigo_postal');        // Código postal
            $table->string('telefone');            // Número de telefone
            $table->string('pais');                // País/Região
            $table->string('email')->nullable();   // Email de contacto
            $table->string('metodo_pagamento');    // Método de pagamento
            $table->decimal('preco', 8, 2);        // Preço do produto
            $table->timestamps();

            // Chave estrangeira para o produto
            $table->foreign('produto_id')->references('id')->on('produtos')->onDelete('cascade');
            // Chave estrangeira para o utilizador
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checkouts');
        
    }
};