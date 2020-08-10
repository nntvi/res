@extends('layouts')
@section('content')
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            Nhóm quyền và hoạt động tương ứng
        </div>
        <div class="row w3-res-tb m-b-xs">
            <div class="col-xs-6 col-sm-3">
                <a href="#myModal-1" data-toggle="modal" class="btn btn-sm btn-default">
                    Thêm mới
                </a>
                <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal-1"
                    class="modal fade" style="display: none;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                <h4 class="modal-title">Thêm mới nhóm quyền</h4>
                            </div>
                            <div class="modal-body">
                                <form class="form-horizontal" action="{{route('permission.p_store')}}" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">Tên nhóm quyền: </label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" name="name" style="margin-top: 5px;" required min="3" max="30">
                                        </div>

                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-12 text-right">
                                            <button type="submit" class="btn btn-success">Lưu</button>
                                        </div>
                                    </div>
                                </form>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-6 col-sm-4">
                <span class="error-message">{{ $errors->first('name') }}</span></p>
            </div>
            <div class="col-xs-12 col-sm-5">
                {{--  <form action="{{ route('permission.search') }}" method="GET">
                    @csrf
                    <div class="input-group">
                        <input type="text" class="input-sm form-control" name="nameSearch" required>
                        <span class="input-group-btn">
                            <button class="btn btn-sm btn-default" type="submit">Tìm kiếm!</button>
                        </span>
                    </div>
                </form>  --}}
            </div>
            <div class="col-sm-7">
                <span class="error-message">{{ $errors->first('namePermissionUpdate') }}</span>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead style="background: lemonchiffon;">
                    <tr>
                        <th scope="col">STT</th>
                        <th scope="col">Name</th>
                        <th scope="col">Các hoạt động có thể truy cập</th>
                        <th scope="col">Xóa</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($permissions as $key => $permission)
                        <tr>
                            <th scope="row">{{ $key + 1 }}</th>
                            <td>
                                <a href="#updateName{{ $permission->id }}" data-toggle="modal" ui-toggle-class="">
                                    <i class="fa fa-pencil-square-o text-success text-active"></i>
                                </a>
                                <div aria-hidden="true" aria-labelledby="myLabel" role="dialog" tabindex="-1"
                                    id="updateName{{ $permission->id }}" class="modal fade" style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button aria-hidden="true" data-dismiss="modal" class="close"
                                                    type="button">×</button>
                                                <h4 class="modal-title">Chỉnh sửa tên quyền</h4>
                                            </div>
                                            <div class="modal-body">
                                                <form role="form"
                                                    action="{{ route('permission.p_updatename',['id' => $permission->id]) }}"
                                                    method="POST">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label>Tên cũ</label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $permission->name }}" disabled="">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Tên cần sửa<span style="color: #ff0000">
                                                                *</span></label>
                                                        <input type="text" size="40" class="form-control"
                                                            required="required" name="namePermissionUpdate"
                                                            maxlength="255" value="{{ $permission->name }}">
                                                        <span </p>
                                                    </div>
                                                    <button type="submit" class="btn btn-default">Lưu</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{ $permission->name }}
                            </td>
                            <td>
                                @foreach($permission->peraction as $key => $peraction)
                                    {{ $peraction->permissiondetail->name }}
                                    {{ count($permission->peraction) != $key+1 ? ',' : '' }}
                                @endforeach
                            </td>
                            <td>
                                <a href="{{ route('permission.delete',['id' => $permission->id]) }}"
                                    class="btn default btn-xs red radius"
                                    onclick="return confirm('Bạn muốn xóa dữ liệu này?')">
                                    <i class="fa fa-trash-o"></i>
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
                </div>
                <div class="col-sm-7 text-right text-center-xs">
                    <ul class="pagination pagination-sm m-t-none m-b-none">
                        {{ $permissions->links() }}
                    </ul>
                </div>
            </div>
        </footer>
    </div>
    @endsection
