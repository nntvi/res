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
                                        @if ($material->status == "1")
                                        <a href="{{route('cook_screen.p_updatematerial',[   'idMaterial' => $material->detailMaterial->id,
                                                                                            'idCook' => $cook->id ])}}"
                                            class="list-group-item" onclick="return confirm('Bạn có chắc muốn nhập thêm [ {{ $material->detailMaterial->name }} ] ?')">
                                                <span class="badge badge-danger">{{$material->qty}}
                                                    <small>{{$material->unit->name}}</small>
                                                </span>
                                            <i class="ti ti-bell"></i> {{ $material->detailMaterial->name }}
                                        </a>
                                        @else
                                        <small class="list-group-item" style="background: linear-gradient(45deg, #ff8181, transparent);">
                                            <span class="badge badge-danger">{{$material->qty}}
                                                {{--  <small>{{$material->unit->name}}</small>  --}}
                                            </span>
                                            <i class="ti ti-bell"></i> {{ $material->detailMaterial->name }}
                                        </small>
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
                                        <th data-breakpoints="xs">Bàn</th>
                                        <th>Tên món</th>
                                        <th>Sl</th>
                                        <th>Ghi chú</th>
                                        <th class="text-center" >Thời gian</th>
                                        <th>Duyệt món</th>
                                        <th>Công thức</th>
                                        <th>Cập nhật</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $key => $dish)
                                                <form action="{{route('cook_screen.p_update',['id' => $dish->id,'idCook' => $cook->id])}}" method="post">
                                                    @csrf
                                                    <input type="text" name="idCook" value="{{$cook->id}}" hidden>
                                                    <tr data-expanded="true">
                                                        <td>{{ $dish->order->table->name }}</td>
                                                        <td>{{ $dish->dish->name }}</td>
                                                        <td class="text-center">
                                                            {{$dish->qty}}
                                                        </td>
                                                        @if ($dish->note != null)
                                                            <td>
                                                                {{ $dish->note }}
                                                            </td>
                                                        @else
                                                            <td class="text-center">--</td>
                                                        @endif
                                                        <td>{{$dish->created_at}}</td>
                                                        @if ($dish->status == '-1')
                                                            <td>
                                                                <label style="display:inline; color: red;">Không đủ NVL</label>
                                                            </td>
                                                        @endif
                                                        @if ($dish->status == '-2')
                                                            <td>
                                                                <label style="display:inline; color: red;">Món đã hủy chọn</label>
                                                            </td>
                                                        @else
                                                            <td>
                                                                @if ($dish->status == '0')
                                                                    <input value="1" type="radio" name="status" checked>
                                                                    <label style="display:inline; color: red;">Đang thực hiện</label>
                                                                @endif
                                                                @if ($dish->status == '1')
                                                                    <input value="2" type="radio" name="status" checked>
                                                                    <label style="display:inline; color: red;">Hoàn thành</label>
                                                                @endif
                                                                @if($dish->status == '2')
                                                                    <label style="display:inline; color: darkgreen;" >
                                                                        <i class="fa fa-check" aria-hidden="true"></i>
                                                                        Đã Hoàn thành
                                                                    </label>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <a href="#myModal{{ $dish->dish->id }}" data-toggle="modal" >
                                                                    <i class="fa fa-eye text-info" aria-hidden="true"></i>
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
                                                            <td>
                                                                @if ($dish->status == '0')
                                                                    <button type="submit" class="btn default btn-xs yellow-crusta radius">
                                                                        <i class="fa fa-edit"></i>
                                                                    </button>
                                                                @endif
                                                                @if ($dish->status == '1')
                                                                    <button type="submit" class="btn default btn-xs yellow-crusta radius">
                                                                        <i class="fa fa-edit"> Cập nhật</i>
                                                                    </button>
                                                                @endif
                                                                @if ($dish->status == '2')
                                                                    --
                                                                @endif
                                                            </td>
                                                        @endif

                                                    </tr>
                                                </form>
                                        @endforeach
                                    </tbody>
                                    </table>
                                </div>
                    </div>
                </div>
            <!-- page end-->
        </div>

</div>



@endsection
