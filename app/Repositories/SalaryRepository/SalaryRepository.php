<?php
namespace App\Repositories\SalaryRepository;

use App\Http\Controllers\Controller;
use App\Salary;

class SalaryRepository extends Controller implements ISalaryRepository{

    public function show()
    {
        $salaries = Salary::with('permission')->get();
        return view('salary.index',compact('salaries'));
    }

    public function updateSalary($request,$id)
    {
        Salary::where('id',$id)->update(['salary' => $request->salary]);
        return redirect(route('salary.index'));
    }
}
