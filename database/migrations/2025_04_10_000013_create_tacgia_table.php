<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTacgiaTable extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('tacgia')) {
            Schema::create('tacgia', function (Blueprint $table) {
                $table->id('maTG');
                $table->string('tenTG');
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('tacgia');
    }
}
