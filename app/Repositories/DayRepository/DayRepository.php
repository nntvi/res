<?php
namespace App\Repositories\DayRepository;

use App\EndDay;
use App\HistoryWhCook;
use App\Http\Controllers\Controller;
use App\StartDay;
use App\WarehouseCook;
use Carbon\Carbon;

class DayRepository extends Controller implements IDayRepository{

    public function getDayToday()
    {
        $toDay = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');
        return $toDay;
    }
    public function getTimeToday()
    {
        $time = Carbon::now('Asia/Ho_Chi_Minh')->format('H:m:s');
        return $time;
    }
    public function checkStartDay()
    {
        $result = StartDay::where('date',$this->getDayToday())->value('id');
        return $result == null ? '0' : $result ;
    }

    public function checkEndDay()
    {
        $result = EndDay::where('date',$this->getDayToday())->value('id');
        return $result == null ? '0' : $result ;
    }

    public function saveFirstQtyStartDay()
    {
        $whCook = WarehouseCook::with('cookArea')->get();
        foreach ($whCook as $key => $item) {
            if($item->cookArea != null){ // bếp đã hủy hoạt động
                $historyWhCook = new HistoryWhCook();
                $historyWhCook->id_cook = $item->cook;
                $historyWhCook->id_material_detail = $item->id_material_detail;
                $historyWhCook->first_qty = $item->qty;
                $historyWhCook->last_qty = $item->qty;
                $historyWhCook->id_unit = $item->id_unit;
                $historyWhCook->save();
            }
        }
    }
    public function startDay()
    {
        $check = $this->checkStartDay();
        if($check == '0'){ // chưa khai ca trong ngày
            $day = new StartDay();
            $day->date = $this->getDayToday();
            $day->time = $this->getTimeToday();
            $this->saveFirstQtyStartDay();
            $day->save();
            return redirect(route('area.index'))->withSuccess('Dữ liệu ngày mới được lưu vào hệ thống');
        }
        else{
            return redirect(route('area.index'))->with('warning','Bạn đã khai ca cho ngày hôm nay rồi!');
        }
    }

    public function saveLastQtyEndDay()
    {
        $s = " 00:00:00";
        $e = " 23:59:59";
        $today = $this->getDayToday();
        $historyWhCook = HistoryWhCook::whereBetween('created_at',[$today . $s, $today . $e ])->get();
        $warehouseCook = WarehouseCook::all();
        foreach ($historyWhCook as $key => $history) {
            foreach ($warehouseCook as $key => $whCook) {
                if($whCook->cook == $history->id_cook && $history->id_material_detail == $whCook->id_material_detail){
                        $history->last_qty = $whCook->qty;
                        $history->save();
                }
            }
        }
    }
    public function endDay()
    {
        $check = $this->checkEndDay();
        if($check == '0'){ // chưa chốt ca trong ngày
            $day = new EndDay();
            $day->date = $this->getDayToday();
            $day->time = $this->getTimeToday();
            $this->saveLastQtyEndDay();
            $day->save();
            return redirect(route('area.index'))->withSuccess('Đã chốt ca ngày hôm nay');
        }
        else{
            return redirect(route('area.index'))->with('warning','Bạn đã chốt ca hôm nay rồi!');
        }
    }
}
