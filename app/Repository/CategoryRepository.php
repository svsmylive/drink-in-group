<?php

namespace App\Repository;

use App\Models\Category;
use Exception;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class CategoryRepository
{
    /**
     * @return Collection
     */
    public function getList(): Collection
    {
        return Category::query()
            ->select(['id', 'name', 'index', 'external_id'])
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
                ]);
        } catch (Exception) {
            Log::channel('category')->debug('Ошибка при создании категории, categoryGuid = ' . $categoryGuid);
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
