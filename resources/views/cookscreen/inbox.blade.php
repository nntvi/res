@extends('layouts')
@section('content')
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            {{ $cook->name }}
        </div>

        <div class="table-responsive">
        <table class="table table-striped b-t b-light" id="example">
            <thead>
            <tr>
                <tr>
                    <th>Ma HD</th>
                    <th>Sl</th>
                    <th>Thời gian</th>
                    <th>Trạng thái</th>
                    <th class="text-center">Chi tiet</th>
                </tr>
            </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td>{{ $order->code }}</td>
                        <td>{{ count($order->orderDetail) }}</td>
                        <td>{{ $order->created_at }}</td>
                        <td></td>
                        <td>
                            <a href="">Xem chi tiet</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>
@endsection
