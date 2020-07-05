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
        $this->tableRepository->validateCodeTable($request);
        $this->tableRepository->validatorNameTable($request);
        return $this->tableRepository->addTable($request);
    }

    public function updateName(Request $request,$id)
    {
        $this->tableRepository->validatorNameTable($request);
        $this->tableRepository->updateNameTable($request,$id);
        return redirect(route('area.index'))->withSuccess('Cập nhật tên bàn thành công');
    }

    public function updateArea(Request $request,$id)
    {
        $this->tableRepository->updateAreaTable($request,$id);
        return redirect(route('area.index'))->withSuccess('Chuyển khu vực thành công');
    }

    public function updateChair(Request $request,$id)
    {
        $this->tableRepository->updateChair($request,$id);
        return redirect(route('area.index'))->withSuccess('Cập nhật số lượng ghế thành công');
    }
    public function search(Request $request)
    {
        return $this->tableRepository->searchTable($request);
    }
    public function delete($id)
    {
        return $this->tableRepository->deleteTable($id);
    }
}
