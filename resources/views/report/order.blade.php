@extends('layouts')
@section('headerreport')
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading" style="margin-bottom: 30px;">
            <i class="fa fa-home"></i> Báo cáo theo đơn hàng
        </div>
        <div class="panel-body">
            <form action="{{ route('report.p_order') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-xs-12 col-sm-4">
                        <div class="form-group ">
                            <label for="cname" class="control-label col-lg-3">Báo cáo theo</label>
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
                    <div class="col-xs-12 col-sm-4">
                        <div class="form-group ">
                            <label for="cname" class="control-label col-lg-3">Từ ngày:</label>
                            <div class="col-lg-9">
                                <input class="date form-control" name="dateStart" type="text" id="dateStart" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4">
                        <div class="form-group ">
                            <label for="cname" class="control-label col-lg-3">Đến ngày:</label>
                            <div class="col-lg-9">
                                <input class="date form-control" name="dateEnd" type="text" id="dateEnd" required>
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
                            <th>Nhân viên</th>
                            <th>Ca</th>
                            <th>Thời gian thanh toán</th>
                            <th>Tổng tiền</th>
                            <th>Tiền khách đưa</th>
                            <th>Tiền thừa</th>
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