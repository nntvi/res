@extends('layouts')
<style>
    div#example_length {
        padding-left: 5px!important;
    }
    a.fa-chevron-down{
        line-height: 47px;
    }
    #exportSupplier_filter input[type=search]{
        margin-left: 0px;
    }
</style>
@section('content')
<div class="form-w3layouts">
    <!-- page start-->
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Các phiếu xuất kho/bếp
                    <span class="tools pull-right" >
                        <a class="fa fa-chevron-down" href="javascript:;"></a>
                    </span>
                </header>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped b-t b-light" id="example">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Mã phiếu</th>
                                    <th>Loại xuất</th>
                                    <th>Đối tượng xuất</th>
                                    <th>Ghi chú</th>
                                    <th>Ngày tạo</th>
                                    <th>Người tạo</th>
                                    <th>Chi tiết</th>
                                </tr>
                            </thead>
                            <tbody>
                               @foreach ($exportCoupons as $key => $exportCoupon)
                               <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$exportCoupon->code}}</td>
                                    <td>{{$exportCoupon->typeExport->name}}</td>
                                    <td>
                                        @foreach ($exportCoupon->detailExportCoupon as $item)
                                            @if ($exportCoupon->id_type == '2')
                                                {{ $item->supplier->status == '1' ? $item->name_object : $item->name_object . '( ngưng hoạt động)' }}
                                                @break
                                            @else
                                                {{ $item->name_object }}
                                                @break
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>{{$exportCoupon->note}}</td>
                                    <td>{{$exportCoupon->created_at}}</td>
                                    <td>{{$exportCoupon->created_by}}</td>
                                    <td>
                                        <a href="{{ route('exportcoupon.detail', ['id' => $exportCoupon->id]) }}" data-toggle="modal">Xem chi tiết</a>

                                    </td>
                               </tr>
                               @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Các phiếu xuất trả hàng nhà cung cấp
                    <span class="tools pull-right">
                        <a class="fa fa-chevron-down" href="javascript:;"></a>
                    </span>
                </header>
                <div class="panel-body">
                    <div class="table-responsive" >
                        <table class="table table-striped b-t b-light" id="exportSupplier">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Mã phiếu xuất</th>
                                    <th>Nhà cung cấp</th>
                                    <th>Mã phiếu nhập</th>
                                    <th>Tổng tiền trả</th>
                                    <th>Ghi chú</th>
                                    <th>Người tạo</th>
                                    <th>Ngày tạo</th>
                                    <th>Chi tiết</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($exSuppliers as $key => $exsupplier)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $exsupplier->code }}</td>
                                        <td>{{ $exsupplier->importCoupon->supplier->name }}</td>
                                        <td>{{ $exsupplier->importCoupon->code }}</td>
                                        <td>{{ number_format($exsupplier->total) . ' đ' }}</td>
                                        <td>{{ $exsupplier->note }}</td>
                                        <td>{{ $exsupplier->created_by }}</td>
                                        <td>{{ $exsupplier->created_at }}</td>
                                        <td>
                                            <a href="{{ route('exportcoupon.detailsupplier',['id' => $exsupplier->id]) }}">Xem chi tiết</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <!-- page end-->
</div>
<script>
    @if(session('success'))
        toastr.success('{{ session('success') }}')
    @endif
    @if(session('info'))
        toastr.info('{{ session('info') }}')
    @endif
</script>
<script type="text/javascript" language="javascript" src="{{ asset('js/data.table.js') }}"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>
<script>
$(document).ready( function () {
    $('#example').dataTable();
    $('#exportSupplier').dataTable();
    @foreach ($exportCoupons as $exportCoupon)
        $('#detail{{ $exportCoupon->id }}').dataTable();
        $('#detail{{ $exportCoupon->id }}_filter').remove();
        $('#detail{{ $exportCoupon->id }}_length').remove();
    @endforeach
    $('#example_info').addClass('text-muted');
    $('input[type="search"]').addClass('form-control');
    $('#example_length').html(
        `<a class="btn btn-sm btn-default" href="#myModal" data-toggle="modal">
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
                                            value="1" checked>
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
    </div>`
    );
    $('#exportSupplier_length').html(
        `<a class="btn btn-sm btn-default" href="#myModal" data-toggle="modal">
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
                                            value="1" checked>
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
    </div>`
    );
});
</script>
@endsection
