<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerguntacertificadovodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perguntacertificadovods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('certificadovod_id')->constrained()->onDelete('cascade');
            $table->text('pergunta');
            $table->text('resposta_1');
            $table->text('resposta_2');
            $table->text('resposta_3')->nullable();
            $table->text('resposta_4')->nullable();
            $table->text('resposta_5')->nullable();
            $table->unsignedInteger('correta');
            $table->unsignedInteger('order')->default(0);
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
        Schema::dropIfExists('perguntacertificadovods');
    }
}
