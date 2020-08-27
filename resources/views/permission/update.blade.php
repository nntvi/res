@extends('layouts')
@section('content')
<div class="form-w3layouts">
    <!-- page start-->
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Cập nhật quyền
                </header>
                <div class="panel-body">
                    <div class="position-center">
                        <form class="panel-body" action="{{ route('permission.p_updatedetail',['id' => $permission->id]) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label>Tên quyền cũ</label>
                                <div class="space"></div>
                                <input type="text" size="40" class="form-control" disabled="disabled" name="oldName"
                                    id="" value="{{ $permission->name }}">
                            </div>
                            <div class="form-group">
                                <label>Cập nhật quyền <span style="color: #ff0000">*</span></label>
                                <div class="checkbox">
                                    @foreach($data as $value)
                                        <div class="col-xs-6 col-sm-3 col-md-3">
                                            @if($value['flag'] == true)
                                                <label>
                                                    <input
                                                        id="{{ $value['id'] . 'check' }}"
                                                        value="{{ $value['id'] }}" type="checkbox"
                                                        name="permissiondetail[]" checked />
                                                    {{ $value['name'] }}
                                                </label>

                                            @else
                                                <label>
                                                    <input
                                                        id="{{ $value['id'] . 'check' }}"
                                                        value="{{ $value['id'] }}" type="checkbox"
                                                        name="permissiondetail[]" />
                                                    {{ $value['name'] }}
                                                </label>

                                            @endif
                                        </div>
                                    @endforeach
                                    <span class="error-message">{{ $errors->first('permissiondetail') }}</span></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12 text-center">
                                    <div class="space"></div>
                                    <div class="space"></div>
                                    <a href="{{ route('permission.index') }}" class="btn btn-default">Trở về</a>
                                    <button type="submit" class="btn btn-info">Lưu</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>

        </div>
    </div>
    <!-- page end-->
</div>
@endsection
