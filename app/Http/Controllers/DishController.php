<?php

namespace App\Http\Controllers;

use App\Http\Resources\Dish\DishResource;
use App\Models\Dish;
use App\Services\DishService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class DishController extends Controller
{
    /**
     * @param DishService $dishService
     */
    public function __construct(private readonly DishService $dishService)
    {
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $data = $this->dishService->getList();

        return DishResource::collection($data);
    }

    /**
     * @param Dish $dish
     * @return DishResource
     */
    public function show(Dish $dish): DishResource
    {
        return new DishResource($dish);
    }
}
