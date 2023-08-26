<?php

namespace App\Orchid\Layouts\Institution;

use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Layouts\Rows;

class BackgroundSaunaImageEditLayout extends Rows
{
    protected function fields(): iterable
    {
        return [
            Upload::make('institution.attachment')
                ->groups('institutionBackgroundImage')
                ->maxFiles(1)
                ->title(__('Фоновое изображение при наведении "О сауне"'))
                ->placeholder(__('Фоновое изображение')),

            Upload::make('institution.attachment')
                ->groups('reserveBackgroundImage')
                ->maxFiles(1)
                ->title(__('Фоновое изображение при наведении "Забронировать"'))
                ->placeholder(__('Фоновое изображение')),

            Upload::make('institution.attachment')
                ->groups('priceAndServicesBackgroundImage')
                ->title(__('Фоновое изображение при наведении "Услуги и цены"'))
                ->placeholder(__('Фоновое изображение')),
        ];
    }
}