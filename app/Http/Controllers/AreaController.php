<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\AreaRepository\IAreaRepository;
use App\Area;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AreaExport;

class AreaController extends Controller
{
    private $areaRepository;

    public function __construct(IAreaRepository $areaRepository)
    {
        $this->areaRepository = $areaRepository;
    }

    public function index()
    {
        $areas = $this->areaRepository->getAllArea();
        $areaTables = Area::where('status','1')->orderBy('name','asc')->get();
        return view('area/index',compact('areas','areaTables'));
    }

    public function store(Request $request)
    {
        $this->areaRepository->validatorArea($request);
        return $this->areaRepository->addArea($request);
    }

    public function update(Request $request, $id)
    {
        $this->areaRepository->validatorArea($request);
        return $this->areaRepository->updateArea($request,$id);
    }

    public function delete($id)
    {
        return $this->areaRepository->deleteArea($id);
    }
}
