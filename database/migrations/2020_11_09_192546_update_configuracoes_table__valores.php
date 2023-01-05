<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateConfiguracoesTableValores extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('configuracoes', function (Blueprint $table) {
            $table->dropColumn('tipo_split');
            $table->dropColumn('valor_split');
            $table->double('valor_fixo', 12, 2)->default(0);
            $table->double('comissao_abaixo', 12, 2)->default(0);
            $table->unsignedInteger('limite_comissao')->default(0);
            $table->double('comissao_acima', 12, 2)->default(0);
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
            $table->unsignedInteger('tipo_split')->default(0);
            $table->double('valor_split', 12, 2)->default(0);
            $table->dropColumn('valor_fixo');
            $table->dropColumn('comissao_abaixo');
            $table->dropColumn('limite_comissao');
            $table->dropColumn('comissao_acima');
        });
    }
}
