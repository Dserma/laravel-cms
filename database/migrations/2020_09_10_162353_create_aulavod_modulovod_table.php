<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAulavodModulovodTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aulavod_modulovod', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aulavod_id')->constrained()->onDelete('cascade');
            $table->foreignId('modulovod_id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('aulavod_modulovod');
    }
}
