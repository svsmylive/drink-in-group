<?php

namespace App\Http\Controllers;

use App\Actions\GetByIdInstitutionsAction;
use App\Actions\GetInstitutionsAction;
use App\Http\Resources\Institutions\InstitutionsMainPageResource;
use App\Http\Resources\Institutions\InstitutionsResource;
use App\Models\Institution;
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

    public function getMainPageInfo(): InstitutionsMainPageResource
    {
        $institution = Institution::query()->whereNotIn('type', Institution::getTypes())->first();

        return new InstitutionsMainPageResource($institution);
    }
}
