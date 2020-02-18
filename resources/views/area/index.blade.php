@extends('layouts')
@section('content')
<div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Thêm mới
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Danh mục</a></li>
                            <li class="breadcrumb-item"><a href="#">Khu vực</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="portlet box green-meadow">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-coffee"></i>
                        Thêm mới khu vực </div>
                    <div class="tools">
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-responsive">
                        <div class="form">
                            <form class="panel-body" enctype="multipart/form-data" role="form" action="{{route('area.p_store')}}" method="POST">
                                @csrf
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="control-label" for="">Tên Khu Vực<span style="color: #ff0000"> *</span></label>
                                                <input type="text" size="40" class="form-control" name="nameArea" id="" maxlength="255">
                                                <span class="error-message">{{ $errors->first('nameArea') }}</span></p>

                                        </div>
                                        <div class="col-md-9" style="margin-top: 16px; padding-left: 0">
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
                        Danh sách khu vực </div>
                </div>

                <div class="portlet-body">
                    <div class="row">
                        <div class="col-md-6">
                            <span class="error-message">{{ $errors->first('AreaName') }}</span></p>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Khu vực</th>
                                    <th>Cập nhật</th>
                                    <th>Xóa</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($areas as $key => $area)
                                    <tr>
                                        <td width="20%">{{$key+1}}</td>
                                        <form method="post" action="{{route('area.update',['id' => $area->id])}}">
                                            @csrf
                                            <td width="50%">
                                                <input type="hidden" name="AreaId" value="">
                                                <input width="30%" class="form-control" type="text"
                                                    name="AreaName" value="{{$area->name}}">
                                            </td>
                                        <td width="10%">
                                            <button type="submit"
                                                class="btn default btn-xs yellow-crusta radius"><i
                                                    class="fa fa-edit"> Cập nhật</i></button>
                                        </td>
                                    </form>
                                        @csrf
                                        <td width="10%">
                                            <a href="{{route('area.delete',['id'=> $area->id])}}">
                                                <button type="submit"
                                                class="btn default btn-xs red radius">
                                                    <i class="fa fa-trash-o"> Xóa</i>
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
