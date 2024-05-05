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
            $category = Category::query()->updateOrCreate(
                [
                    'external_id' => $categoryGuid,
                ],
                [
                    'name' => $categoryData['mgrp_Name'],
                    'is_show' => !$categoryData['mgrp_IsDisabled'],
                ]
            );
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
