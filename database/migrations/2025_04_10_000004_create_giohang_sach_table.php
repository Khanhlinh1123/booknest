<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('giohang_sach')) {
            Schema::create('giohang_sach', function (Blueprint $table) {
                $table->id('maGHS');
                $table->unsignedBigInteger('maGH');
                $table->unsignedBigInteger('maSach');
                $table->integer('soLuong')->default(1);
                $table->timestamps();

                $table->foreign('maGH')->references('maGH')->on('giohang')->onDelete('cascade');
                $table->foreign('maSach')->references('maSach')->on('sach')->onDelete('cascade');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('giohang_sach');
    }
};
