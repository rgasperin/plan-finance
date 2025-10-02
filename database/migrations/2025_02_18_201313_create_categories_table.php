<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Execute a migration para criar a tabela categories.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id(); // Chave primária
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relacionamento com a tabela de usuários
            $table->string('name'); // Nome da categoria
            $table->string('color')->nullable(); // Cor da categoria, pode ser null
            $table->timestamps(); // created_at e updated_at
            $table->softDeletes(); // deleted_at para soft deletes
        });
    }

    /**
     * Reverta a migration e remova a tabela categories.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
