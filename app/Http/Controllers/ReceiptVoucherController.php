<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReceiptVoucherController extends Controller
{
    public function index()
    {
        return view('receiptvoucher.index');
    }
}
