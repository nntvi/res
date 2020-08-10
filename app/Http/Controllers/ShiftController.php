<?php

namespace App\Http\Controllers;

use App\Repositories\ShiftRepository\IShiftRepository;
use Illuminate\Http\Request;
use App\Helper\ICheckAction;

class ShiftController extends Controller
{
    private $shiftRepository;
    private $checkAction;

    public function __construct(ICheckAction $checkAction,IShiftRepository $shiftRepository)
    {
        $this->checkAction = $checkAction;
        $this->shiftRepository = $shiftRepository;
    }

    public function index()
    {
        $result = $this->checkAction->getPermission(auth()->id());
        $check = $this->shiftRepository->checkRoleIndex($result);
        if($check != 0){
            return $this->shiftRepository->showIndex();
        }else{
            return view('layouts')->withErrors('Bạn không thuộc quyền truy cập chức năng này');
        }
    }

    public function store(Request $request)
    {
        $this->shiftRepository->validateUnique($request);
        return $this->shiftRepository->storeShift($request);
    }

    public function updateName(Request $request,$id)
    {
        $this->shiftRepository->validateUnique($request);
        return $this->shiftRepository->updateNameShift($request,$id);
    }

    public function updateTime(Request $request,$id)
    {
        return $this->shiftRepository->updateTimeShift($request,$id);
    }
}
