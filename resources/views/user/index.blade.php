@extends('layouts')
@section('content')
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            Nhân viên
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-hover" id="example">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Chức vụ</th>
                        {{-- <th>Lương tháng</th> --}}
                        <th>Hoạt động</th>
                        <th>Ca</th>
                        <th width="5%"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $key => $user)
                        <tr>
                            <th>{{ $key + 1 }}</th>
                            <td>
                                <a href="#myModal{{ $user->id }}" data-toggle="modal">
                                    <i class="fa fa-pencil-square text-info" aria-hidden="true"></i>
                                </a>
                                <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1"
                                    id="myModal{{ $user->id }}" class="modal fade" style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button aria-hidden="true" data-dismiss="modal" class="close"
                                                    type="button">×</button>
                                                <h4 class="modal-title">Đổi username</h4>
                                            </div>
                                            <div class="modal-body">
                                                <form role="form" action="{{ route('user.p_updateusername',['id' => $user->id]) }}" method="POST">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label>Tên hiện tại</label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $user->name }}" disabled>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Tên mới</label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $user->name }}" name="name" required>
                                                    </div>
                                                    <button type="submit" class="btn btn-default">Cập nhật</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{ $user->name }}
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if (auth()->id() == $user->id)
                                    Admin
                                @else
                                <a href="#position{{ $user->id }}" data-toggle="modal">
                                        <i class="fa fa-pencil-square-o text-warning" aria-hidden="true"></i>
                                    </a>
                                    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1"
                                        id="position{{ $user->id }}" class="modal fade" style="display: none;">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button aria-hidden="true" data-dismiss="modal" class="close"
                                                        type="button">×</button>
                                                    <h4 class="modal-title">Thay đổi chức vụ</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <form role="form"
                                                        action="{{ route('user.p_updateposition',['id' => $user->id]) }}"
                                                        method="POST">
                                                        @csrf
                                                        <div class="form-group">
                                                            <label>Chức vụ hiện tại</label>
                                                            @if($user->position == null )
                                                                <input type="text" class="form-control"
                                                                value="Chưa có chức vụ" disabled>
                                                            @else
                                                                <input type="text" class="form-control"
                                                                value="{{ $user->position->name }}" disabled>
                                                            @endif
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Chức vụ mới</label>
                                                            <select name="position" id="" class="form-control">
                                                                @foreach ($positions as $position)
                                                                    <option value="{{ $position->id }}">{{ $position->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <button type="submit" class="btn btn-default">Cập nhật</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @if($user->position == null )
                                        Chưa có chức vụ
                                    @else
                                        {{ $user->position->name }}
                                    @endif
                                @endif

                            </td>
                            <td>
                                @if ((auth()->id() != $user->id))
                                    <a href="{{ route('user.updaterole',['id' => $user->id]) }}"
                                        class="btn btn-xs btn-success">
                                        <i class="fa fa-eye" aria-hidden="true"></i> Quyền truy cập
                                    </a>
                                @else
                                    Admin
                                @endif
                            </td>
                            <td>
                                @if ((auth()->id() == $user->id))
                                    Admin
                                @else
                                    <a
                                        href="{{ route('user.shift',['id' => $user->id]) }}">
                                        <i class="fa fa-calendar text-info" aria-hidden="true"></i>
                                    </a>
                                @endif
                            </td>
                            <td>
                                @if(auth()->id() == $user->id)

                                @else
                                    <a
                                        href="{{ route('user.delete',['id' => $user->id]) }}"><i
                                            class="fa fa-times text-danger text"
                                            onclick="return confirm('Bạn muốn xóa dữ liệu này?')"></i></a>
                                @endif
                                {{--  <a href="#myModal-1-{{ $user->id }}" data-toggle="modal">
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
                                </div>  --}}
                            </td>
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
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>    <script>
        $(document).ready( function () {
            $('#example').dataTable();
            $('#example_info').addClass('text-muted');
            $('input[type="search"]').addClass('form-control');
            $('#example_length').html(
                `<a href="{{ route('user.store') }}">
                    <button class="btn btn-sm btn-default">Thêm mới</button>
                </a>`
            )
        } );
    </script>
@endsection
