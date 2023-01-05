<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAgendamentoaovivosTableValores extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('agendamentoaovivos', function (Blueprint $table) {
            $table->foreignId('pacoteaulaaovivo_id')->nullable()->constrained();
            $table->double('valor_aula', 12, 2);
            $table->double('valor_professor', 12, 2);
            $table->unsignedInteger('status_pagamento')->default(0);
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
            $table->dropColumn('pacoteaulaaovivo_id');
            $table->dropColumn('valor_aula');
            $table->dropColumn('valor_professor');
            $table->dropColumn('status_pagamento');
        });
    }
}
