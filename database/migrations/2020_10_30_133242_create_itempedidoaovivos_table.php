<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItempedidoaovivosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('itempedidoaovivos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pedidoaovivo_id')->constrained('pedidoaovivo')->onDelete('cascade');
            $table->foreignId('aulaaovivo_id')->constrained('aulaovivo');
            $table->foreignId('pacoteaulaaovivo_id')->nullable()->constrained('pacoteaulaovivo');
            $table->double('valor_unitario', 12, 2);
            $table->unsignedInteger('quantidade');
            $table->double('valor_total', 12, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('itempedidoaovivos');
    }
}
