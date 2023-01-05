<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateConfiguracoesTableSeoHome extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('configuracoes', function (Blueprint $table) {
            $table->string('titulo_home')->nullable();
            $table->text('description_home')->nullable();
            $table->text('keywords_home')->nullable();
            $table->string('titulo_aovivo')->nullable();
            $table->text('description_aovivo')->nullable();
            $table->text('keywords_aovivo')->nullable();
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
            $table->dropColumn('titulo_home');
            $table->dropColumn('description_home');
            $table->dropColumn('keywords_home');
            $table->dropColumn('titulo_aovivo');
            $table->dropColumn('description_aovivo');
            $table->dropColumn('keywords_aovivo');
        });
    }
}
