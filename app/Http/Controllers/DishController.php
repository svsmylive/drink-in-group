<?php

namespace App\Http\Controllers;

use App\Http\Resources\Dish\DishResource;
use App\Models\Dish;
use App\Services\DishService;
use Illuminate\Http\JsonResponse;

class DishController extends Controller
{
    /**
     * @param DishService $dishService
     */
    public function __construct(private readonly DishService $dishService)
    {
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return getSuccessResponse([$this->dishService->getList()]);
    }

    /**
     * @param Dish $dish
     * @return JsonResponse
     */
    public function show(Dish $dish): JsonResponse
    {
        return getSuccessResponse([new DishResource($dish)]);
    }
}
