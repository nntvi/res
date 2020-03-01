@extends('layouts')
@section('content')
<div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Nhóm thực đơn
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Danh mục</a></li>
                            <li class="breadcrumb-item"><a href="#">Nhóm thực đơn</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="row">
                <div class="col-md-10 text-left">
                    <div class="form mr-3">
                        <form class="panel-body" enctype="multipart/form-data" role="form"
                            id="searchFood-form" action="{{route('groupmenu.search')}}" method="POST">
                             @csrf
                            <div class="row">
                                <div class="col-md-8 col-sm-4">
                                    <input type="text" size="40" class="form-control radius"
                                         placeholder="Tên nhóm thực đơn" name="nameSearch" id="SearchFoodForm_foodName"
                                        value="">
                                    <span class="error-message">{{ $errors->first('nameSearch') }}</span></p>

                                </div>
                                <div class="col-md-2 col-sm-12 text-center">
                                    <input type="submit" class="btn green-meadow radius" name="yt0"
                                    value="Tìm kiếm"> </div>
                                </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-2 text-right" style="margin-top:15px">
                        <a href="{{route('groupmenu.v_store')}}" class="btn radius btn btn-warning btn-add"  style="margin: 10px 10px; background:orange; color:black">Thêm mới</a>
                </div>
            </div>

            <div class="portlet box green-meadow ">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-coffee"></i>
                           Danh sách Nhóm thực đơn
                    </div>
                </div>
                <div class="portlet-body">
                        <div class="row">
                            <div class="col-md-6">
                                <span class="error-message">{{ $errors->first('nameGroupArea') }}</span></p>
                            </div>
                        </div>
                    <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Tên nhóm thực đơn</th>
                                        <th>Thuộc bếp</th>
                                        <th>Cập nhật</th>
                                        <th>Xóa</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($groupmenus as $key => $groupmenu)
                                    <tr>
                                            <td width="5%">{{$key+1}}</td>
                                            <form method="post" action="{{route('groupmenu.update',['id' => $groupmenu->id])}}">
                                                @csrf
                                                <td width="20%">
                                                    <input width="18%" class="form-control" type="text"
                                                        name="nameGroupArea" value="{{$groupmenu->name}}">
                                                </td>
                                                <td width="20%" class="text-center">
                                                    @foreach ($cook_active as $item)
                                                        <label style="display:inline">{{$item->name}}</label>
                                                        @if ($groupmenu->id_cook == $item->id)
                                                            <input value="{{$item->id}}" id="cook{{$item->id}}" type="radio" name="idCook" style="margin-right: 20px" checked>
                                                        @else
                                                            <input value="{{$item->id}}" id="cook{{$item->id}}" type="radio" name="idCook" style="margin-right: 20px">
                                                        @endif
                                                    @endforeach
                                                </td>
                                            <td width="10%">
                                                <button type="submit"
                                                    class="btn default btn-xs yellow-crusta radius"><i
                                                        class="fa fa-edit"> Cập nhật</i></button>
                                            </td>
                                            </form>
                                            <td width="10%">
                                                <a href="{{route('groupmenu.delete',['id' => $groupmenu->id])}}"
                                                    class="btn default btn-xs red radius" onclick="return confirm('Bạn muốn xóa dữ liệu này?')">
                                                        <i class="fa fa-trash-o"> Xóa</i>
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
