<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('nguoidung')) {
            Schema::create('nguoidung', function (Blueprint $table) {
                $table->id('maND');
                $table->string('tenDangNhap');
                $table->string('matKhau');
                $table->string('email')->unique();
                $table->string('soDT', 10)->nullable();
                $table->string('tenND');
                $table->text('diaChi')->nullable();
                $table->date('ngaySinh')->nullable();
                $table->string('gioiTinh')->nullable();
                $table->string('phanQuyen')->default('customer');
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('nguoidung');
    }
};
