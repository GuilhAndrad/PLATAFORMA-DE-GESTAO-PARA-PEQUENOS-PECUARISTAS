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
        Schema::table('purchases', function (Blueprint $table) {
            $table->boolean('is_canceled')->default(false);
        });

        Schema::table('sales', function (Blueprint $table) {
            $table->boolean('is_canceled')->default(false);
        });
    }

    public function down(): void
    {
        Schema::table('purchases', function (Blueprint $table) {
            $table->dropColumn('is_canceled');
        });

        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn('is_canceled');
        });
    }
};
