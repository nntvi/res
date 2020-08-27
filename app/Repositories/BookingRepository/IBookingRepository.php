<?php
namespace App\Repositories\BookingRepository;

interface IBookingRepository{
    public function showIndex();
    function createBooking($request);
    function searchBooking($request);
}
