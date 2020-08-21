<?php
namespace App\Repositories\DishRepository;

use App\Dishes;
use App\Http\Controllers\Controller;
use App\GroupMenu;
use App\Material;
use App\MaterialDetail;
use App\Unit;

class DishRepository extends Controller implements IDishRepository{
    public function checkRoleIndex($arr)
    {
        $temp = 0;
        for ($i=0; $i < count($arr); $i++) {
            if($arr[$i] == "XEM_FULL" || $arr[$i] == "XEM_MON_AN"){
                $temp++;
            }
        }
        return $temp;
    }

    public function checkRoleStore($arr)
    {
        $temp = 0;
        for ($i=0; $i < count($arr); $i++) {
            if($arr[$i] == "XEM_FULL" || $arr[$i] == "TAO_MON_AN"){
                $temp++;
            }
        }
        return $temp;
    }

    public function checkRoleUpdate($arr)
    {
        $temp = 0;
        for ($i=0; $i < count($arr); $i++) {
            if($arr[$i] == "XEM_FULL" || $arr[$i] == "SUA_MON_AN"){
                $temp++;
            }
        }
        return $temp;
    }

    public function checkRoleDelete($arr)
    {
        $temp = 0;
        for ($i=0; $i < count($arr); $i++) {
            if($arr[$i] == "XEM_FULL" || $arr[$i] == "XOA_MON_AN"){
                $temp++;
            }
        }
        return $temp;
    }

    public function getGroupMenu()
    {
        $groupmenus = GroupMenu::all();
        return $groupmenus;
    }

    public function getUnit()
    {
        $units = Unit::orderBy('name')->get();
        return $units;
    }
    public function getMaterial()
    {
        $idOldMaterials = Dishes::get('id_groupnvl');
        $materials = Material::whereNotIn('id',$idOldMaterials)->where('status','1')->get();
        return $materials;
    }
    public function getMaterialDetail()
    {
        $materialDetails = MaterialDetail::all();
        return $materialDetails;
    }

    public function validateImage($request)
    {
        $request->validate(['file' => 'image'],
        ['file.image' => 'File vừa chọn không phải file ảnh']);
    }

    public function validatorRequestStore($req){
        $req->validate(
            [
                'status' => 'required',
                'codeDish' => 'unique:dishes,code',
                'file' => 'image',
                'capitalPriceHidden' => 'required',
                'idMaterial' => 'required',
            ],
            [
                'idMaterial.required' => 'Không để trống tên món',
                'status.required' => 'Chọn trạng thái hiển thị',
                'codeDish.unique' => 'Mã sản phẩm đã tồn tại trong hệ thống',
                'file.image' => 'File vừa chọn không phải file ảnh',
                'capitalPriceHidden.required' => 'Vui lòng click chọn tên món ăn để giá vốn không bị trống',
            ]
        );
    }

    public function getNameByIdMaterial($idMaterial)
    {
        $name = Material::where('id',$idMaterial)->value('name');
        return $name;
    }

    public function getIdGroupMenuByIdMaterial($idMaterial)
    {
        $idGroupMenu = Material::where('id',$idMaterial)->value('id_groupmenu');
        return $idGroupMenu;
    }

    public function getImage($request)
    {
        if($request->hasFile('file')){
            // mảng chứa đuôi file
            $type_allow = array('png', 'jpg', 'gift', 'jpeg');
            $error = array();
            $fileUpload = $request->file('file');
            $nameFile = $fileUpload->getClientOriginalName();
            $duoiFile = $fileUpload->getClientOriginalExtension(); // duoifile
            $file_name = pathinfo( $nameFile, PATHINFO_FILENAME); // ko duoi
            $image = $file_name. "." . $duoiFile;

                $k=1;
                while(file_exists("img/".$nameFile)){
                    $nameFile = $file_name . "-Copy({$k})." . $duoiFile ;
                    $k++;
                }
                $fileUpload->move("img/",$nameFile);
                return $image;

        }
    }
    public function addDish($request)
    {
        $dish = new Dishes();
        $dish->code = $request->codeDish;
        $dish->name = $this->getNameByIdMaterial($request->idMaterial);
        $dish->capital_price = $request->capitalPriceHidden;
        $dish->sale_price = $request->salePrice;
        $dish->id_dvt = $request->idUnit;
        $dish->stt = '1';
        $dish->describe = $request->describe;
        $dish->status = $request->status;
        $dish->id_groupnvl = $request->idMaterial;
        $dish->id_groupmenu = $this->getIdGroupMenuByIdMaterial($request->idMaterial);
        $dish->image = $this->getImage($request,1);
        $dish->save();
        return redirect(route('dishes.index'))->withSuccess('Thêm món ăn thành công');
    }

    public function updateImageDish($request,$id)
    {
        $newImg = $this->getImage($request);
        Dishes::where('id',$id)->update(['image' => $newImg]);
        return redirect(route('dishes.index'))->with('info','Cập nhật hình ảnh thành công');
    }

    public function updateSalePriceDish($request,$id)
    {
       Dishes::where('id',$id)->update(array('capital_price' => $request->newCapitalPriceHidden,'sale_price' => $request->newSalePriceUpdate));
       return redirect(route('dishes.index'))->with('info','Cập nhật giá sản phẩm thành công');
    }

    public function updateUnitDish($request,$id)
    {
        Dishes::where('id',$id)->update(['id_dvt' => $request->unitUpdate]);
        return redirect(route('dishes.index'))->with('info','Cập nhật đơn vị thành công');
    }

    public function updateStatusDish($request,$id)
    {
        Dishes::where('id',$id)->update(['status' => $request->status]);
        return redirect(route('dishes.index'))->with('info','Cập nhật trạng thái thành công');
    }

    public function updateNoteDish($request,$id)
    {
        Dishes::where('id',$id)->update(['describe' => $request->describe]);
        return redirect(route('dishes.index'))->with('info','Cập nhật mô tả thành công');
    }

    public function deleteDish($id)
    {
        $dish = Dishes::find($id)->delete();
        return redirect(route('dishes.index'))->withSuccess('Xóa món ăn thành công');
    }
}
