<?php

namespace App\Services;

use App\Repository\CategoryRepository;
use Illuminate\Database\Eloquent\Collection;

class CategoryService
{
    /**
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(private CategoryRepository $categoryRepository)
    {
    }

    /**
     * @param array $data
     * @return Collection
     */
    public function getList(array $data): Collection
    {
        return $this->categoryRepository->getList($data);
    }
}
