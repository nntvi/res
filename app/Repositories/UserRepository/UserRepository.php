<?php

namespace App\Repositories\UserRepository;

use App\User;
use App\Permission;
use App\UserPermission;
use App\Http\Controllers\Controller;

use App\Repositories\UserRepository\IUserRepository;
use App\Salary;
use App\Shift;
use App\UserSchedule;
use App\WeekDays;
use Illuminate\Foundation\Validation\ValidatesRequests;

class UserRepository  extends Controller implements IUserRepository{

    public function getAllUser($arr){
        foreach ($arr as $name) {
            if($name->action_code == "VIEW_USER"){
                $users = User::with('userper.permission')->paginate(7);
                return view('user/index',compact('users'));
            }
        }
        return view('layouts');
    }

    public function validatorRequestStore($req){
        $req->validate(
            [
                'email' => 'unique:users,email',
                'password-confirm' => 'same:password',
                'permission' => 'required',
            ],
            [
                'email.unique' => 'Email đã tồn tại trong hệ thống',
                'password-confirm.same' => 'Password xác nhận không khớp',
                'permission.required' => 'Vui lòng chọn quyền cho user',
            ]
        );
    }

    public function validatorRequestShift($request)
    {
        $request->validate(['shift' => 'required'],
                            ['shift.required' => 'Vui lòng chọn đánh dấu ca làm cho nhân viên']);
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

    public function addUserPermission($request,$iduser)
    {
        $idpermission = $request->permission;
        foreach ($idpermission as $key => $id) {
            $data = [
                'id_user' => $iduser,
                'id_per' => $id,
            ];
            UserPermission::create($data);
        }
    }

    public function createUser($request){
        $user = User::create([  'name' => $request->name,
                                'email' => $request->email,
                                'password' => bcrypt($request->password)]);
        $this->addUserPermission($request,$user->id);
        return redirect(route('user.index'));
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
    public function viewScheduleUser($id)
    {
        $user = User::where('id',$id)->with('userSchedule')->first();
        $weekdays = WeekDays::all();
        $shifts = Shift::all();
        $count = $this->countUserScheduleById($id);
        return view('user.schedule',compact('user','weekdays','shifts','count'));
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
        return redirect(route('user.shift',['id' => $id]));
    }
    public function viewUpdate($id)
    {
        $user = User::find($id);
        $permissions = Permission::all();
        $userpers = UserPermission::where('id_user',$id)->get();
        $data = array();
        foreach ($permissions as  $permission) {
            $check = false;
            foreach ($userpers as $userper) {
                if($userper->id_per === $permission->id){
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
        $user = User::find($id);
        $user->name = $request->name;
        $user->save();
        UserPermission::where('id_user',$id)->delete();
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

    public function searchUser($request)
    {
        $name = $request->nameSearch;
        $users = User::where('name','LIKE',"%{$name}%")
                        ->with('userper.permission')->get();
        return view('user.search',compact('users'));
    }
    public function deleteUser($id)
    {
        UserPermission::where('id_user',$id)->delete();
        User::where('id',$id)->delete();
        return redirect(route('user.index'));
    }
}
