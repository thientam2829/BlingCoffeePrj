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
        Schema::create('binh_luan', function (Blueprint $table) {
            $table->char('id', 18);
            $table->string('hoten', 50);
            $table->boolean('gioitinh');
            $table->text('noidung');
            $table->char('email', 100);
            $table->char('id_sanpham', 18);
            $table->dateTime('thoigian');
            $table->char('matraloi', 18)->nullable();
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
        Schema::dropIfExists('binh_luan');
    }
};
