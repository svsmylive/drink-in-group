<?php

namespace App\Http\Controllers;

use App\Actions\GetByIdInstitutionsAction;
use App\Actions\GetInstitutionsAction;
use App\Http\Resources\Institutions\InstitutionsResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class InstitutionsController
{
    public function get(GetInstitutionsAction $action): AnonymousResourceCollection
    {
        return InstitutionsResource::collection($action->execute());
    }

    public function getById(int $id, GetByIdInstitutionsAction $action): InstitutionsResource
    {
        return new InstitutionsResource($action->execute($id));
    }
}
