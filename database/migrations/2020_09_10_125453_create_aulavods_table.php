<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAulavodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aulavods', function (Blueprint $table) {
            $table->id();
            $table->text('titulo');
            $table->foreignId('categoriavod_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('professorvod_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('nivelvod_id')->nullable()->constrained()->onDelete('set null');
            $table->longText('descricao');
            $table->unsignedInteger('tipo_video')->default(0)->comment('0 - AWS | 1 - Vimeo');
            $table->longText('video');
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
        Schema::dropIfExists('aulavods');
    }
}
