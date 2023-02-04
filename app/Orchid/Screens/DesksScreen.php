<?php

namespace App\Orchid\Screens;


use App\Models\Desk;
use App\Models\Qr;
use Orchid\Support\Facades\Toast;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Layout;



class DesksScreen extends Screen
{
    public function query(): iterable
    {
        $Desks = Desk::with('qrs')->get();
        return ['desks' => $Desks];
    }

    public function name(): ?string
    {
        return 'Столы и QR-коды';
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::table('desks', [
                TD::make('', '')->render(function ($desk) {
                    return CheckBox::make("selected[{$desk->id}]");
                })->width(10)->cantHide(),
                TD::make('name', 'Название')->cantHide(),
                TD::make('qrs', "QR-коды")
                    ->render(function ($Desk) {
                        $result = [];
                        foreach ($Desk->qrs as $qr) {
                            $result[] .= '<span class="inline" title="Добавлен ' . $qr->created_at .'">'
                                            . $qr['code']
                                            . Button::make('')->method('deleteQr', ['qrid'=>$qr->id])->icon('close')->class('border-0 bg-white narrow')
                                     . '</span> ';
                        }
                        $result = implode(', ', $result);
                        return $result;
                    })->cantHide(),
            ]),

            Layout::rows([
                Input::make('name')
                    ->title('Добавить новый стол')
                    ->placeholder('Укажите номер или название стола'),
                Button::make('Сохранить')->method('SaveNewDesk')->class('btn btn-primary')
            ]),
        ];
    }

    /**
     * Button commands.
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Добавить стол')->method('createDesk'),
            Button::make('Создать QR-коды')->method('createQrs'),
            Button::make('Удалить столы')->method('deleteDesks')
        ];
    }

    public function SaveNewDesk() {
        $validated = request()->validate(['name'=>'']);
        $name = $validated['name'];
        if (Desk::where(['name'=> $name])->first()) {
            Toast::error("Стол с именем $name уже существует!" );
        } else {
            Desk::create(['name' => $name]);
            Toast::success("Стол с именем $name добавлен" );
        }
    }

    public function asyncGetData(int $desk_id): array
    {
        if ($Desk = Desk::find($desk_id)) {
            if ($Desk->company_id == \session('company_id'))
                return $Desk->toArray();
        } else return [];
    }


    public function createDesk() {
        Toast::success("Потом добавим стол")->delay(100000);
    }

    public function createQrs() {
        $count = 0;
        foreach (request('selected', []) as $id => $value) {
            Qr::create([
                'code' => rand(),
                'desk_id' => $id
            ]);
            $count++;
        }
        Toast::success("Создано QR-кодов: $count");
    }

    public function deleteDesks() {
        $count = 0;
        foreach (request('selected') as $id => $value) {
            Desk::find($id)->delete();
            $count++;
        }
        Toast::success("Удалено столов: $count");
    }

    public function deleteQr($qrid) {
        if ($Qr = Qr::find($qrid)) {
            $Qr->delete();
            Toast::success("Удалён QR-код {$Qr->code} стола '{$Qr->desk->name}'");
        } else {
            Toast::success("Не найден объект qr_id {$qrid} или нет прав на него");
        }
    }
}
