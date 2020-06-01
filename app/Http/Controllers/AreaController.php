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
        return $this->areaRepository->getAllArea();
    }

    public function store(Request $request)
    {
        $this->areaRepository->validatorRequestStore($request);
        return $this->areaRepository->addArea($request);
    }

    public function update(Request $request, $id)
    {
        $this->areaRepository->validatorRequestUpdate($request);
        return $this->areaRepository->updateArea($request,$id);
    }

    public function delete($id)
    {
        return $this->areaRepository->deleteArea($id);
    }
}
