<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
       
   
        {
            Schema::create('favoritos', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->unsignedBigInteger('produto_id');
                $table->timestamps();
                
                $table->unique(['user_id', 'produto_id']);
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('produto_id')->references('id')->on('produtos')->onDelete('cascade');
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('favorites');
    }
};