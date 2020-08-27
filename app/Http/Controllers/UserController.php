<?php

namespace App\Http\Controllers;

use App\Permission;
use App\User;
use App\UserPermission;
use Illuminate\Http\Request;
use App\Helper\ICheckAction;
use App\Position;
use Illuminate\Support\Facades\Validator;
use App\Repositories\UserRepository\IUserRepository;
use App\Shift;
use App\WeekDays;

class UserController extends Controller
{
    private $checkAction;
    private $userRepository;

    public function __construct(ICheckAction $checkAction, IUserRepository $userRepository)
    {
        $this->checkAction = $checkAction;
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        $result = $this->checkAction->getPermission(auth()->id());
        $check = $this->userRepository->checkRoleIndex($result);
        if($check != 0){
            $users = User::with('userper.permissionDetail','position')->get();
            //dd($users);
            $positions = Position::orderBy('name','asc')->get();
            return view('user/index',compact('users','positions'));
        }else{
            return view('layouts')->withErrors('Bạn không thuộc quyền truy cập chức năng này');
        }
    }

    public function viewstore()
    {
        $permissions = Permission::where('name','!=','FULL')->with('peraction.permissiondetail')->orderBy('name','asc')->get();
        $positions = Position::orderBy('name','asc')->get();
        return view('user/store',compact('permissions','positions'));
    }

    public function checkRoleCook($request)
    {
        $temp = 0;
        foreach ($request->permissiondetail as $key => $value) {
            if($value == '132' || $value == '136' || $value == '140'){
                $temp++;
            }
        }
        return $temp;
    }

    public function store(Request $request)
    {
        $result = $this->checkAction->getPermission(auth()->id());
        $check = $this->userRepository->checkRoleStore($result);
        if($check != 0){
            if($this->checkRoleCook($request) > 1){
                return redirect(route('user.store'))->withErrors('Một nhân viên chỉ đảm nhận một bếp');
            }else{
                $this->userRepository->validatorRequestStore($request);
                return $this->userRepository->createUser($request);
            }
        }else{
            return view('layouts');
        }
    }

    public function updateUsername(Request $request,$id)
    {
        $result = $this->checkAction->getPermission(auth()->id());
        $check = $this->userRepository->checkRoleUpdate($result);
        if($check != 0){
            $this->userRepository->validateRequestUpdateUsername($request);
            return $this->userRepository->updateUserName($request,$id);
        }else{
            return view('layouts');
        }
    }
    public function viewShift($id)
    {
        return $this->userRepository->viewScheduleUser($id);
    }

    public function updateShift(Request $request, $id)
    {
        $result = $this->checkAction->getPermission(auth()->id());
        $check = $this->userRepository->checkRoleUpdate($result);
        if($check != 0){
            $this->userRepository->validatorRequestShift($request);
            return $this->userRepository->updateShiftUser($request,$id);
        }else{
            return view('layouts');
        }
    }

    public function viewUpdateRole($id)
    {
        return $this->userRepository->viewUpdateRole($id);
    }

    public function updateRole(Request $request, $id)
    {
        $this->userRepository->validatorUpdateRole($request);
        return $this->userRepository->updateRole($request,$id);
    }

    public function viewUpdatePassword($id)
    {
        $username = User::where('id',$id)->value('name');
        $email = User::where('id',$id)->value('email');
        return view('user.changepassword',compact('username','email','id'));
    }

    public function updatePassword(Request $request, $id)
    {
        $this->userRepository->validatorRequestUpdatePassword($request);
        return $this->userRepository->updatePasswordUser($request,$id);
    }

    public function updatePosition(Request $request,$id)
    {
        $result = $this->checkAction->getPermission(auth()->id());
        $check = $this->userRepository->checkRoleUpdate($result);
        if($check != 0){
            return $this->userRepository->updatePositionUser($request,$id);
        }else{
            return view('layouts');
        }
    }

    public function delete($id)
    {
        $result = $this->checkAction->getPermission(auth()->id());
        $check = $this->userRepository->checkRoleDelete($result);
        if($check != 0){
            return $this->userRepository->deleteUser($id);
        }else{
            return view('layouts');
        }
    }
}
