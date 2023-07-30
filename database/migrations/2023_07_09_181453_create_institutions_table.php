<?php

use App\Models\Institution;
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
        Schema::create('institutions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->enum('type', ['Ресторан', 'Сауна', 'Караоке'])->nullable();
            $table->string('city')->nullable();
            $table->string('address')->nullable();
            $table->string('full_address')->nullable();
            $table->string('menu_link')->nullable();
            $table->string('time_of_work')->nullable();
            $table->string('phone')->nullable();
            $table->boolean('active')->default(true);
            $table->string('about_detail_text')->nullable();
//            $table->string('about_restaurant_detail_images_link');
            $table->timestamps();
        });

        $this->createRecords();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('institutions');
    }

    private function createRecords(): void
    {
        $institutionsNames = ['БЕЛЫЙ ГРИБ', 'БЕЛЫЙ ГРИБ', 'ВИНО И МОРЕ', 'КАМЕЛОТ', 'ГОЛОС', 'РИМСКИЕ КАНИКУЛЫ'];
        $institutionsTypes = ['Ресторан', 'Ресторан', 'Ресторан', 'Ресторан', 'Караоке', 'Сауна'];
        $institutionsCities = ['Красная Поляна', 'Краснодар', 'Анапа', 'Краснодар', 'Краснодар', 'Краснодар'];
        $institutionsAddresses = ['ул. Горная, 11', 'ул. Васнецова, 16', 'ул. Набережная, 27', 'ул. Васнецова, 16', 'ул. Васнецова, 16', 'ул. Васнецова, 16'];
        $data = [];

        foreach ($institutionsNames as $key => $institutionsName) {
            $data[] = [
                'name' => $institutionsName,
                'type' => $institutionsTypes[$key],
                'city' => $institutionsCities[$key],
                'address' => $institutionsAddresses[$key],
                'full_address' => $institutionsCities[$key] . ', ' . $institutionsAddresses[$key],
            ];
        }

        Institution::query()->insert($data);
    }
};
