<?php

namespace App\Repository;

use App\Models\Dish;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class DishRepository
{
    /**
     * @param string $categoryGuid
     * @param array $data
     * @return Dish|null
     */
    public function updateOrCreate(string $categoryGuid, array $data): ?Dish
    {
        $dish = null;
        try {
            /**@var Dish $dish */
            $dish = Dish::query()->updateOrCreate(
                [
                    'external_id' => $data['mitm_ID'],
                ],
                [
                    'name' => $data['mitm_Name'],
                    'price' => $data['mitm_Price'],
                    'mvtp_ID' => $data['mitm_mvtp_ID'],
                    'category_external_id' => $categoryGuid
                ]);
        } catch (Exception) {
            Log::channel('dish')->debug('Ошибка при создании блюда, dishGuid = ' . $data['mitm_ID']);
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
            ->with('category:id,external_id')
            ->where('is_show', true)
            ->get();
    }
}
