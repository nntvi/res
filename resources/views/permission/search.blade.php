@extends('layouts')
@section('content')
<div class="mail-w3agile">
    <!-- page start-->
    <div class="row">
        <div class="col-sm-3 com-w3ls">
            <section class="panel">
                <div class="panel-body">
                    <form action="{{route('permission.p_store')}}" method="post">
                        @csrf
                        <input type="submit" class="btn btn-compose" value="Tạo mới">
                    <hr>
                    <div class="row">
                        <div class="col-xs-12 col-md-12 col-sm-12">
                            <label class="control-label"
                                for="">Nhập tên quyền<span style="color: #ff0000"></span></label>
                                <input type="text" class="form-control" name="name" style="margin-top: 5px;">
                                <span class="error-message">{{ $errors->first('name') }}</span></p>
                        </div>
                        <div class="col-xs-12 col-md-12 col-sm-12">
                            <label class="control-label"
                                for="">Chi tiết quyền<span style="color: #ff0000"> *</span>
                            </label>
                            <hr>
                            <div class="cover-role-body" id="filters">
                                <ul>
                                    @foreach ($permissiondetails as $permissiondetail)
                                        <li><input id="{{$permissiondetail->id . 'check'}}" value="{{$permissiondetail->id}}" type="checkbox" name="permissiondetail[]">
                                        <label style="display:inline; margin-right:10px;" for="{{$permissiondetail->id . 'check'}}">{{ $permissiondetail->name }}</label></li>
                                    @endforeach
                                </ul>
                            </div>
                            <span class="error-message">{{ $errors->first('permissiondetail') }}</span></p>
                        </div>
                    </div>
                    </form>
                </div>
            </section>
        </div>
        <div class="col-sm-9 mail-w3agile">
                <div class="panel panel-default">
                        <div class="panel-heading">
                          Danh sách quyền
                        </div>
                        <div class="row w3-res-tb">
                                <div class="col-sm-4 m-b-xs">
                                    <a href="{{ route('permission.index') }}" class="btn btn-sm btn-info">Trở về</a>
                                </div>
                                <div class="col-sm-4">
                                    <span
                                        class="error-message">{{ $errors->first('nameMaterial') }}</span>
                                    </p>
                                </div>
                                <div class="col-sm-4">
                                    <form action="{{ route('permission.search') }}" method="GET">
                                        @csrf
                                        <div class="input-group">
                                            <input type="text" class="input-sm form-control" name="nameSearch" required>
                                            <span class="input-group-btn">
                                                <button class="btn btn-sm btn-default" type="submit">Tìm kiếm!</button>
                                            </span>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        <div class="table-responsive">
                          <table class="table table-bordered table-hover">
                                <thead style="background: lemonchiffon;">
                                        <tr>
                                            <th scope="col">STT</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Chi tiết </th>
                                            <th scope="col">Cập nhật</th>
                                            <th scope="col">Xóa</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($permissions as $key => $permission)
                                          <tr>
                                            <th scope="row">{{ $key + 1}}</th>
                                            <td>{{ $permission->name}}</td>
                                            <td>
                                            @foreach($permission->peraction as $key => $peraction)
                                                {{ $peraction->permissiondetail->name }} {{ count($permission->peraction) != $key+1 ? ',' : '' }}
                                            @endforeach
                                            </td>
                                            <td>
                                                <a href="{{ route('permission.update', ['id' => $permission->id])}}" class="btn default btn-xs yellow-crusta radius"><i
                                                    class="fa fa-edit"> Cập nhật</i>
                                                </a>
                                            </td>
                                            <td>
                                                <a href="{{ route('permission.delete',['id' => $permission->id])}}"  class="btn default btn-xs red radius"
                                                        onclick="return confirm('Bạn muốn xóa dữ liệu này?')">
                                                    <i class="fa fa-trash-o"> Xóa</i>
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
                                      {{--  {{ $permissions->links() }}  --}}
                                    </ul>
                                  </div>
                                </div>
                        </footer>
                </div>
        </div>
    </div>

    <!-- page end-->
    </div>
@endsection
