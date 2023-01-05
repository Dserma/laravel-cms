<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateProfessorvodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('professorvods', function (Blueprint $table) {
            $table->renameColumn('linkedin', 'youtube');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('professorvods', function (Blueprint $table) {
            $table->renameColumn('youtube', 'linkedin');
        });
    }
}
