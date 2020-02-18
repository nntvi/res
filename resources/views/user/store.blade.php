@extends('layouts')
@section('content')
<div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Users
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Users</a></li>
                            <li class="breadcrumb-item"><a href="#">Thêm mới</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="portlet box green-meadow">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-gift"></i>
                        Thêm mới User</div>
                </div>
                <div class="portlet-body">
                    <div class="form">
                        <form class="panel-body" enctype="multipart/form-data" role="form"
                            id="createNews-form" action="{{ route('user.p_store')}}" method="POST">
                            @csrf
                            <div class="row margin-top">
                                <div class="form-group">
                                    <label class="col-md-3 control-label text-right">
                                        Tên <span style="color: #ff0000"> *</span>
                                    </label>
                                    <div class="col-md-6">
                                        <input type="text" size="40" class="form-control"
                                            name="name" value=""
                                             maxlength="255">
                                             <span class="error-message">{{ $errors->first('name') }}</span></p>
                                    </div>
                                </div>
                            </div>
                            <div class="row margin-top">
                                <div class="form-group">
                                        <label class="col-md-3 control-label text-right">
                                            Email <span style="color: #ff0000"> *</span>
                                        </label>
                                    <div class="col-md-6">
                                        <input type="email" size="40" class="form-control"
                                            name="email" value=""
                                            maxlength="255" value="">
                                            <span class="error-message">{{ $errors->first('email') }}</span></p>
                                    </div>
                                </div>
                            </div>
                            <div class="row margin-top">
                                    <div class="form-group">
                                            <label class="col-md-3 control-label text-right">
                                                Password <span style="color: #ff0000"> *</span>
                                            </label>
                                        <div class="col-md-6">
                                            <input type="password" size="40" class="form-control"
                                                name="password" value=""
                                                maxlength="255" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row margin-top">
                                        <div class="form-group">
                                                <label class="col-md-3 control-label text-right">
                                                    Confirm Password <span style="color: #ff0000"> *</span>
                                                </label>
                                            <div class="col-md-6 text-center">
                                                <input type="password" size="40" class="form-control"
                                                    name="password-confirm" value=""
                                                    maxlength="255" value="">
                                                    <span class="error-message">{{ $errors->first('password-confirm') }}</span></p>
                                            </div>
                                        </div>
                                </div>
                                <div class="row margin-top">
                                    <div class="form-group">
                                        <div class="col-md-12 text-center">
                                            @foreach ($permissions as $permission)
                                                <input id="{{$permission->id . 'check'}}" value="{{$permission->id}}" type="checkbox" name="permission[]">
                                                <label style="display:inline; margin-right:10px;" for="{{$permission->id . 'check'}}">{{ $permission->name }}</label>
                                            @endforeach
                                        </div>
                                        <div class="col-md-12 text-center">
                                                <span class="error-message">{{ $errors->first('permission') }}</span></p>
                                        </div>
                                    </div>
                                </div>
                            <div class="col-md-12 text-right">
                                <a class="btn grey-silver radius btn-delete text-righ"
                                    href="{{route('user.index')}}">Hủy</a>
                                <input type="submit" class="btn green-meadow radius" name="yt0"
                                    value="Thêm mới"> </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
