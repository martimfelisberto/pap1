<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('produtos', function (Blueprint $table) {
            $table->json('produtos')->change(); // Transformando a coluna em JSON
        });

        Schema::create('categorias', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('slug')->unique();
            $table->enum('genero', ['homem', 'mulher', 'crianca']);
            $table->text('descricao')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::table('produtos', function (Blueprint $table) {
            $table->string('produtos')->change(); // Voltando para string caso precise desfazer
        });

        Schema::dropIfExists('categorias');
    }

};
