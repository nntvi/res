@extends('layouts')
@section('content')
<div class="form-w3layouts">
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Thay đổi password
                </header>
            </section>
            <div class="panel-body">
                <div class="position-center">
                    <div class="form-group">
                        <label>Username</label>
                        <input class="form-control" value="{{ $user->name }}" disabled>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input class="form-control" value="{{ $user->email }}" disabled>
                    </div>
                    <div class="form-group">
                        <div class="space"></div>
                        <div class="alert alert-success" role="alert">
                            Tài khoản <strong>{{ $user->name }}</strong> thay đổi mật khẩu <b>thành công</b>!
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <script>
        @if(session('success'))
            toastr.success('{{ session('success') }}')
        @endif
        @if(session('warning'))
            toastr.warning('{{ session('warning') }}')
        @endif
    </script>
</div>

@endsection
