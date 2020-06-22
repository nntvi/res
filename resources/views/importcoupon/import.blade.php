@extends('layouts')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Nhập Kho
            </header>
            <div class="pannel-body">
                <div class="position-center">
                    <div class="form">
                        <form class="panel-body" role="form" onsubmit="return validateFormImportCoupon()"
                            action="{{ route('importcoupon.p_import') }}" method="POST">
                            @csrf
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="control-label">Mã phiếu nhập<span style="color: #ff0000">
                                                *</span></label>
                                        <div class="space"></div>
                                        <input type="text" class="form-control" name="code" value="{{ $code }}"
                                            id="codeImportCoupon">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="control-label">Nhà cung cấp<span style="color: #ff0000">
                                                *</span></label>
                                        <div class="space"></div>
                                        <select class="form-control m-bot15" name="idSupplier" id="idSupplier">
                                            @foreach($suppliers as $supplier)
                                                <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="space"></div>
                                        <label class="control-label">Ghi chú</label>
                                        <div class="space"></div>
                                        <textarea type="text" size="40" class="form-control" rows="3" name="note">
                                        </textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="space"></div>
                                <div class="space"></div>
                                <div id="material">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th width=25%>Tên mặt hàng</th>
                                                <th width=15%>Sl trong kho</th>
                                                <th width=22%>Sl cần nhập</th>
                                                <th width=17%>Đơn vị tính</th>
                                                <th width=20%>Tổng Giá</th>
                                                <th width=2%></th>
                                            </tr>
                                        </thead>
                                        <tbody class="list" id="myTable">

                                        </tbody>
                                        <script type="text/javascript">
                                            function clickToRemove($id) {
                                                var row = document.getElementById('row' + $id);
                                                row.remove();
                                            }
                                        </script>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 text-center">
                                    <a href="{{ route('warehouse.index') }}" class="btn btn-default">Trở về</a>
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
    @if($errors->any())
        @foreach($errors->all() as $error)
            toastr.error('{{ $error }}')
        @endforeach
    @endif
</script>
@endsection
