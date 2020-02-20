<?php

namespace App\Http\Controllers;

use App\CookArea;
use App\GroupMenu;
use App\Repositories\CookRepository\ICookRepository;
use Illuminate\Http\Request;

class CookController extends Controller
{
    private $cookRepository;

    public function __construct(ICookRepository $cookRepository)
    {
        $this->cookRepository = $cookRepository;
    }

    public function index()
    {
        return $this->cookRepository->getAllCook();
    }

    public function update(Request $request, $id)
    {
        $cook = CookArea::find($id);
        $cook->status = $request->status;
        $cook->save();

        // lấy ra group menu có id_cook = id bếp đang sửa
        $groupmenus = GroupMenu::where('id_cook',$id)->get();
        if($request->status == '0'){ // nếu bếp cập nhật lại ko hđ
            foreach ($groupmenus as $key => $groupmenu) {
                $groupmenu->id_cook = $request->status;
                $groupmenu->save();
            }
        }else{ // = 1 cập nhật bếp đó hđ
            foreach ($groupmenus as $key => $groupmenu) {
                if($groupmenu->id_cook == $id){
                    $groupmenu->id_cook = $id;
                    $groupmenu->save();
                }
            }
        }
    }
}
