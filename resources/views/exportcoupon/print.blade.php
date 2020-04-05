<body style="padding:0px; width:80mm; margin:auto; font-size:11px;">
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
        @foreach ($exportCoupon as $item)
        <div class="info" style="margin-bottom:8px;">
                <H4 style="font-weight:bold; text-align:center; font-size:13px;"> Chi tiết Phiếu Xuất - {{ $item->code }} </H4>
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
                    </tr>

                    @foreach ($item->detailExportCoupon as $key => $detail)
                        <tr>
                            <td align="right" style="padding:5px;">{{$key+1}}</td>
                            <td align="center" style="padding:5px; width: 40%;">{{ $detail->materialDetail->name }}</td>
                            <td align="right" style="padding:15px;">{{ $detail->qty }}</td>
                            <td align="right" style="padding:15px;">{{ $detail->unit->name}}</td>
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
                        <td colspan="2">Loại xuất: </td>
                        <td colspan="5">
                            {{$item->typeExport->name}}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">Đối tượng xuất: </td>
                        <td colspan="5">
                            @if ($item->typeExport->id == 1)
                                @foreach ($item->detailExportCoupon as $detail)
                                    {{ $detail->cook->name }}
                                    @break;
                                @endforeach
                            @endif
                            @if ($item->typeExport->id == 2)
                                @foreach ($item->detailExportCoupon as $detail)
                                    {{ $detail->supplier->name }}
                                    @break;
                                @endforeach
                            @endif
                        </td>
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
