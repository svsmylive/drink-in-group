<?php

namespace App\Services;

use App\Http\Resources\Category\CategoryCollection;
use App\Repository\CategoryRepository;

class CategoryService
{
    /**
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(private CategoryRepository $categoryRepository){}

    /**
     * @return CategoryCollection
     */
    public function getList(): CategoryCollection
    {
        $categories = $this->categoryRepository->getList();

        return new CategoryCollection($categories);
    }
}
