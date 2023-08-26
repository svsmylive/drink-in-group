<?php

namespace App\Orchid\Layouts\Institution;

use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Layouts\Rows;

class BackgroundInstitutionImageEditLayout extends Rows
{
    protected function fields(): iterable
    {
        return [
            Upload::make('institution.attachment')
                ->groups('institutionBackgroundImage')
                ->maxFiles(1)
                ->title(__('Фоновое изображение при наведении "О заведении"'))
                ->placeholder(__('Фоновое изображение')),

            Upload::make('institution.attachment')
                ->groups('reserveBackgroundImage')
                ->maxFiles(1)
                ->title(__('Фоновое изображение при наведении "Забронировать"'))
                ->placeholder(__('Фоновое изображение')),

            Upload::make('institution.attachment')
                ->groups('menuBackgroundImage')
                ->maxFiles(1)
                ->title(__('Фоновое изображение при наведении "Меню"'))
                ->placeholder(__('Фоновое изображение')),

            Upload::make('institution.attachment')
                ->groups('eventBackgroundImage')
                ->maxFiles(1)
                ->title(__('Фоновое изображение при наведении "События"'))
                ->placeholder(__('Фоновое изображение'))
        ];
    }
}