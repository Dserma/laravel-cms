<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHomesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('homes', function (Blueprint $table) {
            $table->id();
            $table->text('titulo_cursos')->nullable();
            $table->text('subtitulo_cursos')->nullable();
            $table->text('box_professores_cursos')->nullable();
            $table->text('titulo_depoimentos')->nullable();
            $table->text('titulo_professores')->nullable();
            $table->text('subtitulo_professores')->nullable();
            $table->text('texto_professores')->nullable();
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
        Schema::dropIfExists('homes');
    }
}
