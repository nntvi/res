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
                                <div style="height:500px; overflow:auto;">
                                    <table class="table table-bordered" id="material">
                                        <thead>
                                            <tr>
                                                <th>Tên mặt hàng</th>
                                                <th>Sl trong kho</th>
                                                <th>Sl cần nhập</th>
                                                <th>Đơn vị</th>
                                                <th>Tổng Giá</th>
                                                <th></th>
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
    <script type="text/javascript" language="javascript" src="{{ asset('js/data.table.js') }}"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/responsive/2.2.5/js/responsive.bootstrap4.min.js"></script>
    {{--  <script>
        $(document).ready( function () {
            $('#material').dataTable();

        } );
    </script>  --}}

@endsection
