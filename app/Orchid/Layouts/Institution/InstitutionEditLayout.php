<?php

namespace App\Orchid\Layouts\Institution;

use App\Models\Institution;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Layouts\Rows;

class InstitutionEditLayout extends Rows
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

            Select::make('institution.type')
                ->options(Institution::getTypes())->title(__('Тип заведения'))
                ->help('Тип заведения'),

            CheckBox::make('institution.has_booking')
                ->title(__('Активность кнопки бронирования'))
                ->sendTrueOrFalse()
                ->placeholder(__('Активность кнопки бронирования'))
                ->help('Будет ли в заведении кнопка забронировать активна'),

            CheckBox::make('institution.has_delivery')
                ->title(__('Активность доставки'))
                ->sendTrueOrFalse()
                ->placeholder(__('Активность доставки'))
                ->help('Активность доставки (если настроена интеграция Tillypad)'),

            Input::make('institution.city')
                ->type('text')
                ->title(__('Город'))
                ->placeholder(__('Город')),

            Input::make('institution.address')
                ->type('text')
                ->title(__('Адрес'))
                ->placeholder(__('Адрес')),

            Input::make('institution.full_address')
                ->type('text')
                ->title(__('Полный адрес'))
                ->placeholder(__('Город, улица')),

            Upload::make('institution.attachment')
                ->groups('menu')
                ->maxFiles(1)
                ->acceptedFiles('application/pdf')
                ->title(__('Меню PDF'))
                ->placeholder(__('Меню PDF')),

            Input::make('institution.time_of_work')
                ->type('text')
                ->title(__('Время работы'))
                ->placeholder(__('Время работы')),

            Input::make('institution.phone')
                ->type('text')
                ->mask('+9(999) 999-9999')
                ->title(__('Телефон'))
                ->placeholder(__('Телефон')),

            CheckBox::make('institution.active')
                ->title(__('Активность'))
                ->sendTrueOrFalse()
                ->placeholder(__('Активность'))
                ->help('Будет ли заведение активно'),

            Upload::make('institution.attachment')
                ->groups('logo')
                ->maxFiles(1)
                ->acceptedFiles('image/*,application/pdf,.psd')
                ->title(__('Логотип заведения'))
                ->placeholder(__('Логотип заведения')),

            Upload::make('institution.attachment')
                ->groups('sliderImagesDesktop')
                ->title(__('Изображения слайдера Desktop'))
                ->placeholder(__('Изображения слайдера desktop')),

            Upload::make('institution.attachment')
                ->groups('sliderImagesMobile')
                ->title(__('Изображения слайдера Mobile'))
                ->placeholder(__('Изображения слайдера mobile')),

            Input::make('institution.title')
                ->type('text')
                ->title(__('SEO Title'))
                ->placeholder(__('seo title')),

            TextArea::make('institution.description')
                ->title(__('SEO Description'))
                ->rows(3)
                ->placeholder(__('seo description')),

            Input::make('institution.url')
                ->type('text')
                ->title(__('SEO url'))
                ->placeholder(__('seo url')),

            TextArea::make('institution.about_detail_text_header')
                ->title(__('Детальный текст на странице "О ресторане" Header'))
                ->placeholder(__('about detail text header'))
                ->rows(6),

            TextArea::make('institution.about_detail_text_body')
                ->title(__('Детальный текст на странице "О ресторане" Body'))
                ->placeholder(__('about detail text body'))
                ->rows(6),

            TextArea::make('institution.about_detail_text_footer')
                ->title(__('Детальный текст на странице "О ресторане" Footer'))
                ->placeholder(__('about detail text footer'))
                ->rows(6),

            TextArea::make('institution.event_text_header')
                ->title(__('"События" header текст'))
                ->placeholder(__('event text header'))
                ->rows(6),

            TextArea::make('institution.event_text_footer')
                ->title(__('"События" Footer текст'))
                ->placeholder(__('event text footer'))
                ->rows(6),

            Upload::make('institution.attachment')
                ->groups('detailImages')
                ->title(__('Изображения на детальной странице'))
                ->placeholder(__('Изображения на детальной странице')),
        ];
    }
}
