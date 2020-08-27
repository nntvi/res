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
                        <form class="panel-body" role="form"
                            action="{{ route('voucher.p_storepaymentemergencytemp') }}" method="POST">
                            @csrf
                            <div class="col-md-12">
                                <div class="row">
                                    <input type="hidden" name="type" value="0">
                                    <div class="col-md-6">
                                        <label class="control-label">Mã phiếu chi</label>
                                        <div class="space"></div>
                                        <input type="hidden" class="form-control" name="code" value="{{ $code }}">
                                        <input class="form-control" value="{{ $code }}" disabled>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="control-label">Chọn bếp</label>
                                        <div class="space"></div>
                                        <input type="hidden" class="form-control" name="type" value="0">
                                        <input type="hidden" class="form-control" name="idCook" value="{{ $idCook }}">
                                        <input class="form-control" value="{{ $nameCook }}" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-xs-6">
                                        <div class="space"></div>
                                        <label class="control-label">Lý do nhập khẩn</label>
                                        <div class="space"></div>
                                        <textarea type="text" class="form-control" rows="1" name="note" required>{{ $note }}</textarea>
                                    </div>
                                    <div class="col-xs-6">
                                        <div class="space"></div>
                                        <label class="control-label">Tổng tiền: </label>
                                        <div class="space"></div>
                                        <input type="number" min="1" name="pay_cash" value="{{ $pay_cash }}" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="space"></div>
                                <div class="table-responsive">
                                    <table class="table table-striped b-t b-light">
                                        <thead>
                                            <tr>
                                                <th>Tên mặt hàng</th>
                                                <th>Sl hiện tại</th>
                                                <th>Sl thêm</th>
                                                <th>Đơn vị</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($arrEmer as $item)
                                                <tr id="{{ $item['idMat'] }}">
                                                    <td>
                                                        <input type="hidden" name="idMaterialDetail[]" value="{{ $item['idMat'] }}">
                                                        {{ $item['nameMat'] }}
                                                    </td>
                                                    <td>{{ $item['qty'] }}</td>
                                                    @if ($item['nameUnit'] == "Kg" || $item['nameUnit'] == "Lít")
                                                        <td><input type="number" class="form-control" name="qty[]" step="any" min="0.001" required></td>
                                                    @else
                                                        <td><input type="number" class="form-control" name="qty[]" min="1" required></td>
                                                    @endif
                                                    <td>{{ $item['nameUnit'] }}</td>
                                                    <td>
                                                        <span class="input-group-btn" onclick="clickToRemove({{ $item['idMat'] }})">
                                                            <button class="btn btn-xs btn-danger" type="button"><i class="fa fa-times" aria-hidden="true"></i></button>
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        </table>
                                </div>
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
    function clickToRemove(id) {
        document.getElementById(id).remove();
    }
</script>
@endsection
