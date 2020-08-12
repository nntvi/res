<?php
namespace App\Repositories\PlanRepository;
use App\Plan;
use App\Supplier;
use Carbon\Carbon;
use App\PlanDetail;
use App\Http\Controllers\Controller;
use App\MaterialDetail;

class PlanRepository extends Controller implements IPlanRepository{

    public function checkRoleIndex($arr)
    {
        $temp = 0;
        for ($i=0; $i < count($arr); $i++) {
            if($arr[$i] == "XEM_FULL" || $arr[$i] == "XEM_LAP_KH_NHAP"){
                $temp++;
            }
        }
        return $temp;
    }

    public function checkRoleStore($arr)
    {
        $temp = 0;
        for ($i=0; $i < count($arr); $i++) {
            if($arr[$i] == "XEM_FULL" || $arr[$i] == "TAO_LAP_KH_NHAP"){
                $temp++;
            }
        }
        return $temp;
    }

    public function checkRoleUpdate($arr)
    {
        $temp = 0;
        for ($i=0; $i < count($arr); $i++) {
            if($arr[$i] == "XEM_FULL" || $arr[$i] == "SUA_LAP_KH_NHAP"){
                $temp++;
            }
        }
        return $temp;
    }

    public function checkRoleDelete($arr)
    {
        $temp = 0;
        for ($i=0; $i < count($arr); $i++) {
            if($arr[$i] == "XEM_FULL" || $arr[$i] == "XOA_LAP_KH_NHAP"){
                $temp++;
            }
        }
        return $temp;
    }

    public function getToday()
    {
        $today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');
        return $today;
    }

    public function getNameSupplierByIdPlan($idPlan)
    {
        $plan = Plan::where('id',$idPlan)->with('supplier')->first();
        return $plan->supplier->name;
    }
    public function getSuppliers()
    {
        $suppliers = Supplier::where('status','1')->get();
        return $suppliers;
    }
    public function getPlan()
    {
        $plans = Plan::with('supplier')->orderBy('created_at','desc')->get();
        return $plans;
    }
    public function getDateCreate($id)
    {
        $date = Plan::where('id',$id)->value('date_create');
        return $date;
    }

    public function getStatusPlan($id)
    {
        $status = Plan::where('id',$id)->value('status');
        return $status;
    }
    public function getMaterialChoosenByIdPlan($id)
    {
        $materialChoosens = PlanDetail::where('id_plan',$id)->with('materialDetail.unit')->get();
        return $materialChoosens;
    }

    public function validateStore($request)
    {
        $request->validate( ['dateStart' => 'after:today'],
                            ['dateStart.after' => "Ngày lập phải sau ngày hôm nay"]);
    }

    public function getNameSupplier($idSupplier)
    {
        $name = Supplier::where('id',$idSupplier)->value('name');
        return $name;
    }

    public function getMaterialDetailByIdSupplier($idSupplier)
    {
        $materialDetails = Supplier::where('id',$idSupplier)->with('typeMaterial.materialDetail')->first();
        return $materialDetails;
    }

    public function findMaterial($idMaterial)
    {
        $name = MaterialDetail::where('id',$idMaterial)->with('unit')->first();
        return $name;
    }

    public function storePlan($request)
    {
        $plan = new Plan();
        $plan->date_create = $request->dateStart;
        $plan->id_supplier = $request->idSupplier;
        $plan->note = $request->note;
        $plan->status = '0';
        $plan->created_by = auth()->user()->name;
        $plan->save();
        return $plan->id;
    }

    public function saveStore($request,$idPlan)
    {
        for ($i=0; $i < count($request->idMaterial); $i++) {
            $detailPlan = new PlanDetail();
            $detailPlan->id_plan = $idPlan;
            $detailPlan->id_material_detail = $request->idMaterial[$i];
            $detailPlan->qty = $request->qty[$i];
            $detailPlan->save();
        }
        return redirect(route('importplan.index'))->withSuccess('Thêm kế hoạc thành công');
    }

    public function createTempArrayMaterialPlan($request)
    {
        $arrIdMaterial = $request->idMaterialDetail;
        $tempMaterial = array();
        for ($i=0; $i < count($arrIdMaterial) ; $i++) {
            $nvl = $this->findMaterial($arrIdMaterial[$i]);
            $temp = [
                'id' => $arrIdMaterial[$i],
                'name' => $nvl->name,
                'unit' => $nvl->unit->name,
            ];
            array_push($tempMaterial,$temp);
        }
        return $tempMaterial;
    }

    public function getDetailPlan($id)
    {
        $today = $this->getToday();
        $idSupplier = Plan::where('id',$id)->value('id_supplier');
        $idType = Supplier::where('id',$idSupplier)->value('id_type');
        $idMatPlan = PlanDetail::where('id_plan',$id)->get('id_material_detail');
        $materialDetails = MaterialDetail::where('id_type',$idType)->whereNotIn('id',$idMatPlan)->get();
        $materialChoosen = $this->getMaterialChoosenByIdPlan($id);
        $plan = Plan::where('id',$id)->with('supplier')->first();
        return view('plan.detail',compact('materialDetails','materialChoosen','id','idSupplier','today','plan'));
    }

    public function updateQtyMaterial($request,$idPlan,$idMaterial)
    {
        PlanDetail::where('id_plan',$idPlan)->where('id_material_detail',$idMaterial)
                    ->update(['qty' => $request->qty]);
        return redirect(route('importplan.detail',['id' => $idPlan]))->withSuccess('Cập nhật thành công');
    }

    public function deleteNullQtyArr($arrQty)
    {
        $newArrQty = array();
        for ($i=0; $i < count($arrQty); $i++) {
            if($arrQty[$i] == null){
                unset($arrQty[$i]);
            }
        }
        foreach ($arrQty as $key => $value) {
            array_push($newArrQty,$value);
        }
        return $newArrQty;
    }

    public function postDetailPlan($request)
    {
        PlanDetail::where('id_plan',$request->id_plan)->delete();
        $arrQty = $this->deleteNullQtyArr($request->qty);
        for ($i=0; $i < count($request->idMaterialDetail); $i++) {
            $detailPlan = new PlanDetail();
            $detailPlan->id_plan = $request->id_plan;
            $detailPlan->id_material_detail = $request->idMaterialDetail[$i];
            $detailPlan->qty = $arrQty[$i];
            $detailPlan->save();
        }
        return redirect(route('importplan.index'))->withSuccess('Cập nhật mặt hàng cần nhập thành công');
    }
}
