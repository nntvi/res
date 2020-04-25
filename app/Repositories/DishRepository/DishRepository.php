<?php
namespace App\Repositories\DishRepository;

use App\Dishes;
use App\Http\Controllers\Controller;
use App\GroupMenu;
use App\Material;
use App\MaterialDetail;
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
    public function getMaterial()
    {
        $materials = Material::all();
        return $materials;
    }
    public function getMaterialDetail()
    {
        $materialDetails = MaterialDetail::all();
        return $materialDetails;
    }

    public function validateImage($request)
    {
        $request->validate(['file' => 'image'],['file.image' => 'File vừa chọn không phải file ảnh']);
    }
    public function validatorRequestStore($req){
        $req->validate(
            [
                'status' => 'required',
                'codeDish' => 'unique:dishes,code',
                'file' => 'image',
            ],
            [
                'status.required' => 'Chọn trạng thái hiển thị',
                'codeDish.unique' => 'Mã sản phẩm đã tồn tại trong hệ thống',
                'file.image' => 'File vừa chọn không phải file ảnh',
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
        $dish->describe = $request->describe;
        $dish->status = $request->status;
        $dish->id_groupnvl = $request->idMaterial;
        $dish->id_groupmenu = $this->getIdGroupMenuByIdMaterial($request->idMaterial);
        $dish->image = $this->getImage($request,1);
        $dish->save();
        return redirect(route('dishes.index'));
    }

    public function updateImageDish($request,$id)
    {
        $newImg = $this->getImage($request);
        Dishes::where('id',$id)->update(['image' => $newImg]);
        return redirect(route('dishes.index'));
    }

    public function updateSalePriceDish($request,$id)
    {
       Dishes::where('id',$id)->update(array('capital_price' => $request->newCapitalPriceHidden,
                                                'sale_price' => $request->newSalePriceUpdate));
       return redirect(route('dishes.index'));
    }

    public function updateUnitDish($request,$id)
    {
        Dishes::where('id',$id)->update(['id_dvt' => $request->unitUpdate]);
        return redirect(route('dishes.index'));
    }

    public function updateStatusDish($request,$id)
    {
        Dishes::where('id',$id)->update(['status' => $request->status]);
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
        $content = $request->nameSearch;
        $dishes = Dishes::with('groupNVL.groupMenu.cookArea','unit')
                            ->where('name','LIKE',"%{$content}%")
                            ->orWhere('code','LIKE',"%{$content}%")->get();
        $units = $this->getUnit();
        return view('dishes.search',compact('dishes','units'));
    }

    public function deleteDish($id)
    {
        $dish = Dishes::find($id)->delete();
        return redirect(route('dishes.index'));
    }
}
