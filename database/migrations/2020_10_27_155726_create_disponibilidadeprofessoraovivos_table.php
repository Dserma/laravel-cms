<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDisponibilidadeprofessoraovivosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disponibilidadeprofessoraovivos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('professoraovivo_id')->constrained()->onDelete('cascade');
            $table->foreignId('aluno_id')->nullable()->constrained()->onDelete('cascade');
            $table->date('inicio');
            $table->date('fim')->nullable();
            $table->string('dias');
            $table->time('hora_inicio');
            $table->time('hora_fim');
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
        Schema::dropIfExists('disponibilidadeprofessoraovivos');
    }
}
