@extends('layouts')
@section('content')
<div class="table-agile-info">
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Khu vực
            </div>
            <div class="row w3-res-tb">
                <div class="col-sm-5 m-b-xs">
                    <a href="#myModal-1" data-toggle="modal">
                        <button class="btn btn-sm btn-success">Thêm mới</button>
                    </a>
                    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal-1"
                        class="modal fade" style="display: none;">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button aria-hidden="true" data-dismiss="modal" class="close"
                                        type="button">×</button>
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
                    <a href="">
                        <button type="submit" class="btn default btn-sm red radius">
                            <i class="fa fa-trash-o" onclick="return confirm('Bạn muốn xóa dữ liệu này?')"> Xóa danh sách</i>
                        </button>
                    </a>
                </div>
                <div class="col-sm-4">
                        @if($errors->any())
                        @foreach($errors->all() as $error)
                            <span class="error-message">{{ $error }}</span></p>
                        @endforeach
                    @endif
                </div>
                <div class="col-sm-3 text-right">

                </div>
                <div>
                    <table class="table" ui-jq="footable" ui-options="{
                        &quot;paging&quot;: {
                        &quot;enabled&quot;: true
                        },
                        &quot;filtering&quot;: {
                        &quot;enabled&quot;: true
                        },
                        &quot;sorting&quot;: {
                        &quot;enabled&quot;: true
                        }}">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Khu vực</th>
                                <th>Cập nhật</th>
                                <th>Xóa</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($areas as $key => $area)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <form method="POST"
                                        action="{{ route('area.update',['id' => $area->id]) }}">
                                        @csrf
                                        <td>
                                            <input type="hidden" name="AreaId" value="">
                                            <input width="30%" class="form-control" type="text" name="AreaName"
                                                value="{{ $area->name }}">
                                        </td>
                                        <td>
                                            <button type="submit" class="btn btn-xs btn-info radius"><i
                                                    class="fa fa-edit"> Cập nhật</i></button>
                                        </td>
                                    </form>
                                    @csrf
                                    <td>
                                        <a
                                            href="{{ route('area.delete',['id'=> $area->id]) }}">
                                            <button type="submit" class="btn default btn-xs red radius">
                                                <i class="fa fa-trash-o"
                                                    onclick="return confirm('Bạn muốn xóa dữ liệu này?')"> Xóa</i>
                                            </button>
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
