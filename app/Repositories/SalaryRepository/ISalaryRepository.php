<?php
namespace App\Repositories\SalaryRepository;

interface ISalaryRepository{
    function show();
    function updateSalary($request,$id);
}
