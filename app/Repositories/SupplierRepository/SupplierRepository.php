<?php
namespace App\Repositories\SupplierRepository;

use App\Http\Controllers\Controller;
use App\Repositories\SupplierRepository\ISupplierRepository;
use App\Supplier;
use App\TypeMaterial;

class SupplierRepository extends Controller implements ISupplierRepository{

    public function getTypeMarial()
    {
        $types = TypeMaterial::all();
        return $types;
    }

    public function getAllSupplier()
    {
        $suppliers = Supplier::with('typeMaterial')->paginate(5);
        return view('supplier.index',compact('suppliers'));
    }

    public function validatorRequest($req){
        $messeages = [
            'code.unique' => 'Mã đã tồn tại trong hệ thống',
            'name.unique' => 'Tên nhà cung cấp đã tồn tại trong hệ thống',
            'email.unique' => 'Email nhà cung cấp đã tồn tại trong hệ thống',
            'phone.regex' => 'Số điện thoại không có thực',
            'status.required' => 'Vui lòng chọn trạng thái',
        ];

        $req->validate(
            [
                'code' => 'unique:suppliers,code',
                'name' => 'unique:suppliers,name',
                'email' => 'unique:suppliers,email',
                'address' => 'min:10|max:100',
                'phone' => 'regex:/(0)[0-9]{9}/',
                'status' => 'required'
            ],
            $messeages
        );
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

    public function updateSupplier($request,$id)
    {
        $supplier = Supplier::find($id);
        $supplier->name = $request->name;
        $supplier->phone = $request->phone;
        $supplier->address = $request->address;
        $supplier->mst = $request->mst;
        $supplier->status = $request->status;
        $supplier->note = $request->note;
        $supplier->id_type = $request->typeMaterial;
        $supplier->save();
        return redirect(route('supplier.index'))->with('info','Cập nhật thông tin NCC thành công');
    }

    public function deleteSupplier($id)
    {
       $supplier = Supplier::find($id)->delete();
       return redirect(route('supplier.index'))->withSuccess('Xóa NCC thành công');
    }
}
