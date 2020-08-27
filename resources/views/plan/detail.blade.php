@extends('layouts')
<style>
    .table-responsive {
        overflow-x: inherit !important;
    }
    input[type="search"] {
        height: 29px;
    }
</style>
@section('content')
<div class="form-w3layouts">
    <!-- page start-->
    <!-- page start-->
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading" style="margin-bottom: 20px">
                    Chọn mặt hàng cần nhập cho kế hoạch
                </header>
                <div class="panel-body">
                    <div class="position-center">
                            <div class="row form-group">
                                <div class="col-xs-12 col-sm-6">
                                    <label>Kế hoạch ngày</label>
                                    <input type="hidden" name="id_plan" value="{{ $id }}">
                                    <input class="form-control" value="{{ $plan->date_create }}" disabled>
                                </div>
                                <div class="col-xs-12 col-sm-6">
                                    <label>Nhà cung cấp</label>
                                    <input class="form-control" value="{{ $plan->supplier->name }}" disabled>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="page-header">
                                    <h3 class="bars text-center">Các mặt hàng cần nhập trong kế hoạch này</h3>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table" id="example">
                                    <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th class="text-center">Tên Nguyên Vật Liệu</th>
                                            <th class="text-center">Đơn vị</th>
                                            <th class="text-center">Số lượng dự tính</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody id="bodyImportPlan">
                                            @foreach ($materialChoosen as $key => $item)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td class="text-center">
                                                        <input type="hidden" class="namematdetail" value="{{ $item->materialDetail->name }}">
                                                        {{ $item->materialDetail->name }}
                                                    </td>
                                                    <td class="text-center">
                                                        {{ $item->materialDetail->unit->name }}
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="#updateQty{{ $item->materialDetail->id }}" data-toggle="modal">
                                                            <i class="fa fa-pencil-square-o text-success" aria-hidden="true"></i>
                                                        </a>
                                                            <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="updateQty{{ $item->materialDetail->id }}" class="modal fade" style="display: none;">
                                                                <div class="modal-dialog text-left">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                                                            <h4 class="modal-title">Cập nhật số lượng nhập</h4>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <form action="{{ route('importplan.update',['idPlan' => $id, 'idMaterial' => $item->materialDetail->id]) }}" method="POST">
                                                                                @csrf
                                                                                <div class="form-group">
                                                                                    <div class="row">
                                                                                        <div class="col-xs-6">
                                                                                            <label>Tên NVL</label>
                                                                                            <input class="form-control" value="{{ $item->materialDetail->name }}" disabled>
                                                                                        </div>
                                                                                        <div class="col-xs-6">
                                                                                            <label>Số lượng hiện tại</label>
                                                                                            <input class="form-control" value="{{ $item->qty }}" disabled>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label>Số lượng cần thay đổi</label>
                                                                                    <input class="form-control" min="1" name="qty" value="{{ $item->qty }}" required>
                                                                                </div>
                                                                                <button type="submit" class="btn btn-default">Cập nhật</button>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        {{ $item->qty }}
                                                    </td>
                                                    <td class="text-right">
                                                        <a href="{{ route('importplan.delete',['idPlan' => $id, 'idMaterial' => $item->materialDetail->id]) }}"
                                                            onclick="return confirm('Bạn muốn xóa NVL này khỏi kế hoạch?')"><i class="fa fa-times text-danger" aria-hidden="true"></i></a>
                                                    </td>
                                                </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="space"></div>
                                <div class="space"></div>
                                <div class="col-xs-12 text-center">
                                    <a href="{{ route('importplan.index') }}" class="btn btn-default">Trở về</a>
                                </div>
                            </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <!-- page end-->
    <script>
            @if(session('success'))
                toastr.success('{{ session('success') }}')
            @endif
            @if(session('warning'))
                toastr.warning('{{ session('warning') }}')
            @endif
    </script>
    <script type="text/javascript" language="javascript" src="{{ asset('js/data.table.js') }}"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>
    <script>
        $(document).ready( function () {
            $('#example').dataTable();
            $('#example_info').addClass('text-muted');
            $('input[type="search"]').addClass('form-control');
            let content =
                `<a href="#myModal" data-toggle="modal" class="btn btn-sm btn-default">
                    Thêm NVL
                </a>
                <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade" style="display: none;">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                    <h4 class="modal-title">Thêm Nguyên vật liệu cho kế hoạch</h4>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('importplan.addMore') }}" role="form" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label>Nhà cung cấp</label>
                                            <input type="hidden" name="id_plan" value="{{ $id }}">
                                            <input class="form-control" value="{{ $plan->supplier->name }}" disable>
                                        </div>
                                        <div class="form-group">
                                            <label></label>`;
                                                @foreach ($materialDetails as $detail)
                                        content += `<div class="col-xs-6 col-sm-4">
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" value="{{ $detail->id }}" name="idMaterialDetail[]">
                                                            <label style="font-weight: normal">{{ $detail->name }}</label>
                                                        </div>
                                                    </div>`;
                                                @endforeach
                            content +=  `</div>
                                    <div class="row">
                                        <div class="col-xs-12 text-center">
                                            <div class="space"></div>
                                            <button type="submit" class="btn btn-default">Thêm</button>
                                        </div>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>`;
            $('#example_length').html(content);
        });
    </script>
</div>
@endsection
