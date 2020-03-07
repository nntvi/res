@extends('layouts')
@section('content')
<div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
            Responsive Table
            </div>
            <div class="row w3-res-tb">
            <div class="col-sm-5 m-b-xs">
                <a href="{{route('user.store')}}">
                    <button class="btn btn-sm btn-default">Thêm mới</button>
                </a>


            </div>
            <div class="col-sm-4">
                    <span class="error-message">{{ $errors->first('password') }}</span></p>
                    <span class="error-message">{{ $errors->first('password-confirm') }}</span></p>
                    @if (session('success'))
                        <span class="success">Thay đổi password thành công</span>
                    @endif
            </div>
            <div class="col-sm-3">
                <div class="input-group">
                <input type="text" class="input-sm form-control" placeholder="Search">
                <span class="input-group-btn">
                    <button class="btn btn-sm btn-default" type="button">Search!</button>
                </span>
                </div>
            </div>
            </div>
            <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr style="
                            background: #242424;">
                                <th scope="col">STT</th>
                                <th scope="col">Username</th>
                                <th scope="col">Email</th>
                                <th scope="col">Thuộc quyền</th>
                                <th>Đổi mật khẩu</th>
                                <th style="width:30px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $key => $user)
                              <tr>
                                <th scope="row">{{ $key + 1}}</th>
                                <td>{{ $user->name}}</td>
                                <td>{{ $user->email}}</td>
                                <td>
                                    @foreach ($user->userper as $key => $userper)
                                        {{ $userper->permission->name }} {{ count($user->userper) != $key+1 ? ',' : '' }}
                                    @endforeach
                                </td>
                                <td>
                                    <a href="#myModal-1-{{$user->id}}" data-toggle="modal" class="btn btn-warning">
                                        Đổi password
                                    </a>
                                    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal-1-{{$user->id}}" class="modal fade" style="display: none;">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                                    <h4 class="modal-title">Thay đổi password</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <form class="form-horizontal" role="form" action="{{route('user.p_updatepassword',['id' => $user->id])}}" method="POST">
                                                        @csrf
                                                        <div class="form-group">
                                                            <label class="col-lg-2 col-sm-2 control-label">Password</label>
                                                            <div class="col-lg-10">
                                                                <input type="password" class="form-control" name="password">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="password-confirm" class="col-lg-2 col-sm-2 control-label">Password Confirm</label>
                                                            <div class="col-lg-10">
                                                                <input type="password" class="form-control" name="password-confirm" >
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
                                <td>
                                    <a href="{{ route('user.update', ['id' => $user->id])}}" class="active" ui-toggle-class=""><i
                                                class="fa fa-pencil-square-o text-success text-active"></i></a>
                                    <a href="{{ route('user.delete',['id' => $user->id])}}" ><i class="fa fa-times text-danger text"
                                        onclick="return confirm('Bạn muốn xóa dữ liệu này?')"></i></a>
                                </td>
                              </tr>
                              @endforeach
                        </tbody>
                    </table>
            </div>
            <footer class="panel-footer">
            <div class="row">

                <div class="col-sm-5 text-center">
                <small class="text-muted inline m-t-sm m-b-sm">showing 20-30 of 50 items</small>
                </div>
                <div class="col-sm-7 text-right text-center-xs">
                <ul class="pagination pagination-sm m-t-none m-b-none">
                    <li><a href=""><i class="fa fa-chevron-left"></i></a></li>
                    <li><a href="">1</a></li>
                    <li><a href="">2</a></li>
                    <li><a href="">3</a></li>
                    <li><a href="">4</a></li>
                    <li><a href=""><i class="fa fa-chevron-right"></i></a></li>
                </ul>
                </div>
            </div>
            </footer>
        </div>
    </div>
@endsection

