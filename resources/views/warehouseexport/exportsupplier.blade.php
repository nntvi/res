@extends('layouts')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Xuất Trả hàng cho nhà cung cấp
            </header>
            <div class="pannel-body">
                    <div class="form">
                        <form class="panel-body" role="form" onsubmit="return validateFormExportSupplier()"
                        action="{{ route('exportcoupon.p_exportSupplier') }}" method="POST">
                            @csrf
                            <div class="col-md-12" style="margin-bottom: 20px">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label class="control-label">Mã phiếu xuất<span style="color: #ff0000"> *</span></label>
                                        <div class="space"></div>
                                        <input type="text" class="form-control" name="code" maxlength="200" id="codeExportSupplier" value="{{ $code }}"  required>

                                    </div>
                                    <div class="col-md-3">
                                        <input name="id_kind" value="2" hidden>
                                        <label class="control-label">Chọn NCC<span style="color: #ff0000"> *</span></label>
                                        <div class="space"></div>
                                        <select class="form-control m-bot15" name="type_object" id="objectSupplier">
                                            @foreach ($suppliers as $supplier)
                                                <option value="{{$supplier->id}}">{{$supplier->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="control-label">Phiếu nhập thuộc nhà cung cấp vừa chọn </label>
                                        <div class="space"></div>
                                        <select name="" id="importCoupons" class="form-control">

                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                        <div class="col-md-6 col-xs-12">

                                        </div>
                                        <div class="col-md-6 col-xs-12">
                                            <div class="space"></div>
                                            <label class="control-label">Lý do trả </label>
                                            <div class="space"></div>
                                            <textarea class="form-control" name="note" rows="2" required></textarea>
                                        </div>
                                    </div>
                            </div>
                            <div class="grid_3 grid_5 wthree">
                                <div class="col-md-12" id="tableMaterialExportSupplier">
                                    <div class="space"></div>
                                </div>
                                <script>
                                    function clickToRemove($id){
                                        var row = document.getElementById('row'+$id);
                                        row.remove();
                                    }

                                </script>
                               <div class="clearfix"> </div>
                            </div>
                            <div class="col-xs-12 text-center" id="submit">

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
