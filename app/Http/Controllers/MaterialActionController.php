<?php

namespace App\Http\Controllers;




use App\Repositories\MaterialActionRepository\IMaterialActionRepository;

use Illuminate\Http\Request;

class MaterialActionController extends Controller
{
    private $materialActionRepository;

    public function __construct(IMaterialActionRepository $materialActionRepository)
    {
        $this->materialActionRepository = $materialActionRepository;
    }

    public function index()
    {
        return $this->materialActionRepository->showIndex();
    }

    public function viewStore($id)
    {
        return $this->materialActionRepository->viewStoreMaterialAction($id);
    }
    public function store(Request $request,$id)
    {
        return $this->materialActionRepository->storeMaterialAction($request,$id);
    }

    public function showMoreDetail($id)
    {
        return $this->materialActionRepository->showMoreDetailById($id);
    }

    public function viewUpdate($id)
    {
        return $this->materialActionRepository->showViewUpdateMaterialAction($id);
    }

    public function update(Request $request, $id)
    {
        return $this->materialActionRepository->updateMaterialAction($request,$id);
    }

    public function delete($id)
    {
        return $this->materialActionRepository->deleteMaterialAction($id);
    }
}
