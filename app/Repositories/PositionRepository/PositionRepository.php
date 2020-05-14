<?php
namespace App\Repositories\PositionRepository;

use App\Http\Controllers\Controller;
use App\Position;
use App\User;

class PositionRepository extends Controller implements IPositionRepository{

    public function show()
    {
        $positions = Position::paginate(10);
        return view('position.index',compact('positions'));
    }

    public function validateNamePosition($request)
    {
        $request->validate(['name' => 'unique:position,name'],['name.unique' => 'Tên chức vụ vừa nhập đã tồn tại trong hệ thông']);
    }

    public function storePosition($request)
    {
        $position = new Position();
        $position->name = $request->name;
        $position->salary = $request->salary;
        $position->save();
        return redirect(route('position.index'));
    }

    public function updateNamePosition($request,$id)
    {
        Position::where('id',$id)->update(['name' => $request->name]);
        return redirect(route('position.index'));
    }

    public function updateSalaryPosition($request,$id)
    {
        Position::where('id',$id)->update(['salary' => $request->salary]);
        return redirect(route('position.index'));
    }

    public function deletePosition($id)
    {
        User::where('id_position',$id)->update(['id_position' => null]);
        Position::where('id',$id)->delete();
        return redirect(route('position.index'));
    }
}
