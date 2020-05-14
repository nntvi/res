<?php
namespace App\Repositories\PermissionRepository;
use App\Http\Controllers\Controller;
use App\Repositories\PermissionRepository\IPermisionRepository;

use App\Permission;
use App\PermissionDetail;
use App\PermissionAction;
use App\Salary;
use App\UserPermission;

class PermissionRepository extends Controller implements IPermissionRepository
{
    public function getAllPermissionDetails()
    {
        $permissiondetails = PermissionDetail::all();
        return $permissiondetails;
    }
    public function showAllPermission()
    {
        $permissions = Permission::with('peraction.permissiondetail')->paginate(10);
        $permissiondetails = $this->getAllPermissionDetails();
        return view('permission/index',compact('permissions','permissiondetails'));
    }

    public function validatorRequestStore($req){
        $messeages = [
            'name.unique' => 'Tên quyền vừa nhập đã tồn tại trong hệ thống',
        ];
        $req->validate(
            [
                'name' => 'unique:permissions,name',
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

    public function addPositionToSalary($idPosition)
    {
        $salary = new Salary();
        $salary->id_position = $idPosition;
        $salary->save();
    }

    public function convertActionCode($str)
    {
        $s = strtoupper($str);
        $s = str_replace(' ','_',$s);
        return $s;
    }

    public function add($data,$idPermission)
    {
        for ($i=0; $i < count($data); $i++) {
            $actionCode = $this->convertActionCode($data[$i]);
            $temp = PermissionDetail::create(['name' => $data[$i],'action_code' => $actionCode]);
            PermissionAction::create(['id_per' => $idPermission, 'id_per_detail' => $temp->id]);
        }
    }
    public function createPermissionDetail($namePermission)
    {
        $arrNameDetailPermission = array();
        $newDetailView = "View " . $namePermission;
        array_push($arrNameDetailPermission,$newDetailView);
        $newDetailCreate = "Create " . $namePermission;
        array_push($arrNameDetailPermission,$newDetailCreate);
        $newDetailDelete = "Delete " . $namePermission;
        array_push($arrNameDetailPermission,$newDetailDelete);
        $newDetailEdit = "Edit " . $namePermission;
        array_push($arrNameDetailPermission,$newDetailEdit);
        return $arrNameDetailPermission;
    }
    public function addPermission($req)
    {
        $permission = Permission::create(['name'=> $req->name]);
        $arrPerDetail = $this->createPermissionDetail($req->name);
        $this->add($arrPerDetail,$permission->id);
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
        $nameDetailPerUpdate = $this->createPermissionDetail($request->namePermissionUpdate);
        $perAction = PermissionAction::where('id_per',$id)->get();
        foreach ($perAction as $key => $item) {
            PermissionDetail::where('id',$item->id_per_detail)
                            ->update(['name' => $nameDetailPerUpdate[$key],
                                        'action_code' => $this->convertActionCode($nameDetailPerUpdate[$key])
                            ]);
        }
        return redirect(route('permission.index'));
    }
    public function deletePermission($id)
    {
        PermissionAction::where('id_per', $id)->delete();
        Permission::find($id)->delete();
        UserPermission::where('id_per',$id)->delete();
        Salary::where('id_position',$id)->delete();
        return redirect(route('permission.index'));
    }
}
