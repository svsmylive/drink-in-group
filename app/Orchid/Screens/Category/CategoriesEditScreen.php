<?php

namespace App\Orchid\Screens\Category;

use App\Http\Requests\SaveCategoryRequest;
use App\Models\Category;
use App\Orchid\Layouts\Category\CategoryEditLayout;
use Illuminate\Http\RedirectResponse;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class CategoriesEditScreen extends Screen
{
    /**
     * @var Category
     */
    public $category;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Category $category): iterable
    {
        $category->load('dishes.institution');

        return [
            'category' => $category
        ];
    }

    /**
     * The name of the screen displayed in the header.
     */
    public function name(): ?string
    {
        return $this->category->exists ? 'Редактирование категории' : 'Создание категории';
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
            Layout::block(CategoryEditLayout::class)
                ->title(__('Категории'))
                ->description(__('Форма редактирования категории'))
                ->vertical()
                ->commands(
                    Button::make(__('Save'))
                        ->type(Color::BASIC)
                        ->icon('bs.check-circle')
                        ->canSee($this->category->exists)
                        ->method('save')
                ),
        ];
    }

    public function save(Category $category, SaveCategoryRequest $request): RedirectResponse
    {
        $data = $request->validated()['category'];

        $category->update($data);

        Toast::info(__('Успешно!'));

        return redirect()->route('platform.systems.categories');
    }

    /**
     * @param Category $category
     * @return RedirectResponse
     */
    public function remove(Category $category): RedirectResponse
    {
        $category->delete();

        Toast::info(__('Удалено успешно'));

        return redirect()->route('platform.systems.categories');
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
                ->canSee($this->category->exists),
        ];
    }
}
