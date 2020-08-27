@extends('layouts')
<style>
    .dt-buttons {
        margin-left: 10px;
    }
</style>
@section('content')
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            Phiếu nhập <b>"{{ $importCoupon->code }}"</b> - {{ $importCoupon->created_at }}
        </div>

        <div class="table-responsive">
            <table class="table table-striped b-t b-light" id="example">
                <thead>
                    <tr>
                        <th>Stt</th>
                        <th>Tên mặt hàng</th>
                        <th>Số lượng nhập</th>
                        <th>Đơn vị</th>
                        <th class="text-right">Tổng giá nhập</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($importCoupon->detailImportCoupon as $key => $item)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $item->materialDetail->name }}</td>
                            <td>{{ $item->qty }}</td>
                            <td>{{ $item->unit->name }}</td>
                            <td class="text-right">{{ number_format($item->price) . ' đ' }}</td>
                        </tr>
                    @endforeach
                    <tfoot>
                        <tr>
                            <td colspan="3" class="bold text-center">Nhà cung cấp: {{ $importCoupon->supplier->name }}</td>
                            <td class="bold">TỔNG: </td>
                            <td class="bold text-right">{{ number_format($importCoupon->total) . ' đ' }}</td>
                        </tr>
                    </tfoot>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript" language="javascript" src="{{ asset('js/data.table.js') }}"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>

    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.flash.min.js"></script>

    <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#example').DataTable( {
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        messageTop: 'Mã phiếu nhập "{{ $importCoupon->code }}" - Ngày nhập: {{ $importCoupon->created_at }} ',
                        messageBottom: 'Nhà cung cấp: {{ $importCoupon->supplier->name }} - Tổng tiền: {{ number_format($importCoupon->total) . ' đ' }} ',
                        title: 'Phiếu Nhập',
                    },
                    {
                        extend: 'pdf',
                        messageTop: 'Mã phiếu nhập "{{ $importCoupon->code }}" - Ngày nhập: {{ $importCoupon->created_at }} ',
                        messageBottom: 'Nhà cung cấp: {{ $importCoupon->supplier->name }} - Tổng tiền: {{ number_format($importCoupon->total) . ' đ' }} ',
                    },
                    {
                        extend: 'print',
                        header: 'oo',
                        messageTop: 'Mã phiếu nhập "{{ $importCoupon->code }}" - <br>Ngày nhập: {{ $importCoupon->created_at }} ',
                        messageBottom: 'Nhà cung cấp: {{ $importCoupon->supplier->name }} - <br> Tổng tiền: {{ number_format($importCoupon->total) . ' đ' }} ',
                        title: 'Phiếu Nhập',
                    },
                ]
            });
            $('input[type="search"]').addClass('form-control');
            $('.dt-button').addClass('btn btn-sm btn-default');
            $('.dt-button').removeClass('dt-button');
            $('div.dt-buttons').append(`<a href="{{ route('importcoupon.index') }}"
                    class="btn btn-sm btn-default" type="button">
                    Trở về </a>`
            );
        });
    </script>
@endsection
