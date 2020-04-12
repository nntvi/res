@extends('layouts')
<style>
</style>
@section('content')
<div class="mail-w3agile">
    <!-- page start-->
    <div class="row">
        <div class="col-sm-3 com-w3ls">
            <section class="panel">
                <header class="panel-heading" style="background: indianred;color: white;">
                    Nhóm Nguyên Vật liệu
                </header>
                <div class="panel-body">
                    <form class="panel-body create-food" enctype="multipart/form-data" role="form" id="createNews-form"
                        action="{{ route('material.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label class="control-label">Tên nhóm NVL cho món<span style="color: #ff0000;">
                                    *</span></label>
                            <input type="text" size="40" class="form-control" name="name" maxlength="100" required>
                            <span class="error-message">{{ $errors->first('name') }}</span></p>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Thuộc Danh mục món<span style="color: #ff0000;">
                                    *</span></label>
                            <select class="form-control radius" name="idGroupMenu" style="margin-top: 15px">
                                @foreach($groupMenus as $groupMenu)
                                    <option value="{{ $groupMenu->id }}">{{ $groupMenu->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="space"></div>
                        <input type="submit" class="btn btn-compose" value="Tạo mới" style="background: darkcyan;">
                    </form>
                </div>
            </section>
        </div>
        <div class="col-sm-9">
            <div class="table-agile-info">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Danh sách nhóm nguyên vật liệu
                    </div>
                    <div class="row w3-res-tb">
                        <div class="col-sm-4 m-b-xs">
                            <a href="{{ route('material.index') }}" class="btn btn-sm btn-info">Trở về</a>
                        </div>
                        <div class="col-sm-4">
                            <span
                                class="error-message">{{ $errors->first('nameMaterial') }}</span>
                            </p>
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
                                    <th>Tên nhóm NVL</th>
                                    <th>Tên danh mục món ăn</th>
                                    <th>Cập nhật</th>
                                    <th class="text-right">Xóa</th>
                                </tr>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($materials as $key => $material)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>
                                            {{ $material->name }}
                                        </td>
                                        <td>
                                            {{ $material->groupMenu->name }}
                                        </td>
                                        <td >
                                            <a href="#myModal{{ $material->id }}" data-toggle="modal"
                                                class="btn-sm btn-success">
                                                Sửa tên
                                            </a>
                                            <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog"
                                                tabindex="-1" id="myModal{{ $material->id }}" class="modal fade"
                                                style="display: none;">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button aria-hidden="true" data-dismiss="modal"
                                                                class="close" type="button">×</button>
                                                            <h4 class="modal-title">Chỉnh sửa tên nhóm NVL cho món</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form role="form" action="{{ route('material.updateName',['id' => $material->id ]) }}" method="POST">
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
                                                                        required="required" name="nameMaterial"
                                                                        maxlength="255" value="{{ $material->name }}">
                                                                </div>
                                                                <button type="submit"
                                                                    class="btn btn-default">Lưu</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            &nbsp;
                                            <a href="#myModalCategory{{ $material->id }}" data-toggle="modal"
                                                    class="btn-sm btn-warning">
                                                    Sửa danh mục
                                                </a>
                                                <div aria-hidden="true" aria-labelledby="myModalCategoryLabel" role="dialog"
                                                    tabindex="-1" id="myModalCategory{{ $material->id }}" class="modal fade"
                                                    style="display: none;">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button aria-hidden="true" data-dismiss="modal"
                                                                    class="close" type="button">×</button>
                                                                <h4 class="modal-title">Chỉnh sửa danh mục cho nhóm NVL</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form role="form" action="{{ route('material.updateGroup',['id' => $material->id ]) }}" method="POST">
                                                                    @csrf
                                                                    <div class="form-group">
                                                                        <label>Danh mục cũ</label>
                                                                        <input type="text" class="form-control"
                                                                            value="{{ $material->name }}" disabled>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Danh mục cần sửa <span style="color: #ff0000">
                                                                                *</span></label>
                                                                        <select class="form-control" name="idGroupMenu">
                                                                            @foreach ($groupMenus as $groupmenu)
                                                                                <option value="{{ $groupmenu->id }}">{{ $groupmenu->name }}</option>
                                                                            @endforeach
                                                                        </select>                                                                    </div>
                                                                    <button type="submit"
                                                                        class="btn btn-default">Lưu</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        </td>
                                        <td class="text-right">
                                            <a href="{{ route('material.delete',['id' => $material->id]) }}"
                                                 onclick="return confirm('Bạn muốn xóa dữ liệu này?')"><i class="fa fa-times text-danger text"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <footer class="panel-footer">
                        <div class="row">
                            <div class="col-sm-5 text-center">
                            </div>
                            <div class="col-sm-7 text-right text-center-xs">
                                <ul class="pagination pagination-sm m-t-none m-b-none">
                                    {{--  {{ $materials->links() }}  --}}
                                </ul>
                            </div>
                        </div>
                    </footer>
                </div>
            </div>
        </div>
    </div>

    <!-- page end-->
</div>
@endsection
