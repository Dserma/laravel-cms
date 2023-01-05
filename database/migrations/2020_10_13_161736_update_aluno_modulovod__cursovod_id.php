<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAlunoModulovodCursovodId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('aluno_modulovod', function (Blueprint $table) {
            $table->foreignId('cursovod_id')->after('aluno_id')->nullable()->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('aluno_modulovod', function (Blueprint $table) {
            $table->dropColumn('cursovod_id');
        });
    }
}
