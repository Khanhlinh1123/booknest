<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNhaxuatbanTable extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('nhaxuatban')) {
            Schema::create('nhaxuatban', function (Blueprint $table) {
                $table->id('maNXB');
                $table->string('tenNXB');
                $table->string('diaChi')->nullable();
                $table->string('soDT', 10)->nullable();
                $table->string('email')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('nhaxuatban');
    }
}
