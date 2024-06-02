<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('institution_id')
                ->constrained('institutions', 'id');
        });

        Schema::table('orders_count', function (Blueprint $table) {
            $table->foreignId('institution_id')
                ->constrained('institutions', 'id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('institution_id');
        });

        Schema::table('orders_count', function (Blueprint $table) {
            $table->dropColumn('institution_id');
        });
    }
};
