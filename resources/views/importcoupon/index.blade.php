@extends('layouts')
@section('content')
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            Các Phiếu Nhập Kho
        </div>
        <div class="row w3-res-tb">
            <div class="col-sm-5 m-b-xs">
                <a href="{{ route('warehouse.index') }}" class="btn btn-sm btn-default">Về trang kho</a>
            </div>
            <div class="col-sm-4">
            </div>
            <div class="col-sm-3">
                <div class="input-group">
                    <input type="text" class="input-sm form-control" placeholder="Search">
                    <span class="input-group-btn">
                        <button class="btn btn-sm btn-default" type="button">Go!</button>
                    </span>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped b-t b-light">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Mã phiếu</th>
                        <th>Tổng tiền</th>
                        <th>Nhà cung cấp</th>
                        <th>Ghi chú</th>
                        <th>Trạng thái</th>
                        <th>Ngày tạo</th>
                        <th>Chi tiết</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($listImports as $key => $import)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $import->code }}</td>
                            <td>{{ number_format($import->total) . ' đ' }}</td>
                            <td>{{ $import->supplier->name }}</td>
                            <td>{{ $import->note }}</td>
                            <td>
                                {{ $import->status == "0" ? "Chưa thanh toán" : "Đã thanh toán" }}
                            </td>
                            <td>{{ $import->created_at }}</td>
                            <td>
                                <a href="#import{{ $import->id }}" data-toggle="modal">Xem chi tiết</a>
                                <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1"
                                    id="import{{ $import->id }}" class="modal fade" style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button aria-hidden="true" data-dismiss="modal" class="close"
                                                    type="button">×</button>
                                                <h4 class="modal-title">Chi tiết phiếu nhập {{ $import->code }}</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-xs-12 bold">
                                                        <i class="fa fa-building-o" aria-hidden="true"></i>
                                                        {{ $import->supplier->name }}
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xs-6 bold">
                                                        Tổng tiền:
                                                        {{ number_format($import->total) . ' đ' }}
                                                    </div>
                                                    <div class="col-xs-6 bold">
                                                        Người tạo: {{ $import->created_by }}
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xs-6 bold">
                                                        Trạng thái:
                                                        {{ $import->status == "0" ? "Chưa thanh toán" : "Đã thanh toán" }}
                                                    </div>
                                                    <div class="col-xs-6 bold">
                                                        Ngày tạo: {{ $import->created_at }}
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xs-12">
                                                        <div class="bs-docs-example">
                                                            <table class="table table-striped">
                                                                <thead>
                                                                    <tr>
                                                                        <th>STT</th>
                                                                        <th>Tên mặt hàng</th>
                                                                        <th>Số lượng nhập</th>
                                                                        <th>Đơn vị tính</th>
                                                                        <th>Giá nhập</th>
                                                                        <th style="width:30px;"></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($import->detailImportCoupon as $key => $detail)
                                                                        <form role="form" action="{{route('importcoupon.p_detail',['id' => $detail->id])}}" method="POST">
                                                                            @csrf
                                                                            <tr>
                                                                                <td>{{$key+1}}</td>
                                                                                <td>{{ $detail->materialDetail->name }}</td>
                                                                                <td>{{ $detail->qty }}</td>
                                                                                <td>{{ $detail->unit->name}}</td>
                                                                                <td><input type="number" min="0" value="{{ $detail->price }}" name="price"></td>
                                                                                <td>
                                                                                    <button type="submit"><i class="fa fa-pencil text-success"></i></button>
                                                                                </td>
                                                                            </tr>
                                                                        </form>
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
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <footer class="panel-footer">
            <div class="row">

                <div class="col-sm-5 text-center">
                    <small class="text-muted inline m-t-sm m-b-sm">showing 20-30 of 50 items</small>
                </div>
                <div class="col-sm-7 text-right text-center-xs">
                    <ul class="pagination pagination-sm m-t-none m-b-none">
                        {{ $listImports->links() }}
                    </ul>
                </div>
            </div>
        </footer>
        <script>
            @if(session('success'))
                toastr.success('{{ session('success') }}')
            @endif
        </script>
    </div>
</div>
@endsection
