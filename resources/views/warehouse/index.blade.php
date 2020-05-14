@extends('layouts')
@section('content')
<div class="form-w3layouts">
    <h2 class="w3ls_head">Kho</h2>
    <div class="row">
        <div class="box_content">
            <div class="icon-box col-md-3 col-sm-4">
                <a class="agile-icon" href="{{ route('importcoupon.import') }}">
                    <i class="fa fa-tasks"></i> Nhập kho
                </a>
            </div>
            <div class="icon-box col-md-3 col-sm-4">
                <a class="agile-icon" href="{{ route('importcoupon.index') }}">
                    <i class="fa fa-wpforms">
                    </i> Xem Phiếu Nhập
                </a>
            </div>
            <div class="icon-box col-md-3 col-sm-4">
                <a class="agile-icon" href="#myModal" data-toggle="modal">
                    <i class="fa fa-stack-overflow">
                    </i> Xuất kho
                </a>
                <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal"
                    class="modal fade" style="display: none;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                <h4 class="modal-title">Chọn loại xuất</h4>
                            </div>
                            <div class="modal-body">
                                <form role="form" action="{{ route('exportcoupon.export') }}"
                                    method="GET">
                                    @csrf
                                    <div class="row">
                                        <div class="radio">
                                            <div class="col-xs-5">
                                                <label>
                                                    <input type="radio" name="optionsRadios" id="optionsRadios1"
                                                        value="1">
                                                    Xuất Bếp
                                                </label>
                                            </div>
                                            <div class="col-xs-5">
                                                <label>
                                                    <input type="radio" name="optionsRadios" id="optionsRadios2"
                                                        value="2">
                                                    Xuất Trả hàng
                                                </label>
                                            </div>
                                            <div class="col-xs-2" style="margin-top: -10px">
                                                <button type="submit" class="btn btn-info">Chọn</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="space"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="icon-box col-md-3 col-sm-4">
                <a class="agile-icon" href="{{ route('exportcoupon.index') }}">
                    <i class="fa fa-wpforms">
                    </i> Xem Phiếu Xuất
                </a>
            </div>
            <div class="icon-box col-md-3 col-sm-4">
                <a class="agile-icon" href="{{ route('exportcoupon.destroywarehouse') }}">
                    <i class="fa fa-trash-o">
                    </i> Hủy hàng
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <section class="panel">
            <div class="panel-body">
                <div class="space"></div>
                <form action="{{ route('reportwarehouse.p_report') }}" method="post"
                    onsubmit="return validateForm()">
                    @csrf
                    <div class="row">
                        <div class="col-xs-12 col-sm-4">
                            <div class="form-group ">
                                <label for="cname" class="control-label col-lg-3">Báo cáo theo</label>
                                <div class="col-lg-9">
                                    <select class="form-control m-bot15" id="timeReport">
                                        <option value="0">Theo ngày</option>
                                        <option value="2">Theo tuần</option>
                                        <option value="4">Theo tháng</option>
                                        <option value="8">Theo năm</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-4">
                            <div class="form-group ">
                                <label for="cname" class="control-label col-lg-3">Từ ngày:</label>
                                <div class="col-lg-9">
                                    <input class="date form-control" name="dateStart" type="text" id="dateStart">
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-4">
                            <div class="form-group ">
                                <label for="cname" class="control-label col-lg-3">Đến ngày:</label>
                                <div class="col-lg-9">
                                    <input class="date form-control" name="dateEnd" type="text" id="dateEnd">
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
                        </div>
                    </div>
                    <div class="space"></div>
                    <div class="space"></div>
                    <div class="row">
                        <div class="col-xs-12 text-center">
                            <button type="submit" class="btn green-meadow radius">Tìm kiếm</button>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
    <!-- page start-->
    @foreach($types as $type)
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        {{ $type->name }}
                        <span class="tools pull-right">
                            <a class="fa fa-chevron-down" href="javascript:;"></a>
                            {{-- <a class="fa fa-cog" href="javascript:;"></a> --}}
                            {{-- <a class="fa fa-times" href="javascript:;"></a> --}}
                        </span>
                    </header>
                    <div class="panel-body">
                        <div>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Tên Nguyên Vật liệu</th>
                                        <th>Số lượng hiện có</th>
                                        <th>Mức tồn</th>
                                        <th>Đơn vị</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($type->warehouse as $key => $detail)
                                        @if($detail->limit_stock == $detail->qty)
                                            <tr style="background:palegoldenrod">
                                                <td>{{ $key+1 }}</td>
                                                <td>{{ $detail->detailMaterial->name }}</td>
                                                <td style="color:red">{{ $detail->qty }}</td>
                                                <td style="color:red">{{ $detail->limit_stock }}</td>
                                                @if($detail->unit == null)
                                                    <td>--- Hàng mới --</td>
                                                @else
                                                    <td>{{ $detail->unit->name }}</td>
                                                @endif
                                                <td>
                                                    <a href="#updateLimit{{ $detail->id }}" data-toggle="modal">
                                                        <i class="fa fa-pencil-square-o text-success text-active"></i>
                                                    </a>
                                                    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog"
                                                        tabindex="-1" id="updateLimit{{ $detail->id }}"
                                                        class="modal fade" style="display: none;">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button aria-hidden="true" data-dismiss="modal"
                                                                        class="close" type="button">×</button>
                                                                    <h4 class="modal-title">Cập nhật số lượng tồn</h4>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form role="form"
                                                                        action="{{ route('warehouse.p_updateLimitStock',['id' => $detail->id]) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        <div class="row">
                                                                            <div class="col-xs-6">
                                                                                <label>Tên
                                                                                    NVL</label>
                                                                                <input class="form-control"
                                                                                    value="{{ $detail->detailMaterial->name }}"
                                                                                    disabled>
                                                                            </div>
                                                                            <div class="col-xs-6">
                                                                                <label>Số lượng
                                                                                    hiện có</label>
                                                                                <input class="form-control"
                                                                                    value="{{ $detail->qty }}"
                                                                                    disabled>
                                                                            </div>
                                                                        </div>
                                                                        <div class="space"></div>
                                                                        <div class="row">
                                                                            <div class="col-xs-6">
                                                                                <label>Đơn
                                                                                    vị</label>
                                                                                <input class="form-control"
                                                                                    value="{{ $detail->unit->name }}"
                                                                                    disabled>

                                                                            </div>
                                                                            <div class="col-xs-6">
                                                                                <label>Mức
                                                                                    tồn</label>
                                                                                <input type="number" step="0.01"
                                                                                    min="0.00"
                                                                                    class="limit form-control"
                                                                                    name="limitStock"
                                                                                    value="{{ $detail->limit_stock }}">
                                                                            </div>
                                                                        </div>
                                                                        <div class="space"></div>
                                                                        <div class="space"></div>
                                                                        <div class="row">
                                                                            <div class="col-xs-12 text-center">
                                                                                <button type="submit"
                                                                                    class="btn btn-info">Lưu</button>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td>{{ $key+1 }}</td>
                                                <td>{{ $detail->detailMaterial->name }}</td>
                                                <td>{{ $detail->qty }}</td>
                                                <td>{{ $detail->limit_stock }}</td>
                                                @if($detail->unit == null)
                                                    <td>--- Hàng mới --</td>
                                                @else
                                                    <td>{{ $detail->unit->name }}</td>
                                                @endif
                                                <td>
                                                    <a href="#updateLimit{{ $detail->id }}" data-toggle="modal">
                                                        <i class="fa fa-pencil-square-o text-success text-active"></i>
                                                    </a>
                                                    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog"
                                                        tabindex="-1" id="updateLimit{{ $detail->id }}"
                                                        class="modal fade" style="display: none;">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button aria-hidden="true" data-dismiss="modal"
                                                                        class="close" type="button">×</button>
                                                                    <h4 class="modal-title">Cập nhật số lượng tồn</h4>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form role="form"
                                                                        action="{{ route('warehouse.p_updateLimitStock',['id' => $detail->id]) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        <div class="row">
                                                                            <div class="col-xs-6">
                                                                                <label>Tên
                                                                                    NVL</label>
                                                                                <input class="form-control"
                                                                                    value="{{ $detail->detailMaterial->name }}"
                                                                                    disabled>
                                                                            </div>
                                                                            <div class="col-xs-6">
                                                                                <label>Số lượng
                                                                                    hiện có</label>
                                                                                <input class="form-control"
                                                                                    value="{{ $detail->qty }}"
                                                                                    disabled>
                                                                            </div>
                                                                        </div>
                                                                        <div class="space"></div>
                                                                        <div class="row">
                                                                            <div class="col-xs-6">
                                                                                <label>Đơn
                                                                                    vị</label>
                                                                                <input class="form-control"
                                                                                    value="{{ $detail->unit->name }}"
                                                                                    disabled>

                                                                            </div>
                                                                            <div class="col-xs-6">
                                                                                <label>Mức
                                                                                    tồn</label>
                                                                                <input type="number" step="0.01"
                                                                                    min="0.00"
                                                                                    class="limit form-control"
                                                                                    name="limitStock"
                                                                                    value="{{ $detail->limit_stock }}">
                                                                            </div>
                                                                        </div>
                                                                        <div class="space"></div>
                                                                        <div class="space"></div>
                                                                        <div class="row">
                                                                            <div class="col-xs-12 text-center">
                                                                                <button type="submit"
                                                                                    class="btn btn-info">Lưu</button>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif

                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </section>
            </div>
        </div>
    @endforeach

    <!-- page end-->
</div>
@endsection
