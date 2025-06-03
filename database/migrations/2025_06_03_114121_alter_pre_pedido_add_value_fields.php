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
        Schema::table('pre_pedido', function (Blueprint $table) {
            $table->foreignId('id_cupom');
            $table->decimal('subtotal');
            $table->decimal('descontos');
            $table->decimal('total');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pre_pedido', function (Blueprint $table) {
            $table->dropColumn('id_cupom');
            $table->dropColumn('subtotal');
            $table->dropColumn('descontos');
            $table->dropColumn('total');
        });
    }
};
