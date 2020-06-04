<?php

namespace App\Http\Controllers;

use App\Dishes;
use App\Repositories\DishRepository\IDishRepository;
use App\Unit;
use Illuminate\Http\Request;
use App\Exports\DishExport;
use Maatwebsite\Excel\Facades\Excel;

class DishesController extends Controller
{
    private $dishesRepository;

    public function __construct(IDishRepository $dishesRepository)
    {
        $this->dishesRepository = $dishesRepository;
    }

    public function index()
    {
        $groupmenus = $this->dishesRepository->getGroupMenu();
        $dishes = Dishes::with('material.groupMenu.cookArea','unit')->paginate(10);
        $units = $this->dishesRepository->getUnit();
        return view('dishes.index',compact('dishes','groupmenus','units'));
    }
    public function viewStore()
    {
        $groupmenus = $this->dishesRepository->getGroupMenu();
        $units = $this->dishesRepository->getUnit();
        $materialDetails = $this->dishesRepository->getMaterialDetail();
        $materials = $this->dishesRepository->getMaterial();
        return view('dishes.store',compact('groupmenus','units','materialDetails','materials'));
    }

    public function store(Request $request)
    {
        $this->dishesRepository->validatorRequestStore($request);
        return $this->dishesRepository->addDish($request);
    }

    public function updateImage(Request $request,$id)
    {
        $this->dishesRepository->validateImage($request);
        return $this->dishesRepository->updateImageDish($request,$id);
    }

    public function updateSalePrice(Request $request,$id)
    {
        return $this->dishesRepository->updateSalePriceDish($request,$id);
    }

    public function updateUnit(Request $request,$id)
    {
        return $this->dishesRepository->updateUnitDish($request,$id);
    }

    public function updateStatus(Request $request,$id)
    {
        return $this->dishesRepository->updateStatusDish($request,$id);
    }
    public function search(Request $request)
    {
        return $this->dishesRepository->searchDish($request);
    }

    public function delete($id)
    {
        return $this->dishesRepository->deleteDish($id);
    }

    public function exportExcel()
    {
        return Excel::download(new DishExport,'dishes.xlsx');
    }
}
