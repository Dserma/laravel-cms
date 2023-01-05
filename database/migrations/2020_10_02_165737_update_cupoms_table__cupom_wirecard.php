<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCupomsTableCupomWirecard extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cupoms', function (Blueprint $table) {
            $table->string('cupom_wirecard');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cupoms', function (Blueprint $table) {
            $table->dropColumn('cupom_wirecard');
        });
    }
}
