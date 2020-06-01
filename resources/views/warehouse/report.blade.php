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
                                                        <label for="cname" class="control-label col-lg-3">Chọn:</label>
                                                        <div class="col-lg-9">
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
                                                        <label for="cname" class="control-label col-lg-3">Từ:</label>
                                                        <div class="col-lg-9">
                                                            <input class="date form-control" name="dateStart" type="text" id="dateStart" value="{{ $dateStart }}">
                                                        </div>
                                                </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-4">
                                                <div class="form-group ">
                                                        <label for="cname" class="control-label col-lg-3">Đến:</label>
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
                                <div class="row">
                                    <div class="col-xs-12 text-center">
                                        <a href="{{ route('warehouse.index') }}" class="btn btn-default">Trở về</a>
                                        <button type="submit" id="submitReport" class="btn green-meadow radius">Tìm kiếm</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <header class="panel-heading" style="text-align:left">
                                <i class="fa fa-edit"></i> Báo cáo
                        </header>
                        <div class="row w3-res-tb" style="padding: 15px">
                            <div class="col-sm-5 bold">
                                Ngày lập: {{ $today }}
                            </div>
                            <div class="col-sm-4">
                            </div>
                            <div class="col-sm-3 text-right">
                                <a href="{{ route('warehouse.exportexcel',['dateStart' => $dateStart,'dateEnd' => $dateEnd]) }}"
                                    class="btn btn-sm btn-default" type="button">
                                    <i class="fa fa-print" aria-hidden="true"></i> Xuất Excel
                                </a>
                            </div>
                        </div>
                        <div class="table-responsive" style="border-top: 1px solid #ddd;">
                            <table class="table table-bordered">
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



    <!-- page end-->
</div>
@endsection
