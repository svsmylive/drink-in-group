<?php

namespace App\Orchid\Screens\Event;

use App\Actions\SaveEventAction;
use App\Http\Requests\SaveEventRequest;
use App\Models\Event;
use App\Orchid\Layouts\Event\EventEditLayout;
use Illuminate\Http\RedirectResponse;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class EventsEditScreen extends Screen
{
    /**
     * @var Event
     */
    public $event;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Event $event): iterable
    {
        $event->load('attachment');

        return [
            'event' => $event
        ];
    }

    /**
     * The name of the screen displayed in the header.
     */
    public function name(): ?string
    {
        return $this->event->exists ? 'Редактирование события' : 'Создание события';
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
            Layout::block(EventEditLayout::class)
                ->title(__('События'))
                ->description(__('Форма создания события'))
                ->vertical()
                ->commands(
                    Button::make(__('Save'))
                        ->type(Color::BASIC)
                        ->icon('bs.check-circle')
                        ->canSee($this->event->exists)
                        ->method('save')
                ),
        ];
    }

    public function save(Event $event, SaveEventAction $action, SaveEventRequest $request): RedirectResponse
    {
        $action->execute($event, $request->all());

        Toast::info(__('Создано успешно'));

        return redirect()->route('platform.systems.events');
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
                ->canSee($this->event->exists),
        ];
    }
}
