<?php

namespace App\Http\Controllers;

use App\Exports\ReportDishExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReportOrderExport;
use App\Exports\ReportTableExport;
use App\GroupMenu;
use App\Repositories\ReportRepository\IReportRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    private $reportRepository;

    public function __construct(IReportRepository $reportRepository)
    {
        $this->reportRepository = $reportRepository;
    }

    public function overview()
    {

        return view('overview.index');
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
        $groupMenus = GroupMenu::all();
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
}
