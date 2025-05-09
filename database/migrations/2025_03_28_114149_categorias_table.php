<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('category_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('gender'); // homem, mulher, crianca
            $table->timestamps();
        });

        Schema::create('category_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_type_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('category_products');
        Schema::dropIfExists('category_types');
    }
};