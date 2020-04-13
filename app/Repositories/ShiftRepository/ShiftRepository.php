<?php
namespace App\Repositories\ShiftRepository;

use App\Http\Controllers\Controller;
use App\Shift;

class ShiftRepository extends Controller implements IShiftRepository{

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
        // dd($shift);
        $shift->save();
        return redirect(route('shift.index'));
    }

    public function updateNameShift($request, $id)
    {
        Shift::where('id',$id)->update(['name' => $request->nameShift]);
        return redirect(route('shift.index'));
    }

    public function updateTimeShift($request,$id)
    {
        Shift::where('id',$id)->update(['hour_start' => $request->timeStart],
                                        ['hour_end' => $request->timeEnd]);
        return redirect(route('shift.index'));
    }

    public function deleteShift($id)
    {
        Shift::where('id',$id)->delete();
        return redirect(route('shift.index'));
    }
}
