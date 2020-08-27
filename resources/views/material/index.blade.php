@extends('layouts')
@section('content')
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            Danh sách tên món ăn
        </div>
        <div class="table-responsive">
            <table class="table table-striped b-t b-light" id="example">
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
                        @if ($material->groupMenu->status == '1')
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
                                                            <label>Tên hiện tại</label>
                                                            <input type="text" class="form-control"
                                                                value="{{ $material->name }}" disabled>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Tên thay đổi <span style="color: #ff0000">
                                                                    *</span></label>
                                                            <input type="text" maxlength="40" class="form-control"
                                                                 name="nameMaterial"
                                                                value="{{ $material->name }}" required>
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
                                        <i class="fa fa-list text-info" aria-hidden="true"></i>
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
                        @endif
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
                `<a href="#myModal" data-toggle="modal" class="btn btn-sm btn-default">
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
                                                <input type="text" class="form-control" name="name"
                                                    maxlength="40" required>
                                            </div>
                                            <div class="col-xs-6">
                                                <label class="control-label">Thuộc Danh mục món</label>
                                                <select class="form-control radius" name="idGroupMenu">
                                                    @foreach($groupMenus as $groupMenu)\
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
                </div>`
            );
        });
    </script>
@endsection
