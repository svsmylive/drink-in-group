<?php

namespace App\Actions;

use App\Models\Institution;

class GetByIdInstitutionsAction
{
    public function execute(int $id): Institution
    {
        return Institution::findOrFail($id);
    }
}
