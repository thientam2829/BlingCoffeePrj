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
        Schema::create('hoa_don', function (Blueprint $table) {
            $table->char('id', 18);
            $table->dateTime('ngaylap');
            $table->integer('tongtienhoadon');
            $table->integer('giamgia');
            $table->integer('thanhtien');
            $table->integer('diemtichluy')->nullable();
            $table->string('tenkhachhang', 50)->nullable();
            $table->char('sdtkhachhang', 10)->nullable();
            $table->string('diachikhachhang', 150)->nullable();
            $table->char('emailkhachhang', 100)->nullable();
            $table->text('ghichukhachhang')->nullable();
            $table->char('id_khachhang', 18);
            $table->char('id_nhanvien', 18);
            $table->char('hinhthucthanhtoan', 10)->nullable();
            $table->tinyInteger('trangthai');
            $table->timestamps();

            $table->primary('id');
            $table->foreign('id_khachhang')->references('id')->on('khach_hang');
            $table->foreign('id_nhanvien')->references('id')->on('nhan_vien');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hoa_don');
    }
};
