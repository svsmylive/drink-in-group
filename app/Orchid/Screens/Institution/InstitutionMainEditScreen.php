<?php

namespace App\Orchid\Screens\Institution;

use App\Models\Institution;
use App\Orchid\Layouts\Institution\InstitutionMainPageEditLayout;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class InstitutionMainEditScreen extends Screen
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
        return [
            'institution' => $institution,
        ];
    }

    /**
     * The name of the screen displayed in the header.
     */
    public function name(): string
    {
        return 'Редактирование SEO главной страницы с заведениями';
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
        $layouts = [
            Layout::block(InstitutionMainPageEditLayout::class)
                ->title(__('Main page SEO'))
                ->vertical()
                ->commands(
                    Button::make(__('Save'))
                        ->type(Color::BASIC)
                        ->icon('bs.check-circle')
                        ->canSee($this->institution->exists)
                        ->method('save')
                ),
        ];

        return $layouts;
    }

    public function save(Institution $institution, Request $request): RedirectResponse
    {
        $data = $request->get('institution');
        $institution->update(Arr::only($data, Institution::FILLABLE));

        Toast::info(__('Создано успешно'));

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
        ];
    }
}
