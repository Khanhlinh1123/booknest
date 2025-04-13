<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('donhang')) {
            Schema::create('donhang', function (Blueprint $table) {
                $table->id('maDH');
                $table->unsignedBigInteger('maND');
                $table->integer('tongTien');
                $table->string('tinhTrang')->default('Đang xử lý');
                $table->string('phuongThucGH')->nullable();
                $table->text('diaChi')->nullable();
                $table->string('soDT', 10)->nullable();
                $table->timestamps();

                $table->foreign('maND')->references('maND')->on('nguoidung')->onDelete('cascade');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('donhang');
    }
};
