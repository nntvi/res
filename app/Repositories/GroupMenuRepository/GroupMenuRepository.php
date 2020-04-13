<?php
namespace App\Repositories\GroupMenuRepository;

use App\Http\Controllers\Controller;
use App\Repositories\GroupMenuRepository\IGroupMenuRepository;
use App\GroupMenu;
use App\CookArea;
use App\Dishes;

class GroupMenuRepository extends Controller implements IGroupMenuRepository{
    public function getAllGroupMenu()
    {
        $groupmenus = GroupMenu::with('cookArea')->paginate(5);
        $cooks = CookArea::all();
        $cook_active = array();
        foreach ($cooks as $key => $cook) {
            if($cook->status != '0'){
                $cook_active[] = $cook;
            }
        }
        return view('groupmenu.index',compact('groupmenus','cook_active'));
    }

    public function validatorRequestStore($req){
        $messeages = [
            'name.required' => 'Không để trống tên nhóm thực đơn',
            'name.min' => 'Tên thực đơn nhiều hơn 3 ký tự',
            'name.max' => 'Tên thực đơn giới hạn 30 ký tự',
            'name.unique' => 'Tên thực đơn vừa nhập đã tồn tại trong hệ thống',

            'idCook.required' => 'Vui lòng chọn bếp cho nhóm thực đơn',
        ];

        $req->validate(
            [
                'name' => 'required|min:3|max:30|unique:groupmenu,name',
                'idCook' =>'required'
            ],
            $messeages
        );
    }
    public function validatorRequestUpadate($req){
        $req->validate([
                'nameGroupMenu' => 'unique:groupmenu,name',
            ],
            [
                'nameGroupMenu.unique' => 'Tên thực đơn vừa nhập đã tồn tại trong hệ thống'
        ]);
    }

    public function addGroupMenu($request)
    {
        $groupmenu = new GroupMenu();
        $groupmenu->name = $request->name;
        $groupmenu->id_cook = $request->idCook;
        //dd($groupmenu);
        $groupmenu->save();
        return redirect(route('groupmenu.index'));
    }

    public function searchGroupMenu($request)
    {
        $temp = $request->nameSearch;
        $groupmenus = GroupMenu::where('name','LIKE',"%{$temp}%")->get();
        $cooks = CookArea::all();
        $cook_active = array();
        foreach ($cooks as $key => $cook) {
            if($cook->status != '0'){
                $cook_active[] = $cook;
            }
        }
        return view('groupmenu.search',compact('groupmenus','cook_active'));
    }
    public function updateNameGroupMenu($request, $id)
    {
        GroupMenu::where('id',$id)->update(['name' => $request->nameGroupMenu]);

        return redirect(route('groupmenu.index'));
    }
    public function updateCookGroupMenu($request, $id)
    {
        GroupMenu::where('id',$id)->update(['id_cook' => $request->idCook]);
        return redirect(route('groupmenu.index'));
    }
    public function deleteGroupMenu($id)
    {
        $groupmenu = GroupMenu::find($id)->delete();
        $dishes = Dishes::where('id_groupmenu',$id)->delete();
        return redirect(route('groupmenu.index'));
    }
}
