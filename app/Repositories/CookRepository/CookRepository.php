<?php
namespace App\Repositories\CookRepository;

use App\Http\Controllers\Controller;
use App\CookArea;
use App\GroupMenu;

class CookRepository extends Controller implements ICookRepository{

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

    public function getGroupMenuByIdCook($idcook)
    {
        $groupmenus = GroupMenu::where('id_cook',$idcook)->get();
        return $groupmenus;
    }

    public function updateCook($request, $id)
    {
        $cook = $this->findCookById($id);
        $cook->status = $request->status;
        $cook->save();
        $groupmenus = $this->getGroupMenuByIdCook($id);
        if($request->status == '0'){ // nếu bếp cập nhật lại ko hđ
            GroupMenu::where('id_cook',$id)->update(['id_cook' => $request->status]);
        }
        return redirect(route('cook.index'));
    }
}
