<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('donhang', function (Blueprint $table) {
        $table->string('tenNguoiNhan')->after('maND');
    });
}

public function down()
{
    Schema::table('donhang', function (Blueprint $table) {
        $table->dropColumn('tenNguoiNhan');
    });
}
};
