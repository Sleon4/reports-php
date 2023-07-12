<?php

namespace App\Http\Controllers;

use App\Models\UsersModel;
use Dompdf\Dompdf;
use LionFiles\Store;
use LionRequest\Request;
use LionSpreadsheet\Spreadsheet;

class ReportsController {

    private UsersModel $usersModel;

    public function __construct() {
        $this->usersModel = new UsersModel();
    }

    public function spreadsheet() {
        $cont = 2;
        Spreadsheet::load(storage_path("templates/template-report.xlsx"));

        foreach ($this->usersModel->readUsersDB() as $key => $user) {
            Spreadsheet::setCell("A{$cont}", $user->getIdusers());
            Spreadsheet::setCell("B{$cont}", $user->getUsersName());
            Spreadsheet::setCell("C{$cont}", $user->getUsersLastname());
            $cont++;
        }

        Spreadsheet::save(storage_path("templates/report.xlsx"));
        Spreadsheet::download(storage_path("templates/"), "report.xlsx");
    }

    public function pdf() {
        $items = "";
        foreach ($this->usersModel->readUsersDB() as $key => $user) {
            $id = "<td>{$user->getIdusers()}</td>";
            $name = "<td>{$user->getUsersName()}</td>";
            $lastname = "<td>{$user->getUsersLastname()}</td>";
            $items .= "<tr>{$id}{$name}{$lastname}</tr>";
        }

        $file = Store::get(storage_path("templates/template-report.html"));
        $dompdf = new Dompdf();
        $dompdf->loadHtml(str->of($file)->replace("--REPLACE--", $items)->get());
        $dompdf->setPaper('A4');
        $dompdf->render();
        file_put_contents(storage_path("templates/report.pdf"), $dompdf->output());

        Request::header("Content-Type", "application/pdf");
        Request::header("Content-Disposition", 'attachment; filename="report.pdf"');
        Request::header("Content-Length", filesize(storage_path("templates/report.pdf")));
        readfile(storage_path("templates/report.pdf"));
        unlink(storage_path("templates/report.pdf"));
    }

}
