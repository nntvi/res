@extends('layouts')
@section('content')
<div class="mail-w3agile">
    <!-- page start-->
    <div class="row">
        <div class="col-sm-8 mail-w3agile">
            <section class="panel">
                <div class="panel-heading">
                    Hóa đơn {{ $idBillTable->code }} --
                    @foreach ($idBillTable->tableOrdered as $key => $item)
                        {{ $item->table->name }}
                        {{ count($idBillTable->tableOrdered) != $key+1 ? ', ' : '' }}
                    @endforeach

                </div>
                {{-- <header class="panel-heading wht-bg">
                    <h5 class="gen-case ">
                        Thời gian: {{ $idBillTable->created_at }}
                </h5>
                </header>
                <hr> --}}
                <div class="row w3-res-tb">
                    <div class="col-sm-5 m-b-xs">
                        <h6>Thời gian vào: {{ $idBillTable->created_at }}</h6>

                    </div>
                    <div class="col-sm-4">
                    </div>
                    <div class="col-sm-3 text-right">
                        <h6>Người tạo: {{ $idBillTable->created_by }}</h6>
                    </div>
                </div>
                <div>
                    <table class="table table-striped b-t b-light">
                        <thead>
                            <tr>
                                <th> STT </th>
                                <th>Tên món</th>
                                <th>Số lượng</th>
                                <th>Đơn giá</th>
                                <th class="text-right">Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bill as $key => $item)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $item->dish->name }}</td>
                                    <td>{{ $item->amount }}</td>
                                    <td>{{ number_format($item->dish->sale_price) . ' đ' }}</td>
                                    <td class="text-right">{{ number_format($item->dish->sale_price * $item->amount) . ' đ' }}</td>
                                </tr>
                            @endforeach
                            <tr class="bold">
                                <td colspan="4" style="text-transform: uppercase; color:black">Tổng tiền</td>
                                <td class="text-right" style="color:black">{{ number_format($totalPrice) . ' đ' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
        <div class="col-sm-4 com-w3ls">
            <form
                action="{{ route('pay.p_update',['id' => $idBillTable->id]) }}"
                method="POST">
                @csrf
                <section class="panel">
                    <div class="panel-body">
                        @if($count > 0)
                            <button type="submit" class="btn btn-compose">
                                Thanh toán
                            </button>
                        @else
                            <a href="{{ route('order.index') }}"
                                class="btn btn-compose">
                                Trở về
                            </a>
                        @endif

                        <hr>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-xs-6 col-sm-6 col-md-6">
                                    <label for="">Tổng tiền: </label>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6 text-right">
                                    <input type="text" name="total" value="{{ $totalPrice }}" hidden>
                                    <input style="font-weight: bold; color: red; font-size: 15px;"
                                        class="form-control totalPrice" type="text" value="{{ $totalPrice }}" disabled>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-6">
                                    <label for="">Tiền khách đưa: </label>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-6 form-group">
                                    <input type="text" class="form-control receive" name="receiveCash" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-6">
                                    <label for="">Tiền thừa: </label>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-6 form-group">
                                    <input name="excessCash" id="excessCash" hidden>
                                    <span class="change"></span>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <label for="">Ghi chú: </label>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 form-group" style="margin-top: 5px">
                                    <textarea name="note" class="form-control"></textarea>
                                </div>
                            </div>
                            <script>
                                $('.receive').keyup(function () {
                                    var customer_pay;
                                    if ($(this).val() == '') {
                                        customer_pay = 0;
                                    } else {
                                        customer_pay = $(this).val();
                                    }
                                    var total_pay = $('.totalPrice').val();
                                    console.log(total_pay);
                                    var debt = customer_pay - total_pay;
                                    $(this).val((customer_pay));
                                    $('.change').html(debt);
                                    $('input#excessCash').val(debt);
                                });

                            </script>
                        </div>
                    </div>
                </section>
            </form>
        </div>
    </div>
    <!-- page end-->
</div>
@endsection
