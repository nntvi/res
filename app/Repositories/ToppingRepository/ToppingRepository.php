<?php
namespace App\Repositories\ToppingRepository;

use App\GroupMenu;
use App\Http\Controllers\Controller;
use App\Repositories\ToppingRepository\IToppingRepository;
use App\Topping;

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
        $messeages = [
            'nameTopping.required' => 'Không để trống tên Topping',
            'nameTopping.min' => 'Tên topping nhiều hơn 3 ký tự',
            'nameTopping.max' => 'Tên topping giới hạn 30 ký tự',

            'priceTopping.required' => 'Không để trống tên Topping',

            'idGroupMenu.required' => 'Không để trống nhóm thực đơn'
        ];

        $req->validate(
            [
                'nameTopping' => 'required|min:3|max:30',
                'priceTopping' => 'required',
                'idGroupMenu' => 'required'
            ],
            $messeages
        );
    }

    public function validatorRequestUpdate($req){
        $messeages = [
            'name.required' => 'Không để trống tên Topping',
            'name.min' => 'Tên topping nhiều hơn 3 ký tự',
            'name.max' => 'Tên topping giới hạn 30 ký tự',

            'price.required' => 'Không để trống giá Topping',

        ];

        $req->validate(
            [
                'name' => 'required|min:3|max:30',
                'price' => 'required',
            ],
            $messeages
        );
    }

    public function addTopping($request)
    {
        $topping = new Topping();
        $topping->name = $request->nameTopping;
        $topping->price = $request->priceTopping;
        $topping->id_groupmenu = $request->idGroupMenu;
        $topping->save();
        return redirect(route('topping.index'));
    }

    public function updateTopping($request,$id)
    {
        $topping = Topping::find($id);
        $topping->name = $request->name;
        $topping->price = $request->price;
        $topping->id_groupmenu = $request->toppingFrom;
        $topping->save();
        return redirect(route('topping.index'));
    }

    public function deleteTopping($id)
    {
        $topping = Topping::find($id)->delete();
        return redirect(route('topping.index'));
    }
}
