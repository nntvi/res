<body style="padding:0px; width:120mm; margin:auto; font-size:11px;">
        <style>
            .tb {
                display: block;
                width: 100%;
            }

            .tb2 {
                display: block;
                width: 100%;
            }

            tbody {
                display: block;
                width: 100%;
            }

            .tb tr {
                display: block;
                width: 100%;
            }

            .tb tr td {
                display: inline-block;
                width: 49%;
            }
        </style>
        <div class="container" style="margin:0px; padding:0px; width:100%; margin:auto;">
            <div id="mydiv" style="page-break-after: always;">
                <h3 style="text-align:center; display: block; font-size:20px; margin-bottom:0px; font-family:'Times New Roman', Times, serif; font-weight:bold">RESTAUR_T</h3>
            </div>
            <div style="text-align:center; margin-bottom:4px;">
            </div>
            @foreach ($importCoupon as $item)
            <div class="info" style="margin-bottom:8px;">
                    <H4 style="font-weight:bold; text-align:center; font-size:13px;"> Chi tiết Phiếu Nhập - {{ $item->code }} </H4>
            </div>

            <hr>
            <div class="product">
                    <div class="info" style="text-align:center;">
                        <span>Ngày nhập: {{$item->created_at}}</span>
                    </div>
                    <table class="tb2">
                        <tr style="font-weight: bold">
                            <td align="right">STT </td>
                            <td align="center" style="padding:5px; width: 40%;">Tên mặt hàng</td>
                            <td align="right" style="padding:5px;">Sl </td>
                            <td align="right" style="padding:15px;">Đơn vị</td>
                            <td align="right" style="padding:15px;">Thành tiền</td>
                        </tr>

                        @foreach ($item->detailImportCoupon as $key => $detail)
                            <tr>
                                <td align="right" style="padding:5px;">{{$key+1}}</td>
                                <td align="center" style="padding:5px; width: 40%;">{{ $detail->materialDetail->name }}</td>
                                <td align="right" style="padding:15px;">{{ $detail->qty }}</td>
                                <td align="right" style="padding:15px;">{{ $detail->unit->name}}</td>
                                <td align="right" style="padding:15px;">{{ number_format($detail->price) . ' đ'}}</td>
                            </tr>
                        @endforeach
                        @if ($item->note != null)
                            <tr>
                                <td colspan="2">Ghi chú: </td>
                                <td><i>{{$item->note}}</i></td>
                            </tr>
                        @else

                        @endif
                        <tr>
                            <td colspan="2">Nhà cung cấp: </td>
                            <td colspan="5">{{$item->supplier->name}}</td>
                        </tr>
                        <tr>
                            <td colspan="2">Địa chỉ: </td>
                            <td colspan="5">{{$item->supplier->address}}</td>
                        </tr>
                        <tr style="font-weight: bold" >
                            <td colspan="2">Tổng cộng: </td>
                            <td colspan="3">{{number_format($item->total). ' đ'}}</td>
                        </tr>
                    </table>
            </div>

            </br>
            </div>
            @endforeach
            <div style="margin-top:18px;">
                <div style="text-align: center;">
                    Facebook.com/officecoffeevietnam
                    <br />
                    <b style="font-size:13px;">0967 123 123</b>
                </div>
            </div>
        </div>
    </body>
