<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('tacgia', function ($table) {
        $table->string('slug')->unique()->after('tenTG')->nullable();
    });
}
};
