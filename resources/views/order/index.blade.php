@extends('layouts')
@section('content')
<style>
    .bill{
        border: 2px solid black;
        background: aquamarine;
        font-size: 14px;
        width: 24%;
        margin-right: 10px;
        margin-top: 13px;
    }
    .text-muted{
        background: black;
        color: white;
        margin: 0px -15px;
    }
    .card-header{
        padding: 5px 0px;
        font-weight: bolder;
    }
    .card-body{
        color: red;
    }
    .action{
        margin: 10px -15px 0px -15px;
    }
    .add{
        border-right: 1.5px solid black;
    }
    .add:hover{
        background: #ffec40eb;
    }
    .add, .detail{
        border-top: 1.5px solid black;
        padding: 3px 0px;
        background: khaki;
        font-weight: 500;
        cursor: pointer;
        transition: 0.4s;
    }
    .add a, .detail a{
        text-decoration: none;
        color: black;
    }
    .detail{
        background: #5f7e8d;
    }
    .detail:hover{
        background: beige;
    }
    .detail a{
        color:white;
        font-weight: 400;
    }
    .detail a:hover{
        color: brown;
        font-weight: bold;
    }
</style>
		<div class="w3layouts-glyphicon">
            <div class="grid_3 grid_4">
                    <h2 class="w3ls_head">Orders</h2>
                    <div class="row">
                        <a href="{{route('order.order')}}" class="btn green-meadow radius col-xs-12">Tạo order</a>
                        </div>
                    @foreach ($areas as $area)
                    <h3 class="page-header icon-subheading">{{$area->name}}</h3>
                        <div class="row">
                            @foreach ($idOrders as $order)
                                @if ($order->table->getArea->id == $area->id)
                                    @if ($order->status == '1')
                                        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6 bill">
                                                <div class="card text-center">
                                                    <div class="card-footer text-muted">
                                                        {{$order->created_at}}
                                                    </div>
                                                    <div class="card-header">
                                                        {{$order->table->name}}
                                                    </div>
                                                    <div class="card-body">
                                                        <h5 class="card-title">Đang có khách</h5>
                                                    </div>
                                                    <div class="action">
                                                        <div class="col-sm-6 col-xs-12 add">
                                                            <a href="{{route('order.addmore',['id' => $order->id])}}">Thêm món</a>
                                                        </div>
                                                        <div class="col-sm-6 col-xs-12 detail">
                                                            <a href="{{route('order.update',['id' => $order->id])}}">Xem chi tiết</a>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                    @else
                                    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6 bill" style="background: burlywood">
                                            <div class="card text-center">
                                                <div class="card-footer text-muted">
                                                    {{$order->created_at}}
                                                </div>
                                                <div class="card-header">
                                                    {{$order->table->name}}
                                                </div>
                                                <div class="card-body">
                                                    <h5 class="card-title">Đã thanh toán</h5>
                                                </div>
                                                <div class="action">
                                                    <div class="col-sm-6 col-xs-12 add">
                                                        <a href="{{route('order.addmore',['id' => $order->id])}}">Thêm món</a>
                                                    </div>
                                                    <div class="col-sm-6 col-xs-12 detail">
                                                        <a href="{{route('order.update',['id' => $order->id])}}">Xem chi tiết</a>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                    @endif
                                @endif
                            @endforeach
                        </div>
                    @endforeach
                    <div class="space"></div>
                <div class="clearfix"></div>
            </div>
		</div>
@endsection
