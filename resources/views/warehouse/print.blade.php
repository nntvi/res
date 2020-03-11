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
                    <H4 style="font-weight:bold; text-align:center; font-size:13px;"> Chi tiết Phiếu Nhập - {{ $import->code }} </H4>
                </div>

                <hr>
                <div class="product">
                    <div class="info" style="text-align:center;">
                        <span>Ngày nhập: {{$import->created_at}}</span>
                    </div>
                    <table class="tb2">
                        <tr style="font-weight: bold">
                            <td align="right">STT </td>
                            <td align="center" style="padding:5px;">Tên mặt hàng</td>
                            <td align="right" style="padding:5px;">Sl </td>
                            <td align="right" style="padding:15px;">Đơn vị</td>
                            <td align="right" style="padding:15px;">Giá nhập</td>
                            <td align="right" style="padding:10px;">Thành tiền </td>

                        </tr>

                        @foreach ($detailImports as $key => $item)
                            <tr>
                                <td align="right" style="padding:5px;">{{$key+1}}</td>
                                <td align="center" style="padding:5px;">{{ $item->materialDetail->name }}</td>
                                <td align="right" style="padding:15px;">{{ $item->qty }}</td>
                                <td align="right" style="padding:15px;">{{ $item->unit->name }}</td>
                                <td align="right" style="padding:15px;">{{number_format($item->price) . ' đ'}}</td>
                                <td align="right" style="padding:15px;">{{number_format($item->qty * $item->price). ' đ'}}</td>
                            </tr>
                        @endforeach
                        @if ($import->note != null)
                            <tr>
                                <td colspan="2">Ghi chú: </td>
                                <td><i>{{$import->note}}</i></td>
                            </tr>
                        @else

                        @endif
                        <tr>
                            <td colspan="2">Nhà cung cấp: </td>
                            <td colspan="5">{{$import->supplier->name}}</td>
                        </tr>
                        <tr>
                            <td colspan="2">Địa chỉ: </td>
                            <td colspan="5">{{$import->supplier->address}}</td>
                        </tr>
                        <tr style="font-weight: bold" >
                            <td colspan="2">Tổng cộng: </td>
                            <td colspan="3">{{number_format($import->total). ' đ'}}</td>
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
