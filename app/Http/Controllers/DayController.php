<?php

namespace App\Http\Controllers;

use App\Repositories\DayRepository\IDayRepository;
use App\StartDay;
use Illuminate\Http\Request;

class DayController extends Controller
{
    private $dayRepository;
    public function __construct(IDayRepository $dayRepository)
    {
        $this->dayRepository = $dayRepository;
    }

    public function open()
    {
        return $this->dayRepository->startDay();
    }

    public function close()
    {
        return $this->dayRepository->endDay();
    }
}
