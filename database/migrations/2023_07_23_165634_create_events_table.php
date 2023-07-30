<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('institution_id');
            $table->string('name')->nullable();
            $table->string('text')->nullable();
            $table->string('date')->nullable();
            $table->string('time')->nullable();
            $table->string('path_to_image')->nullable();

            $table->foreign('institution_id')
                ->references('id')
                ->on('institutions')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
};
