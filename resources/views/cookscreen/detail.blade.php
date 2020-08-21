@extends('layouts')
@section('content')
<div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                {{ $cook->name }}
            </div>

            <div class="table-responsive">
            <table class="table table-striped b-t b-light" id="example">
                <thead>
                    <tr>
                        <th>Bàn</th>
                        <th>Tên món</th>
                        <th>Sl</th>
                        <th>Ghi chú</th>
                        <th>Thời gian</th>
                        <th>Trạng thái</th>
                        <th class="text-center">Cập nhật</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($data as $key => $dish)
                    <tr>
                        <td>
                            @foreach ($dish->order->tableOrdered as $table)
                                {{ $table->table->name }}
                                {{ count($dish->order->tableOrdered) > 1 ? ', ' : '' }}
                            @endforeach
                        </td>
                        <td>{{ $dish->dish->name }}</td>
                        <td>{{ $dish->qty }}</td>
                        <td>{{ $dish->note }}</td>
                        <td>{{ $dish->created_at }}</td>
                        <td>
                            @switch($dish->status)
                                @case(0)
                                    Chưa xem xét
                                    @break
                                @case(1)
                                    Đang thực hiện
                                    @break
                                @default
                            @endswitch
                        </td>
                        <td class="text-center">
                            {{-- món chưa làm  --}}
                            @if ($dish->status == 0)
                                <a href="#myModal{{ $dish->id }}" data-toggle="modal" class="btn btn-xs btn-danger checkNVL" id="{{ $dish->id }}">
                                    Xem xét
                                </a>
                                <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal{{ $dish->id }}" class="modal fade" style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                                <h4 class="modal-title text-left">Xem xét NVL thực hiện món {{ $dish->dish->name }} -
                                                    @foreach ($dish->order->tableOrdered as $item)
                                                        {{ $item->table->name }}
                                                        {{ count($dish->order->tableOrdered) > 1 ? ',' : '' }}
                                                    @endforeach
                                                </h4>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{route('cook_screen.p_update',['id' => $dish->id,'idCook' => $cook->id])}}" method="post">
                                                    @csrf
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>STT</th>
                                                                <th>Tên NVL</th>
                                                                <th>SL Công thức</th>
                                                                <th>SL Đặt</th>
                                                                <th>Cần</th>
                                                                <th>SL Trong bếp</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($dish->dish->material->materialAction as $key => $item)
                                                                <tr>
                                                                        <td>{{ $key + 1 }}</td>
                                                                        <td>{{ $item->materialDetail->name }} ({{ ($item->unit->name) }})</td>
                                                                        <td>{{ $item->qty }}</td>
                                                                        <td>{{ $dish->qty }}</td>
                                                                        <td>{{ $item->qty * $dish->qty }}</td>
                                                                        @foreach ($materials as $material)
                                                                            @if ($material->id_material_detail == $item->materialDetail->id)
                                                                                @if ($material->qty < $item->qty * $dish->qty)
                                                                                    <td style="color:red">{{ $material->qty }}</td>
                                                                                @else
                                                                                    <td>{{ $material->qty }}</td>
                                                                                @endif
                                                                                @break
                                                                            @endif
                                                                        @endforeach
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                    <div class="row">
                                                        <div class="col-xs-4 form-group">
                                                            <label>SL món có thể thực hiện</label>
                                                            <input id="qtyOrder{{ $dish->id }}" name="qtyOrder" hidden>
                                                            <input class="form-control" id="DqtyOrder{{ $dish->id }}" disabled>
                                                        </div>
                                                        <div class="col-xs-4 form-group">
                                                        <label>Bếp thiếu</label>
                                                            <input id="qtyEmptyCook{{ $dish->id }}" name="qtyEmptyCook" hidden>
                                                            <input class="form-control" id="DqtyEmptyCook{{ $dish->id }}" disabled>
                                                        </div>
                                                        <div class="col-xs-4 form-group">
                                                            <label>Kho thiếu</label>
                                                            <input id="qtyEmptyWh{{ $dish->id }}" name="qtyEmptyWh" hidden>
                                                            <input class="form-control" id="DqtyEmptyWh{{ $dish->id }}" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xs-12 text-center">
                                                            <button type="submit" class="btn btn-default">Tiến hành thực hiện</button>
                                                        </div>
                                                    </div>
                                                </form>
                                        </div>
                                    </div>
                                </div>
                            {{--  cập nhật để báo làm xong  --}}
                            @else
                                {{--  nếu có ghi chú => có cập nhật số lượng  --}}
                                @if ($dish->note != null)
                                    <a href="#finish{{ $dish->id }}" data-toggle="modal" class="btn btn-xs btn-warning">
                                        Cập nhật
                                    </a>
                                    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="finish{{ $dish->id }}" class="modal fade" style="display: none;">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                                    <h4 class="modal-title text-left">Xem xét NVL thực hiện món {{ $dish->dish->name }} -
                                                        @foreach ($dish->order->tableOrdered as $item)
                                                            {{ $item->table->name }}
                                                            {{ count($dish->order->tableOrdered) > 1 ? ',' : '' }}
                                                        @endforeach
                                                    </h4>
                                                </div>
                                                <div class="modal-body">
                                                    @if ($dish->note != null)
                                                        <div class="alert alert-xs alert-info text-left" role="alert">
                                                            Ghi chú: <strong>{{ $dish->note }}</strong>
                                                            </div>
                                                    @endif
                                                    <form action="{{ route('cook_screen.updatefinish',['id' => $dish->id,'idCook' => $cook->id]) }}" method="post">
                                                        @csrf
                                                        <table class="table table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th>STT</th>
                                                                    <th>Tên NVL</th>
                                                                    <th>Công thức</th>
                                                                    <th>SL Đặt</th>
                                                                    <th>Cần</th>
                                                                    <th>Chỉnh sửa</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @if ($dish->note != null)
                                                                    @foreach ($dish->dish->material->materialAction as $key => $item)
                                                                        <tr>
                                                                            <td>{{ $key + 1 }}</td>
                                                                            <td>
                                                                                <input type="hidden" name="idMaterialDetail[]" value="{{ $item->materialDetail->id }}">
                                                                                {{ $item->materialDetail->name }} ({{ ($item->unit->name) }})
                                                                            </td>
                                                                            <td>
                                                                                <input type="hidden" name="qtyMethod[]" value="{{ $item->qty }}">
                                                                                {{ $item->qty }}
                                                                            </td>
                                                                            <td>{{ $dish->qty }}</td>
                                                                            <td>{{ $item->qty * $dish->qty }}</td>
                                                                            <td>
                                                                                @if ($item->unit->id == 16)
                                                                                    <input type="hidden" name="qtyReal[]" value="{{ $dish->qty }}">
                                                                                    <input value="{{ $dish->qty }}" disabled>
                                                                                @else
                                                                                    <input type="number" name="qtyReal[]" min="0" max="{{ $dish->qty * 2 }}" value="{{ $dish->qty }}" required>
                                                                                @endif
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                @else
                                                                    @foreach ($dish->dish->material->materialAction as $key => $item)
                                                                        <tr>
                                                                            <td>{{ $key + 1 }}</td>
                                                                            <td>
                                                                                <input type="hidden" name="idMaterialDetail[]" value="{{ $item->materialDetail->id }}">
                                                                                {{ $item->materialDetail->name }} ({{ ($item->unit->name) }})
                                                                            </td>
                                                                            <td>
                                                                                <input type="hidden" name="qtyMethod[]" value="{{ $item->qty }}">
                                                                                {{ $item->qty }}
                                                                            </td>
                                                                            <td>{{ $dish->qty }}</td>
                                                                            <td>{{ $item->qty * $dish->qty }}</td>
                                                                            <td>
                                                                                @if ($item->unit->id == 16)
                                                                                    <input type="hidden" name="qtyReal[]" value="{{ $dish->qty }}">
                                                                                    {{ $dish->qty }}
                                                                                @else
                                                                                    <input type="hidden" name="qtyReal[]" min="0" max="{{ $dish->qty * 2 }}" value="{{ $dish->qty }}">
                                                                                    {{ $dish->qty }}
                                                                                @endif
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                @endif
                                                            </tbody>
                                                        </table>
                                                        <div class="row">
                                                            <div class="col-xs-12 text-center">
                                                                <button type="submit" class="btn btn-default">Hoàn thành</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                {{--  ko có ghi chú => click vào button chọn hoàn thành  --}}
                                    <form action="{{ route('cook_screen.updatefinish',['id' => $dish->id,'idCook' => $cook->id]) }}" method="post">
                                        @csrf
                                        @foreach ($dish->dish->material->materialAction as $key => $item)
                                            <input type="hidden" name="idMaterialDetail[]" value="{{ $item->materialDetail->id }}">
                                            <input type="hidden" name="qtyMethod[]" value="{{ $item->qty }}">
                                            <input type="hidden" name="qtyReal[]" min="0" max="{{ $dish->qty * 2 }}" value="{{ $dish->qty }}">
                                        @endforeach
                                        <button type="submit" class="btn btn-xs btn-success">Hoàn thành</button>
                                    </form>
                                @endif
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            </div>
        </div>
</div>
    <script>
        @if(session('success'))
            toastr.success('{{ session('success') }}')
        @endif
        @if(session('warning'))
            toastr.warning('{{ session('warning') }}')
        @endif
    </script>
    <script type="text/javascript" language="javascript" src="{{ asset('js/data.table.js') }}"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>
    <script>
        $(document).ready( function () {
            $('#example').dataTable( {
                "bSort": false
              } );
            $('#example_info').addClass('text-muted');
            $('#example_length').html(`<a href="{{ route('cook_screen.materialcook',['id' => $cook->id]) }}" class="btn btn-sm btn-default"><i class="fa fa-cubes" aria-hidden="true"></i> NVL {{ $cook->name }}</a>`);
            $('input[type="search"]').addClass('form-control');
        } );
    </script>
@endsection
