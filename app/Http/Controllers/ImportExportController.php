<?php

namespace App\Http\Controllers;

use App\Exports\MenuExport;
use Maatwebsite\Excel\Facades\Excel;


class ImportExportController extends Controller
{
    public function ExportMenu() {
        return Excel::download(new MenuExport, 'menu.xlsx');
    }
}
