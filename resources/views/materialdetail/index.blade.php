@extends('layouts')
@section('content')
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            Chi tiết Nguyên vật liệu
        </div>
        <div class="row w3-res-tb">
            <div class="col-sm-3 m-b-xs">
                <a href="#myModal" data-toggle="modal">
                    <button class="btn btn-sm btn-danger">Thêm mới</button>
                </a>
                <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal"
                    class="modal fade" style="display: none;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                <h4 class="modal-title">Thêm mới chi tiết NVL</h4>
                            </div>
                            <div class="modal-body">
                                <form role="form" action="{{ route('material_detail.store') }}"
                                    method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label>Tên NVL</label>
                                        <input class="form-control" name="nameAdd" min="3" max="30" required="">
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xs-6">
                                                <label>Nhóm NVL</label>
                                                <select class="form-control" name="idType"
                                                    style="margin-right: 3px;margin-top: 3px">
                                                    @foreach($types as $type)
                                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                                    @endforeach
                                                </select> </div>
                                            <div class="col-xs-6">
                                                <label>Đơn vị</label>
                                                <select class="form-control" name="idUnit"
                                                    style="margin-right: 3px;margin-top: 3px">
                                                    @foreach($units as $unit)
                                                        <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="space"></div>
                                    <div class="alert alert-danger" role="alert">
                                        <strong>Lưu ý!</strong> Đơn vị của NVL sẽ không chỉnh sửa được sau khi thêm, vui
                                        lòng xem kĩ đơn vị trước khi thêm mới.
                                    </div>
                                    <div class="form-group">
                                        <div class="col-xs-12 text-center">
                                            <button type="submit" class="btn btn-success">Thêm mới</button>
                                        </div>
                                    </div>
                                    <div class="space"></div>
                                    <div class="space"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-5">
                @if($errors->any())
                    @foreach($errors->all() as $error)
                        <span class="error-message">{{ $error }}</span></p>
                    @endforeach
                @endif
            </div>
            <div class="col-sm-4">
                <form action="{{ route('material_detail.search') }}" method="GET">
                    @csrf
                    <div class="input-group">
                        <input type="text" min="1" max="100" class="input-sm form-control" name="nameSearch" required>
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-sm btn-info" type="button">Tìm kiếm</button>
                        </span>
                    </div>
                </form>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped b-t b-light">
                <thead style="background: #ffeeda;">
                    <tr>
                    <tr>
                        <th>STT</th>
                        <th>Tên nguyên vật liệu</th>
                        <th>Thuộc nhóm</th>
                        <th>Đơn vị</th>
                        <th class="text-right">Xóa</th>
                    </tr>
                    </tr>
                </thead>
                <tbody>
                    @foreach($materialDetails as $key => $materialDetail)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <form method="POST"
                                action="{{ route('material_detail.p_updatename',['id' => $materialDetail->id]) }}">
                                @csrf
                                <td>
                                    <a href="#myModal{{ $materialDetail->id }}" data-toggle="modal"
                                        ui-toggle-class="">
                                        <i class="fa fa-pencil-square-o text-success text-active"></i>
                                    </a>
                                    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1"
                                        id="myModal{{ $materialDetail->id }}" class="modal fade"
                                        style="display: none;">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button aria-hidden="true" data-dismiss="modal" class="close"
                                                        type="button">×</button>
                                                    <h4 class="modal-title">Chỉnh sửa tên NVL</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <form role="form"
                                                        action="{{ route('material_detail.p_updatename',['id' => $materialDetail->id ]) }}"
                                                        method="POST">
                                                        @csrf
                                                        <div class="form-group">
                                                            <label>Tên cũ</label>
                                                            <input type="text" class="form-control"
                                                                value="{{ $materialDetail->name }}" disabled>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Tên cần sửa<span style="color: #ff0000">
                                                                    *</span></label>
                                                            <input type="text" size="40" class="form-control"
                                                                required="required" name="nameUpdate" maxlength="255"
                                                                value="{{ $materialDetail->name }}">
                                                        </div>
                                                        <button type="submit" class="btn btn-default">Lưu</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{ $materialDetail->name }}
                                </td>
                                <td>
                                    <a href="#type{{ $materialDetail->id }}" data-toggle="modal" ui-toggle-class=""><i
                                            class="fa fa-pencil-square-o text-info text-active"></i>
                                    </a>
                                    <div aria-hidden="true" aria-labelledby="type" role="dialog" tabindex="-1"
                                        id="type{{ $materialDetail->id }}" class="modal fade" style="display: none;">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button aria-hidden="true" data-dismiss="modal" class="close"
                                                        type="button">×</button>
                                                    <h4 class="modal-title">Chỉnh sửa nhóm cho NVL</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <form role="form"
                                                        action="{{ route('material_detail.p_updatetype',['id' => $materialDetail->id ]) }}"
                                                        method="POST">
                                                        @csrf
                                                        <div class="form-group">
                                                            <label>Nhóm hiện tại</label>
                                                            <input type="text" class="form-control"
                                                                value="{{ $materialDetail->typeMaterial->name }}"
                                                                disabled>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Nhóm cần sửa<span style="color: #ff0000">
                                                                    *</span></label>
                                                            <select name="type" class="form-control">
                                                                @foreach($types as $type)
                                                                    <option value="{{ $type->id }}">
                                                                        {{ $type->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <button type="submit" class="btn btn-default">Lưu</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{ $materialDetail->typeMaterial->name }}
                                </td>
                                <td>
                                    {{ $materialDetail->unit->name }}
                                </td>
                            </form>
                            <td class="text-right">
                                <a href="{{ route('material_detail.delete',['id' => $materialDetail->id]) }}"
                                    class="btn btn-warning btn-xs radius">
                                    <i class="fa fa-trash-o"
                                        onclick="return confirm('Khi click xóa, NVL trong kho chính và kho bếp cũng được xóa, bạn đã chắc chắn?')">
                                        Xóa</i>

                                </a>
                            </td>
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
                    <ul class="pagination pagination-sm m-t-none m-b-none">
                        {{ $materialDetails->links() }}
                    </ul>
                </div>
            </div>
        </footer>
    </div>
</div>
@endsection
