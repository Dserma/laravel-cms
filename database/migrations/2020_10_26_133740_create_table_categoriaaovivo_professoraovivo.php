<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableCategoriaaovivoProfessoraovivo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categoriaaovivo_professoraovivo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('categoriaaovivo_id')->constrained()->onDelete('cascade');
            $table->foreignId('professoraovivo_id')->constrained()->onDelete('cascade');
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
        Schema::dropIfExists('categoriaaovivo_professoraovivo');
    }
}
