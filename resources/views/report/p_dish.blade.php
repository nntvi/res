@extends('layouts')
<style>
    .datepicker.dropdown-menu {
        z-index: 1003;
    }
    svg text{
        font-size: 14px!important;
        font-family: "Roboto"!important;
    }
</style>
@section('content')
<div class="form-w3layouts">
    <div class="space"></div>
    <h2 class="w3ls_head">Báo cáo Món ăn</h2>
    <!-- page start-->
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading" style="text-align:left">
                    <i class="fa fa-home"></i> Tổng quan
                </header>
                <div class="panel-body">
                    <div class="space"></div>
                    <form action="{{ route('report.p_dish') }}" method="post"
                        onsubmit="return validateForm()">
                        @csrf
                        <div class="row">
                            <div class="col-xs-6 col-sm-3">
                                <div class="form-group ">
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
                            <div class="col-xs-6 col-sm-3">
                                <div class="form-group ">
                                    <label class="control-label">Từ ngày:</label>
                                    <input class="date form-control" name="dateStart" value="{{ $dateStart }}"
                                        type="text" id="dateStart" required>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-3">
                                <div class="form-group ">
                                    <label class="control-label">Đến ngày:</label>
                                    <input class="date form-control" name="dateEnd" value="{{ $dateEnd }}" type="text"
                                        id="dateEnd" required>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-3">
                                <div class="form-group ">
                                    <label class="control-label">Nhóm thực đơn:</label>
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
                            $('div svg text').css({
                                "font-family" : "'Roboto' !important",
                                "font-size" : "13px"
                            });
                        </script>
                        <div class="row">
                            <div class="col-xs-12 text-center">
                                <a href="{{ route('report.dish') }}" class="btn btn-default">Trở
                                    về</a>
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
                        <div class="col-xs-12 col-sm-7">
                            <h3 class="hdg text-center">Lợi nhuận</h3>
                            <div id="money"></div>
                            <script>
                                // Use Morris.Bar
                                Morris.Bar({
                                    element: 'money',
                                    data: @json($results),
                                    xkey: 'name',
                                    ykeys: ['interest'],
                                    labels: ['Lợi nhuận'],
                                    units: ' đ',
                                    xLabelAngle: '70',
    parseTime: false,
    verticalGrid: false,
    resize: false,
    padding: 60,
                                    barColors: function (row, series, type) {
                                        if (type === 'bar') {
                                        var red = Math.ceil(255 * row.y / this.ymax);
                                        return 'rgb(' + red + ',0,0)';
                                        }
                                        else {
                                        return '#000';
                                        }
                                    }
                                });
                                </script>
                        </div>
                        <div class="col-xs-12 col-sm-5">
                            <h3 class="hdg">Best Seller</h3>
                            <div id="bestSeller">

                            </div>
                            <script>
                                Morris.Donut({
                                    element: 'bestSeller',
                                    data: @json($arrBestSeller),
                                    formatter: function (x) {
                                        return x + "%"
                                    }
                                });

                            </script>
                        </div>
                    </div>
                    <script>
                        $('.panel1 ._tools .fa').parents(".panel1").children(".panel-body1").slideUp(200);

                    </script>
                    <div class="space"></div>
                </section>
                <header class="panel-heading" style="text-align:left;">
                    <i class="fa fa-edit"></i> Báo cáo
                </header>
                <div class="table-responsive">
                    <table class="table table-striped b-t b-light display" id="example" >
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
                        <tbody >
                            @foreach($results as $item)
                                <tr>
                                    <td>{{ $item['stt'] }}</td>
                                    <td>{{ $item['code'] }}</td>
                                    <td>{{ $item['name'] }}</td>
                                    <td>{{ $item['group_menu'] }}</td>
                                    <td>{{ $item['unit'] }}</td>
                                    <td>{{ $item['qty'] }}</td>
                                    <td>{{ number_format($item['capital']) . ' đ' }}
                                    </td>
                                    <td>{{ number_format($item['sale']) . ' đ' }}
                                    </td>
                                    <td>{{ number_format($item['interest']) . ' đ' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="bold">
                                <td colspan="5" class="text-right">TỔNG: </td>
                                <td>{{ $footerTotal['0']['qty'] }}</td>
                                <td>{{ number_format($footerTotal[0]['totalCapital']) . ' đ' }}
                                </td>
                                <td>{{ number_format($footerTotal[0]['totalSale']) . ' đ' }}
                                </td>
                                <td>{{ number_format($footerTotal[0]['totalInterest']) . ' đ' }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>

                </div>
            </section>
        </div>
    </div>
    <!-- page end-->
    <script type="text/javascript" language="javascript" src="{{ asset('js/data.table.js') }}"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>
    <script>
        $(document).ready( function () {
            $('#example').dataTable();
            $('#example_info').addClass('text-muted');
            $('input[type="search"]').addClass('form-control');
            $('#example_length').html(
                `<a href="{{ route('report.exportdish',['dateStart' => $dateStart,'dateEnd' => $dateEnd,'idGroupMenu' => $idGroupMenu]) }}"
                        class="btn btn-sm btn-default" type="button">
                        <i class="fa fa-file-excel-o" aria-hidden="true"></i> Xuất Excel
                </a>`
            )
        } );
    </script>
</div>
@endsection
