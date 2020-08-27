@extends('layouts')
@section('content')
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            Nhóm Thực Đơn
        </div>
        <div class="table-responsive">
            <table class="table table-hover" id="example">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Tên nhóm thực đơn</th>
                            <th>Thuộc bếp</th>
                            <th class="text-right">Xóa</th>
                        </tr>
                    </thead>
                    <tbody id="tableGroupMenu">
                        @foreach($groupmenus as $key => $groupmenu)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>
                                    <a href="#myModal{{ $groupmenu->id }}" data-toggle="modal">
                                        <i class="fa fa-pencil-square-o text-success" aria-hidden="true"></i>
                                    </a>
                                            <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1"
                                        id="myModal{{ $groupmenu->id }}" class="modal fade" style="display: none;">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button aria-hidden="true" data-dismiss="modal" class="close"
                                                        type="button">×</button>
                                                    <h4 class="modal-title">Chỉnh sửa tên nhóm thực đơn</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <form role="form" action="{{ route('groupmenu.updatename',['id' => $groupmenu->id ]) }}" method="POST">
                                                        @csrf
                                                        <div class="form-group">
                                                            <label>Tên hiện tại</label>
                                                            <input type="text" class="form-control"
                                                                value="{{ $groupmenu->name }}" disabled>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Action Name <span style="color: #ff0000">
                                                                    *</span></label>
                                                            <input type="text" class="form-control"
                                                             name="nameGroupMenu" maxlength="60"
                                                                value="{{ $groupmenu->name }}" required>
                                                        </div>
                                                        <button type="submit" class="btn btn-default">Lưu</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{ $groupmenu->name }}
                                </td>
                                <td>
                                    @if ($groupmenu->id_cook == '0')
                                    <a href="#myModal-1{{ $groupmenu->id }}" data-toggle="modal">
                                            <i class="fa fa-pencil-square-o text-info" aria-hidden="true"></i>
                                        </a>
                                        <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1"
                                        id="myModal-1{{ $groupmenu->id }}" class="modal fade">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button aria-hidden="true" data-dismiss="modal" class="close"
                                                        type="button">×</button>
                                                    <h4 class="modal-title">Sửa bếp</h4>
                                                </div>
                                                <div class="modal-body">
                                                        <form role="form" action="{{ route('groupmenu.updatecook',['id' => $groupmenu->id]) }}" method="POST">
                                                                @csrf
                                                                <div class="form-group row">
                                                                    <div class="col-xs-12 col-sm-6">
                                                                        <label>Tên nhóm thực đơn</label>
                                                                        <input type="text" class="form-control" value="{{ $groupmenu->name }}" disabled>
                                                                    </div>
                                                                    <div class="col-xs-12 col-sm-6">
                                                                        <label>Bếp hiện tại</label>
                                                                        <input type="text" class="form-control" value="Chưa chọn bếp" disabled>
                                                                    </div>
                                                                </div>
                                                                <div class="space"></div>
                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <div class="col-xs-12 col-sm-6">
                                                                            <label style="color:black">Bếp thay đổi: </label>&nbsp;&nbsp;
                                                                            @foreach ($cook_active as $item)
                                                                                <label style="display:inline">{{$item->name}}</label>
                                                                                <input value="{{$item->id}}"  type="radio" name="idCook" style="margin-right: 20px" checked>
                                                                            @endforeach
                                                                        </div>
                                                                        <div class="col-xs-12 col-sm-6">
                                                                            <input type="checkbox" name="move" value="" hidden>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <hr>
                                                                <div class="form-group row">
                                                                    <div class="col-xs-12 text-center">
                                                                        <button type="submit" class="btn btn-success text-center">Lưu</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                        Chưa chọn bếp
                                    @else
                                        <a href="#myModal-1{{ $groupmenu->id }}" data-toggle="modal">
                                            <i class="fa fa-pencil-square-o text-info" aria-hidden="true"></i>
                                        </a>
                                        <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1"
                                        id="myModal-1{{ $groupmenu->id }}" class="modal fade">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button aria-hidden="true" data-dismiss="modal" class="close"
                                                        type="button">×</button>
                                                    <h4 class="modal-title">Sửa bếp</h4>
                                                </div>
                                                <div class="modal-body">
                                                        <form role="form" action="{{ route('groupmenu.updatecook',['id' => $groupmenu->id]) }}" method="POST">
                                                                @csrf
                                                                <div class="form-group row">
                                                                    <div class="col-xs-12 col-sm-6">
                                                                        <label>Tên nhóm thực đơn</label>
                                                                        <input type="text" class="form-control" value="{{ $groupmenu->name }}" disabled>
                                                                    </div>
                                                                    <div class="col-xs-12 col-sm-6">
                                                                        <label>Bếp hiện tại</label>
                                                                        <input type="text" class="form-control" value="{{ $groupmenu->cookArea->name }}" disabled>

                                                                    </div>
                                                                </div>
                                                                <div class="space"></div>
                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <div class="col-xs-12 col-sm-6">
                                                                            <label style="color:black">Bếp thay đổi: </label>&nbsp;&nbsp;
                                                                            @foreach ($cook_active as $item)
                                                                                @if ($item->id != $groupmenu->cookArea->id)
                                                                                    <label style="display:inline">{{$item->name}}</label>
                                                                                    <input value="{{$item->id}}"  type="radio" name="idCook" style="margin-right: 20px" checked>
                                                                                @endif
                                                                            @endforeach
                                                                        </div>
                                                                        <div class="col-xs-12 col-sm-6">
                                                                            <input type="checkbox" name="move" value="1"> Chuyển tất cả NVL ở bếp cũ sang bếp mới
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <hr>
                                                                <div class="form-group row">
                                                                    <div class="col-xs-12 text-center">
                                                                        <button type="submit" class="btn btn-success text-center">Lưu</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                        {{ $groupmenu->cookArea->name }}
                                    @endif
                                </td>
                                <td class="text-right">
                                    <a href="{{ route('groupmenu.delete',['id' => $groupmenu->id]) }}"
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
            $('#example_length').html(
                `<a href="#myModal-1" data-toggle="modal">
                    <button class="btn btn-sm btn-default">Thêm mới</button>
                </a>
                <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal-1"
                    class="modal fade" style="display: none;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                <h4 class="modal-title">Thêm mới Nhóm thực đơn</h4>
                            </div>
                            <div class="modal-body">
                                <form class="form-horizontal" role="form"
                                    action="{{ route('groupmenu.store') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label class="col-lg-2 col-sm-2 control-label">
                                            Tên
                                        </label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" maxlength="60" name="name" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-2 col-sm-2 control-label">Chọn bếp</label>
                                        <div class="col-lg-10">
                                            @foreach($cook_active as $item)
                                                <label class="checkbox-inline">
                                                    <input type="radio" id="cook{{ $item->id }}"
                                                        value="{{ $item->id }}" name="idCook"> {{ $item->name }}
                                                </label>
                                            @endforeach
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
                </div>`
            )
        } );
    </script>
@endsection
