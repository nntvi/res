@extends('layouts')
@section('content')
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading" style="margin-bottom: 15px;">
            <i class="fa fa-home"></i> Báo cáo Theo bàn
        </div>
        <div class="panel-body">
            <form action="{{ route('report.p_table') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-xs-12 col-sm-3">
                        <div class="form-group ">
                            <label for="cname" class="control-label">Báo cáo theo: </label>
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
                    <div class="col-xs-12 col-sm-3">
                        <div class="form-group ">
                            <label for="cname" class="control-label">Từ ngày:</label>
                                <input class="date form-control" name="dateStart" type="text" id="dateStart">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-3">
                        <div class="form-group ">
                            <label for="cname" class="control-label">Đến ngày:</label>
                                <input class="date form-control" name="dateEnd" type="text" id="dateEnd">
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
                            <select name="statusTable" class="form-control">
                                <option value="0">Hoàn thành</option>
                                <option value="1">Chưa xử lý</option>
                                <option value="2">Tất cả</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 text-center">
                        <button type="submit" class="btn green-meadow radius">Tìm kiếm</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                Kết quả
            </div>
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

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
