<?php

namespace App\Orchid\Layouts\Institution;

use App\Models\Event;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Layouts\Rows;

class InstitutionEventsLayout extends Rows
{
    protected function fields(): iterable
    {
        return [
            Relation::make('events.')
                ->fromModel(Event::class, 'name')
                ->applyScope('FreeRelation')
                ->title('Выбирите свободные события из списка')
                ->multiple(),
        ];
    }
}
