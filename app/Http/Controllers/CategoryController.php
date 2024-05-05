<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchCategoryRequest;
use App\Http\Resources\Category\CategoryResource;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CategoryController extends Controller
{
    /**
     * @param CategoryService $categotyService
     */
    public function __construct(private readonly CategoryService $categotyService)
    {
    }

    /**
     * @param SearchCategoryRequest $request
     * @return AnonymousResourceCollection
     */
    public function index(SearchCategoryRequest $request): AnonymousResourceCollection
    {
        $data = $this->categotyService->getList($request->validated());

        return CategoryResource::collection($data);
    }

    /**
     * @param Category $category
     * @return CategoryResource
     */
    public function show(Category $category): CategoryResource
    {
        return new CategoryResource($category);
    }
}
