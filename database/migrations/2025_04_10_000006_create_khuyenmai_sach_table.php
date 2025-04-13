<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('khuyenmai_sach')) {
            Schema::create('khuyenmai_sach', function (Blueprint $table) {
                $table->id('maKMS');
                $table->unsignedBigInteger('maKM');
                $table->unsignedBigInteger('maSach');
                $table->timestamps();

                $table->foreign('maKM')->references('maKM')->on('khuyenmai')->onDelete('cascade');
                $table->foreign('maSach')->references('maSach')->on('sach')->onDelete('cascade');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('khuyenmai_sach');
    }
};
