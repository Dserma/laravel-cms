<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSobreNosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sobrenos', function (Blueprint $table) {
            $table->id();
            $table->text('sobre')->nullable();
            $table->text('conheca')->nullable();
            $table->text('descricao')->nullable();
            $table->text('texto_vantagens')->nullable();
            $table->json('vantagens')->nullable();
            $table->text('missao')->nullable();
            $table->text('visao')->nullable();
            $table->text('valores')->nullable();
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
        Schema::dropIfExists('sobrenos');
    }
}
