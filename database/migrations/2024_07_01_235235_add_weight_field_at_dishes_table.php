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
        Schema::table('dishes', function (Blueprint $table) {
            $table->unsignedFloat('mitm_Volume')->nullable();
            $table->index('name');
            $table->index('price');
            $table->index('updated_at');
            $table->index('is_show');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->index('name');
            $table->index('is_show');
            $table->index('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dishes', function (Blueprint $table) {
            $table->dropColumn('mitm_Volume');

            $table->dropIndex('dishes_name_index');
            $table->dropIndex('dishes_price_index');
            $table->dropIndex('dishes_updated_at_index');
            $table->dropIndex('dishes_is_show_index');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropIndex('categories_name_index');
            $table->dropIndex('categories_updated_at_index');
            $table->dropIndex('categories_is_show_index');
        });
    }
};
