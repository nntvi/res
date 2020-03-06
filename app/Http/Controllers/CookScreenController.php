<?php

namespace App\Http\Controllers;

use App\CookArea;
use App\OrderDetailTable;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Helper\ICheckAction;
class CookScreenController extends Controller
{
    private $checkAction;

    public function __construct(ICheckAction $checkAction)
    {
        $this->checkAction = $checkAction;
    }

    public function index()
    {
        $result = $this->checkAction->getPermission(auth()->id());
        $cooks = CookArea::all();
        return view('cookscreen.index',compact('cooks','result'));
    }

    public function getDetail($id)
    {
        $cook = CookArea::where('id',$id)->first();
        $date = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');
        $dishes = OrderDetailTable::whereBetween('created_at',[$date . ' 00:00:00', $date . ' 23:59:59'])
                                    ->orderBy('updated_at','asc')
                                    ->with('dish.groupMenu.cookArea')->get();
        $data = array();
        foreach ($dishes as $key => $dish) {
            if($dish->dish->groupMenu->cookArea->id == $id){
                array_push($data,$dish);
            }
        }
        return view('cookscreen.detail',compact('data','cook'));
    }

    public function update(Request $request, $id)
    {
        $idCook = $request->idCook;
        $dish = OrderDetailTable::find($id);
        $dish->status = $request->status;
        $dish->save();
        return redirect(route('cook_screen.detail',['id' => $idCook]));
    }
}
