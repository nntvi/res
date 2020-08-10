@extends('layouts')
<style>
    #example_length{
        color: #5f5f5f;
        font-family: 'Roboto', sans-serif;
    }
</style>
@section('content')
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading" style="margin-bottom: 20px;">
            Danh sách hóa đơn
        </div>
        <div class="table-responsive">
            <table class="table table-striped b-t b-light" id="example">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Mã Bill</th>
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
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bills as $key => $bill)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $bill->code }}</td>
                            <td>
                                @foreach ($bill->tableOrdered as $table)
                                    {{ $table->table->name }} {{ count($bill->tableOrdered) > 1 ? ', ' : '' }}
                                @endforeach
                            </td>
                            <td>
                                @switch($bill->status)
                                    @case('0')
                                        Đã thanh toán
                                        @break
                                    @case('1')
                                        Chưa thanh toán
                                        @break
                                    @case('-1')
                                        Đã hủy
                                        @break
                                    @default
                                @endswitch
                            </td>
                            <td>{{ number_format($bill->total_price) . ' đ' }}</td>
                            <td>{{ number_format($bill->receive_cash) . ' đ' }}</td>
                            <td>{{ number_format($bill->excess_cash) . ' đ' }}</td>
                            <td>{{ $bill->created_by }}</td>
                            <td>{{ $bill->payer }}</td>
                            <td>{{ $bill->id_shift == null ? 'Chưa thanh toán' : $bill->shift->name }}</td>
                            <td>{{ $bill->created_at }}</td>
                            <td>{{ $bill->updated_at }}</td>
                            <td>
                                <a href="#myModal{{ $bill->id }}" data-toggle="modal" class="btn btn-xs btn-info">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1"
                                    id="myModal{{ $bill->id }}" class="modal fade" style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button aria-hidden="true" data-dismiss="modal" class="close"
                                                    type="button">×</button>
                                                <h4 class="modal-title"> Chi tiết hóa đơn "<b>{{ $bill->code }}</b>"
                                                    <a href="{{ route('bill.detail',['id' => $bill->id]) }}"><i class="fa fa-print text-danger" aria-hidden="true"></i></a>
                                                </h4>
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
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <table class="table table-bordered table-hover table">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th>Tên Món</th>
                                                                                        <th>Sl</th>
                                                                                        <th>Giá</th>
                                                                                        <th>Trạng thái</th>
                                                                                        <th>Đầu bếp</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    @foreach ($bill->orderDetail as $detail)
                                                                                        <tr>
                                                                                            <td>{{ $detail->dish->stt == '1' ? $detail->dish->name : $detail->dish->name . ' (ngưng phục vụ)' }}</td>
                                                                                            <td>{{ $detail->qty }}</td>
                                                                                            <td>{{ number_format($detail->price) . ' đ' }}</td>
                                                                                            <td>
                                                                                                @switch($detail->status)
                                                                                                    @case('-3')
                                                                                                        Kho không đủ NVL thực hiện
                                                                                                        @break
                                                                                                    @case('-1')
                                                                                                        Bếp không đủ NVL thực hiện
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
                                                                                                        Đã hủy
                                                                                                @endswitch
                                                                                            </td>
                                                                                            <td>{{ $detail->cooked_by }}</td>
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
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
    <script type="text/javascript" language="javascript" src="{{ asset('js/data.table.js') }}"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>
    <script>
        $(document).ready( function () {
            $('#example').dataTable( {
                "sPaginationType": "simple"
            } );
            $('#example_info').addClass('text-muted');
            $('input[type="search"]').addClass('form-control');
        });
    </script>
</div>
@endsection
