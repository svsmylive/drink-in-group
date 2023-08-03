<?php

namespace App\Orchid\Screens\Institution;

use App\Actions\SaveInstitutionAction;
use App\Http\Requests\SaveInstitutionRequest;
use App\Models\Institution;
use App\Orchid\Layouts\Institution\InstitutionEditLayout;
use App\Orchid\Layouts\Institution\InstitutionEventsLayout;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class InstitutionEditScreen extends Screen
{
    /**
     * @var Institution
     */
    public $institution;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Institution $institution): iterable
    {
        $institution->load(['attachment', 'events']);

        return [
            'institution' => $institution,
            'events' => $institution->events
        ];
    }

    /**
     * The name of the screen displayed in the header.
     */
    public function name(): ?string
    {
        return $this->institution->exists ? 'Редактирование заведения' : 'Создание заведения';
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
            Layout::block(InstitutionEditLayout::class)
                ->title(__('Общая информация о заведении'))
                ->vertical()
                ->commands(
                    Button::make(__('Save'))
                        ->type(Color::BASIC)
                        ->icon('bs.check-circle')
                        ->canSee($this->institution->exists)
                        ->method('save')
                ),
            Layout::block(InstitutionEventsLayout::class)
                ->title(__('События'))
                ->description(__('Собития в заведении'))
                ->vertical()
                ->commands(
                    Button::make(__('Save'))
                        ->type(Color::BASIC)
                        ->icon('bs.check-circle')
                        ->canSee($this->institution->exists)
                        ->method('save')
                ),
        ];
    }

    public function save(Institution $institution, SaveInstitutionRequest $request, SaveInstitutionAction $action): RedirectResponse
    {
        $action->execute($institution, $request->validated());

        Toast::info(__('Создано успешно'));

        return redirect()->route('platform.systems.institutions');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     *
     */
    public function remove(Institution $institution): RedirectResponse
    {
        $institution->delete();

        Toast::info(__('Удалено успешно'));

        return redirect()->route('platform.systems.institutions');
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
                ->canSee($this->institution->exists),
        ];
    }
}
