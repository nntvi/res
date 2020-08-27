@extends('layouts')
@section('content')
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            Thiết lập Ca làm việc cho nhân viên
        </div>
        <div class="space"></div>
        <div class="table-responsive">
            <table class="table table-hover" id="example">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Tên ca làm việc</th>
                            <th class="text-center">Giờ bắt đầu</th>
                            <th class="text-center">Giờ kết thúc</th>
                            <th class="text-center">Cập nhật</th>
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
                                <td class="text-center">
                                    <a href="#myModal-1{{ $shift->id }}" data-toggle="modal"
                                        <i class="fa fa-clock-o" aria-hidden="true"> </i>Thời gian
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
                                                                value="{{ $shift->hour_start }}" min="06:00" max="01:00" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Thời gian kết thúc</label>
                                                            <input type="time" class="form-control" name="timeEnd"
                                                                value="{{ $shift->hour_end }}" min="06:00" max="01:00" required>
                                                        </div>
                                                        <button type="submit"
                                                            class="btn btn-default text-center">Lưu</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
        @if(session('info'))
            toastr.info('{{ session('info') }}')
        @endif
    </script>
    <script type="text/javascript" language="javascript" src="{{ asset('js/data.table.js') }}"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>    <script>
        $(document).ready( function () {
            $('#example').dataTable();
            $('#example_info').addClass('text-muted');
            $('input[type="search"]').addClass('form-control');
            $('.dataTables_length').hide();
        } );
    </script>
@endsection
