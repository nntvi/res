<?php
namespace App\Repositories\PermissionRepository;
use App\Http\Controllers\Controller;
use App\Repositories\PermissionRepository\IPermisionRepository;

use App\Permission;
use App\PermissionDetail;
use App\PermissionAction;

class PermissionRepository extends Controller implements IPermissionRepository
{
    public function getAllPermissionDetails()
    {
        $permissiondetails = PermissionDetail::all();
        return $permissiondetails;
    }
    public function showAllPermission()
    {
        $permissions = Permission::with('peraction.permissiondetail')->paginate(6);
        $permissiondetails = $this->getAllPermissionDetails();
        return view('permission/index',compact('permissions','permissiondetails'));
    }

    public function validatorRequestStore($req){
        $messeages = [
            'name.unique' => 'Tên quyền vừa nhập đã tồn tại trong hệ thống',
            'permissiondetail.required' => 'Vui lòng chọn ít nhất một hành động cho quyền'
        ];

        $req->validate(
            [
                'name' => 'unique:permissions,name',
                'permissiondetail' => 'required'
            ],
            $messeages
        );
    }
    public function validateUpdateName($request)
    {
       $request->validate(['namePermissionUpdate' => 'unique:permissions,name'],
                            ['namePermissionUpdate.unique' => 'Tên vừa nhập đã tồn tại trong hệ thống']);
    }
    public function validateUpdateDetail($req){
        $req->validate(['permissiondetail' => 'required'],
                        ['permissiondetail.required' => 'Vui lòng chọn ít nhất một hành động cho quyền']);
    }
    public function searchMaterial($request)
    {
        $name = $request->nameSearch;
        $permissions = Permission::where('name','LIKE',"%{$name}%")->with('peraction.permissiondetail')->get();
        $permissiondetails = $this->getAllPermissionDetails();
        return view('permission.search',compact('permissions','permissiondetails'));
    }
    public function addPermission($req)
    {
        $input = $req->all();
        $permission = Permission::create(['name'=> $req->name]);
        $idPermissionDetail = $req->permissiondetail;

        // lấy từng chi tiết gắn với id tương xứng để thêm vào bảng action
        foreach ($idPermissionDetail as $key => $id) {
            $data = [
                'id_per' => $permission->id,
                'id_per_detail' => $id
            ];
            PermissionAction::create($data); // thêm vào bảng per_action
        }
        return redirect(route('permission.index'));
    }
    public function getPermissionDetail()
    {
        return $permissiondetails = PermissionDetail::all();
    }
    public function findPermission($id)
    {
        return $permission = Permission::find($id);
    }

    public function getPerActionById($id)
    {
        return $peractions = PermissionAction::where('id_per',$id)->get();
    }

    public function getOldPerDetail($permissiondetails,$peractions)
    {
        $data = array();
        foreach($permissiondetails as $per_detail){
            $check = false;
            // trong bảng action
            foreach ($peractions as $key => $peraction) {
                // nếu id của chi tiết nào trùng với id của chi tiết ở bảng chi tiết
                if($per_detail->id === $peraction->id_per_detail){
                    // đặt 1 biến báo true để biết là đã tìm thấy
                    $obj['flag'] = true;
                    // lấy id đã trùng lưu vào trường id trong mảng obj
                    $obj['id'] = $per_detail->id;
                    // lấy name đã trùng lưu vào trường name để xuất ra
                    // cho người dùng biết những cái đã chọn
                    $obj['name'] = $per_detail->name;
                    // thêm vào mảng data sau khi tìm thấy
                    array_push($data, $obj);
                    $check = true;
                }
            }
            // khi check = false => những chi tiết mà id permission đó ko click trước đó
            if($check == false){
                // cũng thêm vào mảng
                $obj['flag'] = false;
                $obj['id'] = $per_detail->id;
                $obj['name'] = $per_detail->name;
                array_push($data, $obj);
            }else{
                $check = false;
            }
        }
        return $data;
    }

    public function updatePermission($req, $permission)
    {
        PermissionAction::where('id_per', $permission->id)->delete();
        $idPermissionDetail = $req->permissiondetail;

        foreach ($idPermissionDetail as $key => $id) {
            $data = [
                'id_per' => $permission->id,
                'id_per_detail' => $id
            ];
            PermissionAction::create($data);
        }
        return redirect(route('permission.index'));
    }

    public function updateName($request,$id)
    {
        Permission::where('id',$id)->update(['name' => $request->namePermissionUpdate]);
        return redirect(route('permission.index'));
    }
    public function deletePermission($id)
    {
        PermissionAction::where('id_per', $id)->delete();
        $permission = Permission::find($id)->delete();
        return redirect(route('permission.index'));
    }
}
