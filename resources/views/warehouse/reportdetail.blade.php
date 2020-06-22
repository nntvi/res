@extends('layouts')
@section('content')
<div class="form-w3layouts">
    <h2 class="w3ls_head">Báo cáo Kho</h2>
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
                    </div>
                    <div class="space"></div>
                </div>
                <header class="panel-heading" style="text-align:left">
                    <i class="fa fa-edit"></i> Báo cáo
                </header>
                <div class="row">
                    <div class="col-md-12" style="margin-top: 15px; margin-bottom: 15px;">
                        <div class="col-md-2 bold">
                            Tên NVL : <span class=""> {{ $warehouse->status == '1' ? $warehouse->detailMaterial->name : $warehouse->detailMaterial->name . ' (đã xóa)' }}
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
                            <tbody>
                                <tr>
                                    <th width="5%">STT</th>
                                    <th width="15%">Mã phiếu</th>
                                    <th width="10%">Nguồn</th>
                                    <th>Loại phiếu</th>
                                    <th width="10%">Ngày tạo</th>
                                    <th width="10%">Chi tiết kho</th>
                                </tr>
                                @if($importCoupon != null)
                                    @foreach($importCoupon as $key => $item)
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
                                            <td width="5%">{{ $key+1 }}</td>
                                            <td width="15%">{{ $item->code_import }}</td>
                                            <td width="10%">{{ $item->name }}</td>
                                            <td>Nhập mua</td>
                                            <td width="10%">{{ $item->created_at }}</td>
                                            <td width="10%">
                                                <a href="#myModal{{ $item->code }}" data-toggle="modal" class="btn default btn-xs yellow-crusta radius">
                                                    <i class="fa fa-eye"></i>Xem
                                                </a>
                                                <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog"
                                                    tabindex="-1" id="myModal{{ $item->code }}" class="modal fade"
                                                    style="display: none;">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button aria-hidden="true" data-dismiss="modal"
                                                                    class="close" type="button">×</button>
                                                                <h4 class="modal-title">Chi tiết kho</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                    @foreach($infoImports as $info)
                                                                        @if($info->code == $item->code_import)
                                                                                <div class="modal-body">
                                                                                    <div class="row">
                                                                                        <div class="col-md-12"
                                                                                            style="margin-bottom: 15px;">
                                                                                            <div class="col-md-6 bold">
                                                                                                Mã phiếu : <span> {{ $info->code }}</span>
                                                                                            </div>
                                                                                            <div class="col-md-6 bold">
                                                                                                Ngày tạo : <span> {{ $info->created_at }}</span>
                                                                                            </div>
                                                                                            <div class="col-md-6 bold">
                                                                                                Loại phiếu : <span> Nhập mua </span>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-12"
                                                                                            style="margin-bottom: 0;">
                                                                                            <div class="portlet box ">
                                                                                                <div class="portlet-body">
                                                                                                    <div class="">
                                                                                                        <div class="row">
                                                                                                            <div class="col-md-12">
                                                                                                                <table
                                                                                                                    class="table table-bordered table-hover table">
                                                                                                                    <thead>
                                                                                                                        <tr>
                                                                                                                            <th>Tên NVL</th>
                                                                                                                            <th>Số lượng</th>
                                                                                                                            <th>Số tiền</th>
                                                                                                                        </tr>
                                                                                                                    </thead>
                                                                                                                    <tbody>
                                                                                                                        @foreach ($info->detailImportCoupon as $detail)
                                                                                                                            <tr>
                                                                                                                                <td>{{ $detail->materialDetail->name }} </td>
                                                                                                                                <td>{{ $detail->qty }} {{ $detail->unit->name }} </td>
                                                                                                                                <td>{{ number_format($detail->price) . ' đ' }} </td>
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
                                                                                    </div>

                                                                                </div>
                                                                        @endif

                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                        -
                                @endif
                                @if($exportCoupon != null)
                                    @foreach($exportCoupon as $item)
                                        <tr class="extrarow">
                                            <td style="padding:10px" class="extrarow" colspan="50">
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
                                            <td width="5%">{{ $count++ }}</td>
                                            <td width="15%">{{ $item->code }}</td>
                                            <td width="10%">-</td>
                                            <td>{{ $item->name }}</td>
                                            <td width="10%">{{ $item->created_at }}</td>
                                            <td width="10%">
                                                    <a href="#myModal{{ $item->code }}" data-toggle="modal" class="btn default btn-xs yellow-crusta radius">
                                                        <i class="fa fa-eye"></i>Xem
                                                    </a>
                                                    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog"
                                                        tabindex="-1" id="myModal{{ $item->code }}" class="modal fade"
                                                        style="display: none;">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button aria-hidden="true" data-dismiss="modal"
                                                                        class="close" type="button">×</button>
                                                                    <h4 class="modal-title">Chi tiết kho</h4>
                                                                </div>
                                                                <div class="modal-body">
                                                                        @foreach($infoExports as $info)
                                                                            @if($info->code == $item->code)
                                                                                    <div class="modal-body">
                                                                                        <div class="row">
                                                                                            <div class="col-md-12"
                                                                                                style="margin-bottom: 15px;">
                                                                                                <div class="col-md-6 bold">
                                                                                                    Mã phiếu : <span> {{ $info->code }}</span>
                                                                                                </div>
                                                                                                <div class="col-md-6 bold">
                                                                                                    Ngày tạo : <span> {{ $info->created_at }}</span>
                                                                                                </div>
                                                                                                <div class="col-md-6 bold">
                                                                                                    Loại phiếu : <span> Xuất </span>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-md-12"
                                                                                                style="margin-bottom: 0;">
                                                                                                <div class="portlet box ">
                                                                                                    <div class="portlet-body">
                                                                                                        <div class="">
                                                                                                            <div class="row">
                                                                                                                <div class="col-md-12">
                                                                                                                    <table
                                                                                                                        class="table table-bordered table-hover table">
                                                                                                                        <thead>
                                                                                                                            <tr>
                                                                                                                                <th>Tên NVL</th>
                                                                                                                                <th>Số lượng</th>
                                                                                                                                <th>Đơn vị</th>
                                                                                                                            </tr>
                                                                                                                        </thead>
                                                                                                                        <tbody>
                                                                                                                            @foreach ($info->detailExportCoupon as $detail)
                                                                                                                                <tr>
                                                                                                                                    <td>{{ $detail->materialDetail->name }} </td>
                                                                                                                                    <td>{{ $detail->qty }}  </td>
                                                                                                                                    <td>{{ $detail->unit->name }} </td>
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
                                                                                        </div>

                                                                                    </div>
                                                                            @endif

                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                        </tr>
                                    @endforeach
                                @else
                                        -
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <!-- page end-->
</div>
@endsection
