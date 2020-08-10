<?php

namespace App\Http\Controllers;

use App\Dishes;
use App\Repositories\DishRepository\IDishRepository;
use App\Unit;
use Illuminate\Http\Request;
use App\Exports\DishExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Helper\ICheckAction;
class DishesController extends Controller
{
    private $dishesRepository;
    private $checkAction;

    public function __construct(ICheckAction $checkAction, IDishRepository $dishesRepository)
    {
        $this->checkAction = $checkAction;
        $this->dishesRepository = $dishesRepository;
    }

    public function index()
    {
        $result = $this->checkAction->getPermission(auth()->id());
        $check = $this->dishesRepository->checkRoleIndex($result);
        if($check != 0){
            $groupmenus = $this->dishesRepository->getGroupMenu();
            $dishes = Dishes::with('material.groupMenu.cookArea','unit')->where('stt','1')->get();
            $units = $this->dishesRepository->getUnit();
            return view('dishes.index',compact('dishes','groupmenus','units'));
        }else{
            return view('layouts')->withErrors('Bạn không thuộc quyền truy cập chức năng này');
        }
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
        $result = $this->checkAction->getPermission(auth()->id());
        $check = $this->dishesRepository->checkRoleStore($result);
        if($check != 0){
            $this->dishesRepository->validatorRequestStore($request);
            return $this->dishesRepository->addDish($request);
        }else{
            return view('layouts')->withErrors('Bạn không thuộc quyền truy cập chức năng này');
        }
    }

    public function updateImage(Request $request,$id)
    {
        $result = $this->checkAction->getPermission(auth()->id());
        $check = $this->dishesRepository->checkRoleUpdate($result);
        if($check != 0){
            $this->dishesRepository->validateImage($request);
            return $this->dishesRepository->updateImageDish($request,$id);
        }else{
            return view('layouts')->withErrors('Bạn không thuộc quyền truy cập chức năng này');
        }
    }

    public function updateSalePrice(Request $request,$id)
    {
        $result = $this->checkAction->getPermission(auth()->id());
        $check = $this->dishesRepository->checkRoleUpdate($result);
        if($check != 0){
            return $this->dishesRepository->updateSalePriceDish($request,$id);
        }else{
            return view('layouts')->withErrors('Bạn không thuộc quyền truy cập chức năng này');
        }
    }

    public function updateUnit(Request $request,$id)
    {
        $result = $this->checkAction->getPermission(auth()->id());
        $check = $this->dishesRepository->checkRoleUpdate($result);
        if($check != 0){
            return $this->dishesRepository->updateUnitDish($request,$id);
        }else{
            return view('layouts')->withErrors('Bạn không thuộc quyền truy cập chức năng này');
        }
    }

    public function updateStatus(Request $request,$id)
    {
        $result = $this->checkAction->getPermission(auth()->id());
        $check = $this->dishesRepository->checkRoleUpdate($result);
        if($check != 0){
            return $this->dishesRepository->updateStatusDish($request,$id);
        }else{
            return view('layouts')->withErrors('Bạn không thuộc quyền truy cập chức năng này');
        }
    }

    public function updateNote(Request $request,$id)
    {
        $result = $this->checkAction->getPermission(auth()->id());
        $check = $this->dishesRepository->checkRoleUpdate($result);
        if($check != 0){
            return $this->dishesRepository->updateNoteDish($request,$id);
        }else{
            return view('layouts')->withErrors('Bạn không thuộc quyền truy cập chức năng này');
        }
    }

    public function delete($id)
    {
        $result = $this->checkAction->getPermission(auth()->id());
        $check = $this->dishesRepository->checkRoleDelete($result);
        if($check != 0){
            return $this->dishesRepository->deleteDish($id);
        }else{
            return view('layouts')->withErrors('Bạn không thuộc quyền truy cập chức năng này');
        }
    }
}
