@extends('layouts')
@section('content')
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading" style="margin-bottom: 15px;">
            <i class="fa fa-home"></i> Báo cáo theo đơn hàng
        </div>
        <div class="panel-body">
            <form action="{{ route('report.p_order') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-xs-12 col-sm-4">
                        <div class="form-group ">
                            <label for="cname" class="control-label col-lg-3">Chọn: </label>
                            <div class="col-lg-9">
                                <select class="form-control m-bot15" id="timeReport">
                                    <option value="0">Hôm nay</option>
                                    <option value="1">Hôm qua</option>
                                    <option value="2">Tuần này</option>
                                    <option value="3">Tuần trước</option>
                                    <option value="4">Tháng này</option>
                                    <option value="5">Tháng trước</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4">
                        <div class="form-group ">
                            <label for="cname" class="control-label col-lg-3">Từ:</label>
                            <div class="col-lg-9">
                                <input class="date form-control" name="dateStart" type="text" id="dateStart"
                                    value="{{ $dateStart }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4">
                        <div class="form-group ">
                            <label for="cname" class="control-label col-lg-3">Đến:</label>
                            <div class="col-lg-9">
                                <input class="date form-control" name="dateEnd" type="text" id="dateEnd"
                                    value="{{ $dateEnd }}">
                            </div>
                        </div>
                        <script type="text/javascript">
                            $('.date').datepicker({
                                format: 'yyyy-mm-dd'
                            });

                            function validateForm() {
                                var dateStart = document.getElementById('dateStart').value;
                                var dateEnd = document.getElementById('dateEnd').value;

                                if (dateStart == null || dateStart == "") {
                                    alert("Không để trống ngày bắt đầu");
                                    return false;
                                }
                                if (dateEnd == null || dateEnd == "") {
                                    alert("Không để trống ngày kết thúc");
                                    return false;
                                }
                                return true;
                            }

                        </script>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 text-center">
                        <div class="space"></div>
                        <a href="{{ route('report.order') }}" class="btn btn-default">Trở về</a>
                        <button type="submit" class="btn green-meadow radius">Tìm kiếm</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                Kết quả
            </div>
            <div class="row w3-res-tb">
                <div class="col-sm-5 bold">
                    Ngày lập : {{ $dateCreate }}
                </div>
                <div class="col-sm-4">
                </div>
                <div class="col-sm-3 text-right">
                    <a href="{{ route('report.exportorder',['dateStart' => $dateStart, 'dateEnd' => $dateEnd]) }}"
                        class="btn btn-sm btn-default" type="button">
                        <i class="fa fa-file-excel-o" aria-hidden="true"></i> Xuất Excel
                    </a>
                </div>
            </div>
            <hr>
            <table class="table" ui-jq="footable" ui-options="{
                    &quot;paging&quot;: {
                    &quot;enabled&quot;: true
                    },
                    &quot;filtering&quot;: {
                    &quot;enabled&quot;: true
                    },
                    &quot;sorting&quot;: {
                    &quot;enabled&quot;: true
                    }}">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Khu vực</th>
                        <th>Bàn</th>
                        <th>Người tạo</th>
                        <th>Người thanh toán</th>
                        <th>Ca</th>
                        <th>Trạng thái</th>
                        <th>Thời gian thanh toán</th>
                        <th>Tổng tiền</th>
                        <th>Tiền khách đưa</th>
                        <th>Tiền hoàn lại</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $key => $order)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $order->table->getArea->name }}</td>
                            <td>{{ $order->table->name }}</td>
                            <td>{{ $order->created_by }}</td>
                            <td>{{ $order->payer }}</td>
                            <td>{{ $order->shift->name }}</td>
                            <td>{{ $order->status == '0' ? 'Đã thanh toán' : 'Chưa thanh toán' }}</td>
                            <td>{{ $order->updated_at }}</td>
                            <td>{{ number_format($order->total_price) . ' đ' }}</td>
                            <td>{{ number_format($order->receive_cash) . ' đ' }}</td>
                            <td>{{ number_format($order->excess_cash) . ' đ' }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="bold">
                        <td colspan="8" class="text-right">TỔNG: </td>
                        <td>{{ number_format($footer[0]['total']) . ' đ' }}</td>
                        <td>{{ number_format($footer[0]['totalReceive']) . ' đ' }}</td>
                        <td>{{ number_format($footer[0]['totalExcess']) . ' đ' }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
</div>

@endsection
