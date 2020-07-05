<?php
namespace App\Repositories\ReportRepository;

use App\Dishes;
use App\Helper\IGetDateTime;
use App\GroupMenu;
use App\Http\Controllers\Controller;
use App\ImportCoupon;
use App\Order;
use App\OrderDetailTable;
use App\PaymentVoucher;
use App\Supplier;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ReportRepository extends Controller implements IReportRepository{

    private $getDateTime;

    public function paginate($items, $perPage = 3, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

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
        $orders = Order::whereBetween('updated_at',[$dateStart . $s ,$dateEnd . $e])->with('tableOrdered.table.getArea','user','shift')->get();
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

    public function getOrderByAllGroupMenu($dateStart,$dateEnd,$status)
    {
        $orders = OrderDetailTable::selectRaw('id_dish, sum(qty) as sumQty')->whereBetween('updated_at',[$dateStart,$dateEnd])
                        ->whereIn('status',$status)->groupBy('id_dish')->get();
        return $orders;
    }

    public function getOrderByIdGroupMenu($dateStart,$dateEnd,$idGroupMenu,$status)
    {
        $orders = OrderDetailTable::selectRaw('id_dish, sum(qty) as sumQty')->whereBetween('updated_at',[$dateStart,$dateEnd])
                        ->whereIn('status',$status)->groupBy('id_dish')
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
                        'name' => $dish->stt == '1' ? $dish->name : $dish->name . ' (ngưng phục vụ)',
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
        $status = ['1','2'];
        if($idGroupMenu == '0'){
            $orders = $this->getOrderByAllGroupMenu($dateStart,$dateEnd,$status);
            $results = $this->createArrayReportDish($orders);
            $arrBestSeller = $this->createArrayChartBestSeller($results);
            $footerTotal = $this->createFooterTotal($results);
        }
        else{
            $orders = $this->getOrderByIdGroupMenu($dateStart,$dateEnd,$idGroupMenu,$status);
            $results = $this->createArrayReportDish($orders);
            $arrBestSeller = $this->createArrayChartBestSeller($results);
            $footerTotal = $this->createFooterTotal($results);
        }
        $groupMenuChoosen = GroupMenu::where('id',$idGroupMenu)->first();
        $listGroupMenuExcept = GroupMenu::whereNotIn('id',[$idGroupMenu])->get();
        $listGroupMenu = GroupMenu::where('status','1')->get();
        //return $results;
        return view('report.p_dish',compact('results','dateStart','dateEnd','dateCreate','groupMenuChoosen',
                    'listGroupMenuExcept','listGroupMenu','idGroupMenu','arrBestSeller','footerTotal'));
    }

    public function getDishDestroy($dateStart,$dateEnd,$status)
    {
        $dishEmpty = OrderDetailTable::selectRaw('id_dish, sum(qty) as qty')->whereBetween('updated_at',[$dateStart,$dateEnd])
                            ->where('status',$status)->groupBy('id_dish')->with('dish.groupMenu.cookArea','dish.unit')->get();
        return $dishEmpty;
    }

    public function getDishDestroyByIdGroupMenu($dateStart,$dateEnd,$status,$idGroupMenu)
    {
        $dishEmpty = OrderDetailTable::selectRaw('id_dish, sum(qty) as qty')->whereBetween('updated_at',[$dateStart,$dateEnd])
                            ->where('status',$status)->groupBy('id_dish')
                            ->whereHas('dish.groupMenu', function($query) use($idGroupMenu){
                                $query->where('id',$idGroupMenu);
                            })->with('dish.groupMenu.cookArea','dish.unit')->get();
        return $dishEmpty;
    }

    public function createArrayDestroyDish($array,$results,$status)
    {
        foreach ($array as $key => $item) {
            $temp = [
                'code' => $item->dish->code,
                'name' => $item->dish->name,
                'groupmenu' => $item->dish->groupMenu->name,
                'cook' => $item->dish->groupMenu->cookArea->name,
                'unit' => $item->dish->unit->name,
                'qty' => $item->qty,
                'status' => $status == '-3' ? 'Hết NVL ở kho' : ($status == '-2' ? 'Món hủy chọn' : 'Bếp hết NVL'),
            ];
            array_push($results,$temp);
        }
        return $results;
    }

    public function reportDestroyDish($request)
    {
        $dateCreate = $this->getTimeNow();
        $dateStart = $request->dateStart;
        $dateEnd = $request->dateEnd;
        $idGroupMenu = $request->groupMenu;
        $results = array();
        if ($idGroupMenu == '0') {
            $results = $this->createArrayDestroyDish($this->getDishDestroy($dateStart,$dateEnd,'-1'),$results,'-1');
            $results = $this->createArrayDestroyDish($this->getDishDestroy($dateStart,$dateEnd,'-3'),$results,'-3');
            $results = $this->createArrayDestroyDish($this->getDishDestroy($dateStart,$dateEnd,'-2'),$results,'-2');
        } else {
            $results = $this->createArrayDestroyDish($this->getDishDestroyByIdGroupMenu($dateStart,$dateEnd,'-1',$idGroupMenu),$results,'-1');
            $results = $this->createArrayDestroyDish($this->getDishDestroyByIdGroupMenu($dateStart,$dateEnd,'-3',$idGroupMenu),$results,'-3');
            $results = $this->createArrayDestroyDish($this->getDishDestroyByIdGroupMenu($dateStart,$dateEnd,'-2',$idGroupMenu),$results,'-2');
        }
        $groupMenuChoosen = GroupMenu::where('id',$idGroupMenu)->first();
        $listGroupMenuExcept = GroupMenu::whereNotIn('id',[$idGroupMenu])->get();
        $listGroupMenu = GroupMenu::where('status','1')->get();
        return view('report.p_destroydish',compact('results','dateStart','dateEnd','groupMenuChoosen','listGroupMenuExcept','listGroupMenu','idGroupMenu'));
    }

    public function createFooterTotalSupplier($results)
    {
        $total = 0; $paid = 0; $unPaid = 0;
        foreach ($results as $key => $result) {
            $total += $result['total'];
            $paid += $result['paid'];
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

    public function getResultImports($dateStart,$dateEnd, $idSupplier)
    {
        if($idSupplier == 0){
            $resultImports = ImportCoupon::whereBetween('created_at',[$dateStart,$dateEnd])->orderBy('id_supplier','asc')->with('supplier')->get();
        }else{
            $resultImports = ImportCoupon::whereBetween('created_at',[$dateStart,$dateEnd])->where('id_supplier',$idSupplier)
                                            ->orderBy('id_supplier','asc')->with('supplier')->get();
        }
        return $resultImports;
    }

    public function getPaidByIdCoupon($dateStart,$dateEnd,$idImportCoupon)
    {
        $paid = ImportCoupon::whereBetween('updated_at',[$dateStart,$dateEnd])->where('id',$idImportCoupon)->value('paid');
        return $paid == null ? 0 : $paid;
    }

    public function createArrayReportSupplier($dateStart,$dateEnd,$imports)
    {
        $data = array();
        if(empty($imports)){
            return $data;
        }else{
            foreach ($imports as $key => $import) {
                $temp = [
                    'STT' => $key + 1,
                    'code' => $import->code,
                    'name' => $import->supplier->name,
                    'total' => $import->total,
                    'paid' => $this->getPaidByIdCoupon($dateStart,$dateEnd,$import->id),
                    'unpaid' => $import->total - $this->getPaidByIdCoupon($dateStart,$dateEnd,$import->id),
                    'status' => $import->status,
                    'created_at' => $import->created_at,
                    'created_by' => $import->created_by,
                ];
                array_push($data,$temp);
                unset($temp);
            }
            return $data;
        }
    }
    public function reportSupplier($request)
    {
        $dateStart = $request->dateStart;
        $dateEnd = $request->dateEnd;
        $idSupplier = $request->idSupplier;
        $imports = $this->getResultImports($dateStart,$dateEnd,$idSupplier);
        $results = $this->createArrayReportSupplier($dateStart,$dateEnd,$imports);
        $supplierChoosen = Supplier::where('id',$idSupplier)->first();
        $listSupplier = Supplier::whereNotIn('id',[$idSupplier])->get();
        $suppliers = Supplier::all();
        $footerTotalSupplier = $this->createFooterTotalSupplier($results);
        $dataChart = $this->createArrayChartSupplier($dateStart,$dateEnd);
        return view('report.p_supplier',compact('results','dateStart','dateEnd','idSupplier','supplierChoosen',
                                                'listSupplier','suppliers','footerTotalSupplier','dataChart'));
    }

    public function getRevenue($dateStart,$dateEnd)
    {
        $revenue = Order::selectRaw('sum(total_price) as total')->whereBetween('created_at',[$dateStart,$dateEnd])->where('status','0')->value('total');
        return $revenue == null ? 0 : $revenue;
    }

    public function getCapitalPriceOfDish($dateStart,$dateEnd)
    {
        $dishOrders = OrderDetailTable::selectRaw('id_dish, sum(qty) as sumQty')->whereBetween('updated_at',[$dateStart,$dateEnd])
                                        ->whereIn('status',['1','2'])->groupBy('id_dish')->with('dish')->get();
        $capitalPrice = 0;
        foreach ($dishOrders as $key => $dishOrder) {
            $capitalPrice += ($dishOrder->sumQty) * ($dishOrder->dish->capital_price);
        }
        return $capitalPrice;
    }

    public function getTotalPayment($dateStart,$dateEnd)
    {
        $payCash = PaymentVoucher::selectRaw('sum(pay_cash) as total')->whereBetween('created_at',[$dateStart,$dateEnd])->value('total');
        return $payCash == null ? 0 : $payCash;
    }

    public function getExpense($dateStart,$dateEnd)
    {
        $capitalPrice = $this->getCapitalPriceOfDish($dateStart,$dateEnd);
        $payCash = $this->getTotalPayment($dateStart,$dateEnd);
        return $capitalPrice + $payCash;
    }

    public function createDataChartProfitIndex($dateStart,$dateEnd)
    {
        $obj = array(
            'month' => $dateStart,
            'revenue' => $this->getRevenue($dateStart,$dateEnd),
            'expense' => $this->getExpense($dateStart,$dateEnd),
            'profit'  => $this->getRevenue($dateStart,$dateEnd) - $this->getExpense($dateStart,$dateEnd)
        );
        return $obj;
    }

    public function getAllProfit()
    {
        $data = array();
        array_push($data,$this->createDataChartProfitIndex($this->getDateTime->getFirstOfJan(),$this->getDateTime->getEndOfJan()));
        array_push($data,$this->createDataChartProfitIndex($this->getDateTime->getFirstOfFreb(),$this->getDateTime->getEndOfFreb()));
        array_push($data,$this->createDataChartProfitIndex($this->getDateTime->getFirstOfMar(),$this->getDateTime->getEndOfMar()));
        array_push($data,$this->createDataChartProfitIndex($this->getDateTime->getFirstOfApr(),$this->getDateTime->getEndOfApr()));
        array_push($data,$this->createDataChartProfitIndex($this->getDateTime->getFirstOfMay(),$this->getDateTime->getEndOfMay()));
        array_push($data,$this->createDataChartProfitIndex($this->getDateTime->getFirstOfJun(),$this->getDateTime->getEndOfJun()));
        array_push($data,$this->createDataChartProfitIndex($this->getDateTime->getFirstOfJul(),$this->getDateTime->getEndOfJul()));
        array_push($data,$this->createDataChartProfitIndex($this->getDateTime->getFirstOfAug(),$this->getDateTime->getEndOfAug()));
        array_push($data,$this->createDataChartProfitIndex($this->getDateTime->getFirstOfSep(),$this->getDateTime->getEndOfSep()));
        array_push($data,$this->createDataChartProfitIndex($this->getDateTime->getFirstOfOct(),$this->getDateTime->getEndOfOct()));
        array_push($data,$this->createDataChartProfitIndex($this->getDateTime->getFirstOfNov(),$this->getDateTime->getEndOfNov()));
        array_push($data,$this->createDataChartProfitIndex($this->getDateTime->getFirstOfDec(),$this->getDateTime->getEndOfDec()));
        return $data;
    }

    public function indexReportProfit()
    {
        $now = Carbon::now('Asia/Ho_Chi_Minh');
        $firstMonth = $now->firstOfMonth()->format('Y-m-d');
        $endMonth = $now->endOfMonth()->format('Y-m-d');
        $revenue = $this->getRevenue($firstMonth,$endMonth);
        $expense = $this->getExpense($firstMonth,$endMonth);
        $profit = $revenue - $expense;
        $dataChart = $this->getAllProfit();
        return view('report.profit',compact('revenue','expense','profit','firstMonth','endMonth','dataChart'));
    }

    public function getToTalRevenueInYear()
    {
        $firstYear = $this->getDateTime->getFirstOfJan();
        $lastYear = $this->getDateTime->getEndOfDec();
        $totalRevenue = Order::selectRaw('sum(total_price) as total')->whereBetween('created_at',[$firstYear,$lastYear])->value('total');
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
