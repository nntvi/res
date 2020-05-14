<?php

namespace App\Http\Controllers;

use App\WarehouseCook;
use Illuminate\Http\Request;
use App\Repositories\WarehouseCookRepository\IWarehouseCookRepository;

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

}
