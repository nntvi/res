<?php
namespace App\Repositories\ReportRepository;

use App\GroupMenu;
use App\Http\Controllers\Controller;
use App\Order;
use App\OrderDetailTable;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportRepository extends Controller implements IReportRepository{

    public function getTimeNow()
    {
        $timeNow = Carbon::now('Asia/Ho_Chi_Minh')->toDayDateTimeString();
        return $timeNow;
    }
    public function reportOrder($request)
    {
        $s = " 00:00:00";
        $e = " 23:59:59";
        $dateStart = $request->dateStart;
        $dateEnd = $request->dateEnd;
        $orders = Order::whereBetween('updated_at',[$dateStart . $s ,$dateEnd . $e])
                        ->with('table.getArea','user','shift')->get();
        $dateCreate = $this->getTimeNow();
        return view('report.p_order',compact('orders','dateStart','dateEnd','dateCreate'));
    }

    public function reportTable($request)
    {
        $s = " 00:00:00";
        $e = " 23:59:59";
        $dateStart = $request->dateStart;
        $dateEnd = $request->dateEnd;
        $status = $request->statusTable;
        $results = Order::whereBetween('updated_at',[$dateStart . $s ,$dateEnd . $e])
                        ->where('status', $status)
                        ->with('table.getArea','orderDetail.dish')->get();
        $dateCreate = $this->getTimeNow();
        return view('report.p_table',compact('results','dateStart','dateEnd','dateCreate','status'));
    }

    public function reportDish($request)
    {
        $dateCreate = $this->getTimeNow();
        $s = " 00:00:00";
        $e = " 23:59:59";
        $dateStart = $request->dateStart;
        $dateEnd = $request->dateEnd;
        $idGroupMenu = $request->groupMenu;
        if($idGroupMenu == '0'){
            $results = OrderDetailTable::selectRaw('id_dish, sum(qty) as sumQty')
                        ->whereBetween('updated_at',[$dateStart . $s ,$dateEnd . $e])
                        ->groupBy('id_dish')
                        ->with('dish','dish.groupMenu','dish.unit')
                        ->get();

        }
        else{
            $results = OrderDetailTable::selectRaw('id_dish, sum(qty) as sumQty')
                        ->whereBetween('updated_at',[$dateStart . $s ,$dateEnd . $e])
                        ->groupBy('id_dish')
                        ->with('dish','dish.groupMenu','dish.unit')
                        ->whereHas('dish.groupMenu', function($query) use($idGroupMenu){
                            $query->where('id',$idGroupMenu);
                        })->get();
        }
        $listGroupMenu = GroupMenu::all();
        return view('report.p_dish',compact('results','dateStart','dateEnd','dateCreate','idGroupMenu','listGroupMenu'));
    }

    public function getToTalRevenueInYear()
    {
        $firstYear = Carbon::now('Asia/Ho_Chi_Minh')->firstOfYear()->format('Y-m');
        $lastYear = $dec = Carbon::now('Asia/Ho_Chi_Minh')->lastOfYear()->format('Y-m');
        $totalRevenue = Order::selectRaw('sum(total_price) as total')
                                ->whereBetween('created_at',[$firstYear,$lastYear])->value('total');
        return $totalRevenue;
    }
    public function getMonthInYear()
    {
        $jan = Carbon::now('Asia/Ho_Chi_Minh')->firstOfYear()->format('Y-m');
        $freb = Carbon::now('Asia/Ho_Chi_Minh')->firstOfYear()->addMonth(1)->format('Y-m');
        $mar = Carbon::now('Asia/Ho_Chi_Minh')->firstOfYear()->addMonth(2)->format('Y-m');
        $apr = Carbon::now('Asia/Ho_Chi_Minh')->firstOfYear()->addMonth(3)->format('Y-m');
        $may = Carbon::now('Asia/Ho_Chi_Minh')->firstOfYear()->addMonth(4)->format('Y-m');
        $jun = Carbon::now('Asia/Ho_Chi_Minh')->firstOfYear()->addMonth(5)->format('Y-m');
        $jul = Carbon::now('Asia/Ho_Chi_Minh')->firstOfYear()->addMonth(6)->format('Y-m');
        $aug = Carbon::now('Asia/Ho_Chi_Minh')->firstOfYear()->addMonth(7)->format('Y-m');
        $sep = Carbon::now('Asia/Ho_Chi_Minh')->firstOfYear()->addMonth(8)->format('Y-m');
        $oct = Carbon::now('Asia/Ho_Chi_Minh')->firstOfYear()->addMonth(9)->format('Y-m');
        $nov = Carbon::now('Asia/Ho_Chi_Minh')->firstOfYear()->addMonth(10)->format('Y-m');
        $dec = Carbon::now('Asia/Ho_Chi_Minh')->lastOfYear()->format('Y-m');
        $months = array();
        array_push($months,$jan,$freb,$mar,$apr,$may,$jun,$jul,$aug,$sep,$nov,$dec);
        return $months;
    }
}
