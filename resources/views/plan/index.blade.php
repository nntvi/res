@extends('layouts')
@section('content')
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading" style="margin-bottom: 20px">
            Kế hoạch nhập hàng
        </div>
        <div>
                <table id="example" class="table">
                    <thead>
                        <tr>
                            <th data-breakpoints="xs">STT</th>
                            <th>Kế hoạch ngày</th>
                            <th>Nhà cung cấp</th>
                            <th>Ghi chú</th>
                            <th data-breakpoints="xs">Trạng thái</th>
                            <th data-breakpoints="xs sm md">Chi tiết</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($plans as $key => $plan)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $plan->date_create }}</td>
                                <td>{{ $plan->supplier->name }}</td>
                                <td>{{ $plan->note == null ? '' : $plan->note }}</td>
                                @switch($plan->status)
                                    @case('0')
                                        @if ($plan->date_create < $today)
                                            <td style="color: purple"> Trễ kế hoạch</td>
                                        @else
                                            <td style="color: red">Chưa nhập hàng</td>
                                        @endif
                                        @break
                                    @case('1')
                                        <td style="color: darkgreen">Đã nhập hàng</td>
                                        @break
                                    @default
                                @endswitch
                                <td><a href="{{ route('importplan.detail',['id' => $plan->id ]) }}">Xem chi tiết</a></td>
                                @if ($plan->status == '0')
                                    <td><a href="{{ route('importplan.deleteplan',['id' => $plan->id]) }}"
                                        onclick="return confirm('Bạn muốn xóa kế hoạch này?')"><i class="fa fa-times text-danger text"></i></a></td>
                                @else
                                    <td></td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>

    </div>
</div>
<script type="text/javascript" language="javascript" src="{{ asset('js/data.table.js') }}"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>
<script>
    $(document).ready( function () {
        $('#example').dataTable();
        $('#example_info').addClass('text-muted');
        $('input[type="search"]').addClass('form-control');
        {{--  $('#example_length').html(
            `<a href="#myModal" data-toggle="modal" class="btn btn-sm btn-default">
                Thêm mới
            </a>
            <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                            <h4 class="modal-title">Thiết lập kế hoạch nhập hàng</h4>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('importplan.store') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label>Ngày nhập hàng</label>
                                    <input class="date form-control" name="dateStart" type="date" required>
                                </div>
                                <div class="form-group">
                                    <label>Nhà Cung cấp</label>
                                    <select class="form-control" name="idSupplier">
                                        @foreach ($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Ghi chú</label>
                                    <textarea id="my-textarea" class="form-control" name="note" rows="3"></textarea>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 text-center">
                                        <button type="submit" class="btn btn-default">Thiết lập</button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>`
        );  --}}
        $('#example_length').html(
            `<a href="{{ route('importplan.viewstore') }}" class="btn btn-sm btn-default">
                Thêm mới
            </a>`
        )
    } );
</script>
<script>
        @if(session('success'))
            toastr.success('{{ session('success') }}')
        @endif
        @if(session('warning'))
            toastr.warning('{{ session('warning') }}')
        @endif
</script>
@endsection
