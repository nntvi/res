@extends('layouts')
@section('content')
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            Khu Vực - Phòng bàn
        </div>
        <div>
            <table class="table table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>
                            <a href="#myModal-1" data-toggle="modal">
                                <i class="fa fa-plus text-info" aria-hidden="true"></i>
                            </a>
                            <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal-1"
                                    class="modal fade" style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                                <h4 class="modal-title">Thêm mới Khu vực</h4>
                                            </div>
                                            <div class="modal-body">
                                                <form class="form-horizontal" role="form"
                                                    action="{{ route('area.p_store') }}" method="POST">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">
                                                            Nhập tên khu vực
                                                        </label>
                                                        <div class="col-lg-10">
                                                            <input type="text" class="form-control" name="nameArea" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-lg-offset-2 col-lg-10 text-right">
                                                            <button type="submit" class="btn btn-default">Thêm mới</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                            &nbsp; Khu vực
                        </th>
                        <th>
                            <a href="#table" data-toggle="modal">
                                <i class="fa fa-plus text-success" aria-hidden="true"></i>
                            </a>
                                <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="table"
                                                class="modal fade" style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                                <h4 class="modal-title text-center">Thêm mới bàn</h4>
                                            </div>
                                            <div class="modal-body">
                                                <form role="form" action="{{ route('table.p_store') }}" method="POST">
                                                    @csrf
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-xs-6 text-left">
                                                                <label class="text">Mã bàn</label>
                                                                <input type="text" class="form-control" name="codeTable" min="3"  max="15" required>
                                                            </div>
                                                            <div class="col-xs-6 text-left">
                                                                <label>Số lượng ghế</label>
                                                                <input type="text" class="form-control" name="nameTable" min="3" max="30" required>
                                                            </div>
                                                        </div>
                                                        <div class="space"></div>
                                                        <div class="form-group row">
                                                            <div class="col-xs-6">
                                                                <label>Tên bàn</label>
                                                                <input type="number" min="1" max="8" class="form-control" value="2" name="qtyChairs" required>
                                                            </div>
                                                            <div class="col-xs-6">
                                                                <label>Khu vực</label>
                                                                <select name="idArea" class="form-control">
                                                                    @foreach($areaTables as $area)
                                                                        <option id="{{ $area->id }}" value="{{ $area->id }}">{{ $area->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="space"></div>
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-xs-12 text-center">
                                                                    <button type="submit" class="btn btn-info">Thêm mới</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            &nbsp; Bàn
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($areas as $key => $area)
                            <tr>
                                <td>
                                    {{ $key + 1 }}
                                </td>
                                <td class="row">
                                    <div class="col-xs-6 text-left">
                                        <a href="#addArea{{ $area->id }}" data-toggle="modal">
                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                        </a>
                                        <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="addArea{{ $area->id }}"
                                                        class="modal fade" style="display: none;">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                                        <h4 class="modal-title">Chỉnh sửa tên khu vực</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form class="form-horizontal" role="form"  action="{{ route('area.update',['id' => $area->id]) }}" method="POST">
                                                            @csrf
                                                            <div class="form-group">
                                                                <label class="col-lg-3 col-sm-3 control-label">
                                                                    Tên hiện tại
                                                                </label>
                                                                <div class="col-lg-9">
                                                                    <input type="text" class="form-control" value="{{ $area->name }}" disabled>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-lg-3 col-sm-3 control-label">
                                                                    Tên thay đổi
                                                                </label>
                                                                <div class="col-lg-9">
                                                                    <input type="text" class="form-control" name="nameArea"
                                                                    value="{{ $area->name }}" required>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-lg-offset-2 col-lg-10 text-right">
                                                                    <button type="submit" class="btn btn-default">Cập nhật</button>
                                                                 </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{ $area->name }}
                                    </div>
                                    <div class="col-xs-6 text-right">
                                        <a class="text-right" href="{{ route('area.delete',['id' => $area->id]) }}"onclick="return confirm('Bạn muốn xóa dữ liệu này?')">
                                            <i class="fa fa-trash text-danger" aria-hidden="true"></i>
                                        </a>
                                    </div>
                                </td>
                                    @foreach ($area->containTable as $key => $item)
                                        @if ($item->id == null || $item->status == '0')
                                            <td></td>
                                        @else
                                        <td class="row">
                                                <div class="col-xs-6 text-left">
                                                    <a href="#table{{ $item->id }}" data-toggle="modal">
                                                        <i class="fa fa-pencil-square-o text-info" aria-hidden="true"></i>
                                                    </a>
                                                    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="table{{ $item->id }}" class="modal fade" style="display: none;">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                                                        <h4 class="modal-title">Chỉnh sửa tên bàn</h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form action="{{ route('table.p_updatename',['id' => $item->id ]) }}" method="POST">
                                                                            @csrf
                                                                            <div class="form-group row">
                                                                                <div class="col-xs-6">
                                                                                    <label>Mã bàn</label>
                                                                                    <input type="text" class="form-control" value="{{ $item->code }}" disabled>
                                                                                </div>
                                                                                <div class="col-xs-6">
                                                                                    <label>Khu vực </label>
                                                                                    <input type="text" class="form-control" value="{{ $item->getArea->name }}" disabled>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label>Tên bàn</label>
                                                                                <input type="text" class="form-control" name="nameTable" value="{{ $item->name }}" required>
                                                                            </div>
                                                                            <button type="submit" class="btn btn-default">Cập nhật</button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                    </div>
                                                    {{ $item->name }} -
                                                    {{ $item->chairs }} Ghế
                                                        <a href="#chair{{ $item->id }}" data-toggle="modal">
                                                            <i class="fa fa-pencil text-info" aria-hidden="true"></i>
                                                        </a>
                                                        <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="chair{{ $item->id }}" class="modal fade" style="display: none;">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                                                            <h4 class="modal-title">Chỉnh sửa số lượng ghế</h4>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <form action="{{ route('table.p_updatechair',['id' => $item->id]) }}" method="POST">
                                                                                @csrf
                                                                                <div class="form-group row">
                                                                                    <div class="col-xs-6">
                                                                                        <label>Mã bàn</label>
                                                                                        <input type="text" class="form-control" value="{{ $item->code }}" disabled>
                                                                                    </div>
                                                                                    <div class="col-xs-6">
                                                                                        <label>Khu vực</label>
                                                                                        <input type="text" class="form-control" value="{{ $item->getArea->name }}" disabled>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group row">
                                                                                    <div class="col-xs-6">
                                                                                        <label>Tên bàn</label>
                                                                                        <input type="text" class="form-control" name="nameTable" value="{{ $item->name }}" disabled>
                                                                                    </div>
                                                                                    <div class="col-xs-6">
                                                                                        <label>Số lượng ghế</label>
                                                                                        <input type="number" min="1" max="8" class="form-control" name="qtyChairs" value="{{ $item->chairs }}" required>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-xs-12 text-center">
                                                                                        <button type="submit" class="btn btn-default">Cập nhật</button>
                                                                                    </div>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                        </div>
                                                </div>
                                                <div class="col-xs-6 text-right">
                                                    <a class="text-right" href="{{ route('table.delete',['id' => $item->id]) }}"onclick="return confirm('Bạn muốn xóa khu vực này?')">
                                                        <i class="fa fa-trash-o text-danger" aria-hidden="true"></i>
                                                    </a>
                                                    <a href="#updateArea{{ $item->id }}" data-toggle="modal">
                                                            <i class="fa fa-exchange text-warning" aria-hidden="true"></i>
                                                    </a>
                                                            <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="updateArea{{ $item->id }}" class="modal fade" style="display: none;">
                                                                    <div class="modal-dialog">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                                                                <h4 class="modal-title text-left">Chuyển bàn sang khu vực khác</h4>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <form action="{{ route('table.p_updatearea',['id' => $item->id ]) }}" method="POST">
                                                                                    @csrf
                                                                                    <div class="form-group row">
                                                                                        <div class="col-xs-6 text-left">
                                                                                            <label>Mã bàn</label>
                                                                                            <input type="text" class="form-control" value="{{ $item->code }}" disabled>
                                                                                        </div>
                                                                                        <div class="col-xs-6 text-left">
                                                                                            <label>Tên bàn</label>
                                                                                            <input type="text" class="form-control" name="nameTable" value="{{ $item->name }}" disabled>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-group row">
                                                                                        <div class="col-xs-12 text-left">
                                                                                                <label>Khu vực</label>
                                                                                                <select class="form-control" name="changeArea">
                                                                                                    <option value="{{ $item->getArea->id }}">{{ $item->getArea->name }}</option>
                                                                                                    @foreach ($areaTables as $areaTable)
                                                                                                        @if ($areaTable->id == $item->getArea->id )
                                                                                                            @continue
                                                                                                        @else
                                                                                                            <option value="{{ $areaTable->id }}">{{ $areaTable->name }}</option>
                                                                                                        @endif
                                                                                                    @endforeach
                                                                                                </select>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="row">
                                                                                        <div class="col-xs-12 text-center">
                                                                                            <button type="submit" class="btn btn-default">Cập nhật</button>
                                                                                        </div>
                                                                                    </div>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                            </div>
                                                </div>
                                        </td>
                                        @endif
                                        @break
                                    @endforeach
                            </tr>
                            @for ($i = 1; $i < count($area->containTable); $i++)
                                @if ($area->containTable[$i]->status == '0')

                                @else
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td>
                                            <div class="col-xs-6 text-left">
                                                    <a href="#table{{ $area->containTable[$i]->id }}" data-toggle="modal">
                                                        <i class="fa fa-pencil-square-o text-info" aria-hidden="true"></i>
                                                    </a>
                                                    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="table{{ $area->containTable[$i]->id }}" class="modal fade" style="display: none;">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                                                        <h4 class="modal-title">Chỉnh sửa tên bàn</h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form action="{{ route('table.p_updatename',['id' => $area->containTable[$i]->id]) }}" method="POST">
                                                                            @csrf
                                                                            <div class="form-group row">
                                                                                <div class="col-xs-6">
                                                                                    <label>Mã bàn</label>
                                                                                    <input type="text" class="form-control" value="{{ $area->containTable[$i]->code }}" disabled>
                                                                                </div>
                                                                                <div class="col-xs-6">
                                                                                    <label>Khu</label>
                                                                                    <input type="text" class="form-control" value="{{ $area->containTable[$i]->getArea->name }}" disabled>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label>Tên bàn</label>
                                                                                <input type="text" class="form-control" name="nameTable" value="{{ $area->containTable[$i]->name }}" required>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-xs-12 text-center">
                                                                                    <button type="submit" class="btn btn-default">Cập nhật</button>
                                                                                </div>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                    </div>
                                                    {{ $area->containTable[$i]->name }} - {{ $area->containTable[$i]->chairs }} Ghế
                                                    <a href="#chair{{ $area->containTable[$i]->id }}" data-toggle="modal">
                                                            <i class="fa fa-pencil text-info" aria-hidden="true"></i>
                                                        </a>
                                                        <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="chair{{ $area->containTable[$i]->id }}" class="modal fade" style="display: none;">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                                                            <h4 class="modal-title">Chỉnh sửa số lượng ghế</h4>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <form action="{{ route('table.p_updatechair',['id' => $area->containTable[$i]->id ]) }}" method="POST">
                                                                                @csrf
                                                                                <div class="form-group row">
                                                                                    <div class="col-xs-6">
                                                                                        <label>Mã bàn</label>
                                                                                        <input type="text" class="form-control" value="{{ $area->containTable[$i]->code }}" disabled>
                                                                                    </div>
                                                                                    <div class="col-xs-6">
                                                                                        <label>Khu vực</label>
                                                                                        <input type="text" class="form-control" value="{{ $area->containTable[$i]->getArea->name }}" disabled>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group row">
                                                                                    <div class="col-xs-6">
                                                                                        <label>Tên bàn</label>
                                                                                        <input type="text" class="form-control" name="nameTable" value="{{ $area->containTable[$i]->name }}" disabled>
                                                                                    </div>
                                                                                    <div class="col-xs-6">
                                                                                        <label>Số lượng ghế</label>
                                                                                        <input type="number" min="1" max="8" class="form-control" name="qtyChairs" value="{{ $area->containTable[$i]->chairs }}" required>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-xs-12 text-center">
                                                                                        <button type="submit" class="btn btn-default">Cập nhật</button>
                                                                                    </div>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                        </div>
                                            </div>
                                                <div class="col-xs-6 text-right">
                                                    <a class="text-right" href="{{ route('table.delete',['id' => $area->containTable[$i]->id]) }}"onclick="return confirm('Bạn muốn xóa bàn này?')">
                                                        <i class="fa fa-trash-o text-danger" aria-hidden="true"></i>
                                                    </a>
                                                    <a href="#updateArea{{ $area->containTable[$i]->id }}" data-toggle="modal">
                                                            <i class="fa fa-exchange text-warning" aria-hidden="true"></i>
                                                    </a>
                                                            <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="updateArea{{ $area->containTable[$i]->id }}" class="modal fade" style="display: none;">
                                                                    <div class="modal-dialog">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                                                                <h4 class="modal-title text-left">Chuyển bàn sang khu vực khác</h4>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <form action="{{ route('table.p_updatearea',['id' => $item->id ]) }}" method="POST">
                                                                                    @csrf
                                                                                    <div class="form-group row">
                                                                                        <div class="col-xs-6 text-left">
                                                                                            <label>Mã bàn</label>
                                                                                            <input type="text" class="form-control" value="{{ $area->containTable[$i]->code }}" disabled>
                                                                                        </div>
                                                                                        <div class="col-xs-6 text-left">
                                                                                            <label>Tên bàn</label>
                                                                                            <input type="text" class="form-control" name="nameTable" value="{{ $area->containTable[$i]->name }}" disabled>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="form-group row">
                                                                                        <div class="col-xs-12 text-left">
                                                                                                <label>Khu vực</label>
                                                                                                <select class="form-control" name="changeArea">
                                                                                                    <option value="{{ $area->containTable[$i]->id }}">{{ $area->containTable[$i]->name }}</option>
                                                                                                    @foreach ($areaTables as $areaTable)
                                                                                                        @if ($areaTable->id == $area->containTable[$i]->id )
                                                                                                            @continue
                                                                                                        @else
                                                                                                            <option value="{{ $areaTable->id }}">{{ $areaTable->name }}</option>
                                                                                                        @endif
                                                                                                    @endforeach
                                                                                                </select>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="row">
                                                                                        <div class="col-xs-12 text-center">
                                                                                            <button type="submit" class="btn btn-default">Cập nhật</button>
                                                                                        </div>
                                                                                    </div>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                            </div>
                                                </div>
                                    </td>
                                </tr>
                                @endif

                            @endfor
                    @endforeach
                </tbody>
            </table>
            <footer class="panel-footer">
                    <div class="row">

                        <div class="col-sm-5 text-center">
                        <small class="text-muted inline m-t-sm m-b-sm">showing 1-10 bàn thuộc khu vực</small>
                        </div>
                        <div class="col-sm-7 text-right text-center-xs">
                        <ul class="pagination pagination-sm m-t-none m-b-none">
                            {{ $areas->links() }}
                        </ul>
                        </div>
                    </div>
            </footer>
        </div>
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
