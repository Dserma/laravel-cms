<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAulaaovivosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aulaaovivos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('professoraovivo_id')->constrained()->onDelete('cascade');
            $table->foreignId('categoriaaovivo_id')->constrained()->onDelete('cascade');
            $table->unsignedInteger('duracao');
            $table->double('valor', 12, 2);
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
        Schema::dropIfExists('aulaaovivos');
    }
}
