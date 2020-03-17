<?php

namespace App\Http\Controllers;

use App\Order;
use App\OrderDetailTable;
use App\Repositories\PayRepository\IPayRepository;
use Illuminate\Http\Request;
class PayController extends Controller
{
    private $payRepository;

    public function __construct(IPayRepository $payRepository)
    {
       $this->payRepository = $payRepository;
    }

    public function index($id)
    {
        return $this->payRepository->showBill($id);
    }

    public function update(Request $request, $id)
    {
        return $this->payRepository->updateStatusOrder($request,$id);
    }
}
