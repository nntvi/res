@extends('layouts')
<style>
    .dataTables_length{
        display: none;
    }
</style>
@section('content')
<div class="form-w3layouts">
    <h2 class="w3ls_head">Kho</h2>
    <script>
        @if(session('success'))
            toastr.success('{{ session('success') }}')
        @endif
        @if(session('info'))
            toastr.info('{{ session('info') }}')
        @endif
    </script>
    <div class="row">
        <div class="col-xs-12 text-center">
                <a href="#imp" class="btn btn-sm btn-default m-b-xs" data-toggle="modal">
                        <i class="fa fa-tasks"></i> Nhập kho
                    </a>
                <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="imp"
                        class="modal fade" style="display: none;">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                    <h4 class="modal-title">Chọn loại nhập</h4>
                                </div>
                                <div class="modal-body">
                                    <form role="form" action="{{ route('importcoupon.gettype') }}"
                                        method="GET">
                                        @csrf
                                        <div class="row">
                                            <div class="radio">
                                                <div class="col-xs-6">
                                                    <label>
                                                        <input type="radio" name="typeImp"
                                                            value="1" checked>
                                                        Nhập thường
                                                    </label>
                                                </div>
                                                <div class="col-xs-6">
                                                    <label>
                                                        <input type="radio" name="typeImp"
                                                            value="2">
                                                        Nhập theo kế hoạch
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="space"></div>
                                        <div class="row">
                                            <div class="col-xs-12 text-center">
                                                <button type="submit" class="btn btn-default">Chọn</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                </div>
                <a class="btn btn-sm btn-default m-b-xs" href="#myModal" data-toggle="modal">
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
                                    <form role="form" action="{{ route('exportcoupon.export') }}" method="GET">
                                        @csrf
                                        <div class="row">
                                            <div class="radio">
                                                <div class="col-xs-6">
                                                    <label>
                                                        <input type="radio" name="optionsRadios" id="optionsRadios1"
                                                            value="1" checked>
                                                        Xuất Bếp
                                                    </label>
                                                </div>
                                                <div class="col-xs-6">
                                                    <label>
                                                        <input type="radio" name="optionsRadios" id="optionsRadios2"
                                                            value="2">
                                                        Xuất Trả hàng
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="space"></div>
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <button type="submit" class="btn btn-default">Chọn</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                </div>
                <a class="btn btn-sm btn-default m-b-xs" href="{{ route('exportcoupon.destroywarehouse') }}">
                        <i class="fa fa-trash-o">
                        </i> Hủy kho
                </a>
        </div>
    </div>

    <div class="row">
        <section class="panel" style="margin: 1em;">
            <div class="panel-body">
                <div class="space"></div>
                <form action="{{ route('reportwarehouse.p_report') }}" method="post"
                    onsubmit="return validateForm()">
                    @csrf
                    <div class="row">
                        <div class="col-xs-12 col-sm-4">
                            <div class="form-group ">
                                <label class="control-label">Báo cáo theo</label>
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
                        <div class="col-xs-12 col-sm-4">
                            <div class="form-group ">
                                <label class="control-label">Từ ngày:</label>
                                <input class="date form-control" name="dateStart" type="text" id="dateStart" required>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-4">
                            <div class="form-group ">
                                <label class="control-label">Đến ngày:</label>
                                <input class="date form-control" name="dateEnd" type="text" id="dateEnd" required>
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

                            </script>
                        </div>
                    </div>
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
                        <span class="tools pull-right" style="padding-top: 17px">
                            <a class="fa fa-chevron-down" href="javascript:;"></a>
                        </span>
                    </header>
                    <div class="panel-body">
                        <div>
                            <table class="table" id="table{{ $type->id }}">
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
                                        @if ($detail->detailMaterial->status == '0')
                                            @continue
                                        @else
                                            @if($detail->limit_stock >= $detail->qty)
                                                <tr style="background: #fff79f;">
                                                    <td>{{ $key+1 }}</td>
                                                    <td>{{ $detail->detailMaterial->name }}</td>
                                                    <td style="color:red">{{ $detail->qty }}</td>
                                                    <td style="color:red">{{ $detail->limit_stock }}</td>
                                                    @if($detail->unit == null)
                                                        <td>--- Hàng mới --</td>
                                                    @else
                                                        <td>{{ $detail->unit->name }}</td>
                                                    @endif
                                                    <td class="text-right">
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
                                                    <td class="text-right">
                                                        <a href="#updateLimit{{ $detail->id }}" data-toggle="modal">
                                                            <i class="fa fa-pencil-square-o text-success text-active"></i>
                                                        </a>
                                                        <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog"
                                                            tabindex="-1" id="updateLimit{{ $detail->id }}"
                                                            class="modal fade" style="display: none;">
                                                            <div class="modal-dialog text-left">
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
                                                                                        class="btn btn-default">Cập nhật</button>
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
    <script type="text/javascript" language="javascript" src="{{ asset('js/data.table.js') }}"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>
    <script>
        $(document).ready( function () {
            @foreach($types as $key => $type)
                $("table[id^='table{{ $type->id }}']").dataTable();
            @endforeach
            $('#example_info').addClass('text-muted');
            $('input[type="search"]').addClass('form-control');
        });
    </script>
    <!-- page end-->
</div>
@endsection

