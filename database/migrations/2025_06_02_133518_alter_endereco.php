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
        Schema::table('endereco', function (Blueprint $table) {
            $table->dropColumn('id_pre_pedido');
            $table->dropColumn('id_pedido');
            $table->uuid();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('endereco', function (Blueprint $table) {
            $table->foreignId('id_pre_pedido')->nullable()->index();
            $table->foreignId('id_pedido')->nullable()->index();
            $table->dropColumn('uuid');
        });
    }
};
