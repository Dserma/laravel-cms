<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateProfessoraovivosTableDadosTemporarios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('professoraovivos', function (Blueprint $table) {
            $table->unsignedInteger('alterou_conta')->default(0);
            $table->string('token_alteracao')->nullable();
            $table->unsignedInteger('tipo_conta_tmp')->nullable();
            $table->unsignedBigInteger('banco_tmp')->nullable();
            $table->unsignedBigInteger('agencia_tmp')->nullable();
            $table->unsignedBigInteger('agencia_digito_tmp')->nullable();
            $table->unsignedBigInteger('conta_tmp')->nullable();
            $table->unsignedBigInteger('digito_tmp')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('professoraovivos', function (Blueprint $table) {
            $table->dropColumn('alterou_conta');
            $table->dropColumn('token_alteracao');
            $table->dropColumn('tipo_conta_tmp');
            $table->dropColumn('banco_tmp');
            $table->dropColumn('agencia_tmp');
            $table->dropColumn('agencia_digito_tmp');
            $table->dropColumn('conta_tmp');
            $table->dropColumn('digito_tmp');
        });
    }
}
