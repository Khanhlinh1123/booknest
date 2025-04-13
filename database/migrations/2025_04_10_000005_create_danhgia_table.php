<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('danhgia')) {
            Schema::create('danhgia', function (Blueprint $table) {
                $table->id('maNXET');
                $table->unsignedBigInteger('maND');
                $table->unsignedBigInteger('maSach');
                $table->tinyInteger('soSao')->default(5);
                $table->text('nhanXet')->nullable();
                $table->timestamps();

                $table->foreign('maND')->references('maND')->on('nguoidung')->onDelete('cascade');
                $table->foreign('maSach')->references('maSach')->on('sach')->onDelete('cascade');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('danhgia');
    }
};
