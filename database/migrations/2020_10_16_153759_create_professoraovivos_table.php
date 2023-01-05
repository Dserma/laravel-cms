<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfessoraovivosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('professoraovivos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('sobrenome');
            $table->string('telefone')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('email');
            $table->string('senha');
            $table->string('confirmation_token')->nullable();
            $table->string('remember_token');
            $table->string('timezone')->nullable();
            $table->string('cep')->nullable();
            $table->string('logradouro')->nullable();
            $table->string('numero')->nullable();
            $table->string('complemento')->nullable();
            $table->string('bairro')->nullable();
            $table->foreignId('state_id')->nullable()->constrained();
            $table->foreignId('city_id')->nullable()->constrained();
            $table->string('imagem')->nullable();
            $table->string('video')->nullable();
            $table->longText('destaque')->nullable();
            $table->longText('sobre')->nullable();
            $table->longText('metodo')->nullable();
            $table->longText('credenciais')->nullable();
            $table->unsignedInteger('sobre_alunos')->nullable();
            $table->string('slug');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('professoraovivos');
    }
}
