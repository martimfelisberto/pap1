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
            $table->timestamps();
            $table->string('nome');
            $table->string('descricao')->nullable();
            $table->string('slug')->unique();
            $table->boolean('ativo')->default(true);
            $table->integer('ordem')->default(0);
            $table->string('icone')->nullable();
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
