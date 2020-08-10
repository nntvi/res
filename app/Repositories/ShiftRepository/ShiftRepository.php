<?php
namespace App\Repositories\ShiftRepository;

use App\Http\Controllers\Controller;
use App\Shift;

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
        $request->validate(['nameShift' => 'unique:shifts,name'],
                            ['nameShift.unique' => 'Tên vừa nhập đã có trong hệ thống']);
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
        foreach ($shifts as $key => $shift) {
            if($request->timeStart > $shift->hour_start && $request->timeStart < $shift->hour_end){
                $temp++;
            }
        }
        return $temp;
    }

    public function checkEndTime($shifts,$request)
    {
        $temp = 0;
        foreach ($shifts as $key => $shift) {
            if($request->timeEnd > $shift->hour_start && $request->timeEnd < $shift->hour_end){
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
        if($checkStart == 0 && $checkEnd == 0){
            Shift::where('id',$id)->update(['hour_start' => $request->timeStart,'hour_end' => $request->timeEnd]);
            return redirect(route('shift.index'))->with('info','Cập nhật thời gian thành công');
        }else{
            return redirect(route('shift.index'))->withErrors('Thời gian thay đổi bị trùng với khoảng thời gian khác');
        }
    }
}
