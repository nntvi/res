@extends('layouts')

@section('content')
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading" style="margin-bottom: 15px">
            Các Phiếu Nhập Kho
        </div>
        <div class="table-responsive">
            <table class="table table-striped b-t b-light" id="example">
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
                            <td>{{ $import->supplier->status == '1' ? $import->supplier->name : $import->supplier->name . '( ngưng hoạt động)' }}</td>
                            <td>{{ $import->note }}</td>
                            <td>
                                @switch($import->status)
                                    @case(0)
                                        Chưa thanh toán
                                        @break
                                    @case(1)
                                        Thanh toán một phần
                                        @break
                                    @case(2)
                                        Đã thanh toán
                                    @default
                                @endswitch
                            </td>
                            <td>{{ $import->created_at }}</td>
                            <td>
                                <a href="{{ route('importcoupon.detail',['id' => $import->id]) }}" data-toggle="modal">Xem chi tiết</a>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <script>
            @if(session('success'))
                toastr.success('{{ session('success') }}')
            @endif
        </script>
        <script type="text/javascript" language="javascript" src="{{ asset('js/data.table.js') }}"></script>
        <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
        <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>
        <script>
            $(document).ready( function () {
                $('#example').dataTable();
                @foreach($listImports as $import)
                    $('#detail{{ $import->id }}').dataTable();
                    $('#detail{{ $import->id }}_length').remove();
                    $('#detail{{ $import->id }}_filter').remove();
                @endforeach
                $('#example_info').addClass('text-muted');
                $('input[type="search"]').addClass('form-control');
                $('#example_length').html(
                    `<a href="#imp" class="btn btn-sm btn-default" data-toggle="modal">
                            <i class="fa fa-tasks"></i> Tạo phiếu nhập
                    </a>
                    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="imp"
                    class="modal fade" style="display: none;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                <h4 class="modal-title">Chọn loại nhập</h4>
                            </div>
                            <div class="modal-body">
                                <form role="form" action="{{ route('importcoupon.gettype') }}"
                                    method="GET">
                                    @csrf
                                    <div class="row">
                                        <div class="radio">
                                            <div class="col-xs-5">
                                                <label>
                                                    <input type="radio" name="typeImp"
                                                        value="1">
                                                    Nhập thường
                                                </label>
                                            </div>
                                            <div class="col-xs-5">
                                                <label>
                                                    <input type="radio" name="typeImp"
                                                        value="2">
                                                    Nhập theo kế hoạch
                                                </label>
                                            </div>
                                            <div class="col-xs-2" style="margin-top: -10px">
                                                <button type="submit" class="btn btn-default">Chọn</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="space"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>`
                )
            } );
        </script>
    </div>
</div>
@endsection
