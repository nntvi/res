<?php
namespace App\Repositories\CookRepository;

use App\Http\Controllers\Controller;
use App\CookArea;
use App\GroupMenu;

class CookRepository extends Controller implements ICookRepository{

    public function checkRoleIndex($arr)
    {
        $temp = 0;
        for ($i=0; $i < count($arr); $i++) {
            if($arr[$i] == "XEM_FULL" || $arr[$i] == "XEM_KHU_VUC"){
                $temp++;
            }
        }
        return $temp;
    }

    public function checkRoleUpdate($arr)
    {
        $temp = 0;
        for ($i=0; $i < count($arr); $i++) {
            if($arr[$i] == "XEM_FULL" || $arr[$i] == "SUA_KHU_VUC"){
                $temp++;
            }
        }
        return $temp;
    }

    public function getAllCook()
    {
        $groupmenus = GroupMenu::all();
        $cooks = CookArea::with('groupMenu')->get();
        return view('cook.index',compact('cooks','groupmenus'));
    }

    public function findCookById($id)
    {
        $cook = CookArea::find($id);
        return $cook;
    }

    public function getStatusOfCook($id)
    {
        $status = CookArea::where('id',$id)->value('status');
        return $status;
    }

    public function updateCook($request, $id)
    {
        if ($this->getStatusOfCook($id) == $request->status) {
            return redirect(route('cook.index'))->withErrors('Không cập nhật trạng thái trùng với trạng thái hiện tại');
        } else {
            $cook = $this->findCookById($id);
            $cook->status = $request->status;
            $cook->save();
            if($request->status == '0'){ // nếu bếp cập nhật lại ko hđ
                GroupMenu::where('id_cook',$id)->update(['status' => $request->status]);
            }
            return redirect(route('cook.index'))->withSuccess('Cập nhật thành công');
        }
    }
}
