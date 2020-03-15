<body style="padding:0px; width:130mm; margin:auto; font-size:11px;">
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

            <div class="info" style="margin-bottom:8px;">
                <H4 style="font-weight:bold; text-align:center; font-size:13px;"> Chi tiết Phiếu Xuất - {{ $export->code }} </H4>
            </div>

            <hr>
            <div class="product">
                <div class="info" style="text-align:center;">
                    <span>Ngày xuất: {{$export->created_at}}</span>
                </div>
                <table class="tb2">
                    <tr style="font-weight: bold">
                        <td align="right">STT </td>
                        <td align="center" style="padding:5px;">Tên mặt hàng</td>
                        <td align="right" style="padding:5px;">Sl </td>
                        <td align="right" style="padding:15px;">Đơn vị</td>
                    </tr>

                    @foreach ($detailExports as $key => $item)
                        <tr>
                            <td align="right" style="padding:5px;">{{$key+1}}</td>
                            <td align="center" style="padding:5px;">{{ $item->materialDetail->name }}</td>
                            <td align="right" style="padding:15px;">{{ $item->qty }}</td>
                            <td align="right" style="padding:15px;">{{ $item->unit->name }}</td>
                        </tr>
                    @endforeach
                    @if ($export->note != null)
                        <tr>
                            <td colspan="2">Ghi chú: </td>
                            <td><i>{{$export->note}}</i></td>
                        </tr>
                    @else

                    @endif
                    <tr>
                        <td colspan="2">Loại xuất: </td>
                        <td colspan="5">{{$export->typeExport->name}}</td>
                    </tr>

                </table>
            </div>

           <br />



        </div>
        <div style="margin-top:18px;">
            <div style="text-align: center;">
                Facebook.com/officecoffeevietnam
                <br />
                <b style="font-size:13px;">0967 123 123</b>
            </div>
        </div>
    </div>
</body>
