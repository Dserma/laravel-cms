<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateConfiguracoesTableEmails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('configuracoes', function (Blueprint $table) {
            $table->longText('email_assinatura')->nullable();
            $table->longText('email_alteracao_plano')->nullable();
            $table->longText('email_suspende_plano')->nullable();
            $table->longText('email_alteracao_senha')->nullable();
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
            $table->dropColumn('email_assinatura');
            $table->dropColumn('email_alteracao_plano');
            $table->dropColumn('email_suspende_plano');
            $table->dropColumn('email_alteracao_senha');
        });
    }
}
