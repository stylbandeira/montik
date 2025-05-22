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
        Schema::table('variacoes', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('opcoes_variacoes', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('produtos', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('cupons', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('pedidos', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('variacoes', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });

        Schema::table('opcoes_variacoes', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });

        Schema::table('produtos', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });

        Schema::table('cupons', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });

        Schema::table('pedidos', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });
    }
};
