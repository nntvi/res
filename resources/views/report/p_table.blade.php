@extends('layouts')
@section('content')
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="fa fa-home"></i> Báo cáo bán hàng chi tiết
        </div>
        <div class="panel-body">
            <form action="{{ route('report.p_table') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-xs-12 col-sm-3">
                        <div class="form-group ">
                            <label class="control-label">Báo cáo theo: </label>
                                <select class="form-control" id="timeReport">
                                    <option value="0">Hôm nay</option>
                                    <option value="1">Hôm qua</option>
                                    <option value="2">Tuần này</option>
                                    <option value="3">Tuần trước</option>
                                    <option value="4">Tháng này</option>
                                    <option value="5">Tháng trước</option>
                                    {{-- <option value="6">Quý này</option>
                                    <option value="7">Quý trước</option>
                                    <option value="8">Năm nay</option> --}}
                                </select>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-3">
                        <div class="form-group ">
                            <label class="control-label">Từ ngày:</label>
                                <input class="date form-control" name="dateStart" type="text" id="dateStart"
                                    value="{{ $dateStart }}" required>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-3">
                        <div class="form-group ">
                            <label class="control-label">Đến ngày:</label>
                                <input class="date form-control" name="dateEnd" type="text" id="dateEnd"
                                    value="{{ $dateEnd }}" required>
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
                    <div class="col-xs-12 col-sm-3">
                        <div class="form-group ">
                            <label class="control-label">Trạng thái:</label>
                            <select name="statusTable" id="" class="form-control">
                                @if($status == '0')
                                    <option value="0">Hoàn thành</option>
                                    <option value="1">Chưa xử lý</option>
                                    <option value="2">Tất cả</option>
                                @endif
                                @if($status == '1')
                                    <option value="1">Chưa xử lý</option>
                                    <option value="0">Hoàn thành</option>
                                    <option value="2">Tất cả</option>
                                @endif
                                @if($status == '2')
                                    <option value="2">Tất cả</option>
                                    <option value="0">Hoàn thành</option>
                                    <option value="1">Chưa xử lý</option>
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 text-center">
                        <a href="{{ route('report.table') }}" class="btn btn-default">Trở về</a>
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
                    Ngày lập báo cáo : {{ $dateCreate }}
                </div>
                <div class="col-sm-4">
                </div>
                <div class="col-sm-3 text-right">
                    <a href="{{ route('report.exporttable',['dateStart' => $dateStart,'dateEnd' => $dateEnd,'status' => $status]) }}" class="btn btn-sm btn-default" type="button">
                        <i class="fa fa-file-excel-o" aria-hidden="true"></i> Xuất Excel
                    </a>
                </div>
            </div>
            <hr>
            <div>
                <table class="table table-responsive">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Khu vực</th>
                            <th>Bàn</th>
                            <th>Những món đã gọi</th>
                            <th>Thời gian vào</th>
                            <th>Thời gian ra</th>
                            <th>Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($results as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item->table->getArea->name }}</td>
                                <td>{{ $item->table->name }}</td>
                                <td>
                                    @foreach($item->orderDetail as $detail)
                                        {{ $detail->dish->stt == '1' ? $detail->dish->name : $detail->dish->name . ' (ngưng phục vụ)' }}
                                        {{ count($item->orderDetail) > 1 ? ',' : '' }}
                                    @endforeach
                                </td>
                                <td>{{ $item->created_at }}</td>
                                <td>{{ $item->updated_at }}</td>
                                <td>
                                    @switch($item->status)
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
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
