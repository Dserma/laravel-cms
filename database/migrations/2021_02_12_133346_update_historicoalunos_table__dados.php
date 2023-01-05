<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateHistoricoalunosTableDados extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('historicoalunos', function (Blueprint $table) {
            $table->foreignId('plano_id')->nullable()->constrained()->onDelete('set null');
            $table->unsignedInteger('forma')->default(0);
            $table->date('validade')->nullable();
            $table->string('via')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('historicoalunos', function (Blueprint $table) {
            $table->dropColumn('plano_id');
            $table->dropColumn('forma');
            $table->dropColumn('validade');
            $table->dropColumn('via');
        });
    }
}
