<?php

namespace App\Http\Controllers;

use App\MaterialAction;
use App\MaterialDetail;
use App\Repositories\MaterialDetailRepository\IMaterialDetailRepository;
use Illuminate\Http\Request;

class MaterialDetailController extends Controller
{
    private $materialDetailRepository;

    public function __construct(IMaterialDetailRepository $materialDetailRepository)
    {
        $this->materialDetailRepository = $materialDetailRepository;
    }

    public function index()
    {
        return $this->materialDetailRepository->showMaterialDetail();
    }

    public function store(Request $request)
    {
        $this->materialDetailRepository->validatorRequestStore($request);
        return $this->materialDetailRepository->addMaterialDetail($request);
    }

    public function update(Request $request,$id)
    {
        $this->materialDetailRepository->validatorRequestUpdate($request);
        return $this->materialDetailRepository->updateMaterialDetail($request,$id);
    }

    public function updateName(Request $request,$id)
    {
        $this->materialDetailRepository->validatorRequestUpdate($request);
        return  $this->materialDetailRepository->updateNameMaterialDetail($request,$id);
    }
    public function updateType(Request $request,$id)
    {
        return $this->materialDetailRepository->updateTypeMaterialDetail($request,$id);
    }
    public function search(Request $request)
    {
        return $this->materialDetailRepository->searchMaterialDetail($request);
    }

    public function delete($id)
    {
        return $this->materialDetailRepository->deleteMaterialDetail($id);
    }


}
