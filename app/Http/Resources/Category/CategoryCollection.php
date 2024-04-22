<?php

namespace App\Http\Resources\Category;

use Illuminate\Support\Collection;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CategoryCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'data' => $this->transformCollection($this->collectResource($this->collection)),
        ];
    }

    /**
     * @param Collection $categories
     * @return Collection
     */
    private function transformCollection(Collection $categories): Collection
    {
        return $categories->transform(function (CategoryResource $category) {
            return $this->formatCategoryData($category);
        });
    }

    /**
     * @param CategoryResource $category
     * @return array
     */
    private function formatCategoryData(CategoryResource $category): array
    {
        return [
            'id' => $category->id,
            'name' => $category->name,
            'index' => $category->index,
        ];
    }
}
