<?php
namespace App\Repositories\ReportRepository;

use App\Dishes;
use App\Helper\IGetDateTime;
use App\GroupMenu;
use App\Http\Controllers\Controller;
use App\ImportCoupon;
use App\Order;
use App\OrderDetailTable;
use App\Supplier;
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
    public function createFooterOrderReport($orders)
    {
        $total = 0; $totalReceive = 0; $totalExcess = 0; $footerOrderReport = array();
        foreach ($orders as $key => $order) {
            $total += $order->total_price;
            $totalReceive += $order->receive_cash;
            $totalExcess += $order->excess_cash;
        }
        $temp = [
            'total' => $total,
            'totalReceive' => $totalReceive,
            'totalExcess' => $totalExcess
        ];
        array_push($footerOrderReport,$temp);
        return $footerOrderReport;
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
        $footer = $this->createFooterOrderReport($orders);
        return view('report.p_order',compact('orders','dateStart','dateEnd','dateCreate','footer'));
    }

    public function reportTable($request)
    {
        $s = " 00:00:00";
        $e = " 23:59:59";
        $dateStart = $request->dateStart;
        $dateEnd = $request->dateEnd;
        $status = $request->statusTable;
        if($status == '2'){
            $results = Order::whereBetween('updated_at',[$dateStart . $s ,$dateEnd . $e])
                        ->with('table.getArea','orderDetail.dish')->get();
        }else{
            $results = Order::whereBetween('updated_at',[$dateStart . $s ,$dateEnd . $e])
                        ->where('status', $status)->with('table.getArea','orderDetail.dish')->get();
        }
        $dateCreate = $this->getTimeNow();
        return view('report.p_table',compact('results','dateStart','dateEnd','dateCreate','status'));
    }

    public function getTotalQtyDishToReport($results)
    {
        $totalQty = 0;
        foreach ($results as $key => $result) {
            $totalQty += $result['qty'];
        }
        return $totalQty;
    }
    public function createFooterTotal($results)
    {
        $totalCapitalPrice = 0;$totalSalePrice = 0;$totalInterest = 0;
        foreach ($results as $key => $result) {
            $totalCapitalPrice += $result['capital'];
            $totalSalePrice += $result['sale'];
            $totalInterest += $result['interest'];
        }
        $footerReportDish = array();
        $temp = [
            'qty' => $this->getTotalQtyDishToReport($results),
            'totalCapital' => $totalCapitalPrice,
            'totalSale' => $totalSalePrice,
            'totalInterest' => $totalInterest
        ];
        array_push($footerReportDish,$temp);
        return $footerReportDish;
    }

    public function createArrayChartBestSeller($results)
    {
        $totalQty = $this->getTotalQtyDishToReport($results);
        $arrChartBestSeller = array();
        foreach ($results as $key => $result) {
            $temp = [
                'value' => round((($result['qty'] * 100) / $totalQty),2),
                'label' => $result['name'],
            ];
            array_push($arrChartBestSeller,$temp);
            unset($temp);
        }
        return $arrChartBestSeller;
    }
    public function getOrderByAllGroupMenu($dateStart,$dateEnd)
    {
        $orders = OrderDetailTable::selectRaw('id_dish, sum(qty) as sumQty')
                        ->whereBetween('updated_at',[$dateStart,$dateEnd])
                        ->whereIn('status',['1','2'])
                        ->groupBy('id_dish')->get();
        return $orders;
    }
    public function getOrderByIdGroupMenu($dateStart,$dateEnd,$idGroupMenu)
    {
        $orders = OrderDetailTable::selectRaw('id_dish, sum(qty) as sumQty')
                        ->whereBetween('updated_at',[$dateStart,$dateEnd])
                        ->whereIn('status',['1','2'])
                        ->groupBy('id_dish')
                        ->whereHas('dish.groupMenu', function($query) use($idGroupMenu){
                            $query->where('id',$idGroupMenu);
                        })->get();
        return $orders;
    }
    public function createArrayReportDish($orders)
    {
        $dishes = Dishes::with('groupMenu','unit','material')->get();
        $results = array();
        foreach ($dishes as $key => $dish) {
            foreach ($orders as $key => $order) {
                if($order->id_dish == $dish->id){
                    $temp = [
                        'stt' => $key + 1,
                        'code' => $dish->code,
                        'name' => $dish->name,
                        'group_menu' => $dish->groupMenu->name,
                        'unit' => $dish->unit->name,
                        'qty' => $order->sumQty,
                        'capital' => $dish->capital_price,
                        'sale' => $dish->sale_price,
                        'interest' => ($dish->sale_price - $dish->capital_price) *  $order->sumQty
                    ];
                    array_push($results,$temp);
                    unset($temp);
                    break;
                }
            }
        }
        return $results;
    }

    public function reportDish($request)
    {
        $dateCreate = $this->getTimeNow();
        $dateStart = $request->dateStart;
        $dateEnd = $request->dateEnd;
        $idGroupMenu = $request->groupMenu;
        if($idGroupMenu == '0'){
            $orders = $this->getOrderByAllGroupMenu($dateStart,$dateEnd);
            $results = $this->createArrayReportDish($orders);
            $arrBestSeller = $this->createArrayChartBestSeller($results);
            $footerTotal = $this->createFooterTotal($results);
        }
        else{
            $orders = $this->getOrderByIdGroupMenu($dateStart,$dateEnd,$idGroupMenu);
            $results = $this->createArrayReportDish($orders);
            $arrBestSeller = $this->createArrayChartBestSeller($results);
            $footerTotal = $this->createFooterTotal($results);
        }
        $groupMenuChoosen = GroupMenu::where('id',$idGroupMenu)->first();
        $listGroupMenuExcept = GroupMenu::whereNotIn('id',[$idGroupMenu])->get();
        $listGroupMenu = GroupMenu::all();
        return view('report.p_dish',compact('results','dateStart','dateEnd','dateCreate','groupMenuChoosen',
                    'listGroupMenuExcept','listGroupMenu','idGroupMenu','arrBestSeller','footerTotal'));
    }

    public function createFooterTotalSupplier($results)
    {
        $total = 0; $paid = 0; $unPaid = 0;
        foreach ($results as $key => $result) {
            $total += $result->total;
            $paid += $result->paid;
        }
        $unPaid = $total - $paid;
        $temp = [
            'total' => $total,
            'paid' => $paid,
            'unPaid' => $unPaid
        ];
        $footerTotalSupplier = array();
        array_push($footerTotalSupplier,$temp);
        return $footerTotalSupplier;
    }

    public function createArrayChartSupplier($dateStart,$dateEnd)
    {
        $getTotalByTimeAllSupplier = ImportCoupon::selectRaw('id_supplier,sum(total) as Total')->whereBetween('created_at',[$dateStart,$dateEnd])
                                    ->groupBy('id_supplier')->orderBy('id_supplier')->with('supplier')->get();
        $getTotalPaidByTimeAllSupplier = ImportCoupon::selectRaw('id_supplier,sum(paid) as Paid')->whereBetween('created_at',[$dateStart,$dateEnd])
                                        ->groupBy('id_supplier')->orderBy('id_supplier')->get();
        $dataChart = array();
            foreach ($getTotalByTimeAllSupplier as $total) {
                foreach ($getTotalPaidByTimeAllSupplier as $paid) {
                    if($paid->id_supplier == $total->id_supplier){
                        $temp = [
                            'name' => $total->supplier->name,
                            'total' => $total->Total,
                            'paid' => $paid->Paid,
                            'unpaid' => $total->Total - $paid->Paid
                        ];
                        array_push($dataChart,$temp);
                        unset($temp);
                        break;
                    }
                }
            }
        return $dataChart;
    }
    public function reportSupplier($request)
    {
        $dateStart = $request->dateStart;
        $dateEnd = $request->dateEnd;
        $idSupplier = $request->idSupplier;
        if($idSupplier == 0){
            $results = ImportCoupon::whereBetween('created_at',[$dateStart,$dateEnd])->with('supplier')->get();
        }else{
            $results = ImportCoupon::whereBetween('created_at',[$dateStart,$dateEnd])->where('id_supplier',$idSupplier)
                                    ->with('supplier')->get();
        }
        $nameSupplierChoosen = Supplier::where('id',$idSupplier)->value('name');
        $listSupplier = Supplier::whereNotIn('id',[$idSupplier])->get();
        $suppliers = Supplier::all();
        $footerTotalSupplier = $this->createFooterTotalSupplier($results);
        $dataChart = $this->createArrayChartSupplier($dateStart,$dateEnd);
        return view('report.p_supplier',compact('results','dateStart','dateEnd','idSupplier','nameSupplierChoosen',
                                                'listSupplier','suppliers','footerTotalSupplier','dataChart'));
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
