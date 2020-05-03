@extends('layouts')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Tạo phiếu chi
            </header>
            <div class="panel-body">
                <div class="position-center">
                    <form role="form">
                        <div class="form-group row">
                            <div class="col-xs-6">
                                <label>Mã phiếu chi</label>
                                <input type="text" class="form-control" max="30" min="3" required>
                            </div>
                            <div class="col-xs-6" id="supplier">
                                <label>Tên nhà cung cấp</label>
                                <select class="form-control" name="supplier" id="supplierPayment">
                                    @foreach($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="space"></div>
                            <div class="col-md-12">
                                <label>Danh sách những phiếu nhập còn nợ NCC</label>
                                <div class="space"></div>
                                <div id="material">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th width="25%">Ngày nhập hàng</th>
                                                <th width="15%">Mã phiếu nhập</th>
                                                <th width="22%">Tổng tiền</th>
                                                <th width="17%">Tiền phải trả</th>
                                                <th width="2%"></th>
                                            </tr>
                                        </thead>
                                        <tbody id="tablePayment">

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
                        </div>
                        <div class="form-group row">
                            <div class="col-xs-12 text-center">
                                <a href="{{ route('paymentvoucher.index') }}" class="btn btn-default">Trở về</a>
                                <button type="submit" class="btn btn-info">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </section>
    </div>
</div>
@endsection
