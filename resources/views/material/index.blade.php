@extends('layouts')
@section('content')
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            Danh sách tên món ăn
        </div>
        <div class="row w3-res-tb">
            <div class="col-sm-4 m-b-xs">
                <a href="#myModal" data-toggle="modal" class="btn btn-sm btn-default">
                    Thêm mới
                </a>
                <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal"
                    class="modal fade">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                <h4 class="modal-title">Thêm mới tên món ăn</h4>
                            </div>
                            <div class="modal-body">
                                <form role="form" action="{{ route('material.store') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xs-6">
                                                <label>Tên món<span style="color: #ff0000;">*</span></label></label>
                                                <input type="text" size="40" class="form-control" name="name"
                                                    maxlength="100" required>
                                            </div>
                                            <div class="col-xs-6">
                                                <label class="control-label">Thuộc Danh mục món</label>
                                                <select class="form-control radius" name="idGroupMenu">
                                                    @foreach($groupMenus as $groupMenu)
                                                        <option value="{{ $groupMenu->id }}">{{ $groupMenu->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="space"></div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <button type="submit" class="btn btn-info">Thêm mới</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <a href="{{ route('material.exportexcel') }}" class="btn btn-sm btn-default">
                    <i class="fa fa-file-excel-o" aria-hidden="true"></i> Xuất Excel
                </a> --}}
            </div>
            <div class="col-sm-4">
                <script>
                    @if($errors->any())
                        @foreach($errors->all() as $error)
                            toastr.error('{{ $error }}')
                        @endforeach
                    @endif
                    @if(session('success'))
                        toastr.success('{{ session('success') }}')
                    @endif
                    @if(session('info'))
                        toastr.info('{{ session('info') }}')
                    @endif
                </script>
            </div>
            <div class="col-sm-4">
                <form action="{{ route('material.search') }}" method="GET">
                    @csrf
                    <div class="input-group">
                        <input type="text" class="input-sm form-control" required name="nameSearch">
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
                    <tr>
                        <th>STT</th>
                        <th>Nhóm thực đơn</th>
                        <th>Tên món</th>
                        <th>NVL cấu tạo</th>
                        <th></th>
                        <th class="text-right">Xóa</th>
                    </tr>
                    </tr>
                </thead>
                <tbody>
                    @foreach($materials as $key => $material)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>
                                <a href="#myModalCategory{{ $material->id }}" data-toggle="modal">
                                    <i class="fa fa-pencil-square-o text-warning text-active"></i>
                                </a>
                                <div aria-hidden="true" aria-labelledby="myModalCategoryLabel" role="dialog"
                                    tabindex="-1" id="myModalCategory{{ $material->id }}" class="modal fade"
                                    style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button aria-hidden="true" data-dismiss="modal" class="close"
                                                    type="button">×</button>
                                                <h4 class="modal-title">Chỉnh sửa danh mục cho nhóm NVL</h4>
                                            </div>
                                            <div class="modal-body">
                                                <form role="form"
                                                    action="{{ route('material.updateGroup',['id' => $material->id ]) }}"
                                                    method="POST">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label>Danh mục cũ</label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $material->groupMenu->name }}" disabled>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Danh mục cần sửa <span style="color: #ff0000">
                                                                *</span></label>
                                                        <select class="form-control" name="idGroupMenu">
                                                            @foreach($groupMenus as $groupmenu)
                                                                <option value="{{ $groupmenu->id }}">
                                                                    {{ $groupmenu->name }}</option>
                                                            @endforeach
                                                        </select> </div>
                                                    <button type="submit" class="btn btn-default">Lưu</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{ $material->groupMenu->name }}
                            </td>
                            <td>
                                <a href="#myModal{{ $material->id }}" data-toggle="modal">
                                    <i class="fa fa-pencil-square-o text-success text-active"></i>
                                </a>
                                <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1"
                                    id="myModal{{ $material->id }}" class="modal fade" style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button aria-hidden="true" data-dismiss="modal" class="close"
                                                    type="button">×</button>
                                                <h4 class="modal-title">Chỉnh sửa tên nhóm NVL cho món</h4>
                                            </div>
                                            <div class="modal-body">
                                                <form role="form"
                                                    action="{{ route('material.updateName',['id' => $material->id ]) }}"
                                                    method="POST">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label>Tên cũ</label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $material->name }}" disabled>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Action Name <span style="color: #ff0000">
                                                                *</span></label>
                                                        <input type="text" size="40" class="form-control"
                                                            required="required" name="nameMaterial" maxlength="255"
                                                            value="{{ $material->name }}">
                                                    </div>
                                                    <button type="submit" class="btn btn-default">Lưu</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{ $material->name }}
                            </td>
                            <td>
                                <a
                                    href="{{ route('material_action.detail',['id' => $material->id]) }}">
                                    <i class="fa fa-eye text-info" aria-hidden="true"></i>
                                </a>
                                @foreach($material->materialAction as $key => $item)
                                    {{ $item->materialDetail->name }}
                                    {{ count($material->materialAction) != $key+1 ? ',' : '' }}
                                @endforeach
                            </td>
                            <td>
                                <a href="{{ route('material_action.store',['id' => $material->id]) }}"
                                    class="btn btn-xs btn-success">
                                    <i class="fa fa-plus-square-o" aria-hidden="true"></i> Tạo công thức
                                </a>
                            </td>
                            <td class="text-right">
                                <a href="{{ route('material.delete',['id' => $material->id]) }}"
                                    onclick="return confirm('Bạn muốn xóa dữ liệu này?')"><i
                                        class="fa fa-times text-danger text"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endsection
