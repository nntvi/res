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
                        <label for="cname" class="control-label col-lg-2">Chọn </label>
                        <div class="col-lg-9">
                            <select class="form-control" id="timeReport">
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
                <div class="col-xs-12 col-sm-3">
                    <div class="form-group ">
                        <label for="cname" class="control-label col-lg-2">Từ:</label>
                        <div class="col-lg-10">
                            <input class="date form-control" name="dateStart" id="dateStart" disabled>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-3">
                    <div class="form-group ">
                        <label for="cname" class="control-label col-lg-2">Đến:</label>
                        <div class="col-lg-10">
                            <input class="date form-control" name="dateEnd" id="dateEnd" disabled>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-2">
                    <div class="form-group">
                        <button class="btn btn-success" style="width:100%" id="btnOverview">
                            Tìm kiếm
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="space"></div>
        <div class="space"></div>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="dashboard-stat green-haze item-dashboard" style="margin-bottom: 5px;">
                    <div class="visual icon">
                        <i class="fa fa-shopping-cart"></i>
                    </div>
                    <div class="absolute">
                        <div class="title">
                            <h4>Doanh thu</h4>
                        </div>
                        <div class="total-number">
                            <span id="revenue">0</span>
                        </div>
                        <div class="des">
                            <div class="row-item">
                                <span class="left">Đã thanh toán</span>
                                <span class="right paidBill">0</span>
                            </div>
                            <div class="row-item">
                                <span class=" left">Đang phục vụ</span>
                                <span class="right servingBill"> 0 </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="dashboard-stat red-intense item-dashboard" style="margin-bottom: 5px;">
                    <div class="visual icon">
                        <i class="fa fa-comments"></i>
                    </div>
                    <div class="absolute">
                        <div class="title">
                            <h4>Tổng hóa đơn</h4>
                        </div>
                        <div class="total-number">
                            <span id="bill">0</span>
                        </div>
                        <div class="des">
                            <div class="row-item">
                                <span class="left">Đã thanh toán</span>
                                <span class="right paidBill">0</span>
                            </div>
                            <div class="row-item">
                                <span class=" left">Đang phục vụ</span>
                                <span class="right servingBill"> 0 </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
<div class="space"></div>
<div class="chart_agile">
    <div class="col-md-6 chart_agile_left">
        <div class="chart_agile_top">
            <div class="chart_agile_bottom">
                <h3 class="hdg">Doanh thu theo từng tháng</h3>
                <div id="graph11" style="position: relative; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);">

                </div>
                <script>
                    Morris.Line({
                        element: 'graph11',
                        data: @json($allRevenue),
                        xkey: 'month',
                        ykeys: ['value'],
                        labels: ['Doanh thu'],
                        units: ' đ',
                        lineColors: ['deeppink'],
                    });

                </script>

            </div>
        </div>
    </div>
    <div class="col-md-6 floatcharts_w3layouts_left">
        <div class="floatcharts_w3layouts_top">
            <div class="floatcharts_w3layouts_bottom">
                <h3 class="hdg">Số lượng khách theo giờ</h3>
                <div id="graph7" style="position: relative; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);">

                </div>
                <script>
                    // This crosses a DST boundary in the UK.
                    Morris.Area({
                        element: 'graph7',
                        data: @json($qtyCustomer),
                        xkey: 'timeStart',
                        ykeys: ['value'],
                        lineColors: ['skyblue'],
                    });

                </script>

            </div>
        </div>
    </div>
</div>

@endsection
