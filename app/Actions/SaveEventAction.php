<?php

namespace App\Actions;

use App\Models\Event;
use Illuminate\Support\Arr;

class SaveEventAction
{
    public function execute(Event $event, array $data): void
    {
        $eventData = $data['event'];
        $fields = Arr::only($eventData, Event::FILLABLE);
        $event->fill($fields);
        $event->save();

        $file = $eventData['attachment'] ?? null;
        if ($file) {
            $event->attachment()->sync($file);
        }
    }
}
