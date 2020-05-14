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
        return $this->userRepository->getAllUser($result);
    }

    public function viewstore()
    {
        $permissions = Permission::with('peraction.permissiondetail')->orderBy('name','asc')->get();
        $positions = Position::orderBy('name','asc')->get();
        return view('user/store',compact('permissions','positions'));
    }

    public function store(Request $request)
    {
        $this->userRepository->validatorRequestStore($request);
        return $this->userRepository->createUser($request);
    }

    public function updateUsername(Request $request,$id)
    {
        $this->userRepository->validateRequestUpdateUsername($request);
        return $this->userRepository->updateUserName($request,$id);
    }
    public function viewShift($id)
    {
        return $this->userRepository->viewScheduleUser($id);
    }

    public function updateShift(Request $request, $id)
    {
        $this->userRepository->validatorRequestShift($request);
        return $this->userRepository->updateShiftUser($request,$id);
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
    public function updatePassword(Request $request, $id)
    {
        $this->userRepository->validatorRequestUpdatePassword($request);
        return $this->userRepository->updatePasswordUser($request,$id);
    }

    public function updatePosition(Request $request,$id)
    {
        return $this->userRepository->updatePositionUser($request,$id);
    }
    public function search(Request $request)
    {
        return $this->userRepository->searchUser($request);
    }

    public function delete($id)
    {
        return $this->userRepository->deleteUser($id);
    }
}
