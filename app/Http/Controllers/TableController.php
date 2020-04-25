<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Repositories\TableRepository\ITableRepository;
use App\Exports\TableExport;
use Maatwebsite\Excel\Facades\Excel;

class TableController extends Controller
{
    private $tableRepository;

    public function __construct(ITableRepository $tableRepository)
    {
        $this->tableRepository = $tableRepository;
    }

    public function index()
    {
       return $this->tableRepository->getAllTable();
    }

    public function store(Request $request)
    {
        $this->tableRepository->validatorRequestStore($request);
        return $this->tableRepository->addTable($request);
    }

    public function updateName(Request $request,$id)
    {
        $this->tableRepository->validatorRequestStore($request);
        return $this->tableRepository->updateNameTable($request,$id);
    }

    public function updateArea(Request $request,$id)
    {
        return $this->tableRepository->updateArea($request,$id);
    }

    public function search(Request $request)
    {
        return $this->tableRepository->searchTable($request);
    }
    public function delete($id)
    {
        return $this->tableRepository->deleteTable($id);
    }

    public function exportExcel()
    {
        return Excel::download(new TableExport,'table.xlsx');
    }
}
