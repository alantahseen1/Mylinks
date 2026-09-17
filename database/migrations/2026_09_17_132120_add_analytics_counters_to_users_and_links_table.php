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
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('profile_views')->default(0);
        });

        Schema::table('links', function (Blueprint $table) {
            $table->unsignedBigInteger('clicks')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('links', function (Blueprint $table) {
            $table->dropColumn('clicks');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('profile_views');
        });
    }
};
