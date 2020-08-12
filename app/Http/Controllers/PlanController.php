<?php

namespace App\Http\Controllers;
use App\Plan;
use App\Supplier;
use App\PlanDetail;
use App\Helper\ICheckAction;
use Illuminate\Http\Request;
use App\Repositories\PlanRepository\IPlanRepository;

class PlanController extends Controller
{
    private $planRepository;
    private $checkAction;

    public function __construct(ICheckAction $checkAction, IPlanRepository $planRepository)
    {
        $this->checkAction = $checkAction;
        $this->planRepository = $planRepository;
    }

    public function index()
    {
        $result = $this->checkAction->getPermission(auth()->id());
        $check = $this->planRepository->checkRoleIndex($result);
        if($check != 0){
            $plans = $this->planRepository->getPlan();
            $suppliers = $this->planRepository->getSuppliers();
            $today = $this->planRepository->getToday();
            return view('plan.index',compact('plans','suppliers','today'));
        }else{
            return view('layouts')->withErrors('Bạn không thuộc quyền truy cập chức năng này');
        }
    }

    public function viewStore()
    {
        $suppliers = $this->planRepository->getSuppliers();
        return view('plan.store',compact('suppliers'));
    }

    public function store(Request $request)
    {
        $result = $this->checkAction->getPermission(auth()->id());
        $check = $this->planRepository->checkRoleIndex($result);
        if($check != 0){
            $this->planRepository->validateStore($request);
            $date = $request->dateStart;
            $idSupplier = $request->idSupplier;
            $nameSupplier = Supplier::where('id',$idSupplier)->value('name');
            $note = $request->note;
            $arrMaterial = $this->planRepository->createTempArrayMaterialPlan($request);
            return view('plan.store2',compact('date','idSupplier','nameSupplier','note','arrMaterial'));
        }else{
            return view('layouts')->withErrors('Bạn không thuộc quyền truy cập chức năng này');
        }
    }

    public function store2(Request $request)
    {
        $idPlan = $this->planRepository->storePlan($request);
        return $this->planRepository->saveStore($request,$idPlan);
    }

    public function addMore(Request $request)
    {
        $today = $this->planRepository->getToday();
        $date = $this->planRepository->getDateCreate($request->id_plan);
        if($today > $date){ // NGÀY KẾ HOẠCH < HÔM NAY => TRỄ
            return redirect(route('importplan.detail',['id' => $request->id_plan]))->withErrors('Kế hoạch trễ so với ngày hiện tại');
        }else{
            if ($this->planRepository->getStatusPlan($request->id_plan) == 1) { // đã nhập hàng
                return redirect(route('importplan.detail',['id' => $request->id_plan]))->withErrors('Kế hoạch nhập đã được thực hiện, không thể thay đổi');
            } else {
                $nameSupplier = $this->planRepository->getNameSupplierByIdPlan($request->id_plan);
                $temp = $this->planRepository->createTempArrayMaterialPlan($request);
                $idPlan = $request->id_plan;
                return view('plan.addmore',compact('date','nameSupplier','temp','idPlan','today'));
            }
        }
    }

    public function addMorePost(Request $request)
    {
        return $this->planRepository->saveStore($request,$request->id_plan);
    }

    public function getDetail($id)
    {
        return $this->planRepository->getDetailPlan($id);
    }

    public function update(Request $request,$idPlan,$idMaterial)
    {
        $today = $this->planRepository->getToday();
        $date = $this->planRepository->getDateCreate($request->id_plan);
        if($today > $date){ // NGÀY KẾ HOẠCH < HÔM NAY => TRỄ
            return redirect(route('importplan.detail',['id' => $idPlan]))->withErrors('Kế hoạch trễ so với ngày hiện tại');
        }else{
            if ($this->planRepository->getStatusPlan($request->id_plan) == 1) { // đã nhập hàng
                return redirect(route('importplan.detail',['id' =>$idPlan]))->withErrors('Kế hoạch nhập đã được thực hiện, không thể thay đổi');
            } else {
                return $this->planRepository->updateQtyMaterial($request,$idPlan,$idMaterial);
            }
        }
    }

    public function delete($idPlan,$idMaterial)
    {
        $today = $this->planRepository->getToday();
        $date = $this->planRepository->getDateCreate($idPlan);
        if($today > $date){ // NGÀY KẾ HOẠCH < HÔM NAY => TRỄ
            return redirect(route('importplan.detail',['id' => $idPlan]))->withErrors('Kế hoạch trễ so với ngày hiện tại');
        }else{
            if ($this->planRepository->getStatusPlan($idPlan) == 1) { // đã nhập hàng
                return redirect(route('importplan.detail',['id' => $idPlan]))->withErrors('Kế hoạch nhập đã được thực hiện, không thể thay đổi');
            } else {
                PlanDetail::where('id_plan',$idPlan)->where('id_material_detail',$idMaterial)->delete();
                return redirect(route('importplan.detail',['id' => $idPlan]))->withSuccess('Xóa NVL thành công');
            }
        }
    }

    public function deletePlan($idPlan)
    {
        PlanDetail::where('id_plan',$idPlan)->delete();
        Plan::where('id',$idPlan)->delete();
        return redirect(route('importplan.index'))->withSuccess('Xóa kế hoạch thành công');
    }
}
