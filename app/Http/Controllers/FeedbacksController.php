<?php

namespace App\Http\Controllers;

use App\Actions\CreateFeedbackAction;
use App\Http\Requests\CreateFeedbackRequest;
use Illuminate\Http\Resources\Json\JsonResource;

class FeedbacksController
{
    public function create(CreateFeedbackRequest $request, CreateFeedbackAction $action): JsonResource
    {
        return new JsonResource($action->execute($request->validated()));
    }
}
