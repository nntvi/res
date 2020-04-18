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
                            </div>
                            <span class="error-message">{{ $errors->first('name') }}</span></p>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label text-right">
                                Email<span style="color: #ff0000"> *</span>
                            </label>
                            <div class="col-sm-6">
                                <input type="email" class="form-control" name="email" required>
                            </div>
                            <span class="error-message">{{ $errors->first('email') }}</span></p>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label text-right">
                            </label>
                            <div class="col-sm-3">
                                <label class="control-label">
                                    Password<span style="color: #ff0000"> *</span>
                                </label>
                                <input type="password" class="form-control" name="password" required>
                            </div>
                            <div class="col-sm-3">
                                <label class="control-label">
                                    Password Confirm<span style="color: #ff0000"> *</span>
                                </label>
                                <input type="password" class="form-control" name="password-confirm" required>
                                <span
                                    class="error-message">{{ $errors->first('password-confirm') }}</span>
                                </p>
                            </div>

                        </div>
                        {{--  <div class="form-group">
                            <label class="col-sm-3 control-label text-right">
                            </label>
                            <div class="col-sm-3">
                                <label class="control-label">
                                    Ca làm việc<span style="color: #ff0000"> *</span>
                                </label>
                                <select name="" id="" class="form-control">
@foreach($shifts as $shift)
                                        <option value="{{ $shift->id }}">{{ $shift->name }}</option>
                        @endforeach
                        </select>
                </div>
                <div class="col-sm-3 tex-right">
                    <label class="control-label">
                        Ngày làm việc trong tuần<span style="color: #ff0000"> *</span>
                    </label>
                    <div class="actions ">
                        <div class="btn-group full-width" style="margin: 0">
                            <a class="form-control print_view full-width" style="margin-top: 0" href="#"
                                data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                <label id="text-select">Vui lòng chọn</label>&nbsp;<i class="fa fa-angle-down"></i>
                            </a>
                            <div class="dropdown-menu hold-on-click dropdown-checkboxes pull-right full-width"
                                id="dropdown">
                                @foreach($weekdays as $item)
                                    <label>
                                        <input type="hidden" value="{{ $item->id }}" name="weekday[]">
                                        <input value="{{ $item->id }}" class="input_print" name=""
                                            type="checkbox">{{ $item->name }}
                                    </label>
                                @endforeach
                                <script>
                                    var i = 0;
                                    $('#checkall').click(function () {
                                        if (i == 0) {
                                            $('.input_print').prop('checked', true);
                                            i = 1;
                                            $('#text-select').text('Đã chọn 6');
                                        } else {
                                            $('.input_print').prop('checked', false);
                                            i = 0;
                                            $('#text-select').text('Chọn màn hình hiển thị');
                                        }
                                    });

                                    $('input[type=checkbox]').change(function () {
                                        changetext();
                                    });

                                    changetext();

                                    function changetext() {
                                        var text = '';
                                        $('.input_print:checked').each(function (index, data) {
                                            var i = index + 1;
                                            if (index < 4)
                                                text += ($(this).parent('label').text()) + ',';
                                            else
                                                text = 'Đã chọn ' + i + ' ngày   ';
                                        });
                                        if (text != '')
                                            $('#text-select').text(text.slice(0, -1));
                                    }

                                </script>
                            </div>
                        </div>
                    </div>
                </div>
                <span class="error-message">{{ $errors->first('password-confirm') }}</span>
                </p>
        </div> --}}
        <div class="form-group">
            <label class="col-sm-3 control-label text-right">
                Chức vụ: <span style="color: #ff0000"> *</span>
            </label>
            <div class="col-sm-6">
                <div class="space"></div>
                @foreach($permissions as $permission)
                    <div class="col-xs-6 col-sm-6 col-md-4">
                        <input id="{{ $permission->id . 'check' }}"
                            value="{{ $permission->id }}" type="checkbox" name="permission[]">
                        <label style="display:inline; margin-right:10px;"
                            for="{{ $permission->id . 'check' }}">{{ $permission->name }}</label>
                    </div>
                @endforeach
                <span class="error-message">{{ $errors->first('permission') }}</span></p>
            </div>
        </div>
        <hr>
        <div class="form-group">
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
