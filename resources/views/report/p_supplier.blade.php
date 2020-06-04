@extends('layouts')
@section('content')
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="fa fa-home"></i> Báo cáo thu chi NCC
        </div>
        <div class="panel-body">
            <form action="{{ route('report.p_supplier') }}" method="post">
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
                                <option value="6">Quý này</option>
                                <option value="7">Quý trước</option>
                                <option value="8">Năm nay</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-3">
                        <div class="form-group ">
                            <label class="control-label">Từ:</label>
                            <input class="date form-control" name="dateStart" value="{{ $dateStart }}" id="dateStart"
                                required>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-3">
                        <div class="form-group ">
                            <label class="control-label">Đến:</label>
                            <input class="date form-control" name="dateEnd" value="{{ $dateEnd }}" id="dateEnd"
                                required>
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
                    <div class="col-xs-12 col-sm-3">
                        <div class="form-group ">
                            <label class="control-label">Nhà cung cấp: </label>
                            <select name="idSupplier" class="form-control">
                                @if($idSupplier == '0')
                                    <option value="0">Tất cả</option>
                                    @foreach($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                    @endforeach
                                @else
                                    <option value="{{ $idSupplier }}">{{ $nameSupplierChoosen }}</option>
                                    @foreach($listSupplier as $supplier)
                                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                    @endforeach
                                @endif

                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 text-center">
                        <div class="space"></div>
                        <a href="{{ route('report.supplier') }}" class="btn btn-default">Trở về</a>
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
                    <h5 class="hdg text-center">Số tiền nợ/trả với tất cả NCC từ {{ $dateStart }} - {{ $dateEnd }}</h5>
                    <div id="supplier" style="position: relative; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);">
                        <div class="morris-hover morris-default-style" style="left: 312.508px; top: 137px;">

                        </div>
                    </div>
                    <script>
                        Morris.Bar({
                            element: 'supplier',
                            data: @json($dataChart),
                            xkey: 'name',
                            ykeys: ['total', 'paid','unpaid'],
                            labels: ['Tổng tiền', 'Đã trả','Nợ'],
                            units: ' đ'
                        });

                    </script>
                </div>
                <div class="col-sm-3"></div>
            </div>
            <script>
                $('.panel1 ._tools .fa').parents(".panel1").children(".panel-body1").slideUp(200);

            </script>
        </section>
        <div class="panel panel-default">
            <div class="panel-heading">
                Kết quả
            </div>
            <div class="row w3-res-tb" style="padding: 15px">
                <div class="col-sm-5 bold">
                    @if ($idSupplier == '0')
                        NCC: Tất cả - Từ: {{ $dateStart }} - Đến: {{ $dateEnd }}
                    @else
                        NCC: {{ $supplier->name }} - Từ: {{ $dateStart }} - Đến: {{ $dateEnd }}
                    @endif
                </div>
                <div class="col-sm-4">
                </div>
                <div class="col-sm-3 text-right">
                    <a href="{{ route('report.exportsupplier',['dateStart' => $dateStart,'dateEnd' => $dateEnd, 'idSupplier' => $idSupplier]) }}"
                        class="btn btn-sm btn-default" type="button">
                        <i class="fa fa-file-excel-o" aria-hidden="true"></i> Xuất Excel
                    </a>
                </div>
            </div>
            <div>
                <table class="table table-responsive">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Mã phiếu nhập</th>
                            <th>Người tạo</th>
                            <th>Tên Nhà Cung cấp</th>
                            <th>Trạng thái</th>
                            <th>Tổng tiền</th>
                            <th>Đã trả</th>
                            <th>Nợ</th>
                            <th class="text-center">Ngày nhập hàng</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($results as $key => $result)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $result->code }}</td>
                                <td>{{ $result->created_by }}</td>
                                <td>{{ $result->supplier->name }}</td>
                                @switch($result->status)
                                    @case('0')
                                        <td style="color: red">Chưa thanh toán</td>
                                        @break
                                    @case('1')
                                        <td style="color: purple">Còn nợ</td>
                                        @break
                                    @default
                                        <td>Đã thanh toán</td>
                                        @break
                                @endswitch
                                <td>{{ number_format($result->total) . ' đ' }}</td>
                                <td>{{ number_format($result->paid) . ' đ' }}</td>
                                <td>{{ number_format($result->total - $result->paid) . ' đ' }}</td>
                                <td class="text-right">{{ $result->created_at }}</td>
                            </tr>
                        @endforeach
                        <tr class="bold">
                            <td colspan="5" class="text-right">TỔNG: </td>
                            <td>{{ number_format($footerTotalSupplier[0]['total']) . ' đ' }}
                            </td>
                            <td>{{ number_format($footerTotalSupplier[0]['paid']) . ' đ' }}
                            </td>
                            <td>{{ number_format($footerTotalSupplier[0]['unPaid']) . ' đ' }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
