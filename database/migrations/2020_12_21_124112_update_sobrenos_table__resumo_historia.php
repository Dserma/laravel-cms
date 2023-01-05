<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSobrenosTableResumoHistoria extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sobrenos', function (Blueprint $table) {
            $table->text('resumo_historia');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sobrenos', function (Blueprint $table) {
            $table->dropColumn('resumo_historia');
        });
    }
}
