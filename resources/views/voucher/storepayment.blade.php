@extends('layouts')
@section('content')
<div class="form-w3layouts">
    <!-- page start-->
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Phiếu chi
                </header>
                <div class="panel-body">
                    <script>
                        @if($errors->any())
                            @foreach($errors->all() as $error)
                                toastr.error('{{ $error }}')
                            @endforeach
                        @endif
                    </script>
                    <div class="space"></div>
                    <form id="paymentVoucherForm">
                        <div class="row">
                            <div class="col-xs-6 col-sm-3">
                                <div class="form-group ">
                                    <label class="control-label">Báo cáo theo</label>
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
                                    <input class="date form-control" type="text" id="dateStart">
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-3">
                                <div class="form-group ">
                                    <label class="control-label">Đến ngày:</label>
                                    <input class="date form-control" type="text" id="dateEnd">
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-3">
                                <div class="form-group ">
                                    <label class="control-label">Chọn NCC:</label>
                                    <select class="form-control" id="idSupplier">
                                        @foreach($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <script type="text/javascript">
                                $('.date').datepicker({
                                    format: 'yyyy-mm-dd'
                                });

                                function validateForm() {
                                    var dateStart = document.getElementById('dateStart').value;
                                    var dateEnd = document.getElementById('dateEnd').value;

                                    if (dateStart == null || dateStart == "") {
                                        alert("Không để trống ngày bắt đầu");
                                        return false;
                                    }
                                    if (dateEnd == null || dateEnd == "") {
                                        alert("Không để trống ngày kết thúc");
                                        return false;
                                    }
                                    return true;
                                }

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
@endsection
