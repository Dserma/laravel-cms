<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateProfessoraovivosTableSEO extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('professoraovivos', function (Blueprint $table) {
            $table->string('titulo_seo')->nullable();
            $table->text('description_seo')->nullable();
            $table->text('keywords_seo')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('professoraovivos', function (Blueprint $table) {
            $table->dropColumn('titulo_seo');
            $table->dropColumn('description_seo');
            $table->dropColumn('keywords_seo');
        });
    }
}
