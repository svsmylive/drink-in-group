<?php

namespace App\Services;

use App\Repository\DishRepository;
use Illuminate\Database\Eloquent\Collection;

class DishService
{
    /**
     * @param DishRepository $dishRepository
     */
    public function __construct(private readonly DishRepository $dishRepository)
    {
    }

    /**
     * @return Collection
     */
    public function getList(): Collection
    {
        return $this->dishRepository->getList();
    }
}
