@extends('layouts')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Thêm mới kế hoạch
            </header>
            <div class="panel-body">
                <form action="{{ route('importplan.store2') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <div class="row">
                            <div class="col-xs-6 col-sm-4">
                                <label>Ngày nhập hàng</label>
                                <input class="form-control" value="{{ $date }}" disabled>
                                <input name="dateStart" value="{{ $date }}" hidden>
                            </div>
                            <div class="col-xs-6 col-sm-4">
                                <label>Nhà cung cấp</label>
                                <input class="form-control" name="idSupplier" value="{{ $nameSupplier }}" disabled>
                                <input name="idSupplier" value="{{ $idSupplier }}" hidden>
                            </div>
                            <div class="col-xs-12 col-sm-4">
                                <label>Ghi chú</label>
                                <textarea id="my-textarea" class="form-control" name="note" rows="1" value="{{ $note }}">{{ $note }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="space"></div>
                    <div class="position-center">
                        <h3 class="hdg text-center">Nhập số lượng cho các mặt hàng vừa chọn</h3>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Tên NVL</th>
                                    <th>Đơn vị</th>
                                    <th>Số lượng nhập</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($arrMaterial as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            <input type="hidden" name="idMaterial[]" value="{{ $item['id'] }}">
                                            {{ $item['name'] }}
                                        </td>
                                        <td>{{ $item['unit'] }}</td>
                                        <td>
                                            <input type="number" name="qty[]" min="1" class="form-control" required>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 text-center">
                            <a href="{{ route('importplan.index') }}" class="btn btn-default">Trở về</a>
                            <button type="submit" class="btn btn-danger">Lưu</button>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
</div>
@endsection
