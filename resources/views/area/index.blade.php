@extends('layouts')
<style>
    .panel-heading h4, .panel-heading label{
        text-transform: none;
        font-size: 17px;
    }
    .panel-heading label{
        line-height: none;
    }
</style>
@section('content')
<div class="table-agile-info">
    <h2 class="w3ls_head" style="margin-bottom: 15px;">Khu vực - Bàn </h2>
    <div class="row">
        <div class="col-xs-12">
            <a href="#myModal-1" data-toggle="modal" class="btn btn-sm btn-default m-b-xs">
                Thêm khu vực
            </a>
            <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal-1"
                class="modal fade" style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                            <h4 class="modal-title">Thêm mới Khu vực</h4>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal" role="form"
                                action="{{ route('area.p_store') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">
                                        Nhập tên khu vực
                                    </label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" name="nameArea" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-offset-2 col-lg-10 text-right">
                                        <button type="submit" class="btn btn-default">Thêm mới</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <a href="#table" data-toggle="modal" class="btn btn-sm btn-default  m-b-xs">
                Thêm bàn
            </a>
            <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="table"
                class="modal fade" style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                            <h4 class="modal-title text-center">Thêm mới bàn</h4>
                        </div>
                        <div class="modal-body">
                            <form role="form" action="{{ route('table.p_store') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-xs-6 text-left">
                                            <label class="text">Mã bàn</label>
                                            <input type="text" class="form-control" name="codeTable" min="3" max="15"
                                                required>
                                        </div>
                                        <div class="col-xs-6 text-left">
                                            <label>Tên bàn</label>
                                            <input type="text" class="form-control" name="nameTable" min="3" max="30"
                                                required>
                                        </div>
                                    </div>
                                    <div class="space"></div>
                                    <div class="form-group row">
                                        <div class="col-xs-6">
                                            <label>Số lượng ghế</label>
                                            <input type="number" min="2" max="10" class="form-control" value="2"
                                                name="qtyChairs" required>
                                        </div>
                                        <div class="col-xs-6">
                                            <label>Khu vực</label>
                                            <select name="idArea" class="form-control">
                                                @foreach($areaTables as $area)
                                                    <option id="{{ $area->id }}" value="{{ $area->id }}">
                                                        {{ $area->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="space"></div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xs-12 text-center">
                                                <button type="submit" class="btn btn-info">Thêm mới</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        @foreach($areas as $area)
            <div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            {{ $area->name }}
                            <a href="#addArea{{ $area->id }}" data-toggle="modal">
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                            </a>
                            <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="addArea{{ $area->id }}"
                                    class="modal fade" style="display: none;">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                        <h4 class="modal-title">Chỉnh sửa tên khu vực</h4>
                                    </div>
                                    <div class="modal-body">
                                        <form class="form-horizontal" role="form"  action="{{ route('area.update',['id' => $area->id]) }}" method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <label class="col-lg-3 col-sm-3 control-label">
                                                    Tên hiện tại
                                                </label>
                                                <div class="col-lg-9">
                                                    <input type="text" class="form-control" value="{{ $area->name }}" disabled>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-3 col-sm-3 control-label">
                                                    Tên thay đổi
                                                </label>
                                                <div class="col-lg-9">
                                                    <input type="text" class="form-control" name="nameArea"
                                                    value="{{ $area->name }}" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-lg-offset-2 col-lg-10 text-right">
                                                    <button type="submit" class="btn btn-default">Cập nhật</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                            <span class="tools pull-right">
                                <a class="fa fa-chevron-down" href="javascript:;" style="padding-top: 17px"></a>
                            </span>
                        </header>
                        <div class="panel-body">
                            <div>
                                <table class="table table-striped b-t b-light" id="table{{ $area->id }}">
                                    <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>Mã bàn</th>
                                            <th>Tên bàn</th>
                                            <th>Số ghế</th>
                                            <th class="text-center">Chuyển khu vực</th>
                                            <th class="text-right">Xóa</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($area->containTable as $key => $table)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $table->code }}</td>
                                                <td>
                                                    <a href="#table{{ $table->id }}" data-toggle="modal">
                                                        <i class="fa fa-pencil-square-o text-info" aria-hidden="true"></i>
                                                    </a>
                                                    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="table{{ $table->id }}" class="modal fade" style="display: none;">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                                                        <h4 class="modal-title">Chỉnh sửa tên bàn</h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form action="{{ route('table.p_updatename',['id' => $table->id ]) }}" method="POST">
                                                                            @csrf
                                                                            <div class="form-group row">
                                                                                <div class="col-xs-6">
                                                                                    <label>Mã bàn</label>
                                                                                    <input type="text" class="form-control" value="{{ $table->code }}" disabled>
                                                                                </div>
                                                                                <div class="col-xs-6">
                                                                                    <label>Khu vực </label>
                                                                                    <input type="text" class="form-control" value="{{ $table->getArea->name }}" disabled>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label>Tên bàn</label>
                                                                                <input type="text" class="form-control" name="nameTable" value="{{ $table->name }}" required>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-xs-12 text-center">
                                                                                    <button type="submit" class="btn btn-default">Cập nhật</button>
                                                                                </div>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                    </div>
                                                    {{ $table->name }}
                                                </td>
                                                <td>
                                                    <a href="#chair{{ $table->id }}" data-toggle="modal">
                                                        <i class="fa fa-pencil-square-o text-warning" aria-hidden="true"></i>
                                                    </a>
                                                    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="chair{{ $table->id }}" class="modal fade" style="display: none;">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                                                        <h4 class="modal-title">Chỉnh sửa số lượng ghế</h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form action="{{ route('table.p_updatechair',['id' => $table->id]) }}" method="POST">
                                                                            @csrf
                                                                            <div class="form-group row">
                                                                                <div class="col-xs-6">
                                                                                    <label>Mã bàn</label>
                                                                                    <input type="text" class="form-control" value="{{ $table->code }}" disabled>
                                                                                </div>
                                                                                <div class="col-xs-6">
                                                                                    <label>Khu vực</label>
                                                                                    <input type="text" class="form-control" value="{{ $table->getArea->name }}" disabled>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group row">
                                                                                <div class="col-xs-6">
                                                                                    <label>Tên bàn</label>
                                                                                    <input type="text" class="form-control" name="nameTable" value="{{ $table->name }}" disabled>
                                                                                </div>
                                                                                <div class="col-xs-6">
                                                                                    <label>Số lượng ghế</label>
                                                                                    <input type="number" min="2" max="10" class="form-control" name="qtyChairs" value="{{ $table->chairs }}" required>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-xs-12 text-center">
                                                                                    <button type="submit" class="btn btn-default">Cập nhật</button>
                                                                                </div>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                    </div>
                                                    {{ $table->chairs }} ghế
                                                </td>
                                                <td class="text-center">
                                                    <a href="#updateArea{{ $table->id }}" data-toggle="modal">
                                                        <i class="fa fa-exchange text-success" aria-hidden="true"></i> Chuyển
                                                    </a>
                                                    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="updateArea{{ $table->id }}" class="modal fade" style="display: none;">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                                                        <h4 class="modal-title text-left">Chuyển bàn sang khu vực khác</h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form action="{{ route('table.p_updatearea',['id' => $table->id ]) }}" method="POST">
                                                                            @csrf
                                                                            <div class="form-group row">
                                                                                <div class="col-xs-6 text-left">
                                                                                    <label>Mã bàn</label>
                                                                                    <input type="text" class="form-control" value="{{ $table->code }}" disabled>
                                                                                </div>
                                                                                <div class="col-xs-6 text-left">
                                                                                    <label>Tên bàn</label>
                                                                                    <input type="text" class="form-control" name="nameTable" value="{{ $table->name }}" disabled>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group row">
                                                                                <div class="col-xs-12 text-left">
                                                                                        <label>Khu vực</label>
                                                                                        <select class="form-control" name="changeArea">
                                                                                            <option value="{{ $table->getArea->id }}">{{ $table->getArea->name }}</option>
                                                                                            @foreach ($areaTables as $areaTable)
                                                                                                @if ($areaTable->id == $table->getArea->id )
                                                                                                    @continue
                                                                                                @else
                                                                                                    <option value="{{ $areaTable->id }}">{{ $areaTable->name }}</option>
                                                                                                @endif
                                                                                            @endforeach
                                                                                        </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-xs-12 text-center">
                                                                                    <button type="submit" class="btn btn-default">Cập nhật</button>
                                                                                </div>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                    </div>
                                                </td>
                                                <td class="text-right">
                                                    <a class="text-right" href="{{ route('table.delete',['id' => $table->id]) }}" onclick="return confirm('Bạn muốn xóa bàn này?')">
                                                        <i class="fa fa-trash-o text-danger" aria-hidden="true"></i>
                                                    </a>
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
        @endforeach
    </div>
</div>
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
            @foreach($areas as $key => $area)
                $("table[id^='table{{ $area->id }}']").dataTable();
                $('#table{{ $area->id }}_length').html(
                    `<a class="btn btn-sm btn-default" href="{{ route('area.delete',['id' => $area->id]) }}" onclick="return confirm('Bạn muốn xóa dữ liệu này?')">
                        Xóa khu vực
                    </a>`
                );
            @endforeach
            $('#example_info').addClass('text-muted');
            $('input[type="search"]').addClass('form-control');
        });
    </script>
@endsection
