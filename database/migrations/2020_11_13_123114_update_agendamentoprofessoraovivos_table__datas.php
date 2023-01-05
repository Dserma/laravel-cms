<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAgendamentoprofessoraovivosTableDatas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('agendaprofessoraovivos', function (Blueprint $table) {
            $table->date('data')->change();
            $table->time('inicio')->nullable();
            $table->time('fim')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('agendaprofessoraovivos', function (Blueprint $table) {
            $table->dropColumn('data');
            $table->dropColumn('inicio');
            $table->dropColumn('fim');
        });
    }
}
