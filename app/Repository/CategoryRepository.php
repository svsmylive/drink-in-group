<?php

namespace App\Repository;

use App\Models\Category;
use Exception;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class CategoryRepository
{
    /**
     * @param $data
     * @return Collection
     */
    public function getList($data): Collection
    {
        return Category::query()
            ->with('dishes')
            ->whereHas('dishes', function ($query) use ($data) {
                $query->where('institution_id', $data['institution_id']);
            })
            ->where('is_show', true)
            ->orderBy('index')
            ->get();
    }

    /**
     * @param string $categoryGuid
     * @param array $categoryData
     * @return Category|null
     */
    public function updateOrCreate(string $categoryGuid, array $categoryData): ?Category
    {
        $category = null;
        try {
            /**@var Category $category */
            $category = Category::query()->where('external_id', $categoryGuid)->first();

            if (!$category) {
                $category = Category::query()->create(
                    [
                        'name' => $categoryData['mgrp_Name'],
                        'external_id' => $categoryGuid
                    ]
                );
            }
        } catch (Exception $e) {
            Log::channel('category')->debug(
                'Ошибка при создании категории, categoryGuid = ' . $categoryGuid . ' message: ' . $e->getMessage()
            );
        }

        return $category;
    }

    /**
     * @param Category $category
     * @param bool $isShow
     * @return void
     */
    public function update(Category $category, bool $isShow): void
    {
        $category->update([
            'is_show' => $isShow,
        ]);
    }
}
