<?php
namespace App\Repositories\SupplierRepository;

use App\Http\Controllers\Controller;
use App\Repositories\SupplierRepository\ISupplierRepository;
use App\Supplier;

class SupplierRepository extends Controller implements ISupplierRepository{

    public function getAllSupplier()
    {
        $suppliers = Supplier::all();
        return view('supplier.index',compact('suppliers'));
    }

    public function validatorRequestStore($req){
        $messeages = [
            'code.required' => 'Không để trống mã nhà cung cấp',
            'code.min' => 'Mã nhà cung cấp quá ngắn',
            'code.max' => 'Không để trống mã nhà cung cấp',
            'code.unique' => 'Mã đã tồn tại trong hệ thống',

            'name.required' => 'Không để trống tên nhà cung cấp',
            'name.min' => 'Tên nhà cung cấp quá ngắn',
            'name.max' => 'Tên nhà cung cấp không vượt quá 30 ký tự',
            'name.unique' => 'Tên nhà cung cấp đã tồn tại trong hệ thống',

            'address.required' => 'Không để trống địa chỉ nhà cung cấp',
            'address.min' => 'Địa chỉ nhà cung cấp quá ngắn',
            'address.max' => 'Địa chỉ vượt quá 60 ký tự',

            'email.required' => 'Không để trống email nhà cung cấp',
            'email.unique' => 'Email nhà cung cấp đã tồn tại trong hệ thống',

            'phone.required' => 'Không để trống số điẹn thoại ncc',
            'phone.min' => 'Số điện thoại gồm 10 chữ số',
            'phone.max' => 'Số điện thoại không vượt quá 10 chữ số',

            'mst.required' => 'Không để trống số mã số thuế',
            'mst.min' => 'Mã số thuế gồm không nhỏ hơn 10 chữ số',
            'mst.max' => 'Mã số thuế không vượt quá 20 chữ số',

            'status.required' => 'Vui lòng chọn trạng thái',
        ];

        $req->validate(
            [
                'code' => 'required|min:3|max:25|unique:suppliers,code',
                'name' => 'required|min:3|max:30|unique:suppliers,name',
                'email' => 'required|unique:suppliers,email',
                'address' => 'required|min:10|max:60',
                'phone' => 'required|min:10|max:10',
                'mst' => 'required|min:10|max:20',
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
        $supplier->save();
        return redirect(route('supplier.index'));
    }

    public function showViewUpdateSupplier($id)
    {
        $supplier = Supplier::find($id);
        return view('supplier.update',compact('supplier'));
    }

    public function validatorRequestUpdate($req){
        $messeages = [
            'name.required' => 'Không để trống tên nhà cung cấp',
            'name.min' => 'Tên nhà cung cấp quá ngắn',
            'name.max' => 'Tên nhà cung cấp không vượt quá 30 ký tự',

            'address.required' => 'Không để trống địa chỉ nhà cung cấp',
            'address.min' => 'Địa chỉ nhà cung cấp quá ngắn',
            'address.max' => 'Địa chỉ vượt quá 60 ký tự',

            'phone.required' => 'Không để trống số điẹn thoại ncc',
            'phone.min' => 'Số điện thoại gồm 10 chữ số',
            'phone.max' => 'Số điện thoại không vượt quá 10 chữ số',

            'mst.required' => 'Không để trống số mã số thuế',
            'mst.min' => 'Mã số thuế gồm không nhỏ hơn 10 chữ số',
            'mst.max' => 'Mã số thuế không vượt quá 20 chữ số',

            'status.required' => 'Vui lòng chọn trạng thái',
        ];

        $req->validate(
            [
                'name' => 'required|min:3|max:30',
                'address' => 'required|min:10|max:60',
                'phone' => 'required|min:10|max:10',
                'mst' => 'required|min:10|max:20',
                'status' => 'required'
            ],
            $messeages
        );
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
        $supplier->save();
        return redirect(route('supplier.index'));
    }

    public function deleteSupplier($id)
    {
       $supplier = Supplier::find($id)->delete();
       return redirect(route('supplier.index'));
    }
}
