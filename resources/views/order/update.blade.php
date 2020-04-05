@extends('layouts')
@section('content')
<style>
    .check{
        border: none;
        background: none;
        transition: 0.4s;
    }
    button.check:hover{
        font-weight: bold;
        background: whitesmoke;
        border: 1px solid darkgreen;
    }
</style>
<div class="panel panel-default">
        <div class="panel-heading">
        @foreach ($orderById as $order)
              {{ $order->table->name }} -- {{ $order->table->getArea->name }}
        </div>
        <div class="row w3-res-tb text-center">
            @if ($order->status == '1')
                <a href="{{route('order.index')}}">
                    <button class="btn btn-success">Về trang Order</button>
                </a>
                <a href="{{route('pay.index',['id' => $order->id])}}">
                    <button class="btn btn-danger">Thanh toán</button>
                </a>
            @else

            @endif
            <hr>
        </div>
        <div class="table-responsive">
          <table class="table table-striped b-t b-light">
            <thead>
              <tr>
                <th>STT</th>
                <th>Tên món</th>
                <th class="text-center" >Số lượng</th>
                <th class="text-center">Ghi chú</th>
                <th>Trạng thái</th>
                <th class="text-center">Thời gian</th>
                <th style="width:30px;"></th>
              </tr>
            </thead>
            <tbody>
                @foreach ($order->orderDetail as $key => $item)
                        <form action="{{route('order.p_update',['id' => $item->id])}}" method="post">
                            @csrf
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>
                                        {{ $item->dish->name }}
                                    </td>
                                    <td width= 10%>
                                        <div class="input-group m-bot15">
                                            <input type="text" name="qty" id="qty{{ $item->id }}" value="{{$item->qty}}" hidden>
                                            <input type="text" class="form-control" id="quantity{{ $item->id }}" value="{{$item->qty}}" disabled>
                                                <span class="input-group-btn" onclick="clickToPlus({{ $item->id }})">
                                                    <button class="btn btn-info" type="button">
                                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                                    </button>
                                                </span>
                                        </div>
                                        <script>
                                            function clickToPlus($id){
                                                var sl = document.getElementById('quantity'+$id).value;
                                                if(sl < 10){
                                                    sl++;
                                                    document.getElementById('quantity' + $id).value = sl;
                                                    document.getElementById('qty' + $id).value = sl;
                                                }else if(sl == 10){
                                                    document.getElementById('quantity' + $id).value = 10;
                                                    document.getElementById('qty' + $id).value = 10;
                                                }
                                            }
                                        </script>
                                    </td>
                                    <td>
                                        <input class="form-control m-bot15" type="text" name="note" value="{{$item->note}}" >
                                    </td>
                                    @if ($item->status == '-1')
                                        <td>
                                            <span style="color:red;">Không đủ NVL thực hiện</span>
                                        </td>
                                    @else
                                    <td>
                                            @if ($item->status == '0')
                                                <span style="color:red;">Chưa hoàn thành</span>
                                            @endif
                                            @if ($item->status == '1')
                                                <span style="color:purple;"><i class="fa fa-tint" aria-hidden="true"></i> Đang thực hiện</span>
                                            @endif
                                            @if ($item->status == '2')
                                                <span style="color:green;"><i class="fa fa-check" aria-hidden="true"></i> Hoàn thành</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $item->created_at }}
                                        </td>
                                        <td>
                                            @if (($item->created_at != $item->updated_at))
                                                -
                                            @else
                                            <button type="submit" href="" class="active check" ui-toggle-class="">
                                                    <i class="fa fa-check text-success text-active"></i>
                                                </button>
                                                <a href="{{route('order.delete',['id' => $item->id])}}"
                                                    onclick="return confirm('Bạn có muốn xóa món này?');" style="padding-left: 9px">
                                                    <i class="fa fa-times text-danger text"></i>
                                                </a>
                                            @endif
                                        </td>
                                    @endif

                                </tr>
                        </form>
                @endforeach
        @endforeach
            </tbody>
          </table>
        </div>
</div>
@endsection
