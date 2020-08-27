<?php
namespace App\Repositories\ShiftRepository;

use DateTime;
use App\Shift;
use Carbon\Carbon;
use App\Http\Controllers\Controller;

class ShiftRepository extends Controller implements IShiftRepository{

    public function checkRoleIndex($arr)
    {
        $temp = 0;
        for ($i=0; $i < count($arr); $i++) {
            if($arr[$i] == "XEM_FULL"){
                $temp++;
            }
        }
        return $temp;
    }

    public function showIndex()
    {
        $shifts = Shift::all();
        return view('shift.index',compact('shifts'));
    }
    public function validateUnique($request)
    {
        $request->validate(['nameShift' => 'unique:shifts,name','timeEnd' => 'after:timeStart'],
                            ['nameShift.unique' => 'Tên vừa nhập đã có trong hệ thống',
                            'timeEnd.after' => 'Giờ kết thúc không nhỏ hơn hoặc bằng giờ bắt đầu' ]);
    }

    public function storeShift($request)
    {
        $shift = new Shift();
        $shift->name = $request->nameShift;
        $shift->hour_start = $request->hourStart;
        $shift->hour_end = $request->hourEnd;
        $shift->save();
        return redirect(route('shift.index'))->withSuccess('Thêm ca mới thành công');
    }

    public function updateNameShift($request, $id)
    {
        Shift::where('id',$id)->update(['name' => $request->nameShift]);
        return redirect(route('shift.index'))->with('info','Cập nhật tên ca thành công');
    }

    public function checkStartTime($shifts,$request)
    {
        $temp = 0;
        $startTime = Carbon::parse($request->timeStart)->format('H:i');
        foreach ($shifts as $key => $shift) {
            if($startTime > Carbon::parse($shift->hour_start)->format('H:i') && $startTime < Carbon::parse($shift->hour_end)->format('H"i')){
                $temp++;
            }
        }
        return $temp;
    }

    public function checkEndTime($shifts,$request)
    {
        $temp = 0;
        $endTime = Carbon::parse($request->timeEnd)->format('H:i');
        foreach ($shifts as $key => $shift) {
            if($endTime > Carbon::parse($shift->hour_start)->format('H:i') && $endTime < Carbon::parse($shift->hour_end)->format('H"i')){
                $temp++;
            }
        }
        return $temp;
    }

    public function substractTime($timeStart,$timeEnd)
    {
        $a = new DateTime($timeStart);
        $b = new DateTime($timeEnd);
        $interval = $a->diff($b);
        dd($interval->format("%H"));
    }

    public function containAnotherShift($request,$shifts)
    {
        $temp = 0;
        $startTime = Carbon::parse($request->timeStart)->format('H:i');
        $endTime = Carbon::parse($request->timeEnd)->format('H:i');
        foreach ($shifts as $key => $shift) {
            if(Carbon::parse($shift->hour_start)->format('H:i') > $startTime && Carbon::parse($shift->hour_end)->format('H"i') < $endTime){
                $temp++;
            }
        }
        return $temp;
    }
    public function updateTimeShift($request,$id)
    {
        $shifts = Shift::where('id','!=',$id)->get();
        $checkStart = $this->checkStartTime($shifts,$request);
        $checkEnd = $this->checkEndTime($shifts,$request);
        $contain = $this->containAnotherShift($request,$shifts);
        if($contain == 0){
            if($checkStart == 0 && $checkEnd == 0){
                Shift::where('id',$id)->update(['hour_start' => $request->timeStart,'hour_end' => $request->timeEnd]);
                return redirect(route('shift.index'))->with('info','Cập nhật thời gian thành công');
            }else{
                return redirect(route('shift.index'))->withErrors('Thời gian thay đổi bị trùng với khoảng thời gian khác');
            }
        }else{
            return redirect(route('shift.index'))->withErrors('Thời gian thay đổi chứa ca làm việc khác');
        }
    }
}
