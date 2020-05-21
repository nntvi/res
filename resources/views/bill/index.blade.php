@extends('layouts')
@section('content')
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            Danh sách hóa đơn
        </div>
        <div class="row w3-res-tb">
            <div class="col-sm-5 m-b-xs">
                <form action="{{ route('bill.filter') }}" method="get">
                    @csrf
                    <select class="input-sm form-control w-sm inline v-middle" name="typeFilter">
                        <option value="0">Theo ngày</option>
                        <option value="1">Theo giá</option>
                        <option value="2">Theo ca</option>
                    </select>
                    <button class="btn btn-sm btn-default" type="submit">Sắp xếp</button>
                </form>
            </div>
            <div class="col-sm-3">
            </div>
            <div class="col-sm-4">
                <form action="{{ route('bill.search') }}" method="get">
                    @csrf
                    <div class="input-group">
                        <input type="text" class="input-sm form-control" name="searchBill" required>
                        <span class="input-group-btn">
                            <button class="btn btn-sm btn-default" type="submit">Tìm kiếm!</button>
                        </span>
                    </div>
                </form>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped b-t b-light">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Số HĐ</th>
                        <th>Bàn</th>
                        <th>Trạng thái</th>
                        <th>Tổng giá</th>
                        <th>Khách đưa</th>
                        <th>Hoàn lại</th>
                        <th>Tạo bởi</th>
                        <th>Thanh toán bởi</th>
                        <th>Ca</th>
                        <th>Tạo lúc</th>
                        <th>Thanh toán lúc</th>

                    </tr>
                </thead>
                <tbody id="tableBill">
                    @foreach($bills as $key => $bill)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $bill->id }}</td>
                            <td>{{ $bill->id_table }}</td>
                            <td>{{ $bill->status == '0' ? 'Đã thanh toán' : 'Chưa thanh toán' }}</td>
                            <td>{{ number_format($bill->total_price) . ' đ' }}</td>
                            <td>{{ number_format($bill->receive_cash) . ' đ' }}</td>
                            <td>{{ number_format($bill->excess_cash) . ' đ' }}</td>
                            <td>{{ $bill->created_by }}</td>
                            <td>{{ $bill->payer }}</td>
                            <td>
                                {{ $bill->id_shift == null ? 'Chưa thanh toán' : $bill->shift->name }}</td>
                            <td>{{ $bill->created_at }}</td>
                            <td>{{ $bill->updated_at }}</td>
                            <td>
                                <a href="#myModal{{ $bill->id }}" data-toggle="modal"
                                    class="btn btn-xs btn-info">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1"
                                    id="myModal{{ $bill->id }}" class="modal fade" style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button aria-hidden="true" data-dismiss="modal" class="close"
                                                    type="button">×</button>
                                                <h4 class="modal-title"> Chi tiết hóa đơn số {{ $bill->id }}</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-12" style="margin-bottom: 15px;">
                                                            <div class="col-md-6 bold">
                                                                Tổng giá : <span> {{ number_format($bill->total_price) . ' đ' }}</span>
                                                            </div>
                                                            <div class="col-md-6 bold">
                                                                Thời gian vào : <span>{{ $bill->created_at }}</span>
                                                            </div>
                                                            <div class="col-md-6 bold">
                                                                    Người thanh toán : <span>{{ $bill->payer }}</span>
                                                                </div>
                                                            <div class="col-md-6 bold">
                                                                Thời gian ra : <span>{{ $bill->updated_at }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12" style="margin-bottom: 0;">
                                                            <div class="portlet box ">
                                                                <div class="portlet-body">
                                                                    <div class="">
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <table
                                                                                    class="table table-bordered table-hover table">
                                                                                    <thead>
                                                                                        <tr>
                                                                                            <th>Tên Món</th>
                                                                                            <th>Số lượng</th>
                                                                                            <th>Giá</th>
                                                                                            <th>Trạng thái</th>
                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                        @foreach ($bill->orderDetail as $detail)
                                                                                            <tr>
                                                                                                <td>{{ $detail->dish->name }}</td>
                                                                                                <td>{{ $detail->qty }}</td>
                                                                                                <td>{{ number_format($detail->price) . ' đ' }}</td>
                                                                                                <td>
                                                                                                    @switch($detail->status)
                                                                                                        @case('-1')
                                                                                                            Không đủ NVL thực hiện
                                                                                                            @break
                                                                                                        @case('0')
                                                                                                            Chưa thực hiện
                                                                                                            @break
                                                                                                        @case('1')
                                                                                                            Đang thực hiện
                                                                                                            @break
                                                                                                        @case('2')
                                                                                                            Hoàn thành
                                                                                                            @break
                                                                                                        @default
                                                                                                    @endswitch
                                                                                                </td>
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
                    <small class="text-muted inline m-t-sm m-b-sm">showing 1-5 bills </small>
                </div>
                <div class="col-sm-7 text-right text-center-xs">
                    <ul class="pagination pagination-sm m-t-none m-b-none">
                        {{ $bills->links() }}
                    </ul>
                </div>
            </div>
        </footer>
    </div>
</div>
@endsection
