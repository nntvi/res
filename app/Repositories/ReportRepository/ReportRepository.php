<?php
namespace App\Repositories\ReportRepository;

use App\Helper\IGetDateTime;
use App\GroupMenu;
use App\Http\Controllers\Controller;
use App\Order;
use App\OrderDetailTable;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportRepository extends Controller implements IReportRepository{

    private $getDateTime;

    public function __construct(IGetDateTime $getDateTime)
    {
        $this->getDateTime = $getDateTime;
    }

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

    public function createChartDishByTime($dateStart,$dateEnd)
    {
        $dishes = OrderDetailTable::selectRaw('id_dish, sum(qty) as total')
                                    ->whereBetween('created_at',[$dateStart,$dateEnd])
                                    ->groupBy('id_dish')->with('dish')->get();
        $qtyDishes = array();
        foreach ($dishes as $key => $dish) {
            $obj = array(
                'nameDish' => $dish->dish->name,
                'qty' => $dish->total
            );
            array_push($qtyDishes,$obj);
        }
        return $qtyDishes;
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
        $dataChart = $this->createChartDishByTime($dateStart,$dateEnd);
        return view('report.p_dish',compact('results','dateStart','dateEnd','dateCreate','idGroupMenu','listGroupMenu','dataChart'));
    }

    public function getToTalRevenueInYear()
    {
        $firstYear = $this->getDateTime->getFirstOfJan();
        $lastYear = $this->getDateTime->getEndOfDec();
        $totalRevenue = Order::selectRaw('sum(total_price) as total')
                                ->whereBetween('created_at',[$firstYear,$lastYear])->value('total');
        return $totalRevenue;
    }

    public function getRevenueByMonth($startMonth,$endMonth)
    {
        $revenue = Order::selectRaw('sum(total_price) as total')->whereBetween('created_at',[$startMonth,$endMonth])->value('total');
        return $revenue == null ? 0 : (integer) $revenue;
    }

    public function createObjToPushRevenue($dateStart,$dateEnd)
    {
        $obj = array(
            'month' => $dateStart,
            'value' => $this->getRevenueByMonth($dateStart,$dateEnd),
        );
        return $obj;
    }

    public function getAllRevenue()
    {
        $data = array();
        array_push($data,$this->createObjToPushRevenue($this->getDateTime->getFirstOfJan(),$this->getDateTime->getEndOfJan()));
        array_push($data,$this->createObjToPushRevenue($this->getDateTime->getFirstOfFreb(),$this->getDateTime->getEndOfFreb()));
        array_push($data,$this->createObjToPushRevenue($this->getDateTime->getFirstOfMar(),$this->getDateTime->getEndOfMar()));
        array_push($data,$this->createObjToPushRevenue($this->getDateTime->getFirstOfApr(),$this->getDateTime->getEndOfApr()));
        array_push($data,$this->createObjToPushRevenue($this->getDateTime->getFirstOfMay(),$this->getDateTime->getEndOfMay()));
        array_push($data,$this->createObjToPushRevenue($this->getDateTime->getFirstOfJun(),$this->getDateTime->getEndOfJun()));
        array_push($data,$this->createObjToPushRevenue($this->getDateTime->getFirstOfJul(),$this->getDateTime->getEndOfJul()));
        array_push($data,$this->createObjToPushRevenue($this->getDateTime->getFirstOfAug(),$this->getDateTime->getEndOfAug()));
        array_push($data,$this->createObjToPushRevenue($this->getDateTime->getFirstOfSep(),$this->getDateTime->getEndOfSep()));
        array_push($data,$this->createObjToPushRevenue($this->getDateTime->getFirstOfOct(),$this->getDateTime->getEndOfOct()));
        array_push($data,$this->createObjToPushRevenue($this->getDateTime->getFirstOfNov(),$this->getDateTime->getEndOfNov()));
        array_push($data,$this->createObjToPushRevenue($this->getDateTime->getFirstOfDec(),$this->getDateTime->getEndOfDec()));
        return $data;
    }

    public function getQtyCustomerByTime($timeStart,$timeEnd)
    {
        $qtyCustomers = Order::selectRaw('count(id) as qty')->whereBetween('time_created',[$timeStart,$timeEnd])->value('qty');
        return $qtyCustomers == null ? 0 : $qtyCustomers;
    }

    public function createObjToPushQtyCustomer($timeStart,$timeEnd)
    {
        $obj = array(
            'timeStart' => "2020-01-01 " . $timeStart,
            'value' => $this->getQtyCustomerByTime($timeStart,$timeEnd),
        );
        return $obj;
    }

    public function getAllQtyCustomer()
    {
        $data = array();
        array_push($data,$this->createObjToPushQtyCustomer('08:00:00','08:59:59'));
        array_push($data,$this->createObjToPushQtyCustomer('09:00:00','09:59:59'));
        array_push($data,$this->createObjToPushQtyCustomer('10:00:00','10:59:59'));
        array_push($data,$this->createObjToPushQtyCustomer('11:00:00','11:59:59'));
        array_push($data,$this->createObjToPushQtyCustomer('12:00:00','12:59:59'));
        array_push($data,$this->createObjToPushQtyCustomer('13:00:00','13:59:59'));
        array_push($data,$this->createObjToPushQtyCustomer('14:00:00','14:59:59'));
        array_push($data,$this->createObjToPushQtyCustomer('15:00:00','15:59:59'));
        array_push($data,$this->createObjToPushQtyCustomer('16:00:00','16:59:59'));
        array_push($data,$this->createObjToPushQtyCustomer('17:00:00','17:59:59'));
        array_push($data,$this->createObjToPushQtyCustomer('18:00:00','18:59:59'));
        array_push($data,$this->createObjToPushQtyCustomer('19:00:00','19:59:59'));
        array_push($data,$this->createObjToPushQtyCustomer('20:00:00','20:59:59'));
        array_push($data,$this->createObjToPushQtyCustomer('21:00:00','21:59:59'));
        array_push($data,$this->createObjToPushQtyCustomer('22:00:00','22:59:59'));
        return $data;
    }


}
