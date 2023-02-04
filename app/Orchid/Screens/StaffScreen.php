<?php

namespace App\Orchid\Screens;

use App\Models\Staff;
use Illuminate\Support\Facades\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Support\Facades\Toast;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Screen\Fields\Input;



class StaffScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable
    {
        $staff = Staff::all();
        return ['staff' => $staff];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Сотрудники';
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::table('staff', [
                TD::make('name', 'Имя')->width("250px")->cantHide(),
                TD::make('phone', 'Телефон')->width("450px")->cantHide(),
                TD::make('description', 'Описание')->width("450px")->cantHide(),
                TD::make('', 'Действия')->width("200px")->cantHide()
                    ->render(function ($staff) {
                        return Button::make('Удалить')->method('delete', ["id"=>$staff->id])->class('btn') .
                               ModalToggle::make('Редактировать')
                                   ->modal('editStaff')
                                   ->method('Save')->class('btn')
                                   ->asyncParameters($staff->id);
                    }),
            ]),
            Layout::modal('editStaff', [
                Layout::rows([
                    Input::make('id')->type('hidden'),
                    Input::make('name')->title('Имя')->horizontal()->required(),
                    Input::make('phone')->title('Телефон')->horizontal()->required(),
                    Input::make('description')->title('Описание')->horizontal()
                ]),
              ])->title('Сотрудник')
                ->applyButton('Сохранить')->method('Save')
                ->closeButton('Отменить')
                ->async('asyncGetStuffData')
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
            ModalToggle::make('Добавить')->modal('editStaff')->method('Save')
        ];
    }

    public function asyncGetStuffData(int $staff_id): array
    {
        if ($Staff = Staff::find($staff_id)) {
            if ($Staff->company_id == \session('company_id'))
                return $Staff->toArray();
        }
    }

    public function Save() {
        $validated = Request::validate([
            'id' => 'numeric|nullable',
            'name' => '',
            'phone' => '',
            'description' => ''
        ]);
        $id = $validated['id'];
        if (!$id) {
            Staff::Create($validated);
            Toast::success("Информация о сотруднике добавлена");
        } elseif ($Staff = Staff::find($id)) {
            $Staff->update($validated);
            Toast::success("Информация о сотруднике сохранена");
        } else Toast::Error("Не найден объект staff_id = {$id} или нет прав на него");
    }

    public function delete($id) {
        if ($Staff = Staff::find($id)) {
            $Staff->delete();
            Toast::success("Информация о сотруднике {$Staff->name} удалена  из системы.");
        } else {
            Toast::Error("Не найден объект staff_id = {$id} или нет прав на него");
        }
    }
}
