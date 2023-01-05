<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateConfiguracoesTableLicencasZoom extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('configuracoes', function (Blueprint $table) {
            $table->unsignedInteger('licencas_zoom')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('configuracoes', function (Blueprint $table) {
            $table->dropColumn('licencas_zoom');
        });
    }
}