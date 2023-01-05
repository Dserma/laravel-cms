<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePedidoaovivosTableComplementos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pedidoaovivos', function (Blueprint $table) {
            $table->string('pagamento_gateway')->after('pedido_gateway')->nullable();
            $table->double('valor_original')->after('pagamento_gateway')->default(0);
            $table->string('cupons')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pedidoaovivos', function (Blueprint $table) {
            $table->dropColumn('pagamento_gateway');
            $table->dropColumn('valor_original');
            $table->dropColumn('cupons');
        });
    }
}
