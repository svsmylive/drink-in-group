<?php

namespace App\Orchid\Layouts\Institution;

use App\Models\Institution;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Persona;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class InstitutionMainPageLayout extends Table
{
    /**
     * @var string
     */
    public $target = 'main_page';

    protected function columns(): iterable
    {
        return [
            TD::make('name', __('Название'))
                ->sort()
                ->cantHide()
                ->filter(Input::make())
                ->render(fn(Institution $institution) => new Persona($institution->presenter())),

            TD::make('title', __('Title'))
                ->sort(),

            TD::make('description', __('Description'))
                ->sort(),

            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(fn(Institution $institution) => DropDown::make()
                    ->icon('bs.three-dots-vertical')
                    ->list([
                        Link::make(__('Редактировать'))
                            ->route('platform.systems.institutions.main.edit', $institution->id)
                            ->icon('bs.pencil'),
                    ])),
        ];
    }
}
