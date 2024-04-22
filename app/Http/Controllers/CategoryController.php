<?php

namespace App\Http\Controllers;

use App\Http\Resources\Category\CategoryResource;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    /**
     * @param CategoryService $categotyService
     */
    public function __construct(private CategoryService $categotyService){}

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return getSuccessResponse([$this->categotyService->getList()]);
    }

    /**
     * @param Category $category
     * @return JsonResponse
     */
    public function show(Category $category): JsonResponse
    {
        return getSuccessResponse([new CategoryResource($category)]);
    }
}
