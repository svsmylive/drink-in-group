<?php

namespace App\Actions;

use App\Models\Institution;
use Illuminate\Database\Eloquent\Collection;

class GetInstitutionsAction
{
    public function execute(): Collection
    {
        return Institution::query()->whereIn('type', Institution::getTypes())->get();
    }
}
