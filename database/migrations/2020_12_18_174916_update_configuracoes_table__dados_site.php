<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateConfiguracoesTableDadosSite extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('configuracoes', function (Blueprint $table) {
            $table->string('titulo_ligue')->nullable();
            $table->string('ligue')->nullable();
            $table->string('titulo_email')->nullable();
            $table->string('email')->nullable();
            $table->string('titulo_whatsapp')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('titulo_endereco')->nullable();
            $table->string('endereco')->nullable();
            $table->text('chegar')->nullable();
            $table->longText('email_cadastro')->nullable();
            $table->longText('email_pagamento_ok')->nullable();
            $table->longText('email_pagamento_erro')->nullable();
            $table->longText('email_resposta_pergunta')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('configuracoes', function (Blueprint $table) {
            //
        });
    }
}
