<?php

namespace App\Orchid\Screens;

use App\Models\Company;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Screen;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\Cropper;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Toast;

class CompanyScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable
    {
        $id = session('company_id');
        return Company::find($id)->toArray();
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Настройки ресторана';
    }

    public function description(): ?string
    {
        return "Название, адрес, телефон, описание и т.д.";
    }

    /**
     * Views.
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::rows([
                Input::make('name')
                    ->title('Название')
                    ->required()
                    ->placeholder('')
                    ->help('Укажите название ресторана, как оно известно вашим гостям'),
                Quill::make('description')
                    ->title('Описание')
                    ->placeholder('')
                    ->help('Это описание будет размещено на главной странице вашего сайта'),
                CheckBox::make('hasDelivery')->title('Есть доставка')->value(1)->sendTrueOrFalse()->horizontal(),
                TextArea::make('deliveryTerm')->help('Опишите условия доставки'),
                CheckBox::make('hasDelivery')->title('Есть самовывоз')->value(1)->sendTrueOrFalse()->horizontal(),
                Cropper::make('picture')
                    ->acceptedFiles('.jpg')
        ])
        ];
    }

    /**
     * Button commands.
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Сохранить')->method('save'),
        ];
    }

    public function save(): void
    {
        $validated = request()->validate([
            'name' => 'required',
            'description' => '',
            'hasDelivery' => 'boolean',
            'deliveryTerm' => '',
            'hasPickup' => 'boolean',
            'pickupTerm' => ''
        ]);
        if ($Company = Company::find(session('company_id'))) {
            $Company->Update($validated);
            Toast::success('Сведения сохранены');
        } else Toast::error("Не найден ресторан с кодом '{demo}'");
    }
}
