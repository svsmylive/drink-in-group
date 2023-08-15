<?php

namespace App\Actions;

use App\Events\FeedbackCreate;
use App\Models\Feedback;
use Illuminate\Support\Arr;

class CreateFeedbackAction
{
    public function execute(array $data): array
    {
        $feedBack = Feedback::query()->create(Arr::only($data, Feedback::FILLABLE));

        FeedbackCreate::dispatch($feedBack);

        return ['data' => $feedBack];
    }
}
