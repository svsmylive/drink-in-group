<?php

use App\Actions\MakeUrlFromNameAction;
use App\Models\Institution;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $this->createRecords();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }

    private function createRecords(): void
    {
        $institutionsNames = ['КУЛИНАРИЯ'];
        $institutionsTypes = ['Кулинария'];
        $institutionsCities = ['Краснодар'];
        $institutionsAddresses = ['ул. Васнецова, 16'];
        $data = [];

        foreach ($institutionsNames as $key => $institutionsName) {
            $data[] = [
                'name' => $institutionsName,
                'url' => $this->makeUrlFromName($institutionsName),
                'type' => $institutionsTypes[$key],
                'city' => $institutionsCities[$key],
                'address' => $institutionsAddresses[$key],
                'full_address' => $institutionsCities[$key] . ', ' . $institutionsAddresses[$key],
            ];
        }

        Institution::query()->insert($data);
    }

    private function makeUrlFromName(string $name): string
    {
        return resolve(MakeUrlFromNameAction::class)->execute($name);
    }
};
