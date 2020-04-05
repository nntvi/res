<?php

namespace App\Http\Controllers;

use App\Repositories\AnnounceRepository\IAnnouceRepository;
use Illuminate\Http\Request;

class AnnounceController extends Controller
{
    private $announceRepository;

    public function __construct(IAnnouceRepository $announceRepository)
    {
        $this->announceRepository = $announceRepository;
    }

    public function announceWarehousecook()
    {
        $count = $this->announceRepository->countEmptyWarehouseCook();
        return view('layouts',compact('count'));
    }
}
