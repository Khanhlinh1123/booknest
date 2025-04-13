<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('chitietdonhang')) {
            Schema::create('chitietdonhang', function (Blueprint $table) {
                $table->unsignedBigInteger('maDH');
                $table->unsignedBigInteger('maSach');
                $table->integer('soLuong');
                $table->primary(['maDH', 'maSach']);

                $table->foreign('maDH')->references('maDH')->on('donhang')->onDelete('cascade');
                $table->foreign('maSach')->references('maSach')->on('sach')->onDelete('cascade');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('chitietdonhang');
    }
};
