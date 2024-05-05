<?php

namespace App\Orchid\Layouts\Dish;

use App\Models\Dish;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Components\Cells\Boolean;
use Orchid\Screen\Components\Cells\DateTimeSplit;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Persona;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class DishListLayout extends Table
{
    /**
     * @var string
     */
    protected $target = 'dishes';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     * @throws \ReflectionException
     */
    protected function columns(): iterable
    {
        return [
            TD::make('category.name', __('Категория')),

            TD::make('institution.name', __('Заведение')),

            TD::make('name', __('Название'))
                ->sort()
                ->cantHide()
                ->filter(Input::make())
                ->render(fn(Dish $dish) => new Persona($dish->presenter())),


            TD::make('is_show', __('Активность'))
                ->usingComponent(Boolean::class)
                ->sort(),

            TD::make('price', __('Цена'))
                ->sort(),

            TD::make('updated_at', __('Дата обновления'))
                ->usingComponent(DateTimeSplit::class)
                ->align(TD::ALIGN_RIGHT)
                ->sort(),

            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(fn(Dish $dish) => DropDown::make()
                    ->icon('bs.three-dots-vertical')
                    ->list([
                        Link::make(__('Редактировать'))
                            ->route('platform.systems.dishes.edit', $dish->id)
                            ->icon('bs.pencil'),
                        Button::make(__('Удалить'))
                            ->icon('bs.trash3')
                            ->confirm(__('Подтверждение удаления'))
                            ->method('remove', [
                                'id' => $dish->id,
                            ]),
                    ])),
        ];
    }
}
