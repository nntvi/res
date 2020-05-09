@extends('layouts')
@section('content')
<div class="chart_agile">
    <div class="col-md-6 chart_agile_left">
        <div class="chart_agile_top">
            <div class="chart_agile_bottom">
                <div class="panel-heading" style="margin-bottom: 6px">
                    Thời gian
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" action="" method="post">
                        @csrf
                        <div class="form-group">
                            <label class="col-lg-2 col-sm-2 control-label">Chọn: </label>
                            <div class="col-lg-10">
                                <select class="form-control m-bot15" id="timeReport">
                                    <option value="1">Theo ngày</option>
                                    <option value="2">Theo tuần</option>
                                    <option value="3">Theo tháng</option>
                                    <option value="4">Theo năm</option>
                                </select>
                            </div>
                        </div>
                        <div class="space"></div>
                        <div class="form-group">
                            <label class="col-lg-2 col-sm-2 control-label">Từ: </label>
                            <div class="col-lg-10">
                                <input class="date form-control" name="dateStart" type="text" id="dateStart"
                                    value="{{ $dateStart }}" required>
                            </div>
                        </div>
                        <div class="space"></div>
                        <div class="form-group">
                            <label class="col-lg-2 col-sm-2 control-label">Đến: </label>
                            <div class="col-lg-10">
                                <input class="date form-control" name="dateEnd" type="text" id="dateEnd"
                                    value="{{ $dateEnd }}" required>
                            </div>
                        </div>
                        <div class="space"></div>
                        <div class="form-group">
                            <label class="col-lg-2 col-sm-2 control-label">Tất cả: </label>
                            <div class="col-lg-10">
                                <select name="groupMenu" class="form-control">
                                    <option value="0">Tất cả</option>
                                    @foreach($listGroupMenu as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-12 text-center">
                                <button type="submit" class="btn green-meadow radius">Tìm kiếm</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <div class="col-md-6 chart_agile_right">
        <div class="chart_agile_top">
            <div class="chart_agile_bottom">
                <h3 class="hdg">Best Seller trong thời gian vừa nhập</h3>
                <div id="graph6" style="position: relative; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);">
                    <script>
                        Morris.Bar({
                            element: 'graph6',
                            data: @json($dataChart),
                            xkey: 'nameDish',
                            ykeys: ['qty'],
                            labels: ['qty'],
                            units: ' đvt',
                            barColors: function (row, series, type) {
                                if (type === 'bar') {
                                    var red = Math.ceil(255 * row.y / this.ymax);
                                    return 'rgb(' + red + ',0,0)';
                                } else {
                                    return '#000';
                                }
                            }
                        });

                    </script>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="clearfix"></div>
</div>

<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            Danh sách
        </div>
        <div class="row w3-res-tb">
            <div class="col-sm-5 bold">
                Ngày lập : {{ $dateCreate }}
            </div>
            <div class="col-sm-4">
            </div>
            <div class="col-sm-3 text-right">
                <a href="{{ route('report.exportdish',['dateStart' => $dateStart,'dateEnd' => $dateEnd,'idGroupMenu' => $idGroupMenu ]) }}"
                    class="btn btn-sm btn-danger" type="button">
                    <i class="fa fa-print" aria-hidden="true"></i> Xuất Excel
                </a>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped b-t b-light">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Mã món ăn</th>
                        <th>Nhóm thực đơn</th>
                        <th>Tên món</th>
                        <th>Đơn vị tính</th>
                        <th>Số lượng</th>
                        <th>Giá vốn</th>
                        <th>Giá bán</th>
                        <th>Lợi nhuận</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($results as $key => $item)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $item->dish->code }}</td>
                            <td>{{ $item->dish->groupMenu->name }}</td>
                            <td>{{ $item->dish->name }}</td>
                            <td>{{ $item->dish->unit->name }}</td>
                            <td class="text-center">{{ $item->sumQty }}</td>
                            <td>{{ number_format($item->dish->capital_price) . ' đ' }}
                            </td>
                            <td>{{ number_format($item->dish->sale_price) . ' đ' }}
                            </td>
                            <td>{{ number_format((($item->dish->sale_price) - ($item->dish->capital_price)) * $item->sumQty) . ' đ' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
