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
        Schema::create('chi_tiet_hoa_don', function (Blueprint $table) {
            $table->char('id_hoadon', 18);
            $table->char('id_chitietsanpham', 18);
            $table->integer('soluong');
            $table->integer('giamgia');
            $table->integer('tonggia');
            $table->timestamps();

            $table->foreign('id_hoadon')->references('id')->on('hoa_don');
            $table->foreign('id_chitietsanpham')->references('id')->on('chi_tiet_san_pham');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chi_tiet_hoa_don');
    }
};
