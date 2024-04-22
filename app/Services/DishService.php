<?php

namespace App\Services;

use App\Http\Resources\Dish\DishCollection;
use App\Repository\DishRepository;

class DishService
{
    /**
     * @param DishRepository $dishRepository
     */
    public function __construct(private DishRepository $dishRepository){}

    /**
     * @return DishCollection
     */
    public function getList(): DishCollection
    {
        return new DishCollection($this->dishRepository->getList());
    }
}
