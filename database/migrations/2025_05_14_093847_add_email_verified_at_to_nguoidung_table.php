<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::table('nguoidung', function (Blueprint $table) {
        if (!Schema::hasColumn('nguoidung', 'email_verified_at')) {
            $table->timestamp('email_verified_at')->nullable();
        }

        if (!Schema::hasColumn('nguoidung', 'remember_token')) {
            $table->rememberToken(); // varchar(100) nullable
        }
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nguoidung', function (Blueprint $table) {
            //
        });
    }
};
