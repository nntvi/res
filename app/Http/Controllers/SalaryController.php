<?php

namespace App\Http\Controllers;

use App\Repositories\SalaryRepository\ISalaryRepository;
use Illuminate\Http\Request;

class SalaryController extends Controller
{
    private $salaryRepository;

    public function __construct(ISalaryRepository $salaryRepository)
    {
        $this->salaryRepository = $salaryRepository;
    }

    public function index()
    {
        return $this->salaryRepository->show();
    }

    public function update(Request $request,$id)
    {
        return $this->salaryRepository->updateSalary($request,$id);
    }
}
