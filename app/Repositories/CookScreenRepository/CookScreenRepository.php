<?php
namespace App\Repositories\CookScreenRepository;

use App\Dishes;
use App\CookArea;
use Carbon\Carbon;
use Pusher\Pusher;
use App\WarehouseCook;
use App\MaterialAction;
use App\OrderDetailTable;
use App\Http\Controllers\Controller;
use App\MaterialDetail;

class CookScreenRepository extends Controller implements ICookScreenRepository{

    public function getAllCookArea()
    {
        $cooks = CookArea::where('status','1')->get();
        return $cooks;
    }
    public function getDateNow()
    {
        $date = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');
        return $date;
    }
    public function getDishesByDate($date)
    {
        $dishes = OrderDetailTable::whereBetween('created_at',[$date . ' 00:00:00', $date . ' 23:59:59'])
                                    ->orderBy('updated_at','asc')
                                    ->with('dish.groupMenu.cookArea','order.table',
                                            'dish.material.materialAction.materialDetail',
                                            'dish.material.materialAction.unit')->get();
        return $dishes;
    }
    public function getMaterialInWarehouseCook($idCook)
    {
        $materials = WarehouseCook::where('cook',$idCook)
                                    ->with('detailMaterial','unit')
                                    ->get();
        return $materials;
    }
    public function findCookAreaById($id)
    {
        $cook = CookArea::where('id',$id)->first();
        return $cook;
    }
    public function addDishesToArray($dishes,$id)
    {
        $data = array();
        foreach ($dishes as $key => $dish) {
            if($dish->dish->groupMenu->cookArea->id == $id){
                array_push($data,$dish);
            }
        }
        return $data;
    }
    public function getDetailCookScreen($id)
    {
        $cook = $this->findCookAreaById($id);
        $date = $this->getDateNow();
        $dishes = $this->getDishesByDate($date);
        $data = $this->addDishesToArray($dishes,$id);
        $materials = $this->getMaterialInWarehouseCook($id);
        return view('cookscreen.detail',compact('data','cook','materials'));
    }

    public function updateStatusWarehouseCook($idMaterial,$idCook)
    {
        WarehouseCook::where('cook',$idCook)
                        ->where('id_material_detail',$idMaterial)
                        ->update(['status' => '0']);
        $data['idCook'] = (integer) $idCook;
        $data['material'] = MaterialDetail::where('id',$idMaterial)->value('name');
        $options = array(
            'cluster' => 'ap1',
            'useTLS' => true
        );
        $pusher = new Pusher(
            'cc6422348edc9fbaff00',
            '54d59c765665f5bc6194',
            '994181',
            $options
        );
        $pusher->trigger('NotifyOutOfStock', 'need-import-cook', $data);
    }
    public function findIdGroupNVL($idDish)
    {
        $idGroupNVL = Dishes::where('id',$idDish)->value('id_groupnvl');
        return $idGroupNVL;
    }
    public function getMaterialAction($idGroupNVL)
    {
        $materialDetails = MaterialAction::where('id_groupnvl',$idGroupNVL)->get();
        return $materialDetails;
    }
    public function getOnlyIdMaterialAction($idGroupNVL)
    {
        $idMaterialDetails = MaterialAction::where('id_groupnvl',$idGroupNVL)->orderBy('id_material_detail')->get('id_material_detail');
        return $idMaterialDetails;
    }
    public function findInWarehouseCook($idCook,$idMaterialDetails)
    {
        $detailWarehouse = WarehouseCook::where('cook',$idCook)->whereIn('id_material_detail',$idMaterialDetails)
                                        ->orderBy('id_material_detail')->get();
        return $detailWarehouse;
    }

    public function substractMaterial($materialActions,$materialInWarehouseCooks,$qty)
    {
        foreach ($materialActions as $materialAction) {
            foreach ($materialInWarehouseCooks as $key => $materialInWarehouseCook) {
                if($materialAction->id_material_detail == $materialInWarehouseCook->id_material_detail){
                    $temp = $materialAction->qty * $qty;
                    WarehouseCook::where('id',$materialInWarehouseCook->id)
                                    ->update(['qty' => $materialInWarehouseCook->qty - $temp]);
                }
            }
        }
    }
    public function checkStatus($status,$idDish,$idCook,$qty)
    {
        if($status == '1'){
            $idGroupNVL = $this->findIdGroupNVL($idDish);
            $idMaterialDetails = $this->getOnlyIdMaterialAction($idGroupNVL);
            $materialActions = $this->getMaterialAction($idGroupNVL);
            $materialInWarehouseCooks = $this->findInWarehouseCook($idCook,$idMaterialDetails);
            $this->substractMaterial($materialActions,$materialInWarehouseCooks,$qty);
        }
    }
    public function updateStatusDish($request,$id,$idCook)
    {
        $dish = OrderDetailTable::find($id);
        $dish->status = $request->status;
        $qty = $dish->qty;
        $this->checkStatus($request->status,$dish->id_dish,$idCook,$qty);
        $dish->save();
        return redirect(route('cook_screen.detail',['id' => $idCook]));
    }
}
