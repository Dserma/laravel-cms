<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCupomaovivosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cupomaovivos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('professoraovivo_id')->constrained()->onDelete('cascade');
            $table->foreignId('categoriaaovivo_id')->constrained()->onDelete('cascade');
            $table->foreignId('aulaaovivo_id')->nullable()->constrained()->onDelete('cascade');
            $table->double('desconto', 12, 2);
            $table->date('validade');
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
        Schema::dropIfExists('cupomaovivos');
    }
}
