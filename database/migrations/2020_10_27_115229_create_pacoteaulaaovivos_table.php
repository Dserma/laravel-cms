<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePacoteaulaaovivosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pacoteaulaaovivos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('professoraovivo_id')->constrained()->onDelete('cascade');
            $table->foreignId('aulaaovivo_id')->constrained()->onDelete('cascade');
            $table->unsignedInteger('quantidade');
            $table->double('desconto', 12, 2);
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
        Schema::dropIfExists('pacoteaulaaovivos');
    }
}
