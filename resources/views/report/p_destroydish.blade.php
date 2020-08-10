@extends('layouts')
@section('content')
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="fa fa-home"></i> Báo cáo những món đã hủy
        </div>
        <div class="panel-body">
            <form action="{{ route('report.p_dish') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-xs-12 col-sm-3">
                        <div class="form-group">
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
                    <div class="col-xs-12 col-sm-3">
                        <div class="form-group ">
                            <label class="control-label">Từ:</label>
                                <input class="date form-control" name="dateStart" value="{{ $dateStart }}" type="text" id="dateStart" required>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-3">
                        <div class="form-group ">
                            <label class="control-label">Đến:</label>
                                <input class="date form-control" name="dateEnd" value="{{ $dateEnd }}" type="text" id="dateEnd" required>
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
                            @if($groupMenuChoosen == null)
                                        <select name="groupMenu" class="form-control">
                                            <option value="0">Tất cả</option>
                                            @foreach($listGroupMenu as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    @else
                                        <select name="groupMenu" class="form-control">
                                            <option value="{{ $groupMenuChoosen->id }}">
                                                {{ $groupMenuChoosen->name }}</option>
                                            @foreach($listGroupMenuExcept as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                            <option value="0">Tất cả</option>
                                        </select>
                                    @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 text-center">
                        <a href="{{ route('report.destroydish') }}" class="btn btn-default">Trở về</a>
                        <button type="submit" class="btn green-meadow radius">Tìm kiếm</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading" style="margin-bottom: 15px;">
                Kết quả
            </div>

            <div>
                <table id="example" class="table">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Mã món ăn</th>
                            <th>Tên món</th>
                            <th>Nhóm thực đơn</th>
                            <th>Thuộc bếp</th>
                            <th>Đơn vị</th>
                            <th>Số lượng</th>
                            <th>Lý do hủy</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($results as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item['code'] }}</td>
                                <td>{{ $item['name'] }}</td>
                                <td>{{ $item['groupmenu'] }}</td>
                                <td>{{ $item['cook'] }}</td>
                                <td>{{ $item['unit'] }}</td>
                                <td>{{ $item['qty'] }}</td>
                                <td>{{ $item['status'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script type="text/javascript" language="javascript" src="{{ asset('js/data.table.js') }}"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>    <script>
        $(document).ready( function () {
            $('#example').dataTable();
            $('#example_info').addClass('text-muted');
            $('input[type="search"]').addClass('form-control');
            $('#example_length').html(
                `<a href="{{ route('report.exportdestroydish',['dateStart' => $dateStart,'dateEnd' => $dateEnd,'idGroupMenu' => $idGroupMenu]) }}"
                        class="btn btn-sm btn-default" type="button">
                        <i class="fa fa-file-excel-o" aria-hidden="true"></i> Xuất Excel
                </a>`
            );
        } );
    </script>
</div>
@endsection
