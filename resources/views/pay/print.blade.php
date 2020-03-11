<body style="padding:0px; width:100mm; margin:auto; font-size:11px;">
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
                <div style="text-align:center; margin-bottom:8px;"><br />

                </div>

                <div class="info" style="margin-bottom:8px;">
                    <H4 style="font-weight:bold; text-align:center; font-size:13px;">HÓA ĐƠN THANH TOÁN</H4>
                </div>
                <hr>
                <div class="product">

                    <table class="tb2">
                        <tr style="font-weight: bold">
                            <td align="right">STT </td>
                            <td style="padding:5px;">Tên món </td>
                            <td align="right" style="padding:5px;">Sl </td>
                            <td align="right" style="padding:5px;">Đơn giá </td>
                            <td align="right" style="padding:5px;">Thành tiền </td>

                        </tr>

                        @foreach ($billPayment as $key => $item)
                            <tr>
                                <td align="right" style="padding:5px;">{{$key+1}}</td>
                                <td align="right" style="padding:5px;">{{$item->dish->name}}</td>
                                <td align="right" style="padding:5px;">{{$item->amount}}</td>
                                <td align="right" style="padding:5px;">{{number_format($item->dish->sale_price)}}</td>
                                <td align="right" style="padding:5px;">{{number_format($item->dish->sale_price * $item->amount)}}</td>
                            </tr>
                        @endforeach
                        @if ($total->note != null)
                            <tr>
                                <td colspan="4">Ghi chú: </td>
                                <td>{{$total->note}}</td>
                            </tr>
                        @else

                        @endif

                        <tr>
                            <td colspan="4">Tạm tính: </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="4">Chiết khấu: </td>
                            <td></td>
                        </tr>
                        <tr >
                            <td colspan="4">Tông cộng: </td>
                            <td style="font-weight: bold">{{number_format($total->total_price). ' đ'}}</td>
                        </tr>
                    </table>
                </div>

               <br />



            </div>
            <div style="margin-top:18px;">
                <div style="text-align: center;"><b>GÓP Ý </b></br></><i>Phục vụ - Chất lượng đồ uống</i></br>
                    Facebook.com/officecoffeevietnam
                    <br />
                    <b style="font-size:13px;">0967 123 123</b>
                </div>



            </div>
            <div class="conment" style="text-align:center;">
            </div>
            <b style="display:block; text-align:center;">---o0o---</b>
            <i style=" display:block;font-size:12px; text-align:center;">Hẹn gặp lại Quý khách!</i>


        </div>
    </body>
