@extends('layouts')
@section('content')
<div class="form-w3layouts">
    <!-- page start-->
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Thêm mới người dùng
                </header>
                <div class="panel-body">
                    <form class="form-horizontal bucket-form" enctype="multipart/form-data" role="form"
                        id="createNews-form" action="{{ route('user.p_store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label class="col-sm-3 control-label text-right">
                                Username<span style="color: #ff0000"> *</span>
                            </label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="name" min="3" max="30" required>
                                <span class="error-message">{{ $errors->first('name') }}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label text-right">
                                Email<span style="color: #ff0000"> *</span>
                            </label>
                            <div class="col-sm-6">
                                <input type="email" class="form-control" name="email" required>
                                <span class="error-message">{{ $errors->first('email') }}</span>
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label text-right">
                            </label>
                            <div class="col-sm-3">
                                <label class="control-label">
                                    Password<span style="color: #ff0000"> *</span>
                                </label>
                                <input type="password" class="form-control" name="password" min="3" max="15" required>
                            </div>
                            <div class="col-sm-3">
                                <label class="control-label">
                                    Password Confirm<span style="color: #ff0000"> *</span>
                                </label>
                                <input type="password" class="form-control" name="password-confirm" min="3" max="15" required>
                                <span
                                    class="error-message">{{ $errors->first('password-confirm') }}</span>
                            </div>
                        </div>
                        <div class="space"></div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label text-right">
                                Chức vụ
                            </label>
                            <div class="col-sm-6">
                                <select name="position" class="form-control">
                                    @foreach ($positions as $position)
                                        <option value="{{ $position->id }}">{{ $position->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="space"></div>
                        <div class="col-lg-12">
                            <section class="panel1">
                                <header class="panel-heading" style="background:white;line-height: 35px">
                                    Chọn hoạt động &nbsp;
                                    <span class="_tools pull-center">
                                        <a class="fa fa-chevron-circle-up" href="javascript:;"></a>
                                    </span>
                                    <br>
                                    <span class="error-message text-center">{{ $errors->first('permissiondetail') }}</span>
                                </header>
                                <div class="panel-body1" style="display: block;">
                                    <div class="form-group">
                                        @foreach($permissions as $permission)
                                                <div class="col-xs-6 col-sm-3">
                                                    <label class="control-label">
                                                        {{ $permission->name }}
                                                    </label>
                                                    @foreach ($permission->peraction as $action)
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" id="{{$action->permissiondetail->id . 'check'}}" value="{{$action->permissiondetail->id}}" name="permissiondetail[]">
                                                            <label style="font-weight: normal">{{ $action->permissiondetail->name }}</label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                        @endforeach
                                    </div>
                                </div>
                            </section>
                        </div>
                        <script>
                            $('.panel1 ._tools .fa').parents(".panel1").children(".panel-body1").slideUp(200);
                        </script>
                        <div class="form-group">
                            <div class="col-xs-12 text-center">
                                    <div class="space"></div>
                                    <div class="space"></div>
                                    <div class="space"></div>
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
