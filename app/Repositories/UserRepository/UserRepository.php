<?php

namespace App\Repositories\UserRepository;

use App\User;
use App\Shift;
use App\Salary;
use App\Position;
use App\WeekDays;
use App\Permission;
use App\UserPosition;
use App\UserSchedule;
use App\UserPermission;
use App\PermissionDetail;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository\IUserRepository;
use Illuminate\Foundation\Validation\ValidatesRequests;

class UserRepository  extends Controller implements IUserRepository{

    public function checkRole($arr)
    {
        $temp = 0;
        for ($i=0; $i < count($arr); $i++) {
            if($arr[$i] == "XEM_FULL" || $arr[$i] == "XEM_NHAN_VIEN"){
                $temp++;
            }
        }
        return $temp;
    }

    public function getAllUser($arr){
        $check = $this->checkRole($arr);
        if($check != 0){
            $users = User::with('userper.permissionDetail','position')->paginate(5);
            $positions = Position::orderBy('name','asc')->get();
            return view('user/index',compact('users','positions'));
        }else{
            return view('layouts')->withErrors('Bạn không thuộc quyền truy cập chức năng này');
        }
    }

    public function validatorRequestStore($req){
        $req->validate(
            [
                'name' => 'regex:/^\S*$/u|unique:users,name',
                'email' => 'unique:users,email',
                'password-confirm' => 'same:password',
                'permissiondetail' => 'required',
            ],
            [   'name.unique' => 'Username đã tồn tại trong hệ thống',
                'name.regex' => "Vui lòng không nhập khoảng trắng cho username",
                'email.unique' => 'Email đã tồn tại trong hệ thống',
                'password-confirm.same' => 'Password xác nhận không khớp',
                'permissiondetail.required' => 'Vui lòng chọn quyền cho user',
            ]
        );
    }

    public function addUserPermission($idpermissionDetails,$idUser)
    {
        foreach ($idpermissionDetails as $key => $idPermissionDetail) {
            $userPermission = new UserPermission();
            $userPermission->id_per_detail = $idPermissionDetail;
            $userPermission->id_user = $idUser;
            $userPermission->save();
        }
    }

    public function addUserPosition($idUser,$idPosition)
    {
        $position = new UserPosition();
        $position->id_user = $idUser;
        $position->id_position = $idPosition;
        $position->save();
    }

    public function createUser($request){
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();
        $this->addUserPermission($request->permissiondetail,$user->id);
        $this->addUserPosition($user->id,$request->position);
        return redirect(route('user.index'))->withSuccess('Thêm nhân viên thành công');
    }

    public function validateRequestUpdateUsername($request)
    {
        $request->validate(['name' => 'unique:users,name|regex:/^\S*$/u'],
                            ['name.unique' => "Tên vừa thay đổi đã tồn tại trong hệ thống",
                            'name.regex' => "Vui lòng không nhập khoảng trống cho username"]);
    }

    public function updateUserName($request ,$id)
    {
        User::where('id',$id)->update(['name' => $request->name]);
        return redirect(route('user.index'))->with('info','Cập nhật username thành công');
    }

    public function viewScheduleUser($id)
    {
        $user = User::where('id',$id)->with('userSchedule')->first();
        $weekdays = WeekDays::all();
        $shifts = Shift::all();
        $count = $this->countUserScheduleById($id);
        return view('user.schedule',compact('user','weekdays','shifts','count'));
    }

    public function validatorRequestShift($request)
    {
        $request->validate(['shift' => 'required'],
                            ['shift.required' => 'Vui lòng chọn ca làm cho nhân viên']);
    }

    public function countUserScheduleById($idUser)
    {
        return UserSchedule::where('id_user',$idUser)->count();
    }

    public function loopShiftAndWeekday($request)
    {
        for ($i=0; $i < count($request->shift); $i++) {
            $userSchedule = new UserSchedule();
            $userSchedule->id_user = $request->iduser;
            $userSchedule->id_shift = substr( $request->shift[$i], 0, 1 );
            $userSchedule->id_weekday = substr($request->shift[$i], 2, 1);
            $userSchedule->save();
        }
    }

    public function updateShiftUser($request,$id)
    {
        $count = $this->countUserScheduleById($id);
        if($count <= 0){
            $this->loopShiftAndWeekday($request);
        }else{
            $userSchedule = UserSchedule::where('id_user',$id)->delete();
            $this->loopShiftAndWeekday($request);
        }
        return redirect(route('user.shift',['id' => $id]))->with('info','Ca làm việc đã được cập nhật');
    }

    public function validatorUpdateRole($request)
    {
        $request->validate(['permissiondetail' => 'required'],
                            ['permissiondetail.required' => 'Vui lòng chọn quyền cho nhân viên']);
    }

    public function viewUpdateRole($id)
    {
        $user = User::where('id',$id)->with('userper.permissionDetail')->first();
        $permissions = Permission::with('peraction.permissiondetail')->orderBy('name','asc')->get();
        return view('user/update',compact('user','permissions'));
    }

    public function updateRole($request,$id)
    {
        UserPermission::where('id_user',$id)->delete();
        $permissionDetails = $request->permissiondetail;
        foreach ($permissionDetails as $key => $value) {
            $data = [
                'id_user' => $id,
                'id_per_detail' => $value,
            ];
           UserPermission::create($data);
        }
        return redirect(route('user.index'))->with('info','Cập nhật quyền thành công');
    }

    public function validatorRequestUpdatePassword($req){
        $messeages = [
            'oldpassword.check_old_password' => 'Password cũ không khớp',
            'password.min' => 'Password không ít hơn 3 ký tự',
            'password.max' => 'Password nhiều nhất 10 ký tự',
            'passwordconfirm.same' => 'Password xác nhận không khớp',
        ];
        $req->validate(
            [
                'oldpassword' => 'check_old_password',
                'password' => 'min:3|max:10',
                'passwordconfirm' => 'same:password',
            ],
            $messeages
        );
    }

    public function updatePasswordUser($request, $id)
    {
        User::where('id',$id)->update(['password' => bcrypt($request->passwordconfirm)]);
        return redirect(route('user.index'))->with('info','Đổi password thành công');
    }

    public function updatePositionUser($request,$id)
    {
        User::where('id',$id)->update(['id_position' => $request->position]);
        return redirect(route('user.index'))->with('info','Cập nhật vị trí thành công');
    }

    public function searchUser($request)
    {
        $name = $request->nameSearch;
        $count = User::selectRaw('count(id) as qty')->where('name','LIKE',"%{$name}%")->value('qty');
        $users = User::where('name','LIKE',"%{$name}%")->with('userper.permissionDetail','position')->get();
        $positions = Position::orderBy('name','asc')->get();
        return view('user.search',compact('users','positions','count'));
    }

    public function deleteUser($id)
    {
        UserPermission::where('id_user',$id)->delete();
        User::where('id',$id)->delete();
        return redirect(route('user.index'))->withSuccess('Xóa nhân viên thành công');
    }
}
