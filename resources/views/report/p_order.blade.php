@extends('layouts')
@section('content')
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="fa fa-home"></i> Báo cáo theo đơn hàng
        </div>
        <div class="panel-body">
            <form action="{{ route('report.p_order') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-xs-12 col-sm-4">
                        <div class="form-group ">
                                <a data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                                        <label class="control-label" style="cursor:pointer; color: black;">Chọn &nbsp;<i class="fa fa-angle-down" aria-hidden="true"></i> </label>
                                    </a>
                                    <div class="collapse" id="collapseExample">
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
                            <label class="control-label">Từ:</label>
                                <input class="date form-control" name="dateStart" type="text" id="dateStart"
                                    value="{{ $dateStart }}">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4">
                        <div class="form-group ">
                            <label class="control-label">Đến:</label>
                            <input class="date form-control" name="dateEnd" type="text" id="dateEnd"
                                    value="{{ $dateEnd }}">
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
            <div class="table-responsive">
                    <table class="table" id="example">
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
                                        <td>
                                            @foreach ($order->tableOrdered as $table)
                                                {{ $table->table->getArea->name }}
                                                @break
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach ($order->tableOrdered as $table)
                                                {{ $table->table->name }}
                                                {{ count($order->tableOrdered) > 1 ? ', ' : '' }}
                                            @endforeach
                                        </td>
                                        <td>{{ $order->created_by }}</td>
                                        <td>{{ $order->payer }}</td>
                                        <td>{{ $order->shift->name }}</td>
                                        <td>
                                            @switch($order->status)
                                                @case('0')
                                                    Đã thanh toán
                                                    @break
                                                @case('1')
                                                    Chưa thanh toán
                                                    @break
                                                @case('-1')
                                                    Đã hủy
                                                @default
                                            @endswitch
                                        </td>
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
            <script type="text/javascript" language="javascript" src="{{ asset('js/data.table.js') }}"></script>
            <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
            <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>    <script>
                $(document).ready( function () {
                    $('#example').dataTable();
                    $('#example_info').addClass('text-muted');
                    $('#example_length').remove();
                    $('#example_filter').remove();
                } );
            </script>
        </div>
    </div>
</div>
</div>

@endsection
