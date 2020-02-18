@extends('layouts')
@section('content')
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Phân quyền
            </div>
            <div class="portlet box green-meadow" style="margin-top: 20px;">
                    <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-coffee"></i>
                                Thêm mới quyền</div>
                        </div>
                        <div class="portlet-body">
                            <div class="row">
                            </div>
                            <div class="table-responsive">
                                <div class="form">
                                    <form class="panel-body"
                                        id="createNews-form" action="{{route('permission.p_store')}}" method="POST">
                                        @csrf
                                        <div class="row">
                                                <div class="col-md-3">
                                                    <label class="control-label"
                                                        for="">Nhập tên quyền<span style="color: #ff0000"></span></label>
                                                        <input type="text" class="form-control" name="name">
                                                        <span class="error-message">{{ $errors->first('name') }}</span></p>

                                                </div>
                                                <div class="col-md-5">
                                                    <label class="control-label"
                                                        for="">Chi tiết quyền<span style="color: #ff0000"> *</span></label>
                                                    <div class="role">
                                                        <div class="cover-role">
                                                            <div class="cover-role-title"><label class="control-label"
                                                                                for="">Chọn chi tiết<span style="color: #ff0000"></span></label> <i class="fa fa-caret-down" aria-hidden="true"></i></div>
                                                                <div class="cover-role-body" id="filters">
                                                                    <ul>
                                                                        @foreach ($permissiondetails as $permissiondetail)
                                                                            <li><input id="{{$permissiondetail->id . 'check'}}" value="{{$permissiondetail->id}}" type="checkbox" name="permissiondetail[]">
                                                                            <label style="display:inline; margin-right:10px;" for="{{$permissiondetail->id . 'check'}}">{{ $permissiondetail->name }}</label></li>
                                                                        @endforeach
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                    </div>
                                                    <span class="error-message">{{ $errors->first('permissiondetail') }}</span></p>

                                                </div>
                                                <div class="col-md-4 text-right" style=" margin: 23px 0px;">
                                                    <a class="btn grey-silver radius btn-delete text-right"
                                                        href="{{route('permission.index')}}">Hủy</a>
                                                    <input type="submit" class="btn green-meadow radius btn-w-min"
                                                        style="margin-left:10px" value="Tạo mới">
                                                </div>

                                            <div class="space"></div>
                                        </div>
                                        <div class="space"></div>
                                    </form>
                                </div>
                            </div>
                        </div>
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-coffee"></i>
                        Danh sách quyền
                    </div>
                </div>
                <div class="portlet-body">
                        {{-- <div class="row">
                                <div class="col-md-12">
                                    <a href="{{route('permission.store')}}" class="btn radius btn btn-warning btn-add"  style="margin: 10px 10px; background:orange; color:black">Thêm mới</a>
                                </div>
                        </div> --}}
                    <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">STT</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Chi tiết </th>
                                        <th scope="col"></th>
                                        <th scope="col"></th>
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
                                            <a href="{{ route('permission.delete',['id' => $permission->id])}}"  class="btn default btn-xs red radius">
                                                <i class="fa fa-trash-o"> Xóa</i>
                                            </a>
                                        </td>
                                      </tr>

                                    @endforeach
                                </tbody>
                            </table>
                            {{-- {{ $permissions->links() }} --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

