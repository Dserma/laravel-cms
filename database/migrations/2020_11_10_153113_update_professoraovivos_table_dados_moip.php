<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateProfessoraovivosTableDadosMoip extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('professoraovivos', function (Blueprint $table) {
            $table->string('cpf')->nullable();
            $table->date('nascimento')->nullable();
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
            $table->dropColumn('cpf');
            $table->dropColumn('nascimento');
        });
    }
}
