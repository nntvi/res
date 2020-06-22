@extends('layouts')
@section('content')
<div class="form-w3layouts">
    <!-- page start-->
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Thay đổi password
                </header>
                <div class="panel-body">
                    <form class="form-horizontal bucket-form" enctype="multipart/form-data" role="form"
                        id="createNews-form" action="{{ route('user.p_updatepassword',['id' => $id]) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label class="col-sm-3 control-label text-right">
                                Username<span style="color: #ff0000"> *</span>
                            </label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" value="{{ $username }}" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label text-right">
                                Email<span style="color: #ff0000"> *</span>
                            </label>
                            <div class="col-sm-6">
                                <input type="email" class="form-control" value="{{ $email }}" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label text-right">
                                Password cũ <span style="color: #ff0000"> *</span>
                            </label>
                            <div class="col-sm-6">
                                <input type="password" name="oldpassword" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label text-right">
                            </label>
                            <div class="col-sm-3">
                                <label class="control-label">
                                    Password mới<span style="color: #ff0000"> *</span>
                                </label>
                                <input type="password" class="form-control" name="password" min="3" max="15" required>
                            </div>
                            <div class="col-sm-3">
                                <label class="control-label">
                                    PasswordConfirm<span style="color: #ff0000"> *</span>
                                </label>
                                <input type="password" class="form-control" name="passwordconfirm" min="3" max="15" required>
                            </div>
                        </div>
                        <div class="space"></div>
                        <div class="form-group">
                            <div class="col-xs-12 text-center">
                                <div class="space"></div>
                                <button type="submit" class="btn btn-info">Cập nhật</button>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>
    <!-- page end-->
    <script>
        @if($errors->any())
            @foreach($errors->all() as $error)
                toastr.error('{{ $error }}')
            @endforeach
        @endif
        @if(session('success'))
            toastr.success('{{ session('success') }}')
        @endif
        @if(session('info'))
            toastr.info('{{ session('info') }}')
        @endif
    </script>
</div>
@endsection
