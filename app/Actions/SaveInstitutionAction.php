<?php

namespace App\Actions;

use App\Models\Event;
use App\Models\Institution;
use Illuminate\Support\Arr;

class SaveInstitutionAction
{
    public function execute(Institution $institution, array $data): void
    {
        $institutionData = $data['institution'];
        $fields = Arr::only($institutionData, Institution::FILLABLE);
        $sliderImages = $institutionData['attachment'] ?? null;
        $institutionMenu = $institutionData['menu'] ?? null;
        $eventData = $data['event'] ?? null;

        $institution->fill($fields);
        $institution->save();

        if ($sliderImages) {
            $institution->attachment()->sync($sliderImages);
        }
        if ($institutionMenu) {
            $file = request()->file('institution.menu');
            $filePath = 'menu/' . $institution->name;
            $path = $file->storeAs($filePath, $file->getClientOriginalName());
            $institution->menu_link = $path;
            $institution->save();
        }

        if ($eventData) {
            $event = new Event(Arr::only($eventData, Event::FILLABLE));
            $event->institution()->associate($institution);
            $event->save();
            if ($eventData['file']) {

            }
        }
    }
}
