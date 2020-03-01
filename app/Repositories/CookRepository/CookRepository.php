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

    public function updateCook($request, $id)
    {

    }
}
