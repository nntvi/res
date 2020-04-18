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
                    <form class="form-horizontal bucket-form" enctype="multipart/form-data" role="form"
                        id="createNews-form" action="{{ route('user.update',['id' => $user->id]) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label class="col-sm-3 control-label text-right">
                                Username<span style="color: #ff0000"> *</span>
                            </label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="name" value="{{ $user->name }}" min="3"
                                    max="30" required>
                            </div>
                            <span class="error-message">{{ $errors->first('name') }}</span></p>
                        </div>
                        <div class="space"></div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label text-right">
                                Email
                            </label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="email" value="{{ $user->email }}"
                                    disabled>
                            </div>
                            <span class="error-message">{{ $errors->first('email') }}</span></p>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label text-right">
                                Chức vụ: <span style="color: #ff0000"> *</span>
                            </label>
                            <div class="col-sm-6">
                                <div class="space"></div>
                                @foreach($data as $value)
                                    @if($value['flag'] == true)
                                        <div class="col-xs-6 col-sm-6 col-md-4">
                                            <input
                                                id="{{ $value['id'] . 'check' }}"
                                                value="{{ $value['id'] }}" type="checkbox"
                                                name="permission[]" checked>
                                            <label style="display:inline; margin-right:10px;"
                                                for="{{ $value['id'] . 'check' }}">{{ $value['name'] }}</label>
                                        </div>
                                    @else
                                        <div class="col-xs-6 col-sm-6 col-md-4">
                                            <input
                                                id="{{ $value['id'] . 'check' }}"
                                                value="{{ $value['id'] }}" type="checkbox"
                                                name="permission[]">
                                            <label style="display:inline; margin-right:10px;"
                                                for="{{ $value['id'] . 'check' }}">{{ $value['name'] }}</label>
                                        </div>
                                    @endif

                                @endforeach
                                <span
                                    class="error-message">{{ $errors->first('permission') }}</span>
                                </p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12 text-center">
                                <div class="space"></div>
                                <div class="space"></div>
                                <a href="{{ route('user.index') }}" class="btn btn-default">Trở về</a>
                                <button type="submit" class="btn btn-info">Thay đổi</button>
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
