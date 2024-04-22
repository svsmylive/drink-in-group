<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dishes', function (Blueprint $table) {
            $table->id();
            $table->uuid('category_external_id')->nullable();
            $table->uuid('external_id')->unique()->nullable();
            $table->string('name')->nullable();
            $table->string('detail_text')->nullable();
            $table->integer('price')->nullable();
            $table->string('preview_image')->nullable();
            $table->string('detail_image')->nullable();
            $table->integer('index')->nullable()->default(10);
            $table->boolean('is_show')->default(true)->nullable();
            $table->timestamps();

            $table->foreign('category_external_id')
                ->references('external_id')
                ->on('categories')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
//        Schema::dropIfExists('menu');
    }
};
