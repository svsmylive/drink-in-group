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
        Schema::table('institutions', function (Blueprint $table) {
            $table->string('about_detail_text_header', 500)->nullable()->change();
            $table->string('about_detail_text_body', 500)->nullable()->change();
            $table->string('about_detail_text_footer', 500)->nullable()->change();
            $table->string('event_text_footer', 500)->nullable()->change();
            $table->string('event_text_header', 500)->nullable()->change();
            $table->string('services_and_prices_text_header', 500)->nullable()->change();
            $table->string('services_and_prices_text_footer', 500)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
