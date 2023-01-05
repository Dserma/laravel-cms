<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfessorvodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('professorvods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('categoriavod_id')->nullable()->constrained()->onDelete('set null');
            $table->string('nome');
            $table->string('imagem')->nullable();
            $table->longText('sobre')->nullable();
            $table->longText('apresentacao')->nullable();
            $table->text('video')->nullable();
            $table->text('facebook')->nullable();
            $table->text('instagram')->nullable();
            $table->text('linkedin')->nullable();
            $table->text('twitter')->nullable();
            $table->text('site')->nullable();
            $table->string('slug');
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
        Schema::dropIfExists('professorvods');
    }
}
