<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpentMoneyTable extends Migration
{
    /**
     * Execute a migration para criar a tabela spent_money.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spent_money', function (Blueprint $table) {
            $table->id(); // Chave primária
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('available_money_id')->constrained('available_money')->onDelete('cascade');
            $table->foreignId('categories_id')->constrained()->onDelete('cascade'); // Relacionamento com a tabela de categories
            $table->foreignId('payments_id')->constrained()->onDelete('cascade'); // Relacionamento com a tabela de payments
            $table->string('name'); // Nome do gasto
            $table->text('description')->nullable(); // Descrição do gasto
            $table->double('value', 15, 2); // Valor do gasto
            $table->boolean('payable'); // Indica se é um valor a pagar
            $table->date('date'); // Data do gasto
            $table->timestamps(); // created_at e updated_at
            $table->softDeletes(); // deleted_at para soft deletes
        });
    }

    /**
     * Reverta a migration e remova a tabela spent_money.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('spent_money');
    }
}
