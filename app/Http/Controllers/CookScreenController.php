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
                if($cook->id == 1 && $rs == "VIEW_COOK1" || $rs == "VIEW_FULL"){
                    array_push($data,$cook);
                    break;
                }
                if($cook->id == 2 && $rs == "VIEW_COOK2" || $rs == "VIEW_FULL"){
                    array_push($data,$cook);
                    break;
                }
                if($cook->id == 3 && $rs == "VIEW_COOK3" || $rs == "VIEW_FULL"){
                    array_push($data,$cook);
                    break;
                }
            }
        }
        return view('cookscreen.index',compact('data'));
    }

    public function getDetail($id)
    {
        $results = $this->checkAction->getPermission(auth()->id());
        $temp = 0;
        foreach ($results as $key => $result) {
            if($result == "VIEW_COOK1" || $result == "EDIT_COOK1" || $result == "VIEW_FULL"){
                $temp++;
                return $this->cookscreenRepository->getDetailCookScreen(1);
                break;
            }
            else if($result == "VIEW_COOK2" || $result == "EDIT_COOK2" || $result == "VIEW_FULL"){
                $temp++;
                return $this->cookscreenRepository->getDetailCookScreen(2);
                break;
            }
            else if($result == "VIEW_COOK3" || $result == "EDIT_COOK3" || $result == "VIEW_FULL"){
                $temp++;
                return $this->cookscreenRepository->getDetailCookScreen(1);
                break;
            }
        }
        if($temp == 0){
            return view('layouts');
        }
    }

    public function createData($qtyOrder,$qtyNotEnoughCook,$qtyNotEnoughWarehouse)
    {
        $data = [
            'qtyOrder' => $qtyOrder,
            'qtyEmptyCook' => $qtyNotEnoughCook,
            'qtyEmptyWarehouse' => $qtyNotEnoughWarehouse
        ];
        return $data;
    }

    public function checkNVL($idDishOrder)
    {
        $idDish = $this->cookscreenRepository->getIdDishByIdDishOrder($idDishOrder); // lấy ra id món đặt
        $idGroupNVL = $this->cookscreenRepository->findIdGroupNVL($idDish); // lấy ra id tên món
        $idCook = $this->cookscreenRepository->getIdCookByGroupNVL($idGroupNVL); // lấy cook đảm nhiệm món này
        $idMaterialDetails = $this->cookscreenRepository->getOnlyIdMaterialAction($idGroupNVL); // lấy các NVL tạo nên món đó
        $materialInWarehouseCook = $this->cookscreenRepository->findInWarehouseCook($idCook,$idMaterialDetails); // những NVL tạo nên món đó trong bếp
        $materialInWarehouse = $this->cookscreenRepository->findInWarehouse($idMaterialDetails); // những NVL tạo nên món đó trong kho
        $materialActions = $this->cookscreenRepository->getMaterialAction($idGroupNVL);
        $qtyOrder = $this->cookscreenRepository->getQtyDishOrderByIdDishOrder($idDishOrder);
        $qtyEnough = $this->cookscreenRepository->compareWarehouseCook($materialInWarehouseCook,$materialActions,$qtyOrder);

        if($qtyOrder == $qtyEnough){ // đủ NVL thực hiện cho số lượng order món này
            return response()->json($this->createData($qtyOrder,0,0));
        }else{ // bếp ko thể thực hiện hết số lượng order của món đó
            $qtyNotEnoughCook = $qtyOrder - $qtyEnough; // lấy ra số lượng mà bếp ko đủ
            $qtyCheckInWarehouse = $this->cookscreenRepository->compareWarehouse($materialInWarehouse,$materialActions,$qtyNotEnoughCook);
            if($qtyNotEnoughCook <= $qtyCheckInWarehouse){ // bếp ko đủ nhưng kho đủ => sl đó là do bếp ko đủ
                return response()->json($this->createData($qtyEnough,$qtyNotEnoughCook,0));
            }else{
                $qtyNotEnoughWarehouse = $qtyNotEnoughCook - $qtyCheckInWarehouse;
                return response()->json($this->createData($qtyEnough,$qtyCheckInWarehouse,$qtyNotEnoughWarehouse));
            }
        }
    }

    public function update(Request $request,$id,$idCook)
    {
        $this->cookscreenRepository->validateToCook($request);
        $dishOrder = $this->cookscreenRepository->getDishByIdDishOrder($id);
        $qtyCanDo = $request->qtyOrder; $qtyEmptyCook = $request->qtyEmptyCook; $qtyEmptyWh = $request->qtyEmptyWh;
        if($qtyEmptyCook == 0 && $qtyEmptyWh == 0){ // ko bị thiếu
            $this->cookscreenRepository->updateStatusDish($id,$idCook,$dishOrder,$qtyCanDo,'1');
            return redirect(route('cook_screen.detail',['id' => $idCook]))->withSuccess('Đang thực hiện món ' . $dishOrder->dish->name);
        }else if($qtyCanDo == 0){ // bếp hết sạch NVL
            if($qtyEmptyCook != 0 && $qtyEmptyWh == 0){ // bếp thiếu ... mà kho vẫn còn đủ để cung cấp sl thiếu đó
                return $this->cookscreenRepository->updateStatusDish($id,$idCook,$dishOrder,$qtyEmptyCook,'-1');
            }else if($qtyEmptyCook == 0 && $qtyEmptyWh != 0){ // ko thể đảm nhiệm món nào, NVL bếp hết sạch, kho cũng thiếu
                return $this->cookscreenRepository->updateStatusDish($id,$idCook,$dishOrder,$qtyEmptyWh,'-3');
            }
        }else if($qtyCanDo != 0 && $qtyEmptyCook != 0 && $qtyEmptyWh != 0){
            $this->cookscreenRepository->updateStatusDish($id,$idCook,$dishOrder,$qtyCanDo,'1');
            $this->cookscreenRepository->createDishEmptyCook($dishOrder,$qtyEmptyCook,$idCook);
            $this->cookscreenRepository->createDishEmptyWh($dishOrder,$qtyEmptyWh,$idCook);
            return redirect(route('cook_screen.detail',['id' => $idCook]));
        }else if($qtyCanDo != 0 && $qtyEmptyCook != 0 && $qtyEmptyWh == 0){
            $this->cookscreenRepository->updateStatusDish($id,$idCook,$dishOrder,$qtyCanDo,'1');
            $this->cookscreenRepository->createDishEmptyCook($dishOrder,$qtyEmptyCook,$idCook);
            return redirect(route('cook_screen.detail',['id' => $idCook]));
        }
    }

    public function updateFinish(Request $request, $idDishOrder,$idCook)
    {
        $idMaterialDetails = $request->idMaterialDetail;
        $qtyMethods = $request->qtyMethod;
        $qtyReals = $request->qtyReal;
        $dish = $this->cookscreenRepository->getDishByIdDishOrder($idDishOrder);
        return $this->cookscreenRepository->updateFinishDish($idDishOrder,$idCook,$idMaterialDetails,$qtyMethods,$qtyReals,$dish);
    }

    public function updateMaterialDetail($idMaterial,$idCook)
    {
        $this->cookscreenRepository->updateStatusWarehouseCook($idMaterial,$idCook);
        return redirect(route('cook_screen.detail',['id' => $idCook]))->with('Gửi thông báo đến kho thành công');
    }

}
