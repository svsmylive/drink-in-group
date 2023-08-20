<?php

namespace App\Orchid\Layouts\Institution;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Rows;

class InstitutionMainPageEditLayout extends Rows
{
    /**
     * The screen's layout elements.
     *
     * @return Field[]
     */
    public function fields(): array
    {
        return [
            Input::make('institution.name')
                ->type('text')
                ->required()
                ->max(255)
                ->title(__('Название'))
                ->placeholder(__('Название')),

            Input::make('institution.title')
                ->type('text')
                ->title(__('SEO Title'))
                ->placeholder(__('seo title')),

            TextArea::make('institution.description')
                ->title(__('SEO Description'))
                ->rows(3)
                ->placeholder(__('seo description')),
        ];
    }
}
