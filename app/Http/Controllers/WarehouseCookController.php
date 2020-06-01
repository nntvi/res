<?php

namespace App\Http\Controllers;

use App\Exports\ReportWarehouseCook;
use App\WarehouseCook;
use Illuminate\Http\Request;
use App\Repositories\WarehouseCookRepository\IWarehouseCookRepository;
use Maatwebsite\Excel\Facades\Excel;

class WarehouseCookController extends Controller
{
    private $warehousecookRepository;

    public function __construct(IWarehouseCookRepository $warehousecookRepository)
    {
        $this->warehousecookRepository = $warehousecookRepository;
    }

    public function index()
    {
        return $this->warehousecookRepository->showWarehouseCook();
    }

    public function reset()
    {
        return $this->warehousecookRepository->resetWarehouseCook();
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
