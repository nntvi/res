@extends('layouts')
@section('content')
<div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Nhóm Nguyên vật liệu cho món
            </div>

            <div class="portlet box green-meadow">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-coffee"></i>
                        Thêm mới</div>
                    <div class="tools">
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-responsive">
                        <div class="form">
                            <form class="panel-body" enctype="multipart/form-data" role="form" action="{{route('material.store')}}" method="POST">
                                @csrf
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="control-label" for="">Tên nhóm NVL cho món<span style="color: #ff0000"> *</span></label>
                                                <input type="text" size="40" class="form-control" name="name" id="" maxlength="255">
                                                <span class="error-message">{{ $errors->first('name') }}</span></p>

                                        </div>
                                        <div class="col-md-3">
                                            <label class="control-label" for="">Thuộc Danh mục món<span style="color: #ff0000"> *</span></label>
                                            <select class="form-control m-bot15" name="idGroupMenu">
                                                @foreach ($groupMenus as $groupmenu)
                                                    <option value="{{$groupmenu->id}}">{{$groupmenu->name}}</option>
                                                @endforeach
                                            </select>
                                            <span class="error-message">{{ $errors->first('idGroupMenu') }}</span></p>

                                        </div>
                                        <div class="col-md-6" style="margin-top: 16px; padding-left: 0">
                                            <!-- <a href="!#" class="margin-bottom btn grey-silver radius btn-delete text-right"></a> -->
                                            <input type="submit"
                                                class="btn green-meadow radius margin-bottom"
                                                style="width:105px; margin-top: 26px;" name="yt0" value="Tạo mới">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="portlet box green-meadow" style="margin-top: 20px;">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-coffee"></i>
                        Danh sách nhóm nguyên vật liệu </div>
                </div>

                <div class="portlet-body">
                    <div class="row">
                        <div class="col-md-6">
                            <span class="error-message">{{ $errors->first('nameMaterial') }}</span></p>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Tên nhóm NVL</th>
                                    <th>Tên danh mục món ăn</th>
                                    <th>Cập nhật</th>
                                    <th>Xóa</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($materials as $key => $material)
                                    <tr>
                                        <td width="5%">{{$key+1}}</td>
                                        <form method="post" action="{{route('material.update',['id' => $material->id])}}">
                                            @csrf
                                            <td width="35%">
                                                <input width="30%" class="form-control" type="text"
                                                    name="nameMaterial" value="{{$material->name}}">
                                            </td>
                                            <td>
                                                <select class="form-control m-bot15" name="groupMenu">
                                                    <option value="{{$material->groupMenu->id}}">{{$material->groupMenu->name}}</option>
                                                    @foreach ($groupMenus as $groupmenu)
                                                        <option value="{{$groupmenu->id}}">{{$groupmenu->name}}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        <td width="10%">
                                            <button type="submit"
                                                class="btn default btn-xs yellow-crusta radius"><i
                                                    class="fa fa-edit"> Cập nhật</i></button>
                                        </td>
                                    </form>
                                        @csrf
                                        <td width="10%">
                                            <a href="{{route('material.delete',['id' => $material->id])}}">
                                                <button type="submit"
                                                class="btn default btn-xs red radius">
                                                    <i class="fa fa-trash-o" onclick="return confirm('Bạn muốn xóa dữ liệu này?')"> Xóa</i>
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
    </div>
@endsection
