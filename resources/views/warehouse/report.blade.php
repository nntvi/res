@extends('layouts')
@section('content')
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
                                                            <input class="date form-control" name="dateStart" type="text" id="dateStart" value="{{ $dateStart }}">
                                                        </div>
                                                </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-4">
                                                <div class="form-group ">
                                                        <label for="cname" class="control-label col-lg-3">Đến ngày:</label>
                                                        <div class="col-lg-9">
                                                            <input class="date form-control" name="dateEnd" type="text" id="dateEnd" value="{{ $dateEnd }}">
                                                        </div>
                                                    </div>
                                                    <script type="text/javascript">
                                                        $('.date').datepicker({
                                                        format: 'yyyy-mm-dd'
                                                        });
                                                    </script>
                                        </div>

                                </div>
                                <div class="space"></div>
                                <div class="space"></div>
                                <div class="row">
                                    <div class="col-xs-12 text-center">
                                        <button type="submit" id="submitReport" class="btn green-meadow radius">Tìm kiếm</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <header class="panel-heading" style="text-align:left">
                                <i class="fa fa-edit"></i> Báo cáo
                        </header>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Tên NVL</th>
                                        <th>Thuộc nhóm</th>
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
                                            <td><a href="{{ route('reportwarehouse.detail',['id'=> $item['idMaterialDetail'],'dateStart'=> $dateStart,'dateEnd'=>$dateEnd]) }}" class="btn default btn-xs red radius">
                                                <i class="fa fa-eya"> Xem chi tiết</i>
                                        </a></td>
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
