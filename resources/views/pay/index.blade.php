@extends('layouts')
@section('content')
<div class="mail-w3agile">
    <!-- page start-->
    <div class="row">
        <div class="col-sm-8 mail-w3agile just">
            <section class="panel">
                <div class="panel-heading">
                    Hóa đơn tạm {{ $idBillTable->code }} --
                    @foreach ($idBillTable->tableOrdered as $key => $item)
                        {{ $item->table->name }}
                        {{ count($idBillTable->tableOrdered) != $key+1 ? ', ' : '' }}
                    @endforeach
                    <button class="btn btn-xs btn-default"
                        onclick="printJS({ printable: 'printJS-form', type: 'html', header: 'Restaurant' })">
                        <i class="fa fa-print" aria-hidden="true"></i>
                    </button>
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
            <div id="printJS-form" style="visibility:hidden">
                <div id="mydiv">
                    <div class="info">
                        <H4 style="font-weight:bold; text-align:center; font-size:13px;">HÓA ĐƠN TẠM
                    </div>
                    <div class="info">
                        <h5 style="font-weight:bold; text-align:center; font-size:13px;">Mã hóa đơn: {{ $idBillTable->code }} -
                            @foreach ($idBillTable->tableOrdered as $key => $item)
                                {{ $item->table->name }}
                                {{ count($idBillTable->tableOrdered) != $key+1 ? ', ' : '' }}
                            @endforeach
                            @foreach ($idBillTable->tableOrdered as $table)
                                {{ $table->table->getArea->name }}
                                @break
                            @endforeach
                        </h5>
                    </div>
                    <div class="info">
                        <h6>Giờ vào: {{ $idBillTable->created_at }} - Giờ ra: {{ $idBillTable->updated_at }}</h6>
                    </div>
                    <div>
                        <h6>Người tạo: {{ $idBillTable->created_by }} - Ca:  {{ $idBillTable->shift == null ? 'Ngoại lệ' : $idBillTable->shift->name }}
                        </h6>
                    </div>
                    <hr>
                    <div class="product">
                            <table class="tb2" style="display: block; width: 100%;">
                                <tr style="font-weight: bold">
                                    <td align="right">STT </td>
                                    <td style="padding:5px;">Tên món </td>
                                    <td align="right" style="padding:5px;">Sl </td>
                                    <td align="right" style="padding:5px;">Đơn giá </td>
                                    <td align="right" style="padding:5px;">Thành tiền </td>
                                </tr>
                                <tbody>
                                    @foreach($bill as $key => $item)
                                        <tr>
                                            <td align="right" style="padding:5px;">{{ $key+1 }}</td>
                                            <td align="right" style="padding:5px;">{{ $item->dish->name }}</td>
                                            <td align="right" style="padding:5px;">{{ $item->amount }}</td>
                                            <td align="right" style="padding:5px;">{{ number_format($item->dish->sale_price) . ' đ' }}
                                            </td>
                                            <td align="right" style="padding:5px;">
                                                {{ number_format($item->dish->sale_price * $item->amount) . ' đ' }}</td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="4">Tổng cộng: </td>
                                        <td align="right" style="font-weight: bold">
                                            {{ number_format($totalPrice). ' đ' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                    </div>
                    <br>
                    <br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    {!! QrCode::size(50)->generate($idBillTable->code); !!}
                    <br>
                    <br>
                    <i style=" display:block;font-size:12px; text-align:center;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        Cám ơn và Hẹn gặp lại Quý khách!</i>

                </div>
            </div>
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
                                    <input type="text" class="form-control receive" name="receiveCash" min="0" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-6">
                                    <label for="">Tiền hoàn lại: </label>
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
