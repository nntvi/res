<?php

namespace App\Http\Controllers;
use App\Repositories\PlanRepository\IPlanRepository;
use Illuminate\Http\Request;
use App\Helper\ICheckAction;
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
        dd($request->all());
        // $result = $this->checkAction->getPermission(auth()->id());
        // $check = $this->planRepository->checkRoleIndex($result);
        // if($check != 0){
        //     $this->planRepository->validateStore($request);
        //     return $this->planRepository->storePlan($request);
        // }else{
        //     return view('layouts')->withErrors('Bạn không thuộc quyền truy cập chức năng này');
        // }
    }

    public function getDetail($id,$idSupplier)
    {
        return $this->planRepository->getDetailPlan($id,$idSupplier);
    }

    public function postDetail(Request $request)
    {
        dd($request->all());
        //return $this->planRepository->postDetailPlan($request);
    }
}
