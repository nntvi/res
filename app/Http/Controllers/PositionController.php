<?php

namespace App\Http\Controllers;

use App\Repositories\PositionRepository\IPositionRepository;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    private $positionRepository;

    public function __construct(IPositionRepository $positionRepository)
    {
        $this->positionRepository = $positionRepository;
    }

    public function index()
    {
        return $this->positionRepository->show();
    }

    public function store(Request $request)
    {
        $this->positionRepository->validateNamePosition($request);
        return $this->positionRepository->storePosition($request);
    }

    public function updateName(Request $request,$id)
    {
        $this->positionRepository->validateNamePosition($request);
        return $this->positionRepository->updateNamePosition($request,$id);
    }

    public function updateSalary(Request $request,$id)
    {
        return $this->positionRepository->updateSalaryPosition($request,$id);
    }

    public function delete($id)
    {
        return $this->positionRepository->deletePosition($id);
    }
}
