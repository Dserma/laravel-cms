<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAvaliacaoaovivosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('avaliacaoaovivos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agendamentoaovivo_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('aluno_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('professoraovivo_id')->nullable()->constrained()->onDelete('set null');
            $table->unsignedInteger('ocorreu')->default(0);
            $table->double('rate_professor', 12, 2)->nullable();
            $table->double('rate_aluno', 12, 2)->nullable();
            $table->longText('comentario_aluno')->nullable();
            $table->longText('comentario_professor')->nullable();
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
        Schema::dropIfExists('avaliacaoaovivos');
    }
}
