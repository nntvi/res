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
            Phiếu xuất <b>"{{ $exportCoupon->code }}"</b> - {{ $exportCoupon->created_at }}
        </div>
        <div class="table-responsive">
            <table class="table table-striped b-t b-light" id="example">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th class="text-center">Tên mặt hàng</th>
                        <th class="text-center">Số lượng xuất</th>
                        <th class="text-center">Đơn vị tính</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($exportCoupon->detailExportCoupon as $key => $item)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td class="text-center">{{ $item->materialDetail->name }}</td>
                            <td class="text-center">{{ $item->qty }}</td>
                            <td class="text-center">{{ $item->materialDetail->unit->name }}</td>
                        </tr>
                    @endforeach
                    <tfoot>
                        <tr>
                            <td colspan="2" class="bold text-center">Loại xuất : {{ $exportCoupon->typeExport->name }}</td>
                            <td colspan="2" class="bold text-center">Đối tượng xuất: {{ $objectExport }}</td>
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
                        messageTop: 'Mã phiếu xuất "{{ $exportCoupon->code }}" - Ngày xuất: {{ $exportCoupon->created_at }} ',
                        messageBottom: 'Loại xuất: {{ $exportCoupon->typeExport->name }} - Đối tượng xuất:  {{ $objectExport }} ',
                        title: 'Phiếu Xuất',
                    },
                    {
                        extend: 'pdf',
                        messageTop: 'Mã phiếu xuất "{{ $exportCoupon->code }}" - Ngày xuất: {{ $exportCoupon->created_at }} ',
                        messageBottom: 'Nhà cung cấp: {{ $exportCoupon->typeExport->name }} - Đối tượng xuất:  {{ $objectExport }} '
                    },
                    {
                        extend: 'print',
                        messageTop: 'Mã phiếu xuất "{{ $exportCoupon->code }}" - <br>Ngày xuất: {{ $exportCoupon->created_at }} ',
                        messageBottom: 'Nhà cung cấp: {{ $exportCoupon->typeExport->name }} - Đối tượng xuất:  {{ $objectExport }} ',
                        title: 'Phiếu Xuất',
                    },
                ]
            });
            $('input[type="search"]').addClass('form-control');
            $('.dt-button').addClass('btn btn-sm btn-default');
            $('.dt-button').removeClass('dt-button');
            $('div.dt-buttons').append(`<a href="{{ route('exportcoupon.index') }}"
                    class="btn btn-sm btn-default" type="button">
                    Trở về </a>`
            );
        });
    </script>
@endsection
