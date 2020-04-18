@extends('layouts')
@section('content')
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            Chi tiết quyền
        </div>
        <div class="row w3-res-tb">
            <div class="col-sm-3 m-b-xs">
                <a href="{{ route('perdetail.index') }}">
                    <button class="btn btn-sm btn-info">Trở về</button>
                </a>
                <a href="#myModal-1" data-toggle="modal">
                    <button class="btn btn-sm btn-warning">Thêm mới hoạt động</button>
                </a>
                <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal-1"
                    class="modal fade" style="display: none;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                <h4 class="modal-title">Thêm mới hoạt động</h4>
                            </div>
                            <div class="modal-body">
                                <form class="form-horizontal" role="form"
                                    action="{{ route('perdetail.p_store') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">
                                            Tên
                                        </label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" name="action_name" min="3" max="30"
                                                required>
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
            </div>
            <div class="col-sm-5">
                @if($errors->any())
                    @foreach($errors->all() as $error)
                        <span class="error-message">{{ $error }}</span></p>
                    @endforeach
                @endif
            </div>
            <div class="col-sm-4">
                <form action="{{ route('perdetail.search') }}" method="GET">
                    @csrf
                    <div class="input-group">
                        <input type="text" min="1" max="100" class="input-sm form-control" name="nameSearch" required>
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-sm btn-default" type="button">Tìm kiếm</button>
                        </span>
                    </div>
                </form>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped b-t b-light">
                <thead>
                    <tr>
                        <th scope="col">STT</th>
                        <th scope="col">Action Name</th>
                        {{-- <th scope="col">Permission Name</th> --}}
                        <th scope="col">Action Code</th>
                        <th scope="col">Cập nhật</th>
                        <th scope="col">Xóa</th>
                    </tr>
                </thead>
                <tbody>
                <tbody>
                    @if($permissionDetails)
                        @foreach($permissionDetails as $key => $item)
                            <tr>
                                <th scope="row">{{ $key + 1 }}</th>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->action_code }}</td>
                                <td>
                                    <a href="#myModal{{ $item->id }}" data-toggle="modal" class="btn-sm btn-success">
                                        Cập nhật
                                    </a>
                                    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1"
                                        id="myModal{{ $item->id }}" class="modal fade" style="display: none;">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button aria-hidden="true" data-dismiss="modal" class="close"
                                                        type="button">×</button>
                                                    <h4 class="modal-title">Cập nhật chi tiết tên quyền</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <form role="form" id="createNews-form"
                                                        action="{{ route('perdetail.p_update',['id' => $item->id]) }}"
                                                        method="POST">
                                                        @csrf
                                                        <div class="form-group">
                                                            <label>Tên action cũ</label>
                                                            <input type="text" class="form-control"
                                                                value="{{ $item->name }}" disabled>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Tên action mới <span style="color: #ff0000">
                                                                    *</span></label>
                                                            <input type="text" size="40" class="form-control"
                                                                required="required" name="action_name" maxlength="255"
                                                                value="{{ $item->name }}">
                                                        </div>
                                                        <button type="submit" class="btn btn-default">Submit</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <a href="{{ route('perdetail.delete',['id' => $item->id]) }}"
                                        onclick="return confirm('Bạn muốn xóa dữ liệu này?')"
                                        class="btn default btn-xs red radius">
                                        <i class="fa fa-trash-o"> Xóa</i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection
