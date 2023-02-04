<?php

namespace App\Orchid\Screens;

use App\Models\Book;
use App\Models\Category;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use \Orchid\Support\Facades\Layout;

class EditBookScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable
    {
        if ($b = Book::find(request('id'))) {
            return $b->toArray();
        } else return [];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return request()->has('id')?'Редактируем меню':'Добавляем меню';
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        $rows = [
            Input::make('id')->type('hidden'),
            Input::make('name')->title('Название')->required()
        ];
        if (!request()->has('id')) {
            $rows[] = TextArea::make('categories')
                ->title('Список категорий (по одной на строку)')
                ->help('Вы можете добавить или изменить категории позже')
                ->rows(5);
        };

        return [
            Layout::rows($rows)
        ];
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Сохранить')->method('save')
        ];
    }

    public function save() {
        if ($id = request('id')) {
            $book = Book::findOrFail($id);
            $book->update(['name'=>request('name')]);
        } else {
            $book = new Book(['name' => \request('name')]);
            $book->save();
            $categories = array_map(
                fn($name) => new Category(['name' => $name]),
                explode("\n", \request('categories'))
            );
            $book->categories()->saveMany($categories);
        }
        return redirect(route('platform.book', ['id' => $book->id]));
    }
}
