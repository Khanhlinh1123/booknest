<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Bảng phiếu nhập
        Schema::create('phieunhap', function (Blueprint $table) {
            $table->id(); // BIGINT UNSIGNED
            $table->date('ngayNhap');
            $table->text('ghiChu')->nullable();
            $table->unsignedBigInteger('nguoiNhap')->nullable();
            $table->timestamps();
        });

        // Bảng chi tiết phiếu nhập
        Schema::create('chitietphieunhap', function (Blueprint $table) {
            $table->id();

            // ✅ Khớp với phieunhap.id = BIGINT UNSIGNED
            $table->unsignedBigInteger('phieuNhap_id');

            // ✅ Khớp với sach.maSach = INT UNSIGNED
            $table->integer('sach_id');

            $table->integer('soLuong');
            $table->decimal('donGia', 10, 2)->nullable();
            $table->timestamps();

            $table->foreign('phieuNhap_id')
                ->references('id')->on('phieunhap')
                ->onDelete('cascade');

            $table->foreign('sach_id')
                ->references('maSach')->on('sach')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chitietphieunhap');
        Schema::dropIfExists('phieunhap');
    }
};
