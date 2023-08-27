<?php

namespace App\Orchid\Layouts\Institution;

use App\Models\Institution;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Layouts\Rows;

class InstitutionServicesAndPricesEditLayout extends Rows
{
    /**
     * The screen's layout elements.
     *
     * @return Field[]
     */
    public function fields(): array
    {
        return [
            TextArea::make('institution.services_and_prices_text_header')
                ->rows(6)
                ->title(__('Услуги и цены текст header'))
                ->placeholder(__('Услуги и цены текст header')),

            TextArea::make('institution.services_and_prices_text_footer')
                ->rows(6)
                ->title(__('Услуги и цены текст footer'))
                ->placeholder(__('Услуги и цены текст footer')),

            Input::make('institution.services_and_prices_capacity')
                ->type('text')
                ->title(__('Вместимость'))
                ->placeholder(__('Вместимость')),

            Input::make('institution.services_and_prices_price')
                ->type('text')
                ->title(__('Цена'))
                ->placeholder(__('Цена')),

            Select::make('institution.services_and_prices_include')
                ->title(__('Услуги в сауне'))
                ->options(Institution::getSaunaIncludes())
                ->multiple()
                ->empty('Нет'),

            Select::make('institution.services_and_prices_additionally_include')
                ->options(Institution::getSaunaIncludesAdditionally())
                ->title(__('Дополнительные услуги в сауне'))
                ->multiple()
                ->empty('Нет'),

            Upload::make('institution.attachment')
                ->groups('saunaImage')
                ->title(__('Изображение на странице "Наши услуги и цены"'))
                ->placeholder(__('Изображения слайдера')),
        ];
    }
}
