<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('categorias', function (Blueprint $table) {
            $table->id();                     
            $table->string('titulo');         
            $table->string('slug');           
            $table->string('genero');         
            $table->foreignId('created_by')  
                  ->constrained('users')
                  ->onDelete('cascade');
            $table->timestamps();            

            // Add indexes for better performance
            $table->index('genero');
            $table->unique('slug');           
        });
    }

    public function down()
    {
        Schema::dropIfExists('categorias');
    }
};