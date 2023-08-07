<?php

namespace App\Actions;

use App\Models\Feedback;
use Illuminate\Support\Arr;

class CreateFeedbackAction
{
    public function execute(array $data): array
    {
        $isCreated = Feedback::query()->insert(Arr::only($data, Feedback::FILLABLE));

        if (!$isCreated) {
            return ['success' => false];
        }

        return ['success' => true];
    }
}
