<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCursovodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cursovods', function (Blueprint $table) {
            $table->unsignedInteger('gratuito')->default(0)->comment('0 - Não | 1 - Sim');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cursovods', function (Blueprint $table) {
            $table->dropColumn('gratuito');
        });
    }
}
