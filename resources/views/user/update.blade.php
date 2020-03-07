@extends('layouts')
@section('content')
<div class="form-w3layouts">
    <!-- page start-->
    <div class="row">
        <div class="col-lg-12">
                <section class="panel">
                        <header class="panel-heading">
                            Chỉnh sửa thông tin người dùng
                        </header>
                        <div class="panel-body">
                            <form class="panel-body" id="createNews-form" action="{{ route('user.p_update', ['id'=>$user->id])}}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label class="col-sm-3 control-label text-right">
                                        Username<span style="color: #ff0000"> *</span>
                                    </label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="name" value="{{$user->name}}">
                                    </div>
                                    <span class="error-message">{{ $errors->first('name') }}</span></p>
                                </div>
                                <div class="space"></div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label text-right">
                                        Email<span style="color: #ff0000"> *</span>
                                        </label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="email" value="{{$user->email}}">
                                    </div>
                                    <span class="error-message">{{ $errors->first('email') }}</span></p>
                                </div>
                                <div class="space"></div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label text-right">
                                        Chọn quyền: <span style="color: #ff0000"> *</span>
                                    </label>
                                    <div class="col-sm-6">
                                        @foreach ($data as $value)
                                            @if ($value['flag'] == true)
                                                <div class="col-xs-6 col-sm-6 col-md-4">
                                                    <input id="{{$value['id'] . 'check'}}" value="{{$value['id']}}" type="checkbox" name="permission[]" checked>
                                                    <label style="display:inline; margin-right:10px;" for="{{$value['id'] . 'check'}}">{{ $value['name'] }}</label>
                                                </div>
                                            @else
                                                <div class="col-xs-6 col-sm-6 col-md-4">
                                                    <input id="{{$value['id'] . 'check'}}" value="{{$value['id']}}" type="checkbox" name="permission[]">
                                                    <label style="display:inline; margin-right:10px;" for="{{$value['id'] . 'check'}}">{{ $value['name'] }}</label>
                                                </div>
                                            @endif

                                        @endforeach
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 text-center">
                                            <span class="error-message">{{ $errors->first('permission') }}</span></p>
                                        </div>
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
