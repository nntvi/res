@extends('layouts')
@section('content')
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading" style="margin-bottom: 30px;">
            <i class="fa fa-home"></i> Tổng quan
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 col-sm-4">
                    <div class="form-group ">
                        <label class="control-label col-lg-2">Chọn </label>
                        <div class="col-lg-9">
                            <select class="form-control" id="timeReport">
                                <option value="4">Tháng này</option>
                                <option value="0">Hôm nay</option>
                                <option value="1">Hôm qua</option>
                                <option value="2">Tuần này</option>
                                <option value="3">Tuần trước</option>
                                <option value="5">Tháng trước</option>
                                <option value="6">Quý này</option>
                                <option value="7">Quý trước</option>
                                <option value="8">Năm nay</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-3">
                    <div class="form-group ">
                        <label for="cname" class="control-label col-lg-2">Từ:</label>
                        <div class="col-lg-10">
                            <input class="date form-control" name="dateStart" id="dateStart" value="{{ $firstMonth }}">
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-3">
                    <div class="form-group ">
                        <label for="cname" class="control-label col-lg-2">Đến:</label>
                        <div class="col-lg-10">
                            <input class="date form-control" name="dateEnd" id="dateEnd" value="{{ $endMonth }}">
                        </div>
                    </div>
                </div>
                <script type="text/javascript">
                    $('.date').datepicker({
                        format: 'yyyy-mm-dd'
                    });
                </script>
                <div class="col-xs-12 col-sm-2">
                    <div class="form-group">
                        <button class="btn btn-default" style="width:100%" id="btnProfit">
                            Tìm kiếm
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="dashboard-stat green-haze item-dashboard" style="margin-bottom: 5px;">
                    <div class="visual icon">
                        <i class="fa fa-money"></i>
                    </div>
                    <div class="absolute">
                        <div class="details">
                            <div class="number" id="revenue">{{ number_format($revenue) . ' đ' }}</div>
                            <div class="desc">Doanh thu</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="dashboard-stat purple-plum item-dashboard" style="margin-bottom: 5px;">
                    <div class="visual icon">
                        <i class="fa fa-credit-card-alt"></i>
                    </div>
                    <div class="absolute">
                        <div class="details">
                            <div class="number" id="expense">{{ number_format($expense) . ' đ' }}</div>
                            <div class="desc">
                                <a href="#myModal" data-toggle="modal" style="color:white">
                                    Chi phí
                                </a>
                                <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade" style="display: none;">
                                        <div class="modal-dialog text-left" style="color:black">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                                    <h4 class="modal-title" >Các chi phí trong khoảng thời gian vừa chọn</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>Tên chi phí</th>
                                                                <th class="text-center">Số tiền</th>
                                                            </tr>
                                                        </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>Vốn món ăn</td>
                                                                    <td class="text-center"><span class="von">{{ number_format($capital) . ' đ' }}</span></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Trả nhà cung cấp</td>
                                                                    <td class="text-center"><span class="pay">{{ number_format($payment) . ' đ' }}</span></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Trả lại hàng</td>
                                                                    <td class="text-center"><span class="returnpay">{{ number_format($payemer) . ' đ' }}</span></td>
                                                                </tr>
                                                            </tbody>
                                                            <tfoot>
                                                                <tr class="bold">
                                                                    <td>Tổng</td>
                                                                    <td class="text-center"><span class="tong">{{ number_format($capital + $payment - $payemer) . ' đ' }}</span></td>
                                                                </tr>
                                                            </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="dashboard-stat red-intense item-dashboard" style="margin-bottom: 5px;">
                    <div class="visual icon">
                        <i class="fa fa-usd"></i>
                    </div>
                    <div class="absolute">
                        <div class="details">
                            <div class="number" id="profit">{{ number_format($profit) . ' đ' }}</div>
                            <div class="desc">Lợi nhuận</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <section class="panel1">
            <header class="panel-heading" style="background:white;">
                Xem biểu đồ &nbsp;
                <span class="_tools pull-center">
                    <a class="fa fa-chevron-circle-down" href="javascript:;"></a>
                 </span>
            </header>
            <div class="space"></div>
            <div class="panel-body1" style="display: block;">
                <div id="area-chart" ></div>
            </div>
        </section>
        <script>
            $('.panel1 ._tools .fa').parents(".panel1").children(".panel-body1").slideDown(200);
            Morris.Bar({
                element: 'area-chart',
                data: @json($dataChart),
                xkey: 'month',
                ykeys: ['revenue', 'expense','profit'],
                labels: ['Doanh thu', 'Chi phí','Lợi nhuận'],
                fillOpacity: 0.6,
                hideHover: 'auto',
                behaveLikeLine: true,
                resize: true,
                pointFillColors:['#ffffff'],
                pointStrokeColors: ['black'],
                barColors:['green','gray','red'],
                xLabelAngle: '40',
            });
        </script>
    </div>
</div>
<div class="space"></div>
@endsection
