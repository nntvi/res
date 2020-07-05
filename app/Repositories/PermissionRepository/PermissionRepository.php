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

    function vn_to_str ($str){
        $unicode = array(
            'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
            'd'=>'đ',
            'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
            'i'=>'í|ì|ỉ|ĩ|ị',
            'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
            'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
            'y'=>'ý|ỳ|ỷ|ỹ|ỵ',
            'A'=>'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
            'D'=>'Đ',
            'E'=>'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
            'I'=>'Í|Ì|Ỉ|Ĩ|Ị',
            'O'=>'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
            'U'=>'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
            'Y'=>'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
        );
        foreach($unicode as $nonUnicode=>$uni){
            $str = preg_replace("/($uni)/i", $nonUnicode, $str);
        }
        $str  = strtoupper($str);
        $str = str_replace(' ','_',$str);
        return $str;
    }

    public function add($arrPerDetail,$convertArrPerDetail,$idPermission)
    {
        for ($i=0; $i < count($arrPerDetail); $i++) {
            $temp = PermissionDetail::create(['name' => $arrPerDetail[$i],'action_code' => $convertArrPerDetail[$i]]);
            PermissionAction::create(['id_per' => $idPermission, 'id_per_detail' => $temp->id]);
        }
    }
    public function createPermissionDetail($namePermission)
    {
        $arrNameDetailPermission = array();
        $newDetailView = "Xem " . $namePermission;
        array_push($arrNameDetailPermission,$newDetailView);
        $newDetailCreate = "Tạo " . $namePermission;
        array_push($arrNameDetailPermission,$newDetailCreate);
        $newDetailDelete = "Xóa " . $namePermission;
        array_push($arrNameDetailPermission,$newDetailDelete);
        $newDetailEdit = "Sửa " . $namePermission;
        array_push($arrNameDetailPermission,$newDetailEdit);
        return $arrNameDetailPermission;
    }

    public function createArrayVN($array)
    {
        $temp = array();
        for ($i=0; $i < count($array); $i++) {
            $string = $this->vn_to_str($array[$i]);
            array_push($temp,$string);
        }
        return $temp;
    }
    public function addPermission($req)
    {
        $permission = Permission::create(['name'=> $req->name]);
        $arrPerDetail = $this->createPermissionDetail($req->name);
        $convertArrPerDetail = $this->createArrayVN($arrPerDetail);
        $this->add($arrPerDetail,$convertArrPerDetail,$permission->id);
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
        return redirect(route('permission.index'));
    }
}
