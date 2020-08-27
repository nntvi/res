@extends('layouts')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Điền chi tiết phiếu nhập
            </header>
            <div class="panel-body">
                <div class="position-center">
                    <form action="{{ route('importcoupon.p_import') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group">
                                    <label>Mã phiếu nhập</label>
                                    <input type="hidden" class="form-control" name="code" value="{{ $code }}">
                                    <input class="form-control" value="{{ $code }}" disabled>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group">
                                    <label>Ghi chú</label>
                                    <textarea name="note" rows="1" class="form-control" value="{{ $note }}"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12">
                                <div class="form-group">
                                    <label>Nhà cung cấp</label>
                                    <input type="hidden" class="form-control" name="idSupplier" value="{{ $idSupplier }}">
                                    <input class="form-control" value="{{ $nameSupplier }}" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="space"></div>
                        <div class="table-responsive">
                                <table class="table table-bordered b-t b-light">
                                    <thead>
                                        <tr>
                                            <th>Tên NVL</th>
                                            <th>Sl trong kho</th>
                                            <th>Mức tồn</th>
                                            <th>Đơn vị</th>
                                            <th>Sl nhập</th>
                                            <th>Tổng giá</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($arr as $item)
                                            <tr id="{{ $item['id'] }}">
                                                <td>
                                                    <input name="id[]" value="{{ $item['id'] }}" hidden>
                                                    <input name="idMaterial[]" value="{{ $item['idMaterial'] }}" hidden>
                                                    <input type="hidden" class="nameMat" value="{{ $item['name'] }}" >
                                                    {{ $item['name'] }}
                                                </td>
                                                @if ($item['qtyWh'] - $item['limit'] <= 0)
                                                    <td style="color:red">{{ $item['qtyWh'] }}</td>
                                                    <td style="color:red">{{ $item['limit'] }}</td>
                                                @else
                                                    <td>{{ $item['qtyWh'] }}</td>
                                                    <td>{{ $item['limit'] }}</td>
                                                @endif
                                                <td>
                                                    <input value="{{ $item['idUnit'] }}" name="id_unit[]" hidden>
                                                    {{ $item['unitName'] }}
                                                </td>
                                                @if ($item['unitName'] == "Lít" || $item['unitName'] == "Kg")
                                                    <td><input type="number" min="0.01" step="any" class="qty form-control" name="qty[]" required></td>
                                                @else
                                                    <td><input type="number" min="1"  class="qty form-control" name="qty[]" required></td>
                                                @endif
                                                <td><input type="number" min="1" class="price form-control" name="price[]" required></td>
                                                <td>
                                                    <span onclick="clickToRemove({{ $item['id'] }})" style="cursor: pointer">
                                                        <i class="fa fa-times text-danger" aria-hidden="true"></i>
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 text-center">
                                <button type="submit" class="btn green-meadow radius">Tạo phiếu</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>
<script>
    function clickToRemove(id){
        document.getElementById(id).remove();
    }
</script>
@endsection
