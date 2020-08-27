@extends('layouts')
@section('content')
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            Chức vụ và tiền lương
        </div>
        <div class="row w3-res-tb">
            <div class="col-sm-5 m-b-xs">
                <a href="#myModal" data-toggle="modal" class="btn btn-sm btn-default">
                    Thêm mới
                </a>
                <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal"
                    class="modal fade" style="display: none;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                <h4 class="modal-title">Thêm mới chức vụ</h4>
                            </div>
                            <div class="modal-body">
                                <form role="form" action="{{ route('position.p_store') }}"
                                    method="POST">
                                    @csrf
                                    <div class="form-group row">
                                        <div class="col-xs-6">
                                            <label>Tên chức vụ</label>
                                            <input type="text" class="form-control" name="name" required>
                                        </div>
                                        <div class="col-xs-6">
                                            <label>Tiền lương</label>
                                            <input type="number" min="0" class="form-control" name="salary" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-xs-12 text-center">
                                            <div class="space"></div>
                                            <button type="submit" class="btn btn-default">Tạo mới</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <script>
                    @if(session('success'))
                        toastr.success('{{ session('success') }}')
                    @endif
                    @if(session('info'))
                        toastr.info('{{ session('info') }}')
                    @endif
                </script>
            </div>
            <div class="col-sm-3">

            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped b-t b-light">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên chức vụ</th>
                        <th>Tiền lương/tháng</th>
                        <th>Ngày cập nhật</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($positions as $key => $position)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>
                                <a href="#myModal{{ $position->id }}" data-toggle="modal">
                                    <i class="fa fa-pencil-square-o text-info" aria-hidden="true"></i>
                                </a>
                                <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1"
                                    id="myModal{{ $position->id }}" class="modal fade" style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button aria-hidden="true" data-dismiss="modal" class="close"
                                                    type="button">×</button>
                                                <h4 class="modal-title">Chỉnh sửa tên chức vụ</h4>
                                            </div>
                                            <div class="modal-body">
                                                <form role="form"
                                                    action="{{ route('position.p_updatename',['id' => $position->id]) }}"
                                                    method="POST">
                                                    @csrf
                                                    <div class="form-group row">
                                                        <div class="col-xs-6">
                                                            <label>Tên hiện tại</label>
                                                            <input type="text" class="form-control"
                                                                value="{{ $position->name }}" disabled>
                                                        </div>
                                                        <div class="col-xs-6">
                                                            <label>Tên thay đổi</label>
                                                            <input type="text" min="3" class="form-control"
                                                                value="{{ $position->name }}" name="name" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-xs-12 text-center">
                                                            <div class="space"></div>
                                                            <button type="submit" class="btn btn-default">Lưu</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{ $position->name }}
                            </td>
                            <td>
                                <a href="#updateSalary{{ $position->id }}" data-toggle="modal">
                                    <i class="fa fa-pencil-square-o text-warning" aria-hidden="true"></i>
                                </a>
                                <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1"
                                    id="updateSalary{{ $position->id }}" class="modal fade" style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button aria-hidden="true" data-dismiss="modal" class="close"
                                                    type="button">×</button>
                                                <h4 class="modal-title">Chỉnh sửa tiền lương</h4>
                                            </div>
                                            <div class="modal-body">
                                                <form role="form"
                                                    action="{{ route('position.p_updatesalary',['id' => $position->id]) }}"
                                                    method="POST">
                                                    @csrf
                                                    <div class="form-group row">
                                                        <div class="col-xs-6">
                                                            <label>Lương hiện tại</label>
                                                            <input type="text" class="form-control"
                                                                value="{{ $position->salary }}" disabled>
                                                        </div>
                                                        <div class="col-xs-6">
                                                            <label>Lương thay đổi</label>
                                                            <input type="number" min="3" class="form-control"
                                                                value="{{ $position->salary }}" name="salary"
                                                                required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-xs-12 text-center">
                                                            <div class="space"></div>
                                                            <button type="submit" class="btn btn-default">Thay
                                                                đổi</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{ number_format($position->salary) . ' đ' }}
                            </td>
                            <td>{{ $position->updated_at }}</td>
                            <td class="text-right">
                                <a href="{{ route('position.delete',['id' => $position->id]) }}"
                                    class="btn default btn-xs red radius"
                                    onclick="return confirm('Bạn muốn xóa dữ liệu này?')">
                                    <i class="fa fa-trash-o"></i>
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
                    <small class="text-muted inline m-t-sm m-b-sm">showing 1-10 positions</small>
                </div>
                <div class="col-sm-7 text-right text-center-xs">
                    <ul class="pagination pagination-sm m-t-none m-b-none">
                        {{ $positions->links() }}
                    </ul>
                </div>
            </div>
        </footer>
    </div>
</div>
@endsection
