<?php

namespace App\Http\Controllers;

use App\Area;
use App\Table;
use Illuminate\Http\Request;
use App\Repositories\TableRepository\ITableRepository;

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

    public function viewStore()
    {
        return $this->tableRepository->viewAddTable();
    }

    public function store(Request $request)
    {
        $this->tableRepository->validatorRequestStore($request);
        return $this->tableRepository->addTable($request);
    }

    public function viewUpdate($id)
    {
        return $this->tableRepository->viewUpdateTable($id);
    }

    public function update(Request $request,$id)
    {
        $this->tableRepository->validatorRequestStore($request);
        return $this->tableRepository->updateTable($request,$id);
    }

    public function delete($id)
    {
        return $this->tableRepository->deleteTable($id);
    }
}
