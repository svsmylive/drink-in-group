<?php

namespace App\Actions;

use App\Models\Institution;
use Illuminate\Support\Arr;

class SaveInstitutionAction
{

    public function __construct(private readonly SyncInstitutionEventsAction $syncInstitutionEventsAction)
    {
    }

    public function execute(Institution $institution, array $data): void
    {
        $institutionData = $data['institution'];
        $fields = Arr::only($institutionData, Institution::FILLABLE);
        $sliderImages = $institutionData['attachment'] ?? null;
        $institutionMenu = $institutionData['menu'] ?? null;
        $eventData = $data['events'] ?? null;

        $institution->fill($fields);
        $institution->save();

        if ($sliderImages) {
            $institution->attachment()->sync($sliderImages);
        }

        if ($institutionMenu) {
            $file = request()->file('institution.menu');
            $filePath = 'menu/' . $institution->name;
            $path = $file->storeAs($filePath, $file->getClientOriginalName());
            $institution->menu_link = '/storage/' . $path;
            $institution->save();
        }

        if ($eventData) {
            $this->syncInstitutionEventsAction->execute($institution, $eventData);
        }
    }
}
