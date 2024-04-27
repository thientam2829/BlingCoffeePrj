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
        Schema::create('danh_gia', function (Blueprint $table) {
            $table->char('id', 18);
            $table->string('hoten', 50);
            $table->text('noidung');
            $table->char('email', 100);
            $table->char('id_sanpham', 18);
            $table->dateTime('thoigian');
            $table->tinyInteger('sosao');
            $table->boolean('trangthai');
            $table->timestamps();

            $table->primary('id');
            $table->foreign('id_sanpham')->references('id')->on('san_pham');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('danh_gia');
    }
};
