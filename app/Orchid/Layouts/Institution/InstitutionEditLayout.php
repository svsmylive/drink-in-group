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

            Input::make('institution.menu')
                ->type('file')
                ->title(__('Меню PDF'))
                ->placeholder(__('Меню PDF'))
                ->help('Название файла меню должно быть уникальным'),

            Input::make('institution.menu_link')
                ->type('text')
                ->title(__('Ссылка на меню'))
                ->readonly()
                ->placeholder(__('Ссылка на меню')),

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
                ->placeholder(__('Активность'))
                ->help('Будет ли заведение активно'),

            Upload::make('institution.attachment')
                ->title(__('Изображения слайдера'))
                ->placeholder(__('Изображения слайдера')),

            TextArea::make('institution.about_detail_text')
                ->title(__('Детальный текст'))
                ->placeholder(__('Детальный текст'))
                ->rows(5),
        ];
    }

}
