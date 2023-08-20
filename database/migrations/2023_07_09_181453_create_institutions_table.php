<?php

use App\Models\Institution;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public $withinTransaction = true;
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
            $table->string('time_of_work')->nullable();
            $table->string('phone')->nullable();
            $table->boolean('active')->default(true);
            $table->string('about_detail_text_header')->nullable();
            $table->string('about_detail_text_body')->nullable();
            $table->string('about_detail_text_footer')->nullable();
            $table->string('event_text_footer')->nullable();
            $table->string('event_text_header')->nullable();
            $table->string('services_and_prices_text_header')->nullable();
            $table->string('services_and_prices_text_footer')->nullable();
            $table->string('services_and_prices_capacity')->nullable();
            $table->string('services_and_prices_price')->nullable();
            $table->string('title')->nullable();
            $table->string('description')->nullable();
            $table->json('services_and_prices_include')->nullable();
            $table->json('services_and_prices_additionally_include')->nullable();
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
        $institutionsNames = ['БЕЛЫЙ ГРИБ', 'БЕЛЫЙ ГРИБ', 'ВИНО И МОРЕ', 'КАМЕЛОТ', 'ГОЛОС', 'РИМСКИЕ КАНИКУЛЫ', 'ГЛАВНАЯ СТРАНИЦА С ЗАВЕДЕНИЯМИ SEO'];
        $institutionsTypes = ['Ресторан', 'Ресторан', 'Ресторан', 'Ресторан', 'Караоке', 'Сауна', 'Главная'];
        $institutionsCities = ['Красная Поляна', 'Краснодар', 'Анапа', 'Краснодар', 'Краснодар', 'Краснодар', null];
        $institutionsAddresses = ['ул. Горная, 11', 'ул. Васнецова, 16', 'ул. Набережная, 27', 'ул. Васнецова, 16', 'ул. Васнецова, 16', 'ул. Васнецова, 16', null];
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
