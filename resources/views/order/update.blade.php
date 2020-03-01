@extends('layouts')
@section('content')
<div class="panel panel-default">
        <div class="panel-heading">
          @foreach ($orderById as $item)
              {{ $item->table->name }}
          @endforeach
        </div>
        <div class="row w3-res-tb">

        </div>
        <div class="table-responsive">
          <table class="table table-striped b-t b-light">
            <thead>
              <tr>
                <th>STT</th>
                <th>Tên món</th>
                <th>Số lượng</th>
                <th>Giá</th>
                <th>Trạng thái</th>
                <th style="width:30px;"></th>
              </tr>
            </thead>
            <tbody>
                    @foreach ($orderById as $order)
                        @foreach ($order->orderDetail as $key => $item)
                                <form action="{{route('order.p_update',['id' => $item->id])}}" method="post">
                                    @csrf
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>
                                        {{ $item->dish->name }}
                                    </td>
                                    <td>
                                        <input type="number" min="1" name="qty" value="{{$item->qty}}">
                                    </td>
                                    <td>
                                        <input type="number" name="price" value="{{$item->dish->sale_price}}" hidden>
                                        {{$item->dish->sale_price}}
                                    </td>
                                    <td>
                                        @if ($item->status == '0')
                                            <span style="color:red;">Chưa hoàn thành</span>
                                        @else
                                            <span style="color:green;">Hoàn thành</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button type="submit" href="" class="active" ui-toggle-class="">
                                            <i class="fa fa-check text-success text-active"></i>
                                        </button>
                                        <a href="">
                                            <i class="fa fa-times text-danger text"></i>
                                        </a>
                                    </td>
                                </tr>
                            </form>
                        @endforeach
                    @endforeach
            </tbody>
          </table>
        </div>
</div>
@endsection
