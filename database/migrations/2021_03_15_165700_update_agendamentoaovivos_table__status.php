<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAgendamentoaovivosTableStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('agendamentoaovivos', function (Blueprint $table) {
            $table->foreignId('professoraovivo_id')->after('aluno_id')->nullable()->constrained()->onDelete('cascade');
            $table->json('meeting')->nullable();
            $table->unsignedInteger('status')->default(0)->comment('0 - Em aberto | 1 - Iniciada | 2 - Encerrada | 3 - Executada | 4 - Não Executada');
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
            $table->dropColumn('professoraovivo_id');
            $table->dropColumn('meeting');
            $table->dropColumn('status');
        });
    }
}
