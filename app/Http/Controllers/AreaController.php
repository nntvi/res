<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\AreaRepository\IAreaRepository;
use App\Area;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AreaExport;
use App\Helper\ICheckAction;
class AreaController extends Controller
{
    private $areaRepository;
    private $checkAction;

    public function __construct(ICheckAction $checkAction, IAreaRepository $areaRepository)
    {
        $this->areaRepository = $areaRepository;
        $this->checkAction = $checkAction;
    }

    public function index()
    {
        $result = $this->checkAction->getPermission(auth()->id());
        $check = $this->areaRepository->checkRoleIndex($result);
        if($check != 0){
            $areas = $this->areaRepository->getAllArea();
            $areaTables = Area::where('status','1')->orderBy('name','asc')->get();
            return view('area/index',compact('areas','areaTables'));
        }else{
            return view('layouts')->withErrors('Bạn không thuộc quyền truy cập chức năng này');
        }
    }

    public function store(Request $request)
    {
        $result = $this->checkAction->getPermission(auth()->id());
        $check = $this->areaRepository->checkRoleStore($result);
        if($check != 0){
            $this->areaRepository->validatorArea($request);
            return $this->areaRepository->addArea($request);
        }else{
            return view('layouts')->withErrors('Bạn không thuộc quyền truy cập chức năng này');
        }
    }

    public function update(Request $request, $id)
    {
        $result = $this->checkAction->getPermission(auth()->id());
        $check = $this->areaRepository->checkRoleUpdate($result);
        if($check != 0){
            $this->areaRepository->validatorArea($request);
            return $this->areaRepository->updateArea($request,$id);
        }else{
            return view('layouts')->withErrors('Bạn không thuộc quyền truy cập chức năng này');
        }
    }

    public function delete($id)
    {
        $result = $this->checkAction->getPermission(auth()->id());
        $check = $this->areaRepository->checkRoleDelete($result);
        if($check != 0){
            return $this->areaRepository->deleteArea($id);
        }else{
            return view('layouts')->withErrors('Bạn không thuộc quyền truy cập chức năng này');
        }

    }
}
