<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAvailableMoneyTable extends Migration
{
    /**
     * Execute a migration para criar a tabela available_money.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('available_money', function (Blueprint $table) {
            $table->id(); // Chave primária
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relacionamento com a tabela de usuários
            $table->string('name'); // Nome do dinheiro disponível
            $table->double('to_spend', 15, 2); // Valor disponível para gastar
            $table->date('date'); // Data de referência
            $table->timestamps(); // created_at e updated_at
            $table->softDeletes(); // deleted_at para soft deletes
        });
    }

    /**
     * Reverta a migration e remova a tabela available_money.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('available_money');
    }
}
