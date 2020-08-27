<?php
namespace App\Repositories\SupplierRepository;

use App\Http\Controllers\Controller;
use App\Repositories\SupplierRepository\ISupplierRepository;
use App\Supplier;
use App\TypeMaterial;

class SupplierRepository extends Controller implements ISupplierRepository{

    public function checkRoleIndex($arr)
    {
        $temp = 0;
        for ($i=0; $i < count($arr); $i++) {
            if($arr[$i] == "XEM_FULL" || $arr[$i] == "XEM_NHA_CUNG_CAP"){
                $temp++;
            }
        }
        return $temp;
    }

    public function checkRoleStore($arr)
    {
        $temp = 0;
        for ($i=0; $i < count($arr); $i++) {
            if($arr[$i] == "XEM_FULL" || $arr[$i] == "TAO_NHA_CUNG_CAP"){
                $temp++;
            }
        }
        return $temp;
    }

    public function checkRoleUpdate($arr)
    {
        $temp = 0;
        for ($i=0; $i < count($arr); $i++) {
            if($arr[$i] == "XEM_FULL" || $arr[$i] == "SUA_NHA_CUNG_CAP"){
                $temp++;
            }
        }
        return $temp;
    }

    public function checkRoleDelete($arr)
    {
        $temp = 0;
        for ($i=0; $i < count($arr); $i++) {
            if($arr[$i] == "XEM_FULL" || $arr[$i] == "XOA_NHA_CUNG_CAP"){
                $temp++;
            }
        }
        return $temp;
    }

    public function getTypeMarial()
    {
        $types = TypeMaterial::all();
        return $types;
    }

    public function getAllSupplier()
    {
        $suppliers = Supplier::with('typeMaterial')->get();
        return view('supplier.index',compact('suppliers'));
    }

    public function validateCode($request)
    {
        $request->validate(['code' => 'unique:suppliers,code'],['code.unique' => 'Mã đã tồn tại trong hệ thống']);
    }

    public function validateName($request)
    {
        $request->validate(
            ['name' => 'unique:suppliers,name|special_character'],
            ['name.unique' => 'Tên nhà cung cấp đã tồn tại trong hệ thống',
            'name.special_character' => 'Tên NCC không chứa kí tự đặc biệt']
        );
    }

    public function validateEmail($request)
    {
        $request->validate(['email' => 'unique:suppliers,email'],['email.unique' => 'Email nhà cung cấp đã tồn tại trong hệ thống']);
    }

    public function validatePhone($request)
    {
        $request->validate(['phone' => 'digits:10|regex:/(0)[0-9]{9}/'],
                            ['phone.regex' => 'Số điện thoại không có thực',
                            'phone.digits' => 'Chỉ gồm 10 số']);
    }

    public function validateStatus($request)
    {
        $request->validate(['status' => 'required'], ['status.required' => 'Vui lòng chọn trạng thái']);
    }

    public function addSupplier($request)
    {
        $supplier = new Supplier();
        $supplier->code = $request->code;
        $supplier->name = $request->name;
        $supplier->email = $request->email;
        $supplier->phone = $request->phone;
        $supplier->address = $request->address;
        $supplier->mst = $request->mst;
        $supplier->status = $request->status;
        $supplier->note = $request->note;
        $supplier->id_type = $request->typeMaterial;
        $supplier->save();
        return redirect(route('supplier.index'))->withSuccess('Thêm mới NCC thành công');
    }

    public function showViewUpdateSupplier($id)
    {
        $supplier = Supplier::where('id',$id)->with('typeMaterial')->first();
        $types = $this->getTypeMarial();
        return view('supplier.update',compact('supplier','types'));
    }

    public function updateNameSupplier($request,$id)
    {
        Supplier::where('id',$id)->update(['name' => $request->name]);
        return redirect(route('supplier.index'))->with('info','Cập nhật tên NCC thành công');
    }
    public function updateSupplier($request,$id)
    {
        $temp = [
            'phone' => $request->phone,
            'address' => $request->address,
            'mst' => $request->mst,
            'status' => $request->status,
            'note' => $request->note,
            'id_type' => $request->typeMaterial
        ];
        Supplier::where('id',$id)->update($temp);
        return redirect(route('supplier.index'))->with('info','Cập nhật thông tin NCC thành công');
    }

    public function deleteSupplier($id)
    {
       $supplier = Supplier::find($id)->delete();
       return redirect(route('supplier.index'))->withSuccess('Xóa NCC thành công');
    }

}
