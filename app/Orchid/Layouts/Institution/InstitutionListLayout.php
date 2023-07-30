<?php

namespace App\Orchid\Layouts\Institution;

use App\Models\Institution;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Components\Cells\Boolean;
use Orchid\Screen\Components\Cells\DateTimeSplit;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Persona;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class InstitutionListLayout extends Table
{
    /**
     * @var string
     */
    public $target = 'institutions';

    protected function columns(): iterable
    {
        return [
            TD::make('name', __('Название'))
                ->sort()
                ->cantHide()
                ->filter(Input::make())
                ->render(fn(Institution $institution) => new Persona($institution->presenter())),

            TD::make('active', __('Активность'))
                ->usingComponent(Boolean::class)
                ->sort(),

            TD::make('type', __('Тип заведения'))
                ->defaultHidden()
                ->sort(),

            TD::make('full_address', __('Адрес'))
                ->sort(),

            TD::make('time_of_work', __('Время работы'))
                ->sort(),

            TD::make('phone', __('Телефон'))
                ->defaultHidden()
                ->sort(),

            TD::make('created_at', __('Дата создания'))
                ->usingComponent(DateTimeSplit::class)
                ->align(TD::ALIGN_RIGHT)
                ->defaultHidden()
                ->sort(),

            TD::make('updated_at', __('Дата обновления'))
                ->usingComponent(DateTimeSplit::class)
                ->align(TD::ALIGN_RIGHT)
                ->sort(),

            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(fn(Institution $institution) => DropDown::make()
                    ->icon('bs.three-dots-vertical')
                    ->list([
                        Link::make(__('Редактировать'))
                            ->route('platform.systems.institutions.edit', $institution->id)
                            ->icon('bs.pencil'),
                        Button::make(__('Удалить'))
                            ->icon('bs.trash3')
                            ->confirm(__('Подтверждение удаления'))
                            ->method('remove', [
                                'id' => $institution->id,
                            ]),
                    ])),
        ];
    }
}
