<?php

namespace App\Http\Controllers;

use App\Repositories\BookingRepository\IBookingRepository;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    private $bookingRepository;

    public function __construct(IBookingRepository $bookingRepository)
    {
        $this->bookingRepository = $bookingRepository;
    }

    public function index()
    {
        return $this->bookingRepository->showIndex();
    }

    public function store(Request $request)
    {
        return $this->bookingRepository->createBooking($request);
    }

    public function search(Request $request)
    {
        return $this->bookingRepository->searchBooking($request);
    }
}
