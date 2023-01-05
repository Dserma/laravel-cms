<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCursovodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cursovods', function (Blueprint $table) {
            $table->id();
            $table->text('titulo');
            $table->foreignId('categoriavod_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('nivelvod_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('generovod_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('professorvod_id')->nullable()->constrained()->onDelete('set null');
            $table->string('imagem');
            $table->text('resumo');
            $table->longText('descricao');
            $table->longText('aprender');
            $table->longText('requisitos');
            $table->longText('curriculo');
            $table->longText('keywords');
            $table->text('slug');
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
        Schema::dropIfExists('cursovods');
    }
}
