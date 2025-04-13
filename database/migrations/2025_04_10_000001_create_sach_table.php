<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('sach')) {
        Schema::create('sach', function (Blueprint $table) {
            $table->id('maSach');
            $table->unsignedBigInteger('maNXB')->nullable();
            $table->unsignedBigInteger('maTG')->nullable();
            $table->string('tenSach');
            $table->string('tenDG')->nullable();
            $table->year('namXB')->nullable();
            $table->integer('soLuong')->default(0);
            $table->string('kichThuoc')->nullable();
            $table->integer('giaGoc');
            $table->string('hinhanh')->nullable();
            $table->text('mieuta')->nullable();
            $table->timestamps();

            $table->foreign('maNXB')->references('maNXB')->on('nhaxuatban')->onDelete('set null');
            $table->foreign('maTG')->references('maTG')->on('tacgia')->onDelete('set null');
        });
    }
    }

    public function down(): void
    {
        Schema::dropIfExists('sach');
    }
};
