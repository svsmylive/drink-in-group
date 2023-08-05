<?php

namespace App\Observers;

use App\Models\Institution;

class InstitutionObserver
{
    public function deleting(Institution $institution): void
    {
        $institution->attachment->each->delete();
    }
}
