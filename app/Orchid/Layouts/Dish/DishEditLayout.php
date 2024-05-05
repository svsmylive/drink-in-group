<?php

namespace App\Orchid\Layouts\Dish;

use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;

class DishEditLayout extends Rows
{
    protected function fields(): iterable
    {
        return [
            Input::make('dish.institution.name')
                ->type('text')
                ->readonly()
                ->style('background:white; color:black')
                ->title(__('Заведение'))
                ->placeholder(__('Заведение')),

            Input::make('dish.category.name')
                ->type('text')
                ->readonly()
                ->style('background:white; color:black')
                ->title(__('Категория'))
                ->placeholder(__('Категория ')),

            Input::make('dish.name')
                ->type('text')
                ->required()
                ->title(__('Название блюда'))
                ->placeholder(__('Название блюда')),

            Input::make('dish.price')
                ->type('text')
                ->required()
                ->title(__('Цена'))
                ->placeholder(__('Цена')),

            CheckBox::make('dish.is_show')
                ->title(__('Активность'))
                ->sendTrueOrFalse()
                ->placeholder(__('Активность'))
                ->help('Будет ли блюдо активно'),
        ];
    }
}
