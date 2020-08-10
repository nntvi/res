@extends('layouts')
@section('content')
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="fa fa-home"></i> Báo cáo theo món ăn
        </div>
        <div class="panel-body">
            <form action="{{ route('report.p_dish') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-xs-12 col-sm-3">
                        <div class="form-group ">
                            <label class="control-label">Báo cáo theo: </label>
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
                            <label class="control-label">Từ:</label>
                                <input class="date form-control" name="dateStart" type="text" id="dateStart" required>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-3">
                        <div class="form-group ">
                            <label class="control-label">Đến:</label>
                                <input class="date form-control" name="dateEnd" type="text" id="dateEnd" required>
                        </div>
                        <script type="text/javascript">
                            $('.date').datepicker({
                                format: 'yyyy-mm-dd'
                            });

                            function validateForm() {
                                var dateStart = document.getElementById('dateStart').value;
                                var dateEnd = document.getElementById('dateEnd').value;

                                if(dateStart > dateEnd){
                                    alert("Ngày bắt đầu không nhỏ hơn ngày kết thúc");
                                    return false;
                                }
                                return true;
                            }

                        </script>
                    </div>
                    <div class="col-xs-12 col-sm-3">
                        <div class="form-group ">
                            <label class="control-label"> Nhóm thực đơn: </label>
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
                                    <th>Mã món ăn</th>
                                    <th>Tên món</th>
                                    <th>Nhóm thực đơn</th>
                                    <th>Đơn vị</th>
                                    <th>Số lượng</th>
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
