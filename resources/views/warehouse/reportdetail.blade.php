@extends('layouts')
@section('content')
<div class="form-w3layouts">
    <h2 class="w3ls_head">Báo cáo chi tiết</h2>
    <!-- page start-->
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading" style="text-align:left">
                    <i class="fa fa-home"></i> Thời gian
                </header>
                <div class="panel-body">
                    <div class="space"></div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-4">
                            <div class="form-group ">
                                <label for="cname" class="control-label col-lg-3">Từ:</label>
                                <div class="col-lg-9">
                                    <input class="date form-control" name="dateStart" type="text" id="dateStart"
                                        value="{{ $dateStart }}" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-4">
                            <div class="form-group ">
                                <label for="cname" class="control-label col-lg-3">Đến:</label>
                                <div class="col-lg-9">
                                    <input class="date form-control" name="dateEnd" type="text" id="dateEnd"
                                        value="{{ $dateEnd }}" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-4">
                            <form action="{{ route('reportwarehouse.p_report') }}" method="post">
                                @csrf
                                <input type="hidden" name="dateStart" value="{{ $dateStart }}">
                                <input type="hidden" name="dateEnd" value="{{ $dateEnd }}">
                                <button type="submit" class="btn btn-default">Trở về</button>
                            </form>
                        </div>
                    </div>
                    <div class="space"></div>
                </div>
                <header class="panel-heading" style="text-align:left">
                    <i class="fa fa-edit"></i> Báo cáo
                </header>
                <div class="row">
                    <div class="col-md-12" style="margin-top: 15px; margin-bottom: 15px;">
                        <div class="col-md-2 bold">
                            Tên NVL : <span class=""> {{ $warehouse->detailMaterial->status == '1' ? $warehouse->detailMaterial->name : $warehouse->detailMaterial->name . ' (đã xóa)' }}
                            </span>
                        </div>
                        <div class="col-md-2 bold">
                            Tồn cuối kỳ : <span class=""> {{ $warehouse->qty }}<span>
                                </span></span></div>
                        <div class="col-md-2 bold">
                            Tồn đầu kỳ : <span class=""> {{ $tondauky }} </span>
                        </div>
                        <div class="col-md-2 bold">
                            Nhập kho : <span class="">
                                @if($detailImportById != null)
                                    {{ $detailImportById->total }}
                                @else
                                    0.00
                                @endif
                            </span>
                        </div>
                        <div class="col-md-2 bold">
                            Xuất kho : <span class="">
                                @if($detailExportById != null)
                                    {{ $detailExportById->total }}
                                @else
                                    0.00
                                @endif
                            </span>
                        </div>
                        <div class="col-md-2 bold">
                            Đơn vị : <span>{{ $warehouse->unit->name }}</span>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <table class="table table-bordered table-hover table-resposive">
                            <thead>
                                <tr>
                                    <th width="5%">STT</th>
                                    <th width="15%">Mã phiếu</th>
                                    <th width="10%">Đối tượng</th>
                                    <th>Loại phiếu</th>
                                    <th width="10%">Ngày tạo</th>
                                    <th width="10%">Chi tiết kho</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $temp = 1 @endphp
                                @foreach ($data as $key => $item)
                                    @if (!empty($item->id_supplier))
                                        <tr class="extrarow">
                                            <td style="padding:10px" class="extrarow" colspan="8">
                                                <table>
                                                    <tbody>
                                                        <tr style="padding-left: 5px; font-size: 1.5em; color: black">
                                                            <th style="padding-left:5px; width:400px;">
                                                                {{ $item->created_at }}</th>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>{{ $temp }}</td>
                                            <td>{{ $item->code }}</td>
                                            <td>{{ $item->supplier->name }}</td>
                                            <td>Phiếu nhập hàng</td>
                                            <td>{{ $item->created_at }}</td>
                                            <td>
                                                <a href="#myModal{{ $item->code }}" data-toggle="modal" class="btn default btn-xs yellow-crusta radius">
                                                    <i class="fa fa-eye"></i> Xem
                                                </a>
                                                <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal{{ $item->code }}" class="modal fade" style="display: none;">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                                                    <h4 class="modal-title">Phiếu Nhập <b>"{{ $item->code }}"</b></h4>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="row">
                                                                        <div class="col-xs-6 bold">
                                                                            Mã phiếu: {{ $item->code }}
                                                                        </div>
                                                                        <div class="col-xs-6 bold">
                                                                            Ngày tạo: {{ $item->created_at }}
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-xs-6 bold">
                                                                            Người tạo: {{ $item->created_by }} <br>
                                                                            Tổng tiền: {{ number_format($item->total) . ' đ'}}
                                                                        </div>
                                                                        <div class="col-xs-6 bold">
                                                                            NCC: {{ $item->supplier->name }}
                                                                        </div>
                                                                    </div>
                                                                    <div class="space"></div>
                                                                    <div class="row">
                                                                        <div class="col-xs-12">
                                                                            <table class="table table-bordered" id="tblDetail{{ $item->id }}">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th>STT</th>
                                                                                        <th>Tên Nguyên Vật Liệu</th>
                                                                                        <th>Số lượng</th>
                                                                                        <th>Số tiền</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    @foreach ($item->detailImportCoupon as $stt => $value)
                                                                                        <tr>
                                                                                            <td>{{ $stt + 1 }}</td>
                                                                                            <td>{{ $value->materialDetail->name }}</td>
                                                                                            <td>{{ $value->qty }}</td>
                                                                                            <td>{{ number_format($value->price) . ' đ' }}</td>
                                                                                        </tr>
                                                                                    @endforeach
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @else
                                        <tr class="extrarow">
                                            <td style="padding:10px" class="extrarow" colspan="8">
                                                <table>
                                                    <tbody>
                                                        <tr style="padding-left: 5px; font-size: 1.5em; color: black">
                                                            <th style="padding-left:5px; width:400px;">
                                                                {{ $item->created_at }}</th>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>{{ $temp }}</td>
                                            <td>{{ $item->code }}</td>
                                            <td>
                                                @foreach ($item->detailExportCoupon as $value)
                                                    {{ $value->name_object }}
                                                    @break
                                                @endforeach
                                            </td>
                                            <td>{{ $item->typeExport->name }}</td>
                                            <td>{{ $item->created_at }}</td>
                                            <td>
                                                <a href="#myModal{{ $item->code }}" data-toggle="modal" class="btn default btn-xs yellow-crusta radius">
                                                    <i class="fa fa-eye"></i> Xem
                                                </a>
                                                <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal{{ $item->code }}" class="modal fade" style="display: none;">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                                                    <h4 class="modal-title">Phiếu {{ $item->typeExport->name }}  <b>"{{ $item->code }}"</b></h4>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="row">
                                                                        <div class="col-xs-6 bold">
                                                                            Mã phiếu: {{ $item->code }}
                                                                        </div>
                                                                        <div class="col-xs-6 bold">
                                                                            Ngày tạo: {{ $item->created_at }}
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-xs-6 bold">
                                                                            Người tạo: {{ $item->created_by }}
                                                                        </div>
                                                                        <div class="col-xs-6 bold">
                                                                            Đối tượng:
                                                                            @foreach ($item->detailExportCoupon as $value)
                                                                                {{ $value->name_object }}
                                                                                @break
                                                                            @endforeach
                                                                        </div>
                                                                    </div>
                                                                    <div class="space"></div>
                                                                    <div class="row">
                                                                        <div class="col-xs-12">
                                                                            <table class="table table-bordered" id="tblDetail{{ $item->id }}">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th>STT</th>
                                                                                        <th>Tên Nguyên Vật Liệu</th>
                                                                                        <th>Số lượng</th>
                                                                                        <th>Đơn vị</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    @foreach ($item->detailExportCoupon as $stt => $value)
                                                                                        <tr>
                                                                                            <td>{{ $stt + 1 }}</td>
                                                                                            <td>{{ $value->materialDetail->name }}</td>
                                                                                            <td>{{ $value->qty }}</td>
                                                                                            <td>{{ $value->unit->name }}</td>
                                                                                        </tr>
                                                                                    @endforeach
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                    @php $temp++ @endphp
                                @endforeach
                            </tbody>
                        </table>
                        <footer class="panel-footer">
                                <div class="row">

                                    <div class="col-sm-5 text-center">
                                    <small class="text-muted inline m-t-sm m-b-sm">Hiển thị từ 1-7 mục</small>
                                    </div>
                                    <div class="col-sm-7 text-right text-center-xs">
                                    <ul class="pagination pagination-sm m-t-none m-b-none">
                                        {{ $data->links() }}
                                    </ul>
                                    </div>
                                </div>
                        </footer>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <!-- page end-->
</div>
    <script type="text/javascript" language="javascript" src="{{ asset('js/data.table.js') }}"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>
    <script>
        $(document).ready( function () {
            @foreach ($data as $item)
                $('#tblDetail{{ $item->id }}').dataTable();
                $('#tblDetail{{ $item->id }}_info').addClass('text-muted');
                $('#tblDetail{{ $item->id }}_length').hide();
                $('#tblDetail{{ $item->id }}_filter').hide();
            @endforeach
        });
    </script>
@endsection
