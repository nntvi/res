<?php

namespace App\Http\Controllers;

use App\Dishes;
use App\Repositories\DishRepository\IDishRepository;
use App\Unit;
use Illuminate\Http\Request;

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
        $dishes = Dishes::with('groupMenu.cookArea','unit')->get();

        return view('dishes.index',compact('dishes','groupmenus'));
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

    public function viewUpdate($id)
    {
        $dish = $this->dishesRepository->showUpdateDish($id);
        $groupmenus = $this->dishesRepository->getGroupMenu();
        $units = $this->dishesRepository->getUnit();
        $materials = $this->dishesRepository->getMaterial();
        return view('dishes.update',compact('dish','groupmenus','units','materials'));
    }

    public function update(Request $request, $id)
    {
        // $this->dishesRepository->validatorRequestUpdate($request);
        return $this->dishesRepository->updateDish($request,$id);
    }

    public function search(Request $request)
    {
        $this->dishesRepository->validatorRequestSearch($request);
        $dishes = $this->dishesRepository->searchDish($request);
        $groupmenus = $this->dishesRepository->getGroupMenu();
        return view('dishes.search',compact('dishes','groupmenus'));
    }

    public function delete($id)
    {
        return $this->dishesRepository->deleteDish($id);
    }
}
