<?php
namespace App\Repositories\GroupMenuRepository;

use App\Http\Controllers\Controller;
use App\Repositories\GroupMenuRepository\IGroupMenuRepository;
use App\GroupMenu;

class GroupMenuRepository extends Controller implements IGroupMenuRepository{
    public function getAllGroupMenu()
    {
        $groupmenus = GroupMenu::all();
        return view('groupmenu.index',compact('groupmenus'));
    }

    public function validatorRequestStore($req){
        $messeages = [
            'name.required' => 'Không để trống tên thực đơn',
            'name.min' => 'Tên thực đơn nhiều hơn 3 ký tự',
            'name.max' => 'Tên thực đơn giới hạn 30 ký tự',
            'name.unique' => 'Tên thực đơn vừa nhập đã tồn tại trong hệ thống'
        ];

        $req->validate(
            [
                'name' => 'required|min:3|max:30|unique:groupmenu,name',
            ],
            $messeages
        );
    }

    public function validatorRequestUpadate($req){
        $messeages = [
            'nameGroupArea.required' => 'Không để trống tên thực đơn',
            'nameGroupArea.min' => 'Tên thực đơn nhiều hơn 3 ký tự',
            'nameGroupArea.max' => 'Tên thực đơn giới hạn 30 ký tự',
            'nameGroupArea.unique' => 'Tên thực đơn vừa nhập đã tồn tại trong hệ thống'
        ];

        $req->validate(
            [
                'nameGroupArea' => 'required|min:3|max:30|unique:groupmenu,name',
            ],
            $messeages
        );
    }
    public function validatorRequestSearch($req){
        $messeages = [
            'nameSearch.required' => 'Tên tìm kiếm rỗng',
        ];

        $req->validate(
            [
                'nameSearch' => 'required',
            ],
            $messeages
        );
    }

    public function addGroupMenu($request)
    {
        $groupmenu = new GroupMenu();
        $groupmenu->name = $request->name;
        $groupmenu->save();
        return redirect(route('groupmenu.index'));
    }

    public function searchGroupMenu($request)
    {
        $temp = $request->nameSearch;
        $groupmenus = GroupMenu::where('name','LIKE',"%{$temp}%")->get();
        return view('groupmenu.search',compact('groupmenus'));
    }

    public function updateGroupMenu($request, $id)
    {
        $groupmenu = GroupMenu::find($id);
        $groupmenu->name = $request->nameGroupArea;
        $groupmenu->save();
        return redirect(route('groupmenu.index'));
    }
    public function deleteGroupMenu($id)
    {

    }
}
