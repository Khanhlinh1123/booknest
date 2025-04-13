<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('khuyenmai')) {
            Schema::create('khuyenmai', function (Blueprint $table) {
                $table->id('maKM');
                $table->string('tenKM');
                $table->text('moTa')->nullable();
                $table->string('loaiGiam')->nullable();
                $table->integer('giaTri')->nullable();
                $table->dateTime('batDau')->nullable();
                $table->dateTime('ketThuc')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('khuyenmai');
    }
};
