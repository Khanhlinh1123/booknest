<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('danhmuc_sach')) {
            Schema::create('danhmuc_sach', function (Blueprint $table) {
                $table->id('maDMS');
                $table->unsignedBigInteger('maDM');
                $table->unsignedBigInteger('maSach');
                $table->timestamps();

                $table->foreign('maDM')->references('maDM')->on('danhmuc')->onDelete('cascade');
                $table->foreign('maSach')->references('maSach')->on('sach')->onDelete('cascade');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('danhmuc_sach');
    }
};
