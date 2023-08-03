<?php

namespace App\Actions;

use App\Models\Event;
use App\Models\Institution;

class SyncInstitutionEventsAction
{
    public function execute(Institution $institution, array $events): void
    {
        $institution->events()->each(function (Event $event) {
            $event->institution()->disassociate();
            $event->save();
        });

        Event::query()->whereIn('id', $events)->each(function (Event $event) use ($institution) {
            $event->institution()->associate($institution);
            $event->save();
        });
    }
}
