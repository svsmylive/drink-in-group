<?php

namespace App\Orchid\Screens\Dish;

use App\Models\Dish;
use App\Orchid\Layouts\Dish\DishListLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class DishesListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'dishes' => Dish::filters()->defaultSort('name')->with(['category', 'institution'])->paginate(30)
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Блюда';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [

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
            DishListLayout::class
        ];
    }

    public function remove(Request $request): void
    {
        Dish::findOrFail($request->get('id'))->delete();

        Toast::info(__('Блюдо было успешно удалено'));
    }
}
