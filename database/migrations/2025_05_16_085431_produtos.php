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
             
             // Colunas de informações básicas do produto
             $table->string('nome');                // Nome do produto
             $table->text('descricao');             // Descrição do produto
             $table->string('marca');               // Marca do produto
             $table->decimal('preco', 8, 2);        // Preço do produto
             $table->string('tamanho');             // Tamanho do produto
             $table->string('tamanhosapatilhas');   // Convertido para string para flexibilidade
             $table->integer('quantidade')->default(1); // Quantidade do produto
             $table->string('tipo_produto');        // Tipo de produto (ex: Sapatilhas, Roupas)
             $table->string('tipo_sola')->nullable(); // Tipo de sola (opcional)


             // Adicionar genero como string em vez de ID
             $table->string('genero');           

             // Colunas padrão para timestamps
             $table->timestamps();              // Cria as colunas created_at e updated_at
 
             // Chaves estrangeiras
             $table->foreignId('user_id')
                   ->constrained()
                   ->onDelete('cascade');
             
             $table->foreignId('categoria_id')
                   ->constrained()
                   ->onDelete('cascade');
             
             // Outras colunas
             $table->enum('estado', ['novo', 'semi-novo', 'usado']);
             $table->json('cores');                // 'cores' será um JSON
             $table->string('imagem')->nullable();
             $table->text('medidas')->nullable();
 
             // Índices para melhor performance
             $table->index('estado');
             $table->index('genero');              // Agora o índice é válido
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