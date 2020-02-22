<?php
namespace App\Repositories\DishRepository;

use App\Dishes;
use App\Http\Controllers\Controller;
use App\GroupMenu;
use App\Unit;

class DishRepository extends Controller implements IDishRepository{
    public function getGroupMenu()
    {
        $groupmenus = GroupMenu::all();
        $units = Unit::all();
        return $groupmenus;
    }

    public function getUnit()
    {
        $units = Unit::orderBy('name')->get();
        return $units;
    }

    public function validatorRequestStore($req){
        $messeages = [
            'name.required' => 'Không để trống tên món',
            'name.min' => 'Tên món nhiều hơn 2 ký tự',
            'name.max' => 'Tên món giới hạn 40 ký tự',
            'name.unique' => 'Tên món vừa nhập đã tồn tại trong hệ thống',

            'idGroupMenu.required' => 'Vui lòng chọn nhóm thực đơn',
            'salePrice.required' => 'Không để trống giá bán',
            'status.required' => 'Chọn trạng thái hiển thị',
            'capitalPrice.required' => 'Không để trống giá vốn',
            'codeDish.required' => 'Không để trống mã sản phẩm',
            'codeDish.required' => 'Mã sản phẩm ít nhất 3 ký tự',
            'codeDish.required' => 'Mã sản phẩm giới hạn 15 ký tự',
            'tax.required' => 'Không để trống mã thuế',
            'file.required' => 'Cần chọn file ảnh',
        ];

        $req->validate(
            [
                'name' => 'required|unique:dishes,name|min:2|max:40',
                'idGroupMenu' => 'required',
                'salePrice' => 'required',
                'status' => 'required',
                'capitalPrice' => 'required',
                'codeDish' => 'required|min:2|max:15',
                'tax' => 'required',
                'file' => 'required',
            ],
            $messeages
        );
    }

    public function addDish($request)
    {
        $dish = new Dishes();
        $dish->name = $request->name;
        $dish->id_groupmenu = $request->idGroupMenu;
        $dish->sale_price = $request->salePrice;
        $dish->follow_price = $request->followPrice;
        $dish->id_dvt = $request->id_dvt;
        $dish->capital_price = $request->capitalPrice;
        $dish->code = $request->codeDish;
        $dish->tax = $request->tax;
        $dish->describe = $request->note;
        $dish->status = $request->status;

        if($request->hasFile('file')){
            // mảng chứa đuôi file
            $type_allow = array('png', 'jpg', 'gift', 'jpeg');
            $error = array();
            $fileUpload = $request->file('file');
            $nameFile = $fileUpload->getClientOriginalName();
            $duoiFile = $fileUpload->getClientOriginalExtension(); // duoifile
            $file_name = pathinfo( $nameFile, PATHINFO_FILENAME); // ko duoi
            $image = $file_name. "." . $duoiFile;
            if(!in_array(strtolower($duoiFile),$type_allow)){
               return redirect(route('dishes.store'))->with('mes_error','File vừa chọn không phải là file ảnh');
            }else{
                $k=1;
                while(file_exists("img/".$nameFile)){
                    $nameFile = $file_name . "-Copy({$k})." . $duoiFile ;
                    $k++;
                }
                $fileUpload->move("img/",$nameFile);
                $dish->image = $image;
            }

        }else{
            $error['empty'] = "Chưa chọn file ảnh";
        }
        $dish->save();
        return redirect(route('dishes.index'));
    }

    public function showUpdateDish($id)
    {
        $dish = Dishes::with('groupmenu','unit')->find($id);
        return $dish;
    }

    public function validatorRequestUpdate($req){
        $messeages = [
            'name.required' => 'Không để trống tên món',
            'name.min' => 'Tên món nhiều hơn 2 ký tự',
            'name.max' => 'Tên món giới hạn 40 ký tự',

            'idGroupMenu.required' => 'Vui lòng chọn nhóm thực đơn',
            'salePrice.required' => 'Không để trống giá bán',
            'status.required' => 'Chọn trạng thái hiển thị',
            'capitalPrice.required' => 'Không để trống giá vốn',
            'codeDish.required' => 'Không để trống mã sản phẩm',
            'codeDish.required' => 'Mã sản phẩm ít nhất 3 ký tự',
            'codeDish.required' => 'Mã sản phẩm giới hạn 15 ký tự',
            'tax.required' => 'Không để trống mã thuế',
        ];

        $req->validate(
            [
                'name' => 'required|min:2|max:40',
                'idGroupMenu' => 'required',
                'salePrice' => 'required',
                'status' => 'required',
                'capitalPrice' => 'required',
                'codeDish' => 'required|min:2|max:15',
                'tax' => 'required',
            ],
            $messeages
        );
    }

    public function updateDish($request, $id)
    {
        $dish = Dishes::find($id);
        $dish->name = $request->name;
        $dish->id_groupmenu = $request->idGroupMenu;
        $dish->sale_price = $request->salePrice;
        $dish->follow_price = $request->followPrice;
        $dish->id_dvt = $request->id_dvt;
        $dish->capital_price = $request->capitalPrice;
        $dish->tax = $request->tax;
        $dish->describe = $request->note;
        $dish->status = $request->status;

        if($request->hasFile('file')){
            // mảng chứa đuôi file
            $type_allow = array('png', 'jpg', 'gift', 'jpeg');
            $error = array();
            $fileUpload = $request->file('file');
            $nameFile = $fileUpload->getClientOriginalName();
            $duoiFile = $fileUpload->getClientOriginalExtension(); // duoifile
            $file_name = pathinfo( $nameFile, PATHINFO_FILENAME); // ko duoi
            $image = $file_name. "." . $duoiFile;
            if(!in_array(strtolower($duoiFile),$type_allow)){
               $error['not_image'] = "Không phải file ảnh";
            }else{
                $k=1;
                while(file_exists("img/".$nameFile)){
                    $nameFile = $file_name . "-Copy({$k})." . $duoiFile ;
                    $k++;
                }
                $fileUpload->move("img/",$nameFile);
                $dish->image = $image;
            }

        }else{
            $error['empty'] = "Chưa chọn file ảnh";
        }
        $dish->save();
        return redirect(route('dishes.index'));
    }

    public function validatorRequestSearch($req){
        $messeages = [
           'idGroupMenuSearch.required' => 'Vui lòng chọn nhóm thực đơn'
        ];

        $req->validate(
            [
               'idGroupMenuSearch' => 'required'
            ],
            $messeages
        );
    }
    public function searchDish($request)
    {
        $name = $request->nameSearch;
        $idGroupMenu = $request->idGroupMenuSearch;
        if($name == ""){
            $dishes = Dishes::with('groupMenu.cookArea','unit')->where('id_groupmenu',$idGroupMenu)->get();
        }else{
            $dishes = Dishes::with('groupMenu.cookArea','unit')->where([
                ['name', 'LIKE', "%{$name}%"],
                ['id_groupmenu', $idGroupMenu],
            ])->get();
        }
       return $dishes;
    }

    public function deleteDish($id)
    {
        $dish = Dishes::find($id)->delete();
        return redirect(route('dishes.index'));
    }
}
