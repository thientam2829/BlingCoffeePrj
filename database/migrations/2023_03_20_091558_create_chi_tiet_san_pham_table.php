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
        Schema::create('chi_tiet_san_pham', function (Blueprint $table) {
            $table->char('id', 18);
            $table->char('kichthuoc', 18);
            $table->integer('soluong');
            $table->integer('giasanpham');
            $table->date('ngaysanxuat');
            $table->date('hansudung');
            $table->char('id_sanpham', 18);
            $table->boolean('trangthai');
            $table->timestamps();

            $table->primary('id');
            $table->foreign('id_sanpham')->references('id')->on('san_pham');
            $table->foreign('kichthuoc')->references('id')->on('quy_cach');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chi_tiet_san_pham');
    }
};
