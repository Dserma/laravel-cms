<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgendaprofessoraovivosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agendaprofessoraovivos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('professoraovivo_id')->constrained();
            $table->foreignId('aluno_id')->constrained();
            $table->foreignId('aulaaovivo_id')->constrained();
            $table->dateTime('data');
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
        Schema::dropIfExists('agendaprofessoraovivos');
    }
}
