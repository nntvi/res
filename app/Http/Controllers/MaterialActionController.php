<?php

namespace App\Http\Controllers;




use App\Repositories\MaterialActionRepository\IMaterialActionRepository;
use App\Helper\ICheckAction;
use Illuminate\Http\Request;

class MaterialActionController extends Controller
{
    private $materialActionRepository;
    private $checkAction;

    public function __construct(ICheckAction $checkAction, IMaterialActionRepository $materialActionRepository)
    {
        $this->checkAction = $checkAction;
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
        //dd($request->all());
        return $this->materialActionRepository->storeMaterialAction($request,$id);
    }

    public function showMoreDetail($id)
    {
        return $this->materialActionRepository->showMoreDetailById($id);
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
