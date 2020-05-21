@extends('layouts')
@section('content')
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            Đồ uống - Món Ăn
        </div>
        <div class="row w3-res-tb">
                <div class="col-sm-5 m-b-xs">
                    <a href="{{ route('dishes.store') }}" class="btn btn-sm btn-default">Thêm mới</a>
                    <a href="{{ route('dishes.exportexcel') }}" class="btn btn-sm btn-warning">
                        <i class="fa fa-file-excel-o" aria-hidden="true"></i> Xuất Excel
                    </a>
                </div>
                <div class="col-sm-3">
                </div>
                <div class="col-sm-4">
                    <form action="{{ route('dishes.search') }}" method="get">
                        @csrf
                        <div class="input-group">
                            <input type="text" class="input-sm form-control" name="nameSearch" required>
                            <span class="input-group-btn">
                                <button class="btn btn-sm btn-default" type="submit">Tìm kiếm!</button>
                            </span>
                        </div>
                    </form>
                </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped b-t b-light">
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
                                                <h4 class="modal-title">Chỉnh sửa ảnh món ăn</h4>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('dishes.p_updateimage',['id'=>$dish->id]) }}"
                                                    enctype="multipart/form-data" method="post">
                                                    @csrf
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-xs-5">
                                                                <label class="col-xs-4">Ảnh cũ</label>
                                                                <img src="img/{{ $dish->image }}"  class="col-xs-6">
                                                            </div>
                                                            <div class="col-xs-7">
                                                                <label>Chọn ảnh mới</label>
                                                                <input type="file" name="file" id="" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <hr>
                                                            <div class="col-xs-12 text-center">
                                                                <button type="submit" class="btn btn-success">Lưu</button>
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
                            <td>{{ $dish->groupNVL->groupMenu->cookArea->name }}</td>
                            <td class="text-center">{{ $dish->groupNVL->groupMenu->name }}</td>
                            <td>
                                <a href="#updatePrice{{ $dish->id }}" data-toggle="modal" ui-toggle-class="" id="clickUpdatePrice">
                                    <i class="fa fa-pencil-square-o text-success text-active"></i>
                                </a>
                                <input type="hidden" id="idMaterialUpdatePrice" value="{{ $dish->groupNVL->id }}">
                                <div aria-hidden="true" aria-labelledby="updatePrice" role="dialog" tabindex="-1"
                                    id="updatePrice{{ $dish->id }}" class="modal fade" style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button aria-hidden="true" data-dismiss="modal" class="close"
                                                    type="button">×</button>
                                                <h4 class="modal-title">Chỉnh sửa giá NVL</h4>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('dishes.p_updatesaleprice',['id' => $dish->id]) }}" method="post">
                                                    @csrf
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-xs-6">
                                                                <label>Giá vốn cũ</label>
                                                                <input class="form-control" value="{{ $dish->capital_price }}"  disabled>
                                                            </div>
                                                            <div class="col-xs-6">
                                                                <label>Giá vốn mới/tính đến thời điểm hiện tại</label>
                                                                <input name="newCapitalPriceHidden" id="newCapitalPriceHidden" hidden>
                                                                <input class="form-control" id="newCapitalUpdate" >
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
                                                                <label>Giá bán mới</label>
                                                                <input type="number" min="0" class="form-control" id="newSalePriceUpdate" name="newSalePriceUpdate">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-xs-12 text-center">
                                                                <button type="submit" class="btn btn-success">Lưu</button>
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
                                                <h4 class="modal-title">Chỉnh sửa đơn vị món</h4>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('dishes.p_updateunit',['id' => $dish->id]) }}" method="post">
                                                    @csrf
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-xs-6">
                                                                <label>Đơn vị cũ</label>
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
                                                    <button type="submit" class="btn btn-warning">Lưu</button>
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
                                                <h4 class="modal-title">Chỉnh sửa trạng thái</h4>
                                            </div>
                                            <div class="modal-body">
                                                <form class="form-horizontal" action="{{ route('dishes.p_updatestatus',['id' => $dish->id]) }}" method="POST">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label class="col-lg-2 col-sm-2 control-label">Trạng
                                                            thái</label>
                                                        <div class="col-lg-8 text-center">
                                                            @if($dish->status == '0')
                                                                <label class="control-label">Ẩn</label>
                                                                <input value="0" id="status1" type="radio" name="status"
                                                                    style="margin-right: 20px" checked>
                                                                <label class="control-label">Hiện</label>
                                                                <input value="1" id="status2" type="radio" name="status"
                                                                    style="margin-right: 20px">
                                                            @else
                                                                <label class="control-label">Ẩn</label>
                                                                <input value="0" id="status1" type="radio" name="status"
                                                                    style="margin-right: 20px">
                                                                <label class="control-label">Hiện</label>
                                                                <input value="1" id="status2" type="radio" name="status"
                                                                    style="margin-right: 20px" checked>
                                                            @endif
                                                        </div>
                                                        <div class="col-lg-2">
                                                            <button type="submit" class="btn btn-danger">Cập
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
        <footer class="panel-footer">
            <div class="row">

                <div class="col-sm-5 text-center">
                    <small class="text-muted inline m-t-sm m-b-sm">showing 1-10 items</small>
                </div>
                <div class="col-sm-7 text-right text-center-xs">
                    <ul class="pagination  m-t-none m-b-none">
                       {{ $dishes->links() }}
                    </ul>
                </div>
            </div>
        </footer>
    </div>
</div>
@endsection
