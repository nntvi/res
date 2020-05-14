<?php

namespace App\Http\Controllers;

use App\CookArea;
use App\OrderDetailTable;
use Carbon\Carbon;
use App\WarehouseCook;
use Illuminate\Http\Request;
use App\Helper\ICheckAction;
use App\Repositories\CookScreenRepository\ICookScreenRepository;

class CookScreenController extends Controller
{
    private $checkAction;
    private $cookscreenRepository;

    public function __construct(ICheckAction $checkAction,ICookScreenRepository $cookscreenRepository)
    {
        $this->checkAction = $checkAction;
        $this->cookscreenRepository = $cookscreenRepository;
    }

    public function index()
    {
        $result = $this->checkAction->getPermission(auth()->id());
        $data = array();
        $cooks = $this->cookscreenRepository->getAllCookArea();
        foreach ($cooks as $cook) {
            foreach ($result as $rs) {
                if($cook->id == 1 && $rs == "VIEW_COOK1"){
                    array_push($data,$cook);
                    break;
                }
                if($cook->id == 2 && $rs == "VIEW_COOK2"){
                    array_push($data,$cook);
                    break;
                }
                if($cook->id == 3 && $rs == "VIEW_COOK3"){
                    array_push($data,$cook);
                    break;
                }
            }
        }
        return view('cookscreen.index',compact('data'));
    }

    public function getDetail($id)
    {
        return $this->cookscreenRepository->getDetailCookScreen($id);
    }

    public function update(Request $request,$id,$idCook)
    {
        return $this->cookscreenRepository->updateStatusDish($request,$id,$idCook);
    }

    public function updateMaterialDetail($idMaterial,$idCook)
    {
        $this->cookscreenRepository->updateStatusWarehouseCook($idMaterial,$idCook);
        return redirect(route('cook_screen.detail',['id' => $idCook]));
    }

}
