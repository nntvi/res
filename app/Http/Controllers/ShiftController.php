<?php

namespace App\Http\Controllers;

use App\Repositories\ShiftRepository\IShiftRepository;
use Illuminate\Http\Request;

class ShiftController extends Controller
{
    private $shiftRepository;

    public function __construct(IShiftRepository $shiftRepository)
    {
        $this->shiftRepository = $shiftRepository;
    }

    public function index()
    {
       return $this->shiftRepository->showIndex();
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

    public function delete($id)
    {
       return $this->shiftRepository->deleteShift($id);
    }
}
