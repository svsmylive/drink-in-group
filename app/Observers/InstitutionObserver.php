<?php

namespace App\Observers;

use App\Models\Institution;
use Illuminate\Support\Facades\Storage;

class InstitutionObserver
{
    public function deleting(Institution $institution): void
    {
        $institution->attachment->each->delete();
    }

    public function saved(Institution $institution): void
    {
        if ($institution->isDirty('menu_link')) {
            $menuLink = $institution->getOriginal('menu_link');
            if ($menuLink && Storage::has($menuLink)) {
                Storage::delete($menuLink);
            }
        }
    }
}
