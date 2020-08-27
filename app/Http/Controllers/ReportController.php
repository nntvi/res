<?php

namespace App\Http\Controllers;

use App\Exports\ReportDestroyDish;
use App\Supplier;
use App\GroupMenu;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Exports\ReportDishExport;
use App\Exports\ReportOrderExport;
use App\Exports\ReportSupplier;
use App\Exports\ReportTableExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Repositories\ReportRepository\IReportRepository;
use App\Helper\ICheckAction;

class ReportController extends Controller
{
    private $reportRepository;
    private $checkAction;

    public function __construct(ICheckAction $checkAction, IReportRepository $reportRepository)
    {
        $this->checkAction = $checkAction;
        $this->reportRepository = $reportRepository;
    }

    public function overview()
    {
        $allRevenue = $this->reportRepository->getAllRevenue();
        $qtyCustomer = $this->reportRepository->getAllQtyCustomer();
        return view('overview.index',compact('allRevenue','qtyCustomer'));
    }

    public function viewReportOrder()
    {
        $result = $this->checkAction->getPermission(auth()->id());
        $check = $this->reportRepository->checkRoleIndex($result);
        if($check != 0){
            return view('report.order');
        }else{
            return view('layouts')->withErrors('Bạn không thuộc quyền truy cập chức năng này');
        }
    }

    public function reportOrder(Request $request)
    {
        return $this->reportRepository->reportOrder($request);
    }

    public function exportOrderReport($dateStart,$dateEnd)
    {
        return Excel::download(new ReportOrderExport($dateStart,$dateEnd), 'order_report.xlsx');
    }

    public function viewReportTable()
    {
        return view('report.table');
    }

    public function viewDish()
    {
        $result = $this->checkAction->getPermission(auth()->id());
        $check = $this->reportRepository->checkRoleIndex($result);
        if($check != 0){
            $groupMenus = GroupMenu::where('status','1')->get();
            return view('report.dish',compact('groupMenus'));
        }else{
            return view('layouts')->withErrors('Bạn không thuộc quyền truy cập chức năng này');
        }
    }

    public function reportDish(Request $request)
    {
        return $this->reportRepository->reportDish($request);
    }

    public function exportDishReport($dateStart,$dateEnd,$idGroupMenu)
    {
        return Excel::download(new ReportDishExport($dateStart,$dateEnd,$idGroupMenu),'dish_report.xlsx');
    }

    public function viewDestroyDish()
    {
        $result = $this->checkAction->getPermission(auth()->id());
        $check = $this->reportRepository->checkRoleIndex($result);
        if($check != 0){
            $groupMenus = GroupMenu::where('status','1')->get();
            return view('report.destroydish',compact('groupMenus'));
        }else{
            return view('layouts')->withErrors('Bạn không thuộc quyền truy cập chức năng này');
        }
    }

    public function reportDestroyDish(Request $request)
    {
        return $this->reportRepository->reportDestroyDish($request);
    }

    public function exportDestroyDishReport($dateStart,$dateEnd,$idGroupMenu)
    {
        return Excel::download(new ReportDestroyDish($dateStart,$dateEnd,$idGroupMenu),'destroydish_report.xlsx');
    }

    public function viewReportSupplier()
    {
        $result = $this->checkAction->getPermission(auth()->id());
        $check = $this->reportRepository->checkRoleIndex($result);
        if($check != 0){
            $suppliers = Supplier::all();
            return view('report.supplier',compact('suppliers'));
        }else{
            return view('layouts')->withErrors('Bạn không thuộc quyền truy cập chức năng này');
        }

    }

    public function reportSupplier(Request $request)
    {
        return $this->reportRepository->reportSupplier($request);
    }

    public function exportSupplierReport($dateStart,$dateEnd,$idSupplier)
    {
        return Excel::download(new ReportSupplier($dateStart,$dateEnd,$idSupplier),'reportsupplier.xlsx');
    }

    public function profit()
    {
        $result = $this->checkAction->getPermission(auth()->id());
        $check = $this->reportRepository->checkRoleIndex($result);
        if($check != 0){
            return $this->reportRepository->indexReportProfit();
        }else{
            return view('layouts')->withErrors('Bạn không thuộc quyền truy cập chức năng này');
        }

    }
}
