<?php
namespace App\Repositories\ToppingRepository;

use App\GroupMenu;
use App\Http\Controllers\Controller;
use App\Repositories\ToppingRepository\IToppingRepository;
use App\Topping;
use App\WareHouse;

class ToppingRepository extends Controller implements IToppingRepository{
    public function getAllGroupMenu()
    {
        return $groupMenus = GroupMenu::all();
    }
    public function getAllTopping()
    {
        $toppings = Topping::with('groupMenu')->paginate(5);
        return $toppings;
    }

    public function validatorRequestStore($req){
        $req->validate( ['nameTopping' => 'unique:topping,name'],
                        ['nameTopping.unique' => 'Tên vừa thêm đã tồn tại trong hệ thống']
        );
    }

    public function validatorRequestUpdateName($req){
        $req->validate( [ 'nameToppingUpdate' => 'unique:topping,name'],
                        ['nameToppingUpdate.unique' => 'Tên vừa thay đổi đã tồn tại trong hệ thống']);
    }

    public function addTopping($request)
    {
        $topping = new Topping();
        $topping->name = $request->nameTopping;
        $topping->price = $request->priceTopping;
        $topping->id_groupmenu = $request->idGroupMenu;
        $topping->save();

        $warehouse = new WareHouse();
        $warehouse->id_type = $request->idGroupMenu;
        $warehouse->id_material_detail = $topping->id;
        $warehouse->qty = 0;
        $warehouse->id_unit = $request->idUnit;
        $warehouse->tondauky = 0;
        $warehouse->save();

        return redirect(route('topping.index'));
    }
    public function searchTopping($request)
    {
        $name = $request->nameSearch;
        $toppings = Topping::where('name','LIKE',"%{$name}%")->with('groupMenu')->get();
        $groupMenus = $this->getAllGroupMenu();
        return view('topping.search',compact('toppings','groupMenus'));
    }

    public function updateNameTopping($request,$id)
    {
        Topping::where('id',$id)->update(['name' => $request->nameToppingUpdate]);
        return redirect(route('topping.index'));
    }
    public function updatePriceTopping($request,$id)
    {
        Topping::where('id',$id)->update(['price' => $request->priceTopping]);
        return redirect(route('topping.index'));
    }
    public function updateGroupTopping($request,$id)
    {
        Topping::where('id',$id)->update(['id_groupmenu' => $request->idGroupMenu]);
        return redirect(route('topping.index'));
    }
    public function deleteTopping($id)
    {
        $topping = Topping::find($id)->delete();
        return redirect(route('topping.index'));
    }
}
