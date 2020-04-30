@extends('layouts')
@section('headerreport')
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading" style="margin-bottom: 30px;">
            <i class="fa fa-home"></i> Báo cáo theo món ăn
        </div>
        <div class="panel-body">
            <form action="{{ route('report.p_dish') }}" method="post">
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
                                <input class="date form-control" name="dateStart" type="text" id="dateStart" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-3">
                        <div class="form-group ">
                            <label for="cname" class="control-label col-lg-2">Đến:</label>
                            <div class="col-lg-10">
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
                    <div class="col-xs-12 col-sm-3">
                        <div class="form-group ">
                            <select name="groupMenu" class="form-control">
                                <option value="0">Tất cả</option>
                                @foreach ($groupMenus as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
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
                            <th>Mã món ăn</th>
                            <th>Nhóm thực đơn</th>
                            <th>Tên món</th>
                            <th>Số lượng</th>
                            <th>Đơn vị tính</th>
                            <th>Giá vốn</th>
                            <th>Giá bán</th>
                            <th>Lợi nhuận</th>
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
