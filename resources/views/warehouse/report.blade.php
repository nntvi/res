@extends('layouts')
@section('content')
<style>
    input[type=search] {
        margin-bottom: 20px;
    }
</style>
<div class="form-w3layouts">
    <h2 class="w3ls_head">Báo cáo Kho</h2>
    <!-- page start-->
        <div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading" style="text-align:left">
                            <i class="fa fa-home"></i> Tổng quan
                        </header>
                        <div class="panel-body">
                            <div class="space"></div>
                            <form action="{{route('reportwarehouse.p_report') }}" method="post">
                                    @csrf
                                    <div class="row">
                                            <div class="col-xs-12 col-sm-4">
                                                <div class="form-group ">
                                                    <a data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                                                        <label class="control-label" style="cursor:pointer; color: black;">
                                                            Chọn &nbsp;<i class="fa fa-angle-down" aria-hidden="true"></i> </label>
                                                        </label>
                                                    </a>
                                                    <div class="collapse" id="collapseExample">
                                                        <select class="form-control m-bot15" id="timeReport">
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
                                            </div>
                                            <div class="col-xs-12 col-sm-4">
                                                <div class="form-group ">
                                                    <label class="control-label">Từ ngày:</label>
                                                    <input class="date form-control" name="dateStart" type="text" id="dateStart">
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-4">
                                                <div class="form-group ">
                                                    <label class="control-label">Đến ngày:</label>
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
                                        </div>
                                <div class="space"></div>
                                <div class="row">
                                    <div class="col-xs-12 text-center">
                                        <a href="{{ route('warehouse.index') }}" class="btn btn-default">Trở về</a>
                                        <button type="submit" id="submitReport" class="btn green-meadow radius">Tìm kiếm</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <header class="panel-heading" style="text-align:left; margin-bottom: 15px;">
                                <i class="fa fa-edit"></i> Báo cáo
                        </header>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="example">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Tên NVL</th>
                                        <th>Nhóm thực đơn</th>
                                        <th>Đơn vị tính</th>
                                        <th>Tồn đầu kỳ</th>
                                        <th>SL nhập</th>
                                        <th>SL xuất</th>
                                        <th>Tồn cuối kỳ</th>
                                        <th>Xem chi tiết</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($arrayReport as $key => $item)
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td>{{ $item['name'] }}</td>
                                            <td>{{ $item['nameType'] }}</td>
                                            <td>{{ $item['unit'] }}</td>
                                            <td>{{ $item['tondauky'] }}</td>
                                            <td>{{ $item['import'] }}</td>
                                            <td>{{ $item['export'] }}</td>
                                            <td>{{ $item['toncuoiky'] }}</td>
                                            <td>
                                                @if ($item['import'] == 0 && $item['export'] == 0 )

                                                @else
                                                    <a href="{{ route('reportwarehouse.detail',['id'=> $item['idMaterialDetail'],'dateStart'=> $dateStart,'dateEnd'=>$dateEnd]) }}" class="btn default btn-xs red radius">
                                                        <i class="fa fa-eya"> Xem chi tiết</i>
                                                @endif

                                        </a></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                    </section>

            </div>
        </div>
        <script type="text/javascript" language="javascript" src="{{ asset('js/data.table.js') }}"></script>
        <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
        <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>    <script>
            $(document).ready( function () {
                $('#example').dataTable();
                $('#example_info').addClass('text-muted');
                $('input[type="search"]').addClass('form-control');
                $('#example_length').html(`<a href="{{ route('warehouse.exportexcel',['dateStart' => $dateStart,'dateEnd' => $dateEnd]) }}"
                    class="btn btn-sm btn-default" type="button">
                    <i class="fa fa-print" aria-hidden="true"></i> Xuất Excel
                </a>`);
            } );
        </script>


    <!-- page end-->
</div>
@endsection
