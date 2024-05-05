<?php

namespace App\Orchid\Screens\Dish;

use App\Actions\SaveEventAction;
use App\Http\Requests\SaveDishRequest;
use App\Http\Requests\SaveEventRequest;
use App\Models\Dish;
use App\Models\Event;
use App\Orchid\Layouts\Dish\DishEditLayout;
use App\Orchid\Layouts\Event\EventEditLayout;
use Illuminate\Http\RedirectResponse;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class DishesEditScreen extends Screen
{
    /**
     * @var Dish
     */
    public $dish;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Dish $dish): iterable
    {
        $dish->load([
            'category',
            'institution',
            'attachment',
        ]);

        return [
            'dish' => $dish
        ];
    }

    /**
     * The name of the screen displayed in the header.
     */
    public function name(): ?string
    {
        return $this->dish->exists ? 'Редактирование блюда' : 'Создание блюда';
    }

    /**
     * Display header description.
     */
    public function description(): ?string
    {
        return '';
    }

    public function layout(): iterable
    {
        return [
            Layout::block(DishEditLayout::class)
                ->title(__('Блюда'))
                ->description(__('Форма редактирования блюда'))
                ->vertical()
                ->commands(
                    Button::make(__('Save'))
                        ->type(Color::BASIC)
                        ->icon('bs.check-circle')
                        ->canSee($this->dish->exists)
                        ->method('save')
                ),
        ];
    }

    public function save(Dish $dish, SaveDishRequest $request): RedirectResponse
    {
        $data = $request->validated()['dish'];

        if ($attachment = $data['attachment'] ?? null) {
            $dish->attachment()->sync($attachment);
        }

        $dish->update($data);

        Toast::info(__('Успешно!'));

        return redirect()->route('platform.systems.dishes');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     *
     */
    public function remove(Event $event): RedirectResponse
    {
        $event->delete();

        Toast::info(__('Удалено успешно'));

        return redirect()->route('platform.systems.events');
    }

    /**
     * The screen's action buttons.
     *
     * @return Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make(__('Сохранить'))
                ->icon('bs.check-circle')
                ->method('save'),
            Button::make(__('Удалить'))
                ->icon('bs.trash3')
                ->confirm(__('Подтверждение удаления'))
                ->method('remove')
                ->canSee($this->dish->exists),
        ];
    }
}
