<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('giohang')) {
            Schema::create('giohang', function (Blueprint $table) {
                $table->id('maGH');
                $table->unsignedBigInteger('maND');
                $table->timestamps();

                $table->foreign('maND')->references('maND')->on('nguoidung')->onDelete('cascade');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('giohang');
    }
};
