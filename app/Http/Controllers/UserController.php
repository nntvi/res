<?php

namespace App\Http\Controllers;

use App\Permission;
use App\User;
use App\UserPermission;
use Illuminate\Http\Request;
use App\Helper\ICheckAction;
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
        $permissions = Permission::all();
        $shifts = Shift::all();
        return view('user/store',compact('permissions'));
    }

    public function store(Request $request)
    {
        $this->userRepository->validatorRequestStore($request);
        return $this->userRepository->createUser($request);
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
    public function viewUpdate($id)
    {

        return $this->userRepository->viewUpdate($id);
    }

    public function update(Request $request,$id)
    {
        $this->userRepository->validatorRequestUpdate($request);
        return $this->userRepository->updateUser($request,$id);
    }
    public function updatePassword(Request $request, $id)
    {
        $this->userRepository->validatorRequestUpdatePassword($request);
        return $this->userRepository->updatePasswordUser($request,$id);
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
