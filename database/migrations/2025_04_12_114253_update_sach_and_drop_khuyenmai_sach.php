<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('sach', function (Blueprint $table) {
            $table->unsignedBigInteger('maKM')->nullable()->after('giaGoc');
            $table->foreign('maKM')->references('maKM')->on('khuyenmai')->onDelete('set null');
        });

        Schema::dropIfExists('khuyenmai_sach');
    }

    public function down()
    {
        Schema::create('khuyenmai_sach', function (Blueprint $table) {
            $table->id('maKMS');
            $table->unsignedBigInteger('maSach');
            $table->unsignedBigInteger('maKM');
            $table->timestamps();
        });

        Schema::table('sach', function (Blueprint $table) {
            $table->dropForeign(['maKM']);
            $table->dropColumn('maKM');
        });
    }
};
