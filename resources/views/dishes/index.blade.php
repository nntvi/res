@extends('layouts')
@section('content')
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            Đồ uống - Món Ăn
        </div>
        <div class="table-responsive">
            <table class="table table-striped b-t b-light" id="example">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Hình minh họa</th>
                        <th>Mã sản phẩm</th>
                        <th>Tên món</th>
                        <th>Bếp</th>
                        <th>Nhóm thực đơn</th>
                        <th>Giá bán</th>
                        <th>Đơn vị tính</th>
                        <th>Trạng thái</th>
                        <th>Ghi chú</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dishes as $key => $dish)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>
                                <img href="#img{{ $dish->id }}" data-toggle="modal" ui-toggle-class="" height="50px"
                                    width="70px" src="img/{{ $dish->image }}" style="cursor:pointer">
                                <div aria-hidden="true" aria-labelledby="updatePrice" role="dialog" tabindex="-1"
                                    id="img{{ $dish->id }}" class="modal fade" style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button aria-hidden="true" data-dismiss="modal" class="close"
                                                    type="button">×</button>
                                                <h4 class="modal-title">Chỉnh sửa ảnh món ăn "<b>{{ $dish->name }}</b>"</h4>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('dishes.p_updateimage',['id'=>$dish->id]) }}"
                                                    enctype="multipart/form-data" method="post">
                                                    @csrf
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-xs-5">
                                                                <label class="col-xs-4">Ảnh hiện tại</label>
                                                                <img src="img/{{ $dish->image }}"  class="col-xs-6">
                                                            </div>
                                                            <div class="col-xs-7">
                                                                <label>Chọn ảnh mới</label>
                                                                <input type="file" name="file" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <hr>
                                                            <div class="col-xs-12 text-center">
                                                                <button type="submit" class="btn btn-default">Cập nhật</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $dish->code }}</td>
                            <td>{{ $dish->name }}</td>
                            <td>{{ $dish->material->groupMenu->cookArea->name }}</td>
                            <td class="text-center">{{ $dish->material->groupMenu->name }}</td>
                            <td>
                                <a href="#updatePrice{{ $dish->id }}" data-toggle="modal" class="clickUpdatePrice" id="{{ $dish->material->id }}">
                                    <i class="fa fa-pencil-square-o text-success text-active"></i>
                                </a>
                                <div aria-hidden="true" aria-labelledby="updatePrice" role="dialog" tabindex="-1"
                                    id="updatePrice{{ $dish->id }}" class="modal fade" style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button aria-hidden="true" data-dismiss="modal" class="close"
                                                    type="button">×</button>
                                                <h4 class="modal-title">Chỉnh sửa giá món "<b>{{ $dish->name }}</b>"</h4>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('dishes.p_updatesaleprice',['id' => $dish->id]) }}" method="post"
                                                    onsubmit="return checkPriceUpdateDish({{ $dish->material->id }})">
                                                    @csrf
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-xs-6">
                                                                <label>Giá vốn cũ</label>
                                                                <input class="form-control" value="{{ $dish->capital_price }}"  disabled>
                                                            </div>
                                                            <div class="col-xs-6">
                                                                <label>Giá vốn mới/tính đến thời điểm hiện tại</label>
                                                                <input name="newCapitalPriceHidden" id="newCapitalPriceHidden{{ $dish->material->id }}" hidden>
                                                                <input class="form-control" id="newCapitalUpdate{{ $dish->material->id }}" disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-xs-6">
                                                                <label>Giá bán hiện tại</label>
                                                                <input class="form-control" value="{{ $dish->sale_price }}" disabled>
                                                            </div>
                                                            <div class="col-xs-6">
                                                                <label>Giá bán mới (Hệ số: <span class="heso"></span>)</label>
                                                                <input type="number" min="2000" class="form-control" id="newSalePriceUpdate{{ $dish->material->id }}"
                                                                name="newSalePriceUpdate" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-xs-12 text-center">
                                                                <button type="submit" class="btn btn-default">Cập nhật</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{ number_format("$dish->sale_price") . ' đ' }}
                            </td>
                            <td>
                                <a href="#updateUnit{{ $dish->id }}" data-toggle="modal" ui-toggle-class="">
                                    <i class="fa fa-pencil-square-o text-warning text-active"></i>
                                </a>
                                <div aria-hidden="true" aria-labelledby="updateUnit" role="dialog" tabindex="-1"
                                    id="updateUnit{{ $dish->id }}" class="modal fade" style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button aria-hidden="true" data-dismiss="modal" class="close"
                                                    type="button">×</button>
                                                <h4 class="modal-title">Chỉnh sửa đơn vị món "<b>{{ $dish->name }}</b>"</h4>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('dishes.p_updateunit',['id' => $dish->id]) }}" method="post">
                                                    @csrf
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-xs-6">
                                                                <label>Đơn vị hiện tại</label>
                                                                <input type="text" class="form-control"
                                                                    value="{{ $dish->unit->name }}" disabled>
                                                            </div>
                                                            <div class="col-xs-6">
                                                                <label>Đơn vị muốn chỉnh sửa</label>
                                                                <select name="unitUpdate" class="form-control">
                                                                    @foreach($units as $unit)
                                                                        <option value="{{ $unit->id }}">
                                                                            {{ $unit->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                        <button type="submit" class="btn btn-default">Cập nhật</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{ $dish->unit->name }}
                            </td>
                            <td>
                                <a href="#myModal-1{{ $dish->id }}" data-toggle="modal" ui-toggle-class="">
                                    <i class="fa fa-pencil-square-o text-info text-active"></i>
                                </a>
                                <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1"
                                    id="myModal-1{{ $dish->id }}" class="modal fade" style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button aria-hidden="true" data-dismiss="modal" class="close"
                                                    type="button">×</button>
                                                <h4 class="modal-title">Chỉnh sửa trạng thái "<b>{{ $dish->name }}</b>"</h4>
                                            </div>
                                            <div class="modal-body">
                                                <form class="form-horizontal" action="{{ route('dishes.p_updatestatus',['id' => $dish->id]) }}" method="POST">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label class="col-lg-2 col-sm-2 control-label">Trạng
                                                            thái</label>
                                                        <div class="col-lg-7 text-center">
                                                            @if($dish->status == '0')
                                                                <label class="control-label">Ẩn</label>
                                                                <input value="0" type="radio" name="status"
                                                                    style="margin-right: 20px" checked>
                                                                <label class="control-label">Hiện</label>
                                                                <input value="1" type="radio" name="status"
                                                                    style="margin-right: 20px">
                                                            @else
                                                                <label class="control-label">Ẩn</label>
                                                                <input value="0" type="radio" name="status"
                                                                    style="margin-right: 20px">
                                                                <label class="control-label">Hiện</label>
                                                                <input value="1" type="radio" name="status"
                                                                    style="margin-right: 20px" checked>
                                                            @endif
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <button type="submit" class="btn btn-default">Cập
                                                                nhật</button>
                                                        </div>
                                                    </div>

                                                </form>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                                @if($dish->status == '0')
                                    Ẩn
                                @else
                                    Hiện
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="#note{{ $dish->id }}" data-toggle="modal">
                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                </a>
                                <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="note{{ $dish->id }}" class="modal fade">
                                        <div class="modal-dialog text-left">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                                    <h4 class="modal-title">Ghi chú món {{ $dish->name }}</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('dishes.p_updatenote',['id' => $dish->id]) }}" method="POST">
                                                        @csrf
                                                        <div class="form-group">
                                                            <label>Ghi chú</label>
                                                            <textarea name="describe" class="form-control" rows="3">
                                                                {{ $dish->describe }}
                                                            </textarea>
                                                        </div>
                                                        <button type="submit" class="btn btn-default">Cập nhật</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                </div>

                            </td>
                            {{-- <td>
                                <a href="{{ route('dishes.delete',['id' => $dish->id]) }}"
                                    onclick="return confirm('Bạn muốn xóa dữ liệu này?')"><i
                                        class="fa fa-times text-danger text"></i></a>
                            </td> --}}
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
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
            $('#example_info').addClass('text-muted');
            $('input[type="search"]').addClass('form-control');
            $('#example_length').html(
                `<a href="{{ route('dishes.store') }}" class="btn btn-sm btn-default">Thêm mới</a>`
            );
        });
    </script>
@endsection
