@extends('layouts')
@section('content')

<div class="table-agile-info" style="padding: 2em;">
    <div class="position-center">
        <div class="text-center ">
            <button class="btn btn-success"
                onclick="printJS({ printable: 'printJS-form', type: 'html', header: 'Restaurant' })">
                <i class="fa fa-print" aria-hidden="true"></i> In Hóa đơn
            </button>
            <a href="{{ route('order.index') }}" class="btn btn-default">
                Trở về
            </a>
        </div>
    </div>
    <div class="space"></div>
    <div class="panel panel-default">
        <div class="row" style="padding-top: 15px">
            <div class="col-xs-5 text-right">
                {!! QrCode::size(72)->generate($bill->code); !!}
            </div>
            <div class="col-xs-7 text-left">
                <h2>Restaurant</h2><Br>
                <h4>Mã hóa đơn: {{ $bill->code }}</h4>
            </div>
        </div>
        <div class="row w3-res-tb">
            <div class="col-sm-5 m-b-xs">
                <h6>
                    @foreach ($bill->tableOrdered as $table)
                        {{ $table->table->name }}
                        {{ count($bill->tableOrdered) > 1 ? ', ' : '' }}
                    @endforeach
                    @foreach ($bill->tableOrdered as $table)
                        {{ $table->table->getArea->name }}
                        @break
                    @endforeach
                    - Ca: {{ $bill->shift->name }}
                </h6><br>
                <h6>Khu vực:
                    @foreach ($bill->tableOrdered as $table)
                        {{ $table->table->getArea->name }}
                        @break
                    @endforeach
                </h6>
            </div>
            <div class="col-sm-3">
                <h6>Người tạo: {{ $bill->created_by }}</h6><br>
                <h6>Thu ngân: {{ $bill->payer }}</h6>
            </div>
            <div class="col-sm-4 text-right">
                <h6>Thời gian vào: {{ $bill->created_at }}</h6><Br>
                <h6>Thời gian ra: {{ $bill->updated_at }}</h6>
            </div>
        </div>
        <div>
            <div class="space"></div>
            <table class="table">
                <thead class="bold">
                    <tr>
                        <td width="5%">STT </td>
                        <td width="10%">Tên món </td>
                        <td width="5%">Số lượng </td>
                        <td width="10%">Đơn giá </td>
                        <td width="10%" class="text-center">Thành tiền </td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($billPayment as $key => $item)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $item->dish->name }}</td>
                            <td>{{ $item->amount }}</td>
                            <td>{{ number_format($item->dish->sale_price) . ' đ' }}
                            </td>
                            <td class="text-center">
                                {{ number_format($item->dish->sale_price * $item->amount) . ' đ' }}
                            </td>
                        </tr>
                    @endforeach
                    <tr class="bold">
                        <td colspan="4" style="text-transform: uppercase; color:black">Tổng tiền</td>
                        <td class="text-center">
                            {{ number_format($bill->total_price) . ' đ' }}</td>
                    </tr>
                    <tr class="bold">
                        <td colspan="4" style="text-transform: uppercase; color:black">Tiền khách đưa</td>
                        <td class="text-center">
                            {{ number_format($bill->receive_cash) . ' đ' }}</td>
                    </tr>
                    <tr class="bold">
                        <td colspan="4" style="text-transform: uppercase; color:black">Tiền hoàn lại</td>
                        <td class="text-center">
                            {{ number_format($bill->excess_cash) . ' đ' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div id="printJS-form" style="visibility:hidden">
    <div id="mydiv">
        <div class="info">
            <H4 style="font-weight:bold; text-align:center; font-size:13px;">HÓA ĐƠN THANH TOÁN
        </div>
        <div class="info">
            <h5 style="font-weight:bold; text-align:center; font-size:13px;">Mã hóa đơn: {{ $bill->code }} -
                @foreach ($bill->tableOrdered as $table)
                    {{ $table->table->name }}
                    {{ count($bill->tableOrdered) > 1 ? ', ' : '' }}
                @endforeach
                @foreach ($bill->tableOrdered as $table)
                    {{ $table->table->getArea->name }}
                    @break
                @endforeach
            </h5>

        </div>
        <div class="info">
            <h6>Giờ vào: {{ $bill->created_at }} - Giờ ra: {{ $bill->updated_at }}</h6>
        </div>
        <div>
            <h6>Nhân viên: {{ $bill->created_by }} - Thu ngân: {{ $bill->payer }} - Ca:
                {{ $bill->shift->name }}
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
                    @foreach($billPayment as $key => $item)
                        <tr>
                            <td align="right" style="padding:5px;">{{ $key+1 }}</td>
                            <td align="right" style="padding:5px;">{{ $item->dish->name }}</td>
                            <td align="right" style="padding:5px;">{{ $item->amount }}</td>
                            <td align="right" style="padding:5px;">{{ number_format($item->dish->sale_price) }}
                            </td>
                            <td align="right" style="padding:5px;">
                                {{ number_format($item->dish->sale_price * $item->amount) }}</td>
                        </tr>
                    @endforeach
                    @if($bill->note != null)
                        <tr>
                            <td colspan="4">Ghi chú: </td>
                            <td>{{ $bill->note }}</td>
                        </tr>
                    @else

                    @endif

                    <tr>
                        <td colspan="4">Tổng cộng: </td>
                        <td align="right" style="font-weight: bold">
                            {{ number_format($bill->total_price). ' đ' }}</td>
                    </tr>
                    <tr>
                        <td colspan="4">Tiền khách đưa: </td>
                        <td align="right" style="font-weight: bold">
                            {{ number_format($bill->receive_cash). ' đ' }}</td>
                    </tr>
                    <tr>
                        <td colspan="4">Tiền hoàn lại: </td>
                        <td align="right" style="font-weight: bold">
                            {{ number_format($bill->excess_cash). ' đ' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <br>
        <br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        {!! QrCode::size(50)->generate($bill->code); !!}
        <br>
        <br>
        <i style=" display:block;font-size:12px; text-align:center;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Hẹn
            gặp lại Quý khách!</i>

    </div>
</div>
<script>
    @if(session('success'))
        toastr.success('{{ session('success') }}')
    @endif
</script>
@endsection
