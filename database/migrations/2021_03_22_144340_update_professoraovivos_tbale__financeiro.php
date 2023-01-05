<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateProfessoraovivosTbaleFinanceiro extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('professoraovivos', function (Blueprint $table) {
            $table->unsignedInteger('tipo_conta')->nullable();
            $table->float('banco')->nullable();
            $table->float('agencia')->nullable();
            $table->float('agencia_digito')->nullable();
            $table->float('conta')->nullable();
            $table->float('digito')->nullable();
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
            $table->dropColumn('tipo_conta');
            $table->dropColumn('banco');
            $table->dropColumn('agencia');
            $table->dropColumn('agencia_digito');
            $table->dropColumn('conta');
            $table->dropColumn('digito');
        });
    }
}
