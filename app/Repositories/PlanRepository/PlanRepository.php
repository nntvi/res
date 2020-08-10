<?php
namespace App\Repositories\PlanRepository;
use App\Plan;
use App\Supplier;
use Carbon\Carbon;
use App\PlanDetail;
use App\Http\Controllers\Controller;

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

    public function getMaterialChoosenByIdPlan($id)
    {
        $materialChoosens = PlanDetail::where('id_plan',$id)->get();
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

    public function storePlan($request)
    {
        $plan = new Plan();
        $plan->date_create = $request->dateStart;
        $plan->id_supplier = $request->idSupplier;
        $plan->note = $request->note;
        $plan->status = '0';
        $plan->created_by = auth()->user()->name;
        $plan->save();
        return redirect(route('importplan.detail',['id' => $plan->id, 'idSupplier' => $plan->id_supplier]))->with('info','Chọn mặt hàng cần nhập cho kế hoạch');
    }

    public function getDetailPlan($id,$idSupplier)
    {
        $today = $this->getToday();
        $materialDetails = $this->getMaterialDetailByIdSupplier($idSupplier);
        $materialChoosen = $this->getMaterialChoosenByIdPlan($id);
        $plan = Plan::where('id',$id)->with('supplier')->first();
        return view('plan.detail',compact('materialDetails','materialChoosen','id','idSupplier','today','plan'));
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
