@extends('layouts')
<style>
    .datepicker.dropdown-menu {
        z-index: 1003;
    }

</style>
@section('content')
<div class="form-w3layouts">
    <div class="space"></div>
    <h2 class="w3ls_head">Báo cáo Bếp</h2>
    <!-- page start-->
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading" style="text-align:left">
                    <i class="fa fa-home"></i> Tổng quan
                </header>
                <div class="panel-body">
                    <div class="space"></div>
                    <form action="{{ route('warehousecook.report') }}" method="post"
                        onsubmit="return validateForm()">
                        @csrf
                        <div class="row">
                            <div class="col-xs-6 col-sm-3">
                                <div class="form-group ">
                                    <label class="control-label">Báo cáo theo</label>
                                    <select class="form-control" id="timeReport" name="timeReport">
                                        <option value="0">Hôm nay</option>
                                        <option value="1">Hôm qua</option>
                                        <option value="2">Tuần này</option>
                                        <option value="3">Tuần trước</option>
                                        <option value="4">Tháng này</option>
                                        <option value="5">Tháng trước</option>
                                        <option value="6">Quý này</option>
                                        <option value="7">Quý trước</option>
                                        <option value="8">Năm nay</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-3">
                                <div class="form-group ">
                                    <label class="control-label">Từ ngày:</label>
                                    <input class="date form-control" name="dateStart" value="{{ $dateStart }}"
                                        type="text" id="dateStart">
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-3">
                                <div class="form-group ">
                                    <label class="control-label">Đến ngày:</label>
                                    <input class="date form-control" name="dateEnd" value="{{ $dateEnd }}" type="text"
                                        id="dateEnd">
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-3">
                                <div class="form-group ">
                                    <label class="control-label">Chọn bếp:</label>
                                    <select name="cook" class="form-control">
                                        <option value="{{ $cookFind->id }}">{{ $cookFind->name }}</option>
                                        @foreach($cookDiffs as $cook)
                                            <option value="{{ $cook->id }}">{{ $cook->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
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
                        <div class="row">
                            <div class="col-xs-12 text-center">
                                <a href="{{ route('warehousecook.index') }}"
                                    class="btn btn-default">Trở về</a>
                                <button type="submit" class="btn green-meadow radius">Tìm kiếm</button>
                            </div>
                        </div>
                    </form>
                </div>
                <section class="panel1">
                    <header class="panel-heading" style="background:white;line-height: 35px">
                        Xem biểu đồ &nbsp;
                        <span class="_tools pull-center">
                            <a class="fa fa-chevron-circle-up" href="javascript:;"></a>
                        </span>
                        <br>
                    </header>
                    <div class="panel-body1 row" style="display: block;">
                        <div class="col-sm-3"></div>
                        <div class="floatcharts_w3layouts_bottom col-xs-12 col-sm-6">
                            <h5 class="hdg text-center">Biểu đồ biểu thị mức tồn của bếp</h5>
                            <div id="graph8" style="position: relative; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);">
                                <div class="morris-hover morris-default-style" style="left: 312.508px; top: 137px;">

                                </div>
                            </div>
                            <script>
                                Morris.Bar({
                                    element: 'graph8',
                                    data: @json($result),
                                    xkey: 'name_detail_material',
                                    ykeys: ['tondauky', 'toncuoiky'],
                                    labels: ['Tồn đầu kỳ', 'Tồn cuối kỳ'],
                                    });
                            </script>
                        </div>
                        <div class="col-sm-3"></div>
                    </div>
                    <script>
                        $('.panel1 ._tools .fa').parents(".panel1").children(".panel-body1").slideUp(200);

                    </script>
                </section>
                <header class="panel-heading" style="text-align:left">
                    <i class="fa fa-edit"></i> Báo cáo
                </header>
                <div class="row w3-res-tb" style="padding: 15px">
                    <div class="col-sm-5 bold">
                        {{ $cookFind->name }} - Từ: {{ $dateStart }} - Đến: {{ $dateEnd }}
                    </div>
                    <div class="col-sm-4">
                    </div>
                    <div class="col-sm-3 text-right">
                        <a href="{{ route('warehousecook.exportexcel',['cook' => $cookFind->id, 'dateStart' => $dateStart, 'dateEnd' => $dateEnd]) }}"
                            class="btn btn-sm btn-default" type="button">
                            <i class="fa fa-file-excel-o" aria-hidden="true"></i> Xuất Excel
                        </a>
                    </div>
                </div>
                <div class="table-responsive" style="border-top: 1px solid #ddd;">
                    <table class="table bg-light table-bordered">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Tên NVL</th>
                                <th>Nhóm</th>
                                <th>Tồn đầu kỳ</th>
                                <th>Tồn cuối kỳ</th>
                                <th>Đã sử dụng</th>
                                <th>Đơn vị</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($result as $item)
                                <tr>
                                    <td>{{ $item['stt'] }}</td>
                                    <td>{{ $item['name_detail_material'] }}</td>
                                    <td>{{ $item['name_type_material'] }}</td>
                                    <td>{{ $item['tondauky'] }}</td>
                                    <td>{{ $item['toncuoiky'] }}</td>
                                    <td>{{ $item['dasudung'] }}</td>
                                    <td>{{ $item['name_unit'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </section>

        </div>
    </div>



    <!-- page end-->
</div>
@endsection
