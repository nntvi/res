<?php

namespace App\Repositories\UserRepository;

use App\User;
use App\Permission;
use App\UserPermission;
use App\Http\Controllers\Controller;

use App\Repositories\UserRepository\IUserRepository;
use Illuminate\Foundation\Validation\ValidatesRequests;

class UserRepository  extends Controller implements IUserRepository{

    public function getAllUser($arr){
        foreach ($arr as $name) {
            if($name->action_code == "CREATE_POST"){
                $users = User::with('userper.permission')->get();
                return view('user/index',compact('users'));
            }
        }
        return view('layouts');
    }

    public function validatorRequestStore($req){
        $messeages = [
            'name.required' => 'Không để trống tên người dùng',
            'name.min' => 'Tên người dùng nhiều hơn 3 ký tự',
            'name.max' => 'Tên người dùng giới hạn 30 ký tự',
            'email.required' => 'Không để trống email',
            'email.unique' => 'Email đã tồn tại trong hệ thống',
            'password.required' => 'Không để trống password',
            'password-confirm.same' => 'Password xác nhận không khớp',
            'permission.required' => 'Vui lòng chọn quyền cho user'
        ];

        $req->validate(
            [
                'name' => 'required|min:3|max:30',
                'email' => 'required|unique:users,email',
                'password' => 'required',
                'password-confirm' => 'same:password',
                'permission' => 'required'
            ],
            $messeages
        );
    }

    public function validatorRequestUpdate($req){
        $messeages = [
            'name.required' => 'Không để trống tên người dùng',
            'name.mix' => 'Tên người dùng nhiều hơn 3 ký tự',
            'name.max' => 'Tên người dùng giới hạn 30 ký tự',
            'permission.required' => 'Vui lòng chọn quyền cho user'
        ];

        $req->validate(
            [
                'name' => 'required|min:3|max:30',
                'permission' => 'required'
            ],
            $messeages
        );
    }

    public function createUser($request){
        $user = User::create([  'name' => $request->name,
                                'email' => $request->email,
                                'password' => bcrypt($request->password)
                            ]);

        $idpermission = $request->permission;
        foreach ($idpermission as $key => $id) {
            $data = [
                'id_user' => $user->id,
                'id_per' => $id,
            ];
            UserPermission::create($data);
        }
        return redirect(route('user.index'))->with('success',"Thêm thành công");
    }

    public function viewUpdate($id)
    {
        // tìm đến id của user cần update
        $user = User::find($id);
        // lấy hết những nhóm quyền trong permisssions ra
        $permissions = Permission::all();
        // tìm trong bảng user_per id nào trùng với id cần chỉnh sửa
        $userpers = UserPermission::where('id_user',$id)->get();
        // tạo mảng chứa những permission đã chọn và chưa chọn
        $data = array();
        // duyệt từ bảng permission
        foreach ($permissions as  $permission) {
            $check = false;
            // đi vào bảng user_per để tìm id
            foreach ($userpers as $userper) {
                // nếu id của permission nào trùng với id ở bảng permissions
                if($userper->id_per === $permission->id){
                    // thông báo đã tìm thấy
                    $obj['flag'] = true;
                    $obj['id'] = $permission->id;
                    $obj['name'] = $permission->name;
                    array_push($data,$obj);
                    $check = true;
                }
            }
            if($check == false){
                $obj['flag'] = false;
                $obj['id'] = $permission->id;
                $obj['name'] = $permission->name;
                array_push($data,$obj);
            }else{
                $check = false;
            }
        }
        return view('user/update',compact('user','data','permissions'));
    }
    public function updateUser($request,$id)
    {

        // tìm user cần sửa
        $user = User::find($id);
        $user->name = $request->name;
        //$user->password = bcrypt($request->password);
        // lưu lại
        //dd($user);
        $user->save();

        // ở bảng user_per tìm id_user trùng với id cần sửa
        // xóa tất cả để cập nhật lại
        UserPermission::where('id_user',$id)->delete();

        // lấy những id của permission vừa click
        $idPermission = $request->permission;

        foreach ($idPermission as $key => $value) {
            $data = [
                'id_user' => $user->id,
                'id_per' => $value,
            ];
           UserPermission::create($data);
        }
        return redirect(route('user.index'));
    }

    public function validatorRequestUpdatePassword($req){
        $messeages = [
            'password.required' => 'Không để trống password cần thay đổi',
            'password.min' => 'Password không ít hơn 3 ký tự',
            'password.max' => 'Password nhiều nhất 10 ký tự',
            'password-confirm.same' => 'Password xác nhận không khớp',
            'password-confirm.required' => 'Vui lòng nhập password xác nhận',
        ];

        $req->validate(
            [
                'password' => 'required|min:3|max:10',
                'password-confirm' => 'required|same:password',
            ],
            $messeages
        );
    }

    public function updatePasswordUser($request, $id)
    {
        $user = User::find($id);
        $user->password = bcrypt($request->password);
        $user->save();
        return redirect(route('user.index'))->with('success','Đổi password thành công');
    }
    public function deleteUser($id)
    {
        // Tìm trong bảng user_per xóa trước
        UserPermission::where('id_user',$id)->delete();
        // Tìm id ở bảng user
        User::where('id',$id)->delete();
        return redirect(route('user.index'));
    }
}
