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
        Schema::create('nhan_vien', function (Blueprint $table) {
            $table->char('id', 18);
            $table->string('tennhanvien', 50);
            $table->char('sdt', 10);
            $table->string('diachi', 150);
            $table->char('email', 100);
            $table->date('ngaysinh');
            $table->boolean('gioitinh');
            $table->char('hinhanh', 25);
            $table->integer('luong');
            $table->char('password', 200);
            $table->char('id_loainhanvien', 18);
            $table->boolean('trangthai');
            $table->timestamps();

            $table->primary('id');
            $table->foreign('id_loainhanvien')->references('id')->on('loai_nhan_vien');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nhan_vien');
    }
};
