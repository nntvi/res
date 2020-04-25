@extends('layouts')
@section('content')
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            Tiền lương/tháng Nhân viên
        </div>
        <div>
            <table class="table table-striped b-t b-light" <thead>
                <tr>
                    <th>STT</th>
                    <th width="25%">Chức vụ</th>
                    <th width="25%">Tiền lương</th>
                    <th width="25%">Ngày cập nhật</th>
                    <th >Chỉnh sửa mức lương</th>

                </tr>
                </thead>
                <tbody>
                    @foreach($salaries as $key => $salary)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $salary->permission->name }}</td>
                            <td>{{ number_format($salary->salary) . ' đ/tháng' }}
                            </td>
                            <td>{{ $salary->updated_at }}</td>
                            <td>
                                <a href="#myModal{{ $salary->id }}" data-toggle="modal" class="btn-sm btn-success">
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Cập nhật
                                </a>
                                <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1"
                                    id="myModal{{ $salary->id }}" class="modal fade">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button aria-hidden="true" data-dismiss="modal" class="close"
                                                    type="button">×</button>
                                                <h4 class="modal-title">Chỉnh sửa mức lương</h4>
                                            </div>
                                            <div class="modal-body">
                                                <form role="form" action="{{ route('salary.p_update',['id' => $salary->id]) }}" method="POST">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label>Tên chức vụ</label>
                                                        <input class="form-control" value="{{ $salary->permission->name }}" disabled>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-xs-6">
                                                                    <label>Mức lương hiện tại</label>
                                                                    <input class="form-control" value="{{ $salary->salary }}" disabled>
                                                            </div>
                                                            <div class="col-xs-6">
                                                                    <label>Mức lương thay đổi</label>
                                                                    <input type="number" class="form-control" name="salary" min="500000" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="space"></div>
                                                        <div class="col-xs-12 text-center">
                                                            <button type="submit" class="btn btn-info">Lưu thay đổi</button>
                                                        </div>
                                                        <div class="space"></div>
                                                        <div class="space"></div>
                                                    </div>
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
@endsection
