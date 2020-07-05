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

class ReportController extends Controller
{
    private $reportRepository;

    public function __construct(IReportRepository $reportRepository)
    {
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
        return view('report.order');
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

    public function reportTable(Request $request)
    {
        return $this->reportRepository->reportTable($request);
    }

    public function exportTableReport($dateStart,$dateEnd,$status)
    {
        return Excel::download(new ReportTableExport($dateStart,$dateEnd,$status),'table_report.xlsx');
    }

    public function viewDish()
    {
        $groupMenus = GroupMenu::where('status','1')->get();
        return view('report.dish',compact('groupMenus'));
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
        $groupMenus = GroupMenu::where('status','1')->get();
        return view('report.destroydish',compact('groupMenus'));
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
        $suppliers = Supplier::all();
        return view('report.supplier',compact('suppliers'));
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
        return $this->reportRepository->indexReportProfit();
    }
}
