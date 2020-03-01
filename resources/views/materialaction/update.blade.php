@extends('layouts')
@section('content')
<div class="panel panel-default">
    <div class="panel-heading">
        Nguyên vật liệu
    </div>
    <div class="row">
        <div class="col-xs-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Hàng hóa</a></li>
                    <li class="breadcrumb-item"><a href="#">Chi tiết nguyên vật liệu</a></li>
                    <li class="breadcrumb-item"><a href="#">Chỉnh sửa</a></li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="portlet box green-meadow">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-coffee"></i>
                Chỉnh sửa chi tiết NVL </div>
        </div>
        <div class="portlet-body">
            <div class="table-responsive">
                <style type="text/css">
                    .hide-default-file-input {
                        position: absolute;
                        top: 0;
                        right: 0;
                        margin: 0;
                        opacity: 0;
                        filter: alpha(opacity=0);
                        transform: translate(-300px, 0) scale(4);
                        font-size: 1px;
                        direction: ltr;
                        cursor: pointer;
                    }

                    .delete-product-image-btn {
                        top: 50px;
                        position: absolute;
                        cursor: pointer;
                        margin-left: 7px;
                    }

                    .delete-product-image-btn>i {
                        color: #ef4836;
                    }

                    .delete-product-child-image-btn {
                        top: 0;
                        position: absolute;
                        cursor: pointer;
                        margin-left: 7px;
                        z-index: 999999;
                    }

                    .delete-product-child-image-btn>i {
                        color: #ef4836;
                    }
                </style>
                <div class="form">
                    <form class="panel-body create-food" enctype="multipart/form-data" role="form"
                        id="createNews-form" @foreach ($materialAction as $item)
                            action="{{route('material_action.p_update',['id' => $item->id])}}" method="POST">
                            @endforeach
                        @csrf
                        <div class="col-md-12">
                            <div class="space"></div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="control-label">Nhóm NVL cho món<span style="color: #ff0000"> *</span></label>
                                        @foreach ($materialAction as $item)
                                            <input class="form-control" name="nameGroupMaterial" type="name" value="{{$item->material->name}}" disabled>
                                        @endforeach
                                </div>
                                <div class="col-md-6">
                                    <label class="control-label">Tên chi tiết NVL<span style="color: #ff0000"> *</span></label>
                                    @foreach ($materialAction as $item)
                                        <input class="form-control" name="nameDetail" type="name" value="{{$item->materialDetail->name}}" disabled>
                                    @endforeach
                                </div>
                            </div>
                            <div class="space"></div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="control-label" for="FoodForm_Đơn_vị_tính">Đơn Vị Tính</label>
                                    <select class="form-control" name="id_dvt">
                                        @foreach ($materialAction as $item)
                                            <option value="{{$item->unit->id}}">{{$item->unit->name}}</option>
                                        @endforeach
                                        <div class="cover-role-body" id="filters">
                                            @foreach ($units as $unit)
                                                <option value="{{$unit->id}}">{{$unit->name}}</option>
                                            @endforeach
                                        </div>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label>Số lượng</label>
                                    @foreach ($materialAction as $item)
                                        <input class="form-control" name="qty" type="number" value="{{$item->qty}}">
                                    @endforeach
                                    <span class="error-message">{{ $errors->first('capitalPrice') }}</span></p>
                                </div>
                            </div>
                            <div class="space"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-offset-3 col-md-6 text-center"
                                style="margin-top: 20px">
                                <input type="submit" class="btn green-meadow radius"
                                    style="width:105px; margin-left:10px" name="yt0" value="Lưu">
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
