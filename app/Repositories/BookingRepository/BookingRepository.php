<?php
namespace App\Repositories\BookingRepository;

use App\Booking;
use Pusher\Pusher;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class BookingRepository extends Controller implements IBookingRepository{

    public function countNewBooking()
    {
        $count = Booking::selectRaw('count(status) as qty')->where('status','0')->value('qty');
        return $count;
    }
    public function showIndex()
    {
        $bookings = Booking::orderBy('created_at')->paginate(3);
        $countNewBooking = $this->countNewBooking();
        return view('booking.index',compact('bookings','countNewBooking'));
    }
    public function notify($timeCreate,$email,$dateBooking)
    {
        $options = array(
            'cluster' => 'ap1',
            'useTLS' => true
        );
        $pusher = new Pusher(
            'cc6422348edc9fbaff00',
            '54d59c765665f5bc6194',
            '994181',
            $options
        );
        $data['time'] = Carbon::createFromFormat('Y-m-d H:i:s',$timeCreate)->format('H:i:s');
        $data['email'] = $email;
        $data['dateBooking'] =  $dateBooking;
        $pusher->trigger('Booking', 'book-table', $data);
    }
    public function createBooking($request)
    {
        $booking = new Booking();
        $booking->name = $request->name;
        $booking->date = $request->date;
        $booking->time = $request->time;
        $booking->email = $request->email;
        $booking->phone = $request->phone;
        $booking->status = '0'; // vừa nhận thông báo, chưa đặt bàn
        $booking->save();
        $this->notify($booking->created_at,$booking->email,$booking->date);
        return redirect(route('customer.index'));
    }

    public function searchBooking($request)
    {
        $countNewBooking = $this->countNewBooking();
        $search = $request->search;
        $bookings = Booking::where('name','LIKE',"%{$search}%")
                            ->orWhere('email','LIKE',"%{$search}%")
                            ->orWhere('phone','LIKE',"%{$search}%")->get();
        return view('booking.search',compact('bookings','countNewBooking'));
    }
}
