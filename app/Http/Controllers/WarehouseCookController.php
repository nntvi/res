<?php

namespace App\Http\Controllers;

use App\Exports\ReportWarehouseCook;
use App\WarehouseCook;
use Illuminate\Http\Request;
use App\Repositories\WarehouseCookRepository\IWarehouseCookRepository;
use Maatwebsite\Excel\Facades\Excel;
use App\Helper\ICheckAction;

class WarehouseCookController extends Controller
{
    private $warehousecookRepository;
    private $checkAction;

    public function __construct(ICheckAction $checkAction, IWarehouseCookRepository $warehousecookRepository)
    {
        $this->checkAction = $checkAction;
        $this->warehousecookRepository = $warehousecookRepository;
    }

    public function index()
    {
        $result = $this->checkAction->getPermission(auth()->id());
        $check = $this->warehousecookRepository->checkRoleIndex($result);
        if($check != 0){
            return $this->warehousecookRepository->showWarehouseCook();
        }else{
            return view('layouts')->withErrors('Bạn không thuộc quyền truy cập chức năng này');
        }
    }

    public function reset()
    {
        $result = $this->checkAction->getPermission(auth()->id());
        $check = $this->warehousecookRepository->checkRoleUpdate($result);
        if($check != 0){
            return $this->warehousecookRepository->resetWarehouseCook();
        }else{
            return view('layouts')->withErrors('Bạn không thuộc quyền truy cập chức năng này');
        }
    }

    public function report(Request $request)
    {
        return $this->warehousecookRepository->reportWarehouseCook($request);
    }

    public function exportExcel($cook,$dateStart,$dateEnd)
    {
        return Excel::download(new ReportWarehouseCook($cook,$dateStart,$dateEnd),'reportwhcook.xlsx');
    }
}
