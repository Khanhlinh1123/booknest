<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('danhmuc')) {
            Schema::create('danhmuc', function (Blueprint $table) {
                $table->id('maDM');
                $table->string('tenDM');
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('danhmuc');
    }
};
