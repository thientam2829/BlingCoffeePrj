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
        Schema::create('chi_tiet_khuyen_mai', function (Blueprint $table) {
            $table->char('id_chitietsanpham', 18);
            $table->char('id_khuyenmai', 18);
            $table->integer('muckhuyenmai');
            $table->timestamps();

            $table->foreign('id_chitietsanpham')->references('id')->on('chi_tiet_san_pham');
            $table->foreign('id_khuyenmai')->references('id')->on('khuyen_mai');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chi_tiet_khuyen_mai');
    }
};
