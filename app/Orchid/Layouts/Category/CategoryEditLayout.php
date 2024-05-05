<?php

namespace App\Orchid\Layouts\Category;

use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;

class CategoryEditLayout extends Rows
{
    protected function fields(): iterable
    {
        return [
            Input::make('category.name')
                ->type('text')
                ->required()
                ->title(__('Название категории'))
                ->placeholder(__('Название категории')),

            CheckBox::make('category.is_show')
                ->title(__('Активность'))
                ->sendTrueOrFalse()
                ->placeholder(__('Активность'))
                ->help('Будет ли категория активна'),
        ];
    }
}
