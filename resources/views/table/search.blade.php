@extends('layouts')
@section('content')
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            Danh sách bàn
        </div>
        <div class="row w3-res-tb">
            <div class="col-sm-5 m-b-xs">
                <a href="{{ route('table.index') }}" class="btn btn-sm btn-default">
                    Trở về
                </a>
                <a href="#myModal" data-toggle="modal" class="btn btn-sm btn-success">
                    Thêm mới
                </a>
                <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal"
                    class="modal fade" style="display: none;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                <h4 class="modal-title">Thêm mới bàn</h4>
                            </div>
                            <div class="modal-body">
                                <form role="form" action="{{ route('table.p_store') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xs-6">
                                                <label>Mã bàn</label>
                                                <input type="text" class="form-control" name="codeTable" min="3"
                                                    max="15" required>
                                            </div>
                                            <div class="col-xs-6">
                                                <label>Tên bàn</label>
                                                <input type="text" class="form-control" name="nameTable" min="3"
                                                    max="30" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Khu vực</label>
                                        <select name="idArea" class="form-control">
                                            @foreach($areas as $area)
                                                <option id="{{ $area->id }}" value="{{ $area->id }}">
                                                    {{ $area->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="space"></div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xs-12 text-center">
                                                <button type="submit" class="btn btn-info">Thêm mới</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                @if($errors->any())
                    @foreach($errors->all() as $error)
                        <span class="error-message">{{ $error }}</span></p>
                    @endforeach
                @endif
            </div>
            <div class="col-sm-4">
                <form action="{{ route('table.search') }}" method="GET">
                    @csrf
                    <div class="input-group">
                        <input type="text" class="input-sm form-control" name="nameSearch" required>
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
                        <th>Mã bàn</th>
                        <th>Tên bàn</th>
                        <th>Khu vực</th>
                        <th width="10%">Xóa</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tables as $key => $table)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $table->code }}</td>
                            <td>
                                <a href="#updateName{{ $table->id }}" data-toggle="modal">
                                    <i class="fa fa-edit text-success"></i>
                                </a>
                                <div aria-hidden="true" aria-labelledby="updateName" role="dialog" tabindex="-1"
                                    id="updateName{{ $table->id }}" class="modal fade" style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button aria-hidden="true" data-dismiss="modal" class="close"
                                                    type="button">×</button>
                                                <h4 class="modal-title">Chỉnh sửa tên bàn</h4>
                                            </div>
                                            <div class="modal-body">
                                                <form role="form"
                                                    action="{{ route('table.p_updatename',['id' => $table->id]) }}"
                                                    method="POST">
                                                    @csrf
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-xs-6">
                                                                <label>Mã bàn</label>
                                                                <input type="text" class="form-control"
                                                                    value="{{ $table->code }}" disabled>
                                                            </div>
                                                            <div class="col-xs-6">
                                                                <label>Tên bàn</label>
                                                                <input type="text" class="form-control" name="nameTable"
                                                                    value="{{ $table->name }}" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="space"></div>
                                                    <div class="form-group">
                                                        <div class="col-xs-12 text-center">
                                                            <button type="submit" class="btn btn-info">Chỉnh
                                                                sửa</button>
                                                        </div>
                                                    </div>
                                            </div>
                                            <div class="space"></div>
                                            <div class="space"></div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
        </div>
        {{ $table->name }}
        </td>
        <td>
            <a href="#updateArea{{ $table->id }}" data-toggle="modal">
                <i class="fa fa-edit text-info"></i>
            </a>
            <div aria-hidden="true" aria-labelledby="updateArea" role="dialog" tabindex="-1"
                id="updateArea{{ $table->id }}" class="modal fade" style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                            <h4 class="modal-title">Chỉnh sửa khu vực bàn</h4>
                        </div>
                        <div class="modal-body">
                            <form role="form"
                                action="{{ route('table.p_updatearea',['id' => $table->id]) }}"
                                method="POST">
                                @csrf
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <label>Mã bàn</label>
                                            <input type="text" class="form-control" value="{{ $table->code }}"
                                                disabled>
                                        </div>
                                        <div class="col-xs-6">
                                            <label>Tên bàn</label>
                                            <input type="text" class="form-control" name="nameTable"
                                                value="{{ $table->name }}" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="space"></div>
                                <div class="form-group">
                                    <label>Khu vực</label>
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <select name="idArea" class="form-control">
                                                <option value="{{ $table->getArea->id }}">
                                                    {{ $table->getArea->name }}</option>
                                                @foreach($areas as $area)
                                                    <option id="{{ $area->id }}" value="{{ $area->id }}">
                                                        {{ $area->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-xs-6">
                                            <button type="submit" class="btn btn-info">Chỉnh
                                                sửa</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="space"></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            {{ $table->getArea->name }}
        </td>
        <td>
            <a href="{{ route('table.delete',['id'=>$table->id]) }}"
                class="btn default btn-xs red radius" onclick="return confirm('Bạn muốn xóa dữ liệu này?')">
                <i class="fa fa-trash-o"> Xóa</i>
            </a>
        </td>
        </tr>
        @endforeach

        </tbody>
        </table>
    </div>
    <footer class="panel-footer">
        <div class="row">
            <div class="col-sm-5 text-center">
                <small class="text-muted inline m-t-sm m-b-sm">showing 1->8 items</small>
            </div>
            <div class="col-sm-7 text-right text-center-xs">
                <ul class="pagination m-t-none m-b-none">
                    {{--  {{ $tables->links() }}  --}}
                </ul>
            </div>
        </div>
    </footer>
</div>
</div>
@endsection
