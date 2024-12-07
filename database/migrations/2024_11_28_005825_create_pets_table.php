<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('pets', function (Blueprint $table) {
            $table->id(); // Chave primária
            $table->string('nome'); // Nome do pet
            $table->string('especie'); // Espécie do pet (ex.: cachorro, gato)
            $table->string('raca'); // Raca do pet (ex.: golden retriever, pitbull)
            $table->integer('idade')->nullable(); // Idade do pet (opcional)
            $table->unsignedBigInteger('user_id'); // Chave estrangeira para usuários
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // Define a relação
            $table->timestamps(); // created_at e updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pets');
    }
};
