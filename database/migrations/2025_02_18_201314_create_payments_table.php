<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Execute a migration para criar a tabela payments.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id(); // Chave primária
            $table->string('name'); // Nome do pagamento
            $table->timestamps(); // created_at e updated_at
            $table->softDeletes(); // deleted_at para soft deletes
        });
    }

    /**
     * Reverta a migration e remova a tabela payments.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
