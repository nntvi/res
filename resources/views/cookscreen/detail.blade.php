@extends('layouts')
@section('content')
<div class="table-agile-info">
        <div class="mail-w3agile">
                <!-- page start-->
                <div class="row">
                    <div class="col-sm-3 com-w3ls">
                            <div class="panel-heading" style="background:#1ca59e; color:white">
                                NVL {{ $cook->name }} Hiện có
                            </div>
                            <div class="list-group list-group-alternate">
                                    @foreach ($materials as $material)
                                        @if ($material->detailMaterial->status == '1')
                                            @switch($material->status)
                                                @case('1')
                                                <a href="{{route('cook_screen.p_updatematerial',[   'idMaterial' => $material->detailMaterial->id,
                                                        'idCook' => $cook->id ])}}"
                                                    class="list-group-item" onclick="return confirm('Bạn có chắc muốn nhập thêm [ {{ $material->detailMaterial->name }} ] ?')">
                                                        <span class="badge badge-danger">{{$material->qty}}
                                                            <small>{{$material->unit->name}}</small>
                                                        </span>
                                                    <i class="ti ti-bell"></i> {{ $material->detailMaterial->name }}
                                                </a>
                                                    @break
                                                @case('0')
                                                    <small class="list-group-item" style="background: linear-gradient(45deg, #ff8181, transparent);">
                                                        <span class="badge badge-danger">{{$material->qty}}
                                                            {{--  <small>{{$material->unit->name}}</small>  --}}
                                                        </span>
                                                        <i class="ti ti-bell"></i> {{ $material->detailMaterial->name }}
                                                    </small>
                                                    @break
                                                @default
                                            @endswitch
                                        @else
                                            @continue
                                        @endif
                                    @endforeach
                            </div>
                    </div>
                    <div class="col-sm-9 mail-w3agile">
                            <div class="panel-heading">
                                    {{ $cook->name }}
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-striped b-t b-light">
                                    <thead>
                                        <tr>
                                            <th>Bàn</th>
                                            <th>Tên món</th>
                                            <th>Sl</th>
                                            <th class="text-center">Thời gian</th>
                                            <th>Duyệt món</th>
                                            <th>Công thức</th>
                                            <th class="text-center">Cập nhật</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $key => $dish)
                                                    <input name="idCook" value="{{$cook->id}}" hidden>
                                                    @foreach ($dish->order->tableOrdered as $item)
                                                        <input name="nameTable" value="{{ $item->table->name }} {{ count($dish->order->tableOrdered) != $key+1 ? ',' : '' }}" hidden>
                                                    @endforeach
                                                    <tr data-expanded="true">
                                                        <td>
                                                            @foreach ($dish->order->tableOrdered as $item)
                                                                {{ $item->table->name }}
                                                                {{ count($dish->order->tableOrdered) > 1 ? ', ' : '' }}
                                                            @endforeach
                                                        </td>
                                                        <td>{{ $dish->dish->name }}</td>
                                                        <td class="text-center">{{$dish->qty}}</td>
                                                        <td>{{$dish->created_at}}</td>
                                                        @switch($dish->status)
                                                            @case('-3')
                                                                <td>
                                                                    <label style="display:inline; color: red;">Bếp lẫn kho không đủ NVL thực hiện</label>
                                                                </td>
                                                                @break
                                                            @case('-2')
                                                                <td>
                                                                    <label style="display:inline; color: red;">Món đã hủy chọn</label>
                                                                </td>
                                                                @break
                                                            @case('-1')
                                                                <td>
                                                                    <label style="display:inline; color: red;">Bếp không đủ NVL thực hiện</label>
                                                                </td>
                                                                @break
                                                            @case('0')
                                                                <td>
                                                                    {{--  <input value="1" type="radio" name="status" checked>
                                                                    <label style="display:inline; color: red;">Đang thực hiện</label>  --}}
                                                                    Chưa xem xét
                                                                </td>
                                                                @break
                                                            @case('1')
                                                                <td>
                                                                    <input value="2" type="radio" name="status" checked>
                                                                    <label style="display:inline; color: purple;">Hoàn thành</label>
                                                                </td>
                                                                @break
                                                            @default
                                                                <td>
                                                                    <label style="display:inline; color: darkgreen;" >
                                                                                <i class="fa fa-check" aria-hidden="true"></i>
                                                                                Đã Hoàn thành
                                                                    </label>
                                                                </td>
                                                                @break
                                                        @endswitch
                                                        <td>
                                                                <a href="#myModal{{ $dish->dish->id }}" data-toggle="modal" >
                                                                    <i class="fa fa-eye text-info" aria-hidden="true"></i> Xem CT
                                                                </a>
                                                                <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal{{ $dish->dish->id }}" class="modal fade" style="display: none;">
                                                                    <div class="modal-dialog">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                                                                <h4 class="modal-title">Công thức món {{ $dish->dish->name }}</h4>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <div class="bs-docs-example">
                                                                                    <table class="table table-bordered">
                                                                                        <thead>
                                                                                            <tr>
                                                                                                <th>#</th>
                                                                                                <th>Tên NVL</th>
                                                                                                <th>Số lượng</th>
                                                                                                <th>Đơn vị</th>
                                                                                            </tr>
                                                                                        </thead>
                                                                                        <tbody>
                                                                                            @foreach ($dish->dish->material->materialAction as $key => $item)
                                                                                                <tr>
                                                                                                    <td>{{ $key + 1 }}</td>
                                                                                                    <td>{{ $item->materialDetail->name }}</td>
                                                                                                    <td>{{ $item->qty }}</td>
                                                                                                    <td>{{ $item->unit->name }}</td>
                                                                                                </tr>
                                                                                            @endforeach

                                                                                        </tbody>
                                                                                    </table>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                        </td>
                                                            <td class="text-center">
                                                                @if ($dish->status == '0')
                                                                <a href="#myModal{{ $dish->id }}" data-toggle="modal" class="btn btn-xs btn-danger checkNVL" id="{{ $dish->id }}">
                                                                    Cập nhật
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
                                                                                    <button type="submit" class="btn btn-default">Tiến hành thực hiện</button>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @endif
                                                                @if ($dish->status == '1')
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
                                                                                    <div class="alert alert-xs alert-info text-left" role="alert">
                                                                                        Ghi chú: <strong>{{ $dish->note }}</strong>
                                                                                    </div>
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
                                                                                                                <input type="number" name="qtyReal[]" min="0" max="{{ $dish->qty }}" value="{{ $dish->qty }}" required>
                                                                                                            @endif
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                @endforeach
                                                                                            </tbody>
                                                                                        </table>
                                                                                        <button type="submit" class="btn btn-default">Hoàn thành</button>
                                                                                    </form>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                                @if ($dish->status == '2')
                                                                    <i class="fa fa-check text-success" aria-hidden="true"></i>
                                                                @endif
                                                            </td>
                                                    </tr>
                                        @endforeach
                                    </tbody>
                                    </table>
                                </div>
                                <footer class="panel-footer">
                                        <div class="row">
                                            <div class="col-sm-5 text-center">
                                            <small class="text-muted inline m-t-sm m-b-sm">1-10 món mới nhất được order</small>
                                            </div>
                                            <div class="col-sm-7 text-right text-center-xs">
                                            <ul class="pagination pagination-sm m-t-none m-b-none">
                                                {{ $data->links() }}
                                            </ul>
                                            </div>
                                        </div>
                                </footer>
                    </div>
                </div>
            <!-- page end-->
        </div>

</div>
<script>
    @if($errors->any())
        @foreach($errors->all() as $error)
            toastr.error('{{ $error }}')
        @endforeach
    @endif
    @if(session('success'))
        toastr.success('{{ session('success') }}')
    @endif
    @if(session('warning'))
        toastr.warning('{{ session('warning') }}')
    @endif
</script>
@endsection
