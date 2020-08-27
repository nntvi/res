@extends('layouts')
@section('content')
<style>
    .black {
        color: #32323a !important;
    }

</style>
<div class="row">
    <div class="col-lg-12 mail-w3agile">
        <section class="panel">
            <header class="panel-heading wht-bg">
                <h4 class="gen-case">Thông báo đặt bàn mới ({{ $countNewBooking }}) </h4>

            </header>
            <div class="panel-body minimal">
                <div class="mail-option">
                    <div class="row">
                        <div class="col-xs-6 col-sm-4">
                            <a href="{{ route('booking.index') }}" class="btn bnt-sm btn-default">Trở về</a>
                        </div>
                        <div class="col-sm-4"></div>
                        <div class="col-xs-6 col-sm-4 text-right">
                            <form action="{{ route('booking.search') }}" method="get">
                                @csrf
                                <div class="input-group">
                                    <input type="text" class="input-sm form-control" name="search" required>
                                    <span class="input-group-btn">
                                        <button class="btn btn-sm btn-success" type="submit">Tìm kiếm</button>
                                    </span>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
                <div class="table-inbox-wrap ">
                    <table class="table table-inbox table-hover">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Tên KH</th>
                                <th>Email</th>
                                <th>Sđt</th>
                                <th>Ngày đặt</th>
                                <th>Giờ đặt</th>
                                <th>Trạng thái</th>
                                <th></th>
                                <th class="text-right">Thời gian tạo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bookings as $key => $booking)
                                @if($booking->status == '0')
                                    <tr class="unread">
                                        <td class="view-message ">{{ $key + 1 }}</td>
                                        <td class="view-message black">{{ $booking->name }}</td>
                                        <td class="view-message black">{{ $booking->email }}</td>
                                        <td class="view-message black">{{ $booking->phone }}</td>
                                        <td class="view-message black">{{ $booking->date }}</td>
                                        <td class="view-message black">{{ $booking->time }}</td>
                                        <td class="view-message black">
                                            @switch($booking->status)
                                                @case('-1')
                                                    Hủy (khách không đến)
                                                    @break
                                                @case('0')
                                                    Chưa duyệt
                                                    @break
                                                @case('1')
                                                    Đã duyệt
                                                    @break
                                                @default
                                                @endswitch
                                            </td>
                                            <td class="view-message"><a href=""><i class="fa fa-pencil text-success"
                                                        aria-hidden="true"></i></a></td>
                                            <td class="view-message  text-right">{{ $booking->created_at }}</td>
                                        </tr>
                                    @else
                                        <tr class="">
                                            <td class="view-message ">{{ $key + 1 }}</td>
                                            <td class="view-message ">{{ $booking->name }}</td>
                                            <td class="view-message ">{{ $booking->email }}</td>
                                            <td class="view-message ">{{ $booking->phone }}</td>
                                            <td class="view-message ">{{ $booking->date }}</td>
                                            <td class="view-message ">{{ $booking->time }}</td>
                                            <td class="view-message black">
                                                @switch($booking->status)
                                                    @case('-1')
                                                    Hủy (khách không đến)
                                                    @break
                                                @case('0')
                                                    Chưa duyệt
                                                    @break
                                                @case('1')
                                                    Đã duyệt
                                                    @break
                                                @default
                                            @endswitch
                                        </td>
                                        <td></td>
                                        <td class="view-message  text-right">{{ $booking->created_at }}</td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </section>
    </div>
</div>
@endsection
