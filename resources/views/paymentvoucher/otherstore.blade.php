@extends('layouts')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Phiếu chi
            </header>
            <div class="panel-body">
                <div class="position-center">
                    <form action="{{ route('paymentvoucher.storeother') }}" method="GET">
                        @csrf
                        <div class="form-group row">
                            <div class="col-xs-6">
                                <label>Loại phiếu chi</label>
                                <select class="form-control" name="typePayment">
                                    @foreach($types as $type)
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-xs-6">
                                <label>Mã phiếu chi</label>
                                <input class="form-control" type="text" name="codePayment" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-xs-6">
                                <label>Người nhận</label>
                                <input class="form-control" type="text" name="receiver">
                            </div>
                            <div class="col-xs-6">
                                <label>Lý do chi</label>
                                <input class="form-control" type="text" name="content" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-xs-6">
                                <label>Nhân viên chi</label>
                                <select class="form-control" name="idUser">
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-xs-6">
                                <label>Số tiền chi</label>
                                <input class="form-control" type="number" name="money">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-xs-12 text-center">
                                <div class="space"></div>
                                <div class="space"></div>
                                <a href="{{ route('paymentvoucher.index') }}" class="btn btn-default">Trở về</a>
                                <button type="submit" class="btn btn-info">Tạo phiếu</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </section>

    </div>
</div>
@endsection
