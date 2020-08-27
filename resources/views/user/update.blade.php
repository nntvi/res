@extends('layouts')
@section('content')
<div class="form-w3layouts">
    <!-- page start-->
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Chỉnh sửa quyền truy cập
                </header>
                <div class="panel-body">
                    <form class="form-horizontal bucket-form" enctype="multipart/form-data" role="form"
                        id="createNews-form" action="{{ route('user.p_updaterole',['id' => $user->id]) }}" method="POST">
                        @csrf
                        <div class="form-group">
                                <label class="col-sm-3 control-label text-right">
                                    Username<span style="color: #ff0000"> *</span>
                                </label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="name" value="{{$user->name}}" disabled>
                                </div>
                            </div>
                            <div class="space"></div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label text-right">
                                    Email<span style="color: #ff0000"> *</span>
                                    </label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="email" value="{{$user->email}}" disabled>
                                </div>
                            </div>
                        <div class="space"></div>
                        <div class="col-lg-12">
                            <section class="panel1">
                                <header class="panel-heading" style="background:white">
                                    Quyền truy cập &nbsp;
                                    <span class="_tools pull-center">
                                        <a class="fa fa-chevron-circle-down" href="javascript:;"></a>
                                     </span>
                                </header>
                                <div class="space"></div>
                                <div class="panel-body1" style="display: block;">
                                    <div class="form-group">
                                        @foreach($permissions as $permission)
                                                <div class="col-xs-6 col-sm-3">
                                                    <label class="control-label">
                                                        {{ $permission->name }}
                                                    </label>
                                                    @foreach ($permission->peraction as $action)
                                                        @php
                                                            $temp = false;
                                                        @endphp
                                                        @foreach ($user->userper as $item)
                                                            @if ($item->id_per_detail == $action->permissiondetail->id)
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" id="{{$action->permissiondetail->id . 'check'}}"
                                                                    value="{{$action->permissiondetail->id}}" name="permissiondetail[]" checked>
                                                                    <label style="font-weight: normal">{{ $action->permissiondetail->name }}</label>
                                                                </div>
                                                                @php
                                                                    $temp = true
                                                                @endphp
                                                                @break
                                                            @endif
                                                        @endforeach
                                                        @if ($temp == false)
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" id="{{$action->permissiondetail->id . 'check'}}"
                                                                value="{{$action->permissiondetail->id}}" name="permissiondetail[]">
                                                                <label style="font-weight: normal">{{ $action->permissiondetail->name }}</label>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                        @endforeach
                                    </div>
                                </div>
                            </section>
                        </div>
                        <script>
                            $('.panel1 ._tools .fa').parents(".panel1").children(".panel-body1").slideDown(200);
                        </script>
                        <div class="form-group">
                            <div class="space"></div>
                            <div class="col-xs-12 text-center">
                                <a href="{{ route('user.index') }}" class="btn btn-default">Trở về</a>
                                <button type="submit" class="btn btn-info">Thêm mới</button>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>
    <!-- page end-->
</div>
@endsection
