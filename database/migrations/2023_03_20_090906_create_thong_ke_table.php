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
        Schema::create('thong_ke', function (Blueprint $table) {
            $table->char('id', 18);
            $table->date('thoigian');
            $table->integer('doanhso');
            $table->integer('loinhuan');
            $table->integer('soluongdaban');
            $table->integer('soluongdonhang');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('thong_ke');
    }
};
