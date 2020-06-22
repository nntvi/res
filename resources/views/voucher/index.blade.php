@extends('layouts')
@section('content')
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            Danh sách phiếu chi
        </div>
        <div class="row w3-res-tb">
            <div class="col-sm-5 m-b-xs">
                <a href="#myModal" data-toggle="modal" class="btn btn-sm btn-default">
                    <i class="fa fa-file-text-o" aria-hidden="true"></i> Tạo phiếu chi
                </a>
                <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal"
                    class="modal fade" style="display: none;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                <h4 class="modal-title">Chọn đối tượng chi</h4>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('voucher.payment') }}" method="GET">
                                    @csrf
                                    <div class="form-group row">
                                        <div class="col-xs-5">
                                            <input type="radio" name="object" value="1">
                                            <label for="">Trả nợ nhà cung cấp</label>
                                        </div>
                                        <div class="col-xs-4">
                                            <input type="radio" name="object" value="2">
                                            <label for="">Mua gấp NVL</label>
                                        </div>
                                        <div class="col-xs-3 text-right">
                                            <button type="submit" class="btn btn-default">Chọn</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <script>
                    @if(session('success'))
                        toastr.success('{{ session('success') }}')
                    @endif
                </script>
            </div>
            <div class="col-sm-4">
                <div class="input-group">
                    <input type="text" class="input-sm form-control" id="codeSearchPaymentVc">
                    <span class="input-group-btn">
                        <button class="btn btn-sm btn-default" type="button" id="btnSearchPaymentVc">Tìm kiếm</button>
                    </span>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped b-t b-light">
                <thead>
                    <tr>
                        <th style="width:20px;">STT</th>
                        <th>Mã phiếu chi</th>
                        <th>Lý do chi</th>
                        <th>Đối tượng</th>
                        <th>Số tiền</th>
                        <th>Ghi chú</th>
                        <th>Người tạo</th>
                        <th></th>
                        <th class="text-center">Thời gian tạo</th>
                    </tr>
                </thead>
                <tbody id="bodyPaymentVc">
                    @foreach ($payments as $key => $payment)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $payment->code }}</td>
                            <td>{{ $payment->type == '1' ? 'Chi nợ NCC' : 'Mua Gấp NVL' }}</td>
                            <td>{{ $payment->name }}</td>
                            <td>{{ number_format($payment->pay_cash) . ' đ' }}</td>
                            <td>{{ $payment->note }}</td>
                            <td>{{ $payment->created_by }}</td>
                            <td>
                                @if ($payment->type == '1')

                                @else
                                    <a href="#payment{{ $payment->id }}" data-toggle="modal">
                                        <i class="fa fa-pencil text-success" aria-hidden="true"></i>
                                    </a>
                                    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="payment{{ $payment->id }}" class="modal fade" style="display: none;">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                                        <h4 class="modal-title">Chi tiết phiếu chi {{ $payment->code }}</h4>
                                                    </div>
                                                    <div class="modal-body" >
                                                        <div class="titleImportCoupon">
                                                            <div class="row bold">
                                                                <div class="col-xs-6">
                                                                    Lý do Chi: {{ $payment->type == '1' ? 'Chi nợ NCC' : 'Mua gấp NVL' }}
                                                                </div>
                                                                <div class="col-xs-6">
                                                                    Đối tượng: {{ $payment->name }} - Người tạo: {{ $payment->created_by }}
                                                                </div>
                                                            </div>
                                                            <div class="row bold">
                                                                <div class="col-xs-6">
                                                                    Tổng tiền: {{ number_format($payment->pay_cash) . ' đ' }}
                                                                </div>
                                                                <div class="col-xs-6">
                                                                    Ngày tạo: {{ $payment->created_at }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-xs-12">
                                                                <div class="bs-docs-example">
                                                                    <table class="table table-striped">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>STT</th>
                                                                                <th>Tên NVL</th>
                                                                                <th>Số lượng nhập</th>
                                                                                <th>Đơn vị tính</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @foreach ($payment->detailPaymentVc as $key => $detail)
                                                                                <tr>
                                                                                    <td>{{ $key + 1 }}</td>
                                                                                    <td>{{ $detail->detailMaterial->name }}</td>
                                                                                    <td>{{ $detail->qty }}</td>
                                                                                    <td>{{ $detail->detailMaterial->unit->name }}</td>
                                                                                </tr>
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                @endif
                            </td>
                            <td class="text-right">{{ $payment->created_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <footer class="panel-footer">
            <div class="row">
                <div class="col-sm-7 text-right text-center-xs">
                    <ul class="pagination pagination-sm m-t-none m-b-none">
                        {{ $payments->links() }}
                    </ul>
                </div>
            </div>
        </footer>
    </div>
</div>
@endsection
