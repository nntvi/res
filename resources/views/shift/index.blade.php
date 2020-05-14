@extends('layouts')
@section('content')
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            Thiết lập Ca làm việc cho nhân viên
        </div>
        <div class="row w3-res-tb">
            <div class="col-sm-3 m-b-xs">
                <a href="#myModal" data-toggle="modal">
                    <button class="btn btn-sm btn-success">Thêm mới</button>
                </a>
                <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal"
                    class="modal fade" style="display: none;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                <h4 class="modal-title">Thêm mới ca làm việc</h4>
                            </div>
                            <div class="modal-body">
                                <form role="form" action="{{ route('shift.p_store') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label>Tên ca</label>
                                        <input class="form-control" name="nameShift" min="3" max="30" required>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xs-6">
                                                <label>Giờ bắt đầu</label>
                                                <input type="time" class="time ui-timepicker-input form-control"
                                                    name="hourStart" id="hourStart" required>
                                            </div>
                                            <div class="col-xs-6">
                                                <label>Giờ kết thúc</label>
                                                <input type="time" class="form-control" name="hourEnd" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="space"></div>
                                    <div class="form-group">
                                        <div class="col-xs-12 text-center">
                                            <button type="submit" class="btn btn-info">Thêm mới</button>
                                        </div>
                                    </div>
                                    <div class="space"></div>
                                    <div class="space"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-5">
                @if($errors->any())
                    @foreach($errors->all() as $error)
                        <span class="error-message">{{ $error }}</span></p>
                    @endforeach
                @endif
            </div>
            <div class="col-sm-4">

            </div>
        </div>
        <div class="space"></div>
        <div class="table-responsive">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead style="background: lightyellow;">
                        <tr>
                            <th>STT</th>
                            <th>Tên ca làm việc</th>
                            <th class="text-center">Giờ bắt đầu</th>
                            <th class="text-center">Giờ kết thúc</th>
                            <th>Cập nhật</th>
                            <th>Xóa</th>
                        </tr>
                    </thead>
                    <tbody id="tableGroupMenu">
                        @foreach($shifts as $key => $shift)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>
                                    <a href="#myModal{{ $shift->id }}" data-toggle="modal">
                                        <i class="fa fa-pencil-square-o text-info" aria-hidden="true"></i>
                                    </a>
                                    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1"
                                        id="myModal{{ $shift->id }}" class="modal fade" style="display: none;">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button aria-hidden="true" data-dismiss="modal" class="close"
                                                        type="button">×</button>
                                                    <h4 class="modal-title">Chỉnh sửa tên ca làm việc</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <form role="form" action="{{ route('shift.p_updatename',['id' => $shift->id]) }}" method="POST">
                                                        @csrf
                                                        <div class="form-group row">
                                                            <div class="col-xs-6">
                                                                <label>Tên hiện tại</label>
                                                                <input type="text" class="form-control" value="{{ $shift->name }}" disabled>
                                                            </div>
                                                            <div class="col-xs-6">
                                                                <label>Tên mới <span style="color: #ff0000">
                                                                            *</span></label>
                                                                <input type="text" size="40" class="form-control"
                                                                        required="required" name="nameShift" maxlength="255"
                                                                        value="{{ $shift->name }}">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <div class="space"></div>
                                                            <div class="col-xs-12 text-center">
                                                                <button type="submit" class="btn btn-info">Lưu</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{ $shift->name }}
                                </td>
                                <td class="text-center">
                                    {{ $shift->hour_start }}
                                </td>
                                <td class="text-center">
                                    {{ $shift->hour_end }}
                                </td>
                                <td>
                                    <a href="#myModal-1{{ $shift->id }}" data-toggle="modal"
                                        class="btn-sm btn-warning">
                                        Sửa thời gian
                                    </a>
                                    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1"
                                        id="myModal-1{{ $shift->id }}" class="modal fade">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button aria-hidden="true" data-dismiss="modal" class="close"
                                                        type="button">×</button>
                                                    <h4 class="modal-title">Sửa thời gian</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <form role="form"
                                                        action="{{ route('shift.p_updatetime',['id' => $shift->id]) }}"
                                                        method="POST">
                                                        @csrf
                                                        <div class="form-group">
                                                            <label>Tên ca</label>
                                                            <input type="text" class="form-control"
                                                                value="{{ $shift->name }}" disabled>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Thời gian bắt đầu</label>
                                                            <input type="time" class="form-control" name="timeStart"
                                                                value="{{ $shift->hour_start }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Thời gian kết thúc</label>
                                                            <input type="time" class="form-control" name="timeEnd"
                                                                value="{{ $shift->hour_end }}" required>
                                                        </div>
                                                        <button type="submit"
                                                            class="btn btn-default text-center">Lưu</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <a href="{{ route('shift.delete',['id' => $shift->id]) }}"
                                        class="btn default btn-xs red radius"
                                        onclick="return confirm('Bạn có chắc muốn xóa dữ liệu này?')">
                                        <i class="fa fa-trash-o"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection
