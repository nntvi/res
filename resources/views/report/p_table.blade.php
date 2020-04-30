@extends('layouts')
@section('headerreport')
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading" style="margin-bottom: 30px;">
            <i class="fa fa-home"></i> Báo cáo bán hàng chi tiết
        </div>
        <div class="panel-body">
            <form action="{{ route('report.p_table') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-xs-12 col-sm-3">
                        <div class="form-group ">
                            <label for="cname" class="control-label col-lg-3"> Chọn: </label>
                            <div class="col-lg-9">
                                <select class="form-control m-bot15" id="timeReport">
                                    <option value="1">Theo ngày</option>
                                    <option value="2">Theo tuần</option>
                                    <option value="3">Theo tháng</option>
                                    <option value="4">Theo năm</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-3">
                        <div class="form-group ">
                            <label for="cname" class="control-label col-lg-2">Từ:</label>
                            <div class="col-lg-10">
                                <input class="date form-control" name="dateStart" type="text" id="dateStart"
                                    value="{{ $dateStart }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-3">
                        <div class="form-group ">
                            <label for="cname" class="control-label col-lg-2">Đến:</label>
                            <div class="col-lg-10">
                                <input class="date form-control" name="dateEnd" type="text" id="dateEnd"
                                    value="{{ $dateEnd }}" required>
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
                    <div class="col-xs-12 col-sm-3">
                        <div class="form-group ">
                            <select name="" id="" class="form-control">
                                @if($status == '0')
                                    <option value="0">Hoàn thành</option>
                                    <option value="1">Chưa xử lý</option>
                                @else
                                    <option value="1">Chưa xử lý</option>
                                    <option value="0">Hoàn thành</option>
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 text-center">
                        <div class="space"></div>
                        <div class="space"></div>
                        <button type="submit" class="btn green-meadow radius">Tìm kiếm</button>
                        <div class="space"></div>
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
                    <a href="{{ route('report.exporttable',['dateStart' => $dateStart,'dateEnd' => $dateEnd, 'status' => $status]) }}" class="btn btn-sm btn-danger" type="button">
                        <i class="fa fa-print" aria-hidden="true"></i> Xuất Excel
                    </a>
                </div>
            </div>
            <hr>
            <div>
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
                                        {{ $detail->dish->name }}
                                        {{ count($item->orderDetail) > 1 ? ',' : '' }}
                                    @endforeach
                                </td>
                                <td>{{ $item->created_at }}</td>
                                <td>{{ $item->updated_at }}</td>
                                <td>
                                    {{ $item->status == '0' ? 'Đã thanh toán' : 'Chưa thanh toán' }}
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
