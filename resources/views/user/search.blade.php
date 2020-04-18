@extends('layouts')
@section('content')
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            Nhân viên
        </div>
        <div class="row w3-res-tb">
            <div class="col-sm-3 m-b-xs">
                <a href="{{ route('user.index') }}">
                    <button class="btn btn-sm btn-default">Trở về</button>
                </a>
                <a href="{{ route('user.store') }}">
                    <button class="btn btn-sm btn-danger">Thêm mới</button>
                </a>
            </div>
            <div class="col-sm-5">
                <span class="error-message">{{ $errors->first('password') }}</span></p>
                <span class="error-message">{{ $errors->first('password-confirm') }}</span></p>
            </div>
            <div class="col-sm-4">
                <form action="{{ route('user.search') }}" method="get">
                    @csrf
                    <div class="input-group">
                        <input type="text" class="input-sm form-control" name="nameSearch" required>
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-sm btn-info" type="button">Search!</button>
                        </span>
                    </div>
                </form>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr style="
                            background: #f1efef;">
                        <th scope="col">STT</th>
                        <th scope="col">Username</th>
                        <th scope="col">Email</th>
                        <th scope="col">Chức vụ</th>
                        <th>Ca làm việc</th>
                        <th width="5%"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $key => $user)
                        <tr>
                            <th>{{ $key + 1 }}</th>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @foreach($user->userper as $key => $userper)
                                    {{ $userper->permission->name }}
                                    {{ count($user->userper) != $key+1 ? ',' : '' }}
                                @endforeach
                            </td>
                            <td>
                                <a
                                    href="{{ route('user.shift',['id' => $user->id]) }}">Xem
                                    ca làm việc</a>
                            </td>
                            <td>
                                <a href="{{ route('user.update', ['id' => $user->id]) }}"
                                    class="active" ui-toggle-class=""><i
                                        class="fa fa-pencil-square-o text-success text-active"></i></a>
                                @if(auth()->id() == $user->id)

                                @else
                                    <a
                                        href="{{ route('user.delete',['id' => $user->id]) }}"><i
                                            class="fa fa-times text-danger text"
                                            onclick="return confirm('Bạn muốn xóa dữ liệu này?')"></i></a>
                                @endif
                                <a href="#myModal-1-{{ $user->id }}" data-toggle="modal">
                                    <i class="fa fa-key text-warning" aria-hidden="true"></i>
                                </a>
                                <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1"
                                    id="myModal-1-{{ $user->id }}" class="modal fade" style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button aria-hidden="true" data-dismiss="modal" class="close"
                                                    type="button">×</button>
                                                <h4 class="modal-title">Thay đổi password</h4>
                                            </div>
                                            <div class="modal-body">
                                                <form class="form-horizontal" role="form"
                                                    action="{{ route('user.p_updatepassword',['id' => $user->id]) }}"
                                                    method="POST">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label class="col-lg-2 col-sm-2 control-label">Username</label>
                                                        <div class="col-lg-10">
                                                            <input class="form-control" value="{{ $user->name }}"
                                                                disabled>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-lg-2 col-sm-2 control-label">Password</label>
                                                        <div class="col-lg-10">
                                                            <input type="password" class="form-control" name="password">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="password-confirm"
                                                            class="col-lg-2 col-sm-2 control-label">Password
                                                            Confirm</label>
                                                        <div class="col-lg-10">
                                                            <input type="password" class="form-control"
                                                                name="password-confirm">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-lg-offset-2 col-lg-10">
                                                            <button type="submit" class="btn btn-default">Lưu</button>
                                                        </div>
                                                    </div>
                                                </form>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection
