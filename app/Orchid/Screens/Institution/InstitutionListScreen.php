<?php

namespace App\Orchid\Screens\Institution;

use App\Models\Institution;
use App\Orchid\Layouts\Institution\InstitutionListLayout;
use App\Orchid\Layouts\Institution\InstitutionMainPageLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class InstitutionListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'institutions' => Institution::filters()->defaultSort('id')->whereIn('type', Institution::getTypes())->paginate(),
            'main_page' => Institution::whereNotIn('type', Institution::getTypes())->paginate(),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Заведения';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make(__('Добавить'))
                ->icon('bs.plus-circle')
                ->route('platform.systems.institutions.create'),
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            InstitutionListLayout::class,
            InstitutionMainPageLayout::class,
        ];
    }

    public function remove(Request $request): void
    {
        Institution::findOrFail($request->get('id'))->delete();

        Toast::info(__('Заведение было успешно удалено'));
    }
}
