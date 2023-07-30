<?php

namespace App\Orchid\Layouts\Institution;

use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Layouts\Rows;

class InstitutionEventsLayout extends Rows
{

    protected function fields(): iterable
    {
        return  [
            Input::make('event.name')
                ->type('text')
                ->title(__('Название события'))
                ->placeholder(__('Название события')),
            TextArea::make('event.text')
                ->title(__('Описание события'))
                ->placeholder(__('Описание события'))
                ->rows(5),
            DateTimer::make('event.date')
                ->title(__('Дата события'))
                ->format('d-m-Y')
                ->placeholder(__('Дата события')),
            DateTimer::make('event.time')
                ->title(__('Время события'))
                ->noCalendar()
                ->format('H:i')
                ->placeholder(__('Время события')),
            Upload::make('event.image')
                ->title(__('Изображение события'))
                ->placeholder(__('Изображение события')),

        ];
    }
}
