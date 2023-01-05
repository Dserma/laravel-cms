<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAgendamentoaovivosTableDataLiberacao extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('agendamentoaovivos', function (Blueprint $table) {
            $table->date('liberacao_aluno')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('agendamentoaovivos', function (Blueprint $table) {
            $table->dropColumn('liberacao_aluno');
        });
    }
}
