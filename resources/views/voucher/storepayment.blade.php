@extends('layouts')
<style>
    #infoImportCoupons_filter, #infoImportCoupons_length{
        display: none;
    }
</style>
@section('content')
<div class="form-w3layouts">
    <!-- page start-->
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Tạo phiếu chi
                </header>
                <div class="panel-body">
                    <div class="space"></div>
                    <form id="paymentVoucherForm">
                        <div class="row">
                            <div class="col-xs-6 col-sm-3">
                                <div class="form-group ">
                                    <label class="control-label">Chọn thời gian</label>
                                    <select class="form-control" id="timeReport">
                                        <option value="0">Hôm nay</option>
                                        <option value="1">Hôm qua</option>
                                        <option value="2">Tuần này</option>
                                        <option value="3">Tuần trước</option>
                                        <option value="4">Tháng này</option>
                                        <option value="5">Tháng trước</option>
                                        <option value="6">Quý này</option>
                                        <option value="7">Quý trước</option>
                                        <option value="8">Năm nay</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-3">
                                <div class="form-group ">
                                    <label class="control-label">Từ ngày:</label>
                                    <input class="date form-control" type="text" id="dateStart" required>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-3">
                                <div class="form-group ">
                                    <label class="control-label">Đến ngày:</label>
                                    <input class="date form-control" type="text" id="dateEnd" required>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-3">
                                <div class="form-group ">
                                    <label class="control-label">Chọn NCC:</label>
                                    <select class="form-control" id="idSupplier">
                                        @foreach($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}">{{ $supplier->status == '1' ? $supplier->name : $supplier->name . ' (ngưng hđ)' }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <script type="text/javascript">
                                $('.date').datepicker({
                                    format: 'yyyy-mm-dd'
                                });
                            </script>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 text-center">
                                <a href="{{ route('voucher.index') }}" class="btn btn-default">Trở về</a>
                                <button id="submitPaymentVc" class="btn green-meadow radius">Tìm kiếm</button>
                            </div>
                        </div>
                    </form>
                    <div class="grid_3 grid_5 wthree" style="padding-bottom: 0px;">
                        <div class="col-md-12 agileits-w3layouts" id="leftTable">

                        </div>
                        <div class="clearfix"> </div>
                    </div>
                    <div class="panel-body collapse" id="collapseExample">
                        <div class="position-center">
                            <form class="form-horizontal" action="{{ route('voucher.p_storepayment') }}" method="POST"
                            onsubmit="return validatePaymentVoucher()">
                                @csrf
                                <input type="hidden" name="type" value="1">
                                <div id="formPaymentVoucherSupplier">

                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </section>
        </div>
    </div>
    <!-- page end-->
</div>
    <script type="text/javascript" language="javascript" src="{{ asset('js/data.table.js') }}"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>

@endsection
