@extends('layouts')
@section('content')
<style>
    div::-webkit-scrollbar {
        width: 10px;
        background: #f1f1f1;
    }
</style>
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Phiếu Chi Bếp Khẩn Cấp
            </header>
            <div class="pannel-body">
                <div class="position-center">
                    <div class="form">
                        <form class="panel-body" role="form" onsubmit="return validateCookEmer();"
                            action="{{ route('voucher.p_storepaymentemergency') }}" method="POST">
                            @csrf
                            <div class="col-md-12">
                                <div class="row">
                                    <input type="hidden" name="type" value="0">
                                    <div class="col-md-6">
                                        <label class="control-label">Mã phiếu chi<span style="color: #ff0000">
                                                *</span></label>
                                        <div class="space"></div>
                                        <input type="text" class="form-control" name="code" value="{{ $code }}" id="codePaymentCE" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="control-label">Chọn bếp<span style="color: #ff0000">
                                                *</span></label>
                                        <div class="space"></div>
                                        <select class="form-control m-bot15" name="idCook" id="cookEmergency">
                                            @foreach($cooks as $cook)
                                                <option value="{{ $cook->id }}">{{ $cook->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-xs-6">
                                        <div class="space"></div>
                                        <label class="control-label">Lý do nhập khẩn</label>
                                        <div class="space"></div>
                                        <textarea type="text" class="form-control" rows="1" name="note" required></textarea>
                                    </div>
                                    <div class="col-xs-6">
                                        <div class="space"></div>
                                        <label class="control-label">Tổng tiền: </label>
                                        <div class="space"></div>
                                        <input type="number" min="1" name="pay_cash" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="chooseMaterial">

                            </div>
                            <div class="row">
                                <div class="col-xs-12 text-center">
                                    <a href="{{ route('voucher.index') }}" class="btn btn-default">Trở về</a>
                                    <button type="submit" class="btn green-meadow radius">Tạo phiếu</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
<script type="text/javascript">
    function clickToRemove($id) {
        var row = document.getElementById('row' + $id);
        row.remove();
    }
</script>
@endsection
