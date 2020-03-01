@extends('layouts')
@section('content')
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Users
            </div>
            <div class="portlet box green-meadow" style="margin-top: 20px;">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-coffee"></i>
                        Danh sách Users</div>
                </div>
                <div class="portlet-body">
                         <div class="row">
                                <div class="col-md-6">
                                    <a href="{{route('user.store')}}" class="btn radius btn btn-warning btn-add"  style="margin: 10px 10px; background:orange; color:black">Thêm mới</a>
                                </div>
                                <div class="col-md-6 ">
                                    @if (session('success'))
                                        <p class="success text-right">
                                            Thành công!!!
                                        </p>
                                    @endif
                                </div>
                        </div>

                    <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">STT</th>
                                        <th scope="col">Username</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Thuộc quyền</th>
                                        <th style="width:30px;"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $key => $user)
                                      <tr>
                                        <th scope="row">{{ $key + 1}}</th>
                                        <td>{{ $user->email}}</td>
                                        <td>{{ $user->name}}</td>
                                        <td>
                                            @foreach ($user->userper as $key => $userper)
                                                {{ $userper->permission->name }} {{ count($user->userper) != $key+1 ? ',' : '' }}
                                            @endforeach
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
                </div>
            </div>
        </div>
    </div>
@endsection

