<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Repositories\TableRepository\ITableRepository;
use App\Exports\TableExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Helper\ICheckAction;
class TableController extends Controller
{
    private $tableRepository;
    private $checkAction;

    public function __construct(ICheckAction $checkAction, ITableRepository $tableRepository)
    {
        $this->checkAction = $checkAction;
        $this->tableRepository = $tableRepository;
    }

    public function index()
    {
       return $this->tableRepository->getAllTable();
    }

    public function store(Request $request)
    {
        $result = $this->checkAction->getPermission(auth()->id());
        $check = $this->tableRepository->checkRoleStore($result);
        if($check != 0){
            $this->tableRepository->validateCodeTable($request);
            $this->tableRepository->validateNameTable($request);
            return $this->tableRepository->addTable($request);
        }else{
            return view('layouts')->withErrors('Bạn không thuộc quyền truy cập chức năng này');
        }
    }

    public function updateName(Request $request,$id)
    {
        $result = $this->checkAction->getPermission(auth()->id());
        $check = $this->tableRepository->checkRoleUpdate($result);
        if($check != 0){
            $this->tableRepository->validateNameTable($request);
            $this->tableRepository->updateNameTable($request,$id);
            return redirect(route('area.index'))->withSuccess('Cập nhật tên bàn thành công');
        }else{
            return view('layouts')->withErrors('Bạn không thuộc quyền truy cập chức năng này');
        }

    }

    public function updateArea(Request $request,$id)
    {
        $result = $this->checkAction->getPermission(auth()->id());
        $check = $this->tableRepository->checkRoleUpdate($result);
        if($check != 0){
            $this->tableRepository->updateAreaTable($request,$id);
            return redirect(route('area.index'))->withSuccess('Chuyển khu vực thành công');
        }else{
            return view('layouts')->withErrors('Bạn không thuộc quyền truy cập chức năng này');
        }

    }

    public function updateChair(Request $request,$id)
    {
        $result = $this->checkAction->getPermission(auth()->id());
        $check = $this->tableRepository->checkRoleUpdate($result);
        if($check != 0){
            $this->tableRepository->updateChair($request,$id);
            return redirect(route('area.index'))->withSuccess('Cập nhật số lượng ghế thành công');
        }else{
            return view('layouts')->withErrors('Bạn không thuộc quyền truy cập chức năng này');
        }
    }

    public function delete($id)
    {
        $result = $this->checkAction->getPermission(auth()->id());
        $check = $this->tableRepository->checkRoleDelete($result);
        if($check != 0){
            $this->tableRepository->deleteTable($id);
            return redirect(route('area.index'))->withSuccess('Xóa bàn thành công');
        }else{
            return view('layouts')->withErrors('Bạn không thuộc quyền truy cập chức năng này');
        }
    }
}
