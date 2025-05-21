<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produto_variacoes_opcoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_produto_variacoes')->index();
            $table->foreignId('id_opcoes_variacoes')->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('produto_variacoes_opcoes');
    }
};
