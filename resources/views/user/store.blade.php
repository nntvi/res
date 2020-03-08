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
                                    id="createNews-form" action="{{ route('user.p_store')}}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label text-right">
                                            Username<span style="color: #ff0000"> *</span>
                                        </label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" name="name">
                                        </div>
                                        <span class="error-message">{{ $errors->first('name') }}</span></p>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label text-right">
                                            Email<span style="color: #ff0000"> *</span>
                                            </label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" name="email">
                                        </div>
                                        <span class="error-message">{{ $errors->first('email') }}</span></p>
                                    </div>

                                    <div class="form-group">
                                            <label class="col-sm-3 control-label text-right">
                                                Password<span style="color: #ff0000"> *</span>
                                            </label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="password">
                                            </div>
                                    </div>
                                    <div class="form-group">
                                            <label class="col-sm-3 control-label text-right">
                                                Password Confirm<span style="color: #ff0000"> *</span>
                                            </label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="password-confirm">
                                            </div>
                                            <span class="error-message">{{ $errors->first('password-confirm') }}</span></p>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label text-right">
                                            Chọn quyền: <span style="color: #ff0000"> *</span>
                                        </label>
                                        <div class="col-sm-6">
                                                @foreach ($permissions as $permission)
                                                <div class="col-xs-6 col-sm-6 col-md-4">
                                                    <input id="{{$permission->id . 'check'}}" value="{{$permission->id}}" type="checkbox" name="permission[]">
                                                    <label style="display:inline; margin-right:10px;" for="{{$permission->id . 'check'}}">{{ $permission->name }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <div class="col-xs-12 text-center">
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
