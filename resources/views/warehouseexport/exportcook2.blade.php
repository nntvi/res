@extends('layouts')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Xuất cho Bếp
            </header>
            <div class="pannel-body">
                    <div class="form">
                        <form class="panel-body" role="form" onsubmit="return validateFormExportCook()"
                         action="{{ route('exportcoupon.p_export') }}" method="POST">
                            @csrf
                            <div class="col-md-12" style="margin-bottom: 20px">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label class="control-label">Mã phiếu xuất</label>
                                        <input type="hidden" class="form-control" name="code" value="{{ $code }}">
                                        <input class="form-control" value="{{ $code }}" disabled>
                                    </div>
                                    <div class="col-md-3">
                                        <input name="id_kind" value="1" hidden>
                                        <label class="control-label">Bếp</label>
                                        <input type="hidden" class="form-control" name="type_object" value="{{ $idObject }}">
                                        <input class="form-control" value="{{ $nameCook }}" disabled>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="control-label">Ghi chú</label>
                                        <textarea type="text" class="form-control" rows="1"
                                            name="note" value="{{ $note }}">
                                        </textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-1"></div>
                                <div class="col-xs-12 col-sm-10">
                                    <h3 class="hdg text-center">Nhập số lượng xuất cho các NVL vừa chọn</h3>
                                    <div class="table-responsive">
                                        <table class="table table-bordered b-t b-light">
                                            <thead>
                                                <tr>
                                                    <th>Tên NVL</th>
                                                    <th>Sl trong bếp</th>
                                                    <th>Sl trong kho</th>
                                                    <th>Sl cần xuất</th>
                                                    <th>Đơn vị</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody id="bodyWarehouseExportCook">
                                                @foreach ($arr as $item)
                                                    <tr id="{{ $item['idWh'] }}">
                                                        <td>
                                                            <input name="id[]" value="{{ $item['idWh'] }}" hidden>
                                                            <input name="idMaterial[]" value="{{ $item['idMaterial'] }}" hidden>
                                                            <input type="hidden" class="nameMatDet" value="{{ $item['nameMaterial'] }}">
                                                            {{ $item['nameMaterial'] }}
                                                        </td>
                                                        <td>{{ $item['qtyWhC'] }}</td>
                                                        <td>
                                                            <input type="number" name="oldQty[]" value="{{ $item['qtyWh'] }}" class="oldQty" hidden>
                                                            {{ $item['qtyWh'] }}
                                                        </td>
                                                        @if ($item['nameUnit']  == 'Kg' || $item['nameUnit']  == 'Lít')
                                                            <td><input type="number" min="0.001" step="any" class="qty form-control" name="qty[]" required></td>
                                                        @else
                                                            <td><input type="number" min="1" class="qty form-control" name="qty[]" required></td>
                                                         @endif
                                                        <td>
                                                            <input value="{{ $item['idUnit'] }}" name="id_unit[]" hidden>
                                                            {{ $item['nameUnit'] }}
                                                        </td>
                                                        <td class="text-center">
                                                            <span onclick="clickToRemove({{ $item['idWh'] }})">
                                                                <i class="fa fa-times text-danger" aria-hidden="true"></i>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="col-sm-1"></div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 text-center">
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
<script>
    function clickToRemove(id){
        document.getElementById(id).remove();
    }
</script>
@endsection
