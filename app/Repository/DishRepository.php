<?php

namespace App\Repository;

use App\Models\Dish;
use App\Models\Institution;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class DishRepository
{
    /**
     * @param Institution $institution
     * @param string $categoryGuid
     * @param array $data
     * @return Dish|null
     */
    public function updateOrCreate(Institution $institution, string $categoryGuid, array $data): ?Dish
    {
        $dish = null;

        try {
            /**@var Dish $dish */
            $dish = Dish::query()->where('external_id', $data['mitm_ID'])->first();

            if (!$dish) {
                $dish = Dish::query()->create([
                    'external_id' => $data['mitm_ID'],
                    'name' => $data['mitm_Name'],
                    'price' => $data['mitm_Price'],
                    'mvtp_ID' => $data['mitm_mvtp_ID'],
                    'category_external_id' => $categoryGuid,
                    'institution_id' => $institution->id,
                ]);
            } else {
                $dish->update([
                    'price' => $data['mitm_Price'],
                    'mvtp_ID' => $data['mitm_mvtp_ID'],
                    'category_external_id' => $categoryGuid,
                    'institution_id' => $institution->id,
                ]);
            }
        } catch (Exception $e) {
            Log::channel('dish')->debug(
                'Ошибка при создании блюда, dishGuid = ' . $data['mitm_ID'] . ' message: ' . $e->getMessage()
            );
        }

        return $dish;
    }

    /**
     * @param Dish $dish
     * @param bool $isShow
     * @return void
     */
    public function update(Dish $dish, bool $isShow): void
    {
        $dish->update([
            'is_show' => $isShow,
        ]);
    }

    /**
     * @return Collection
     */
    public function getList(): Collection
    {
        return Dish::query()
            ->select(['id', 'name', 'price', 'index', 'preview_image', 'category_external_id'])
            ->with('category:id,external_id', 'attachment')
            ->where('is_show', true)
            ->get();
    }
}
