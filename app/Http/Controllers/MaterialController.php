<?php

namespace App\Http\Controllers;

use App\Material;
use Illuminate\Http\Request;
use App\Repositories\MaterialRepository\IMaterialRepository;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MaterialExport;

class MaterialController extends Controller
{
    private $materialRepository;

    public function __construct(IMaterialRepository $materialRepository)
    {
        $this->materialRepository = $materialRepository;
    }

    public function index()
    {
        return $this->materialRepository->showMaterial();
    }

    public function store(Request $request)
    {
        $this->materialRepository->validatorRequestStore($request);
        return $this->materialRepository->addMaterial($request);
    }
    public function search(Request $request)
    {
        return $this->materialRepository->searchMaterial($request);
    }
    public function updateName(Request $request, $id)
    {
        $this->materialRepository->validatorRequestUpdate($request);
        return $this->materialRepository->updateNameMaterial($request,$id);
    }
    public function updateGroup(Request $request, $id)
    {
       return $this->materialRepository->updateGroupMaterial($request,$id);
    }
    public function delete($id)
    {
        return $this->materialRepository->deleteMaterial($id);
    }

    public function exportExcel()
    {
        return Excel::download(new MaterialExport,'material.xlsx');
    }
}
