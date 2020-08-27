@extends('layouts')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Thêm mặt hàng cho kế hoạch
            </header>
            <div class="panel-body">
                <div class="position-center">
                    <form action="{{ route('importplan.p_addMore') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <div class="row">
                                <div class="col-xs-12 col-sm-6">
                                    <label>Kế hoạch nhập ngày</label>
                                    <input class="form-control" value="{{ $date }}" disabled>
                                </div>
                                <div class="col-xs-12 col-sm-6">
                                    <label>Nhà cung cấp</label>
                                    <input class="form-control" name="idSupplier" value="{{ $nameSupplier }}" disabled>
                                    <input name="id_plan" value="{{ $idPlan }}" hidden>
                                </div>
                            </div>
                        </div>
                        <div class="space"></div>
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
                                    @foreach ($temp as $key => $item)
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

                        <div class="row">
                            <div class="col-xs-12 text-center">
                                <a href="{{ route('importplan.detail',['id' => $idPlan]) }}" class="btn btn-default">Trở về</a>
                                <button type="submit" class="btn btn-danger">Lưu</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
