<?php

namespace App\Actions;

use App\Models\Institution;
use Illuminate\Support\Arr;
use Orchid\Attachment\File;

class SaveInstitutionAction
{
    public function __construct(private readonly SyncInstitutionEventsAction $syncInstitutionEventsAction)
    {
    }

    public function execute(Institution $institution, array $data): void
    {
        $institutionData = $data['institution'];
        $fields = Arr::only($institutionData, Institution::FILLABLE);
        $eventData = $data['events'] ?? null;
        $attachment = $institutionData['attachment'] ?? null;

        $institution->fill($fields);
        $institution->save();

        if ($attachment) {
            $institution->attachment()->sync($attachment);
        }

        $this->syncInstitutionEventsAction->execute($institution, $eventData);

        $institution->save();
    }
}
