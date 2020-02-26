@extends('layouts')
@section('content')
<div class="panel panel-default">
    <div class="panel-heading">
        Thêm mới
    </div>
    <div class="row">
        <div class="col-xs-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Danh mục</a></li>
                    <li class="breadcrumb-item"><a href="#">Chi tiết nguyên vật liệu</a></li>
                    <li class="breadcrumb-item"><a href="#">Tạo mới</a></li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="portlet box green-meadow">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-coffee"></i>
                Thêm mới món chi tiết </div>
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
                        id="createNews-form" action="{{route('material_action.p_store')}}" method="POST">
                        @csrf
                        <div class="col-md-12">
                            <div class="space"></div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="control-label">Tên chi tiết NVL<span style="color: #ff0000"> *</span></label>
                                    <select class="form-control" name="idMaterialDetail">
                                            <div class="cover-role-body" id="filters">
                                                @foreach ($materialDetails as $materialDetail)
                                                    <option value="{{ $materialDetail->id }}">{{$materialDetail->name}}</option>
                                                @endforeach
                                            </div>
                                    </select>
                                    <span class="error-message">{{ $errors->first('name') }}</span></p>

                                </div>
                                <div class="col-md-6">
                                    <label class="control-label">Nhóm NVL cho món<span style="color: #ff0000"> *</span></label>
                                    <select class="form-control" name="idGroupNVL">
                                        <option value="">-- Vui lòng chọn nhóm thực đơn --</option>
                                        @foreach ($materials as $material)
                                            <option value="{{ $material->id }}">{{$material->name}}</option>
                                        @endforeach
                                    </select>
                                    <span class="error-message">{{ $errors->first('idGroupMenu') }}</span></p>
                                </div>
                            </div>
                            <div class="space"></div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="control-label" for="FoodForm_Đơn_vị_tính">Đơn Vị Tính</label>
                                    <select class="form-control" name="id_dvt">
                                        <div class="cover-role-body" id="filters">
                                            @foreach ($units as $unit)
                                                <option value="{{ $unit->id }}">{{$unit->name}}</option>
                                            @endforeach
                                        </div>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label>Số lượng</label>
                                    <input class="form-control" name="qty" type="number">
                                    <span class="error-message">{{ $errors->first('capitalPrice') }}</span></p>
                                </div>
                            </div>
                            <div class="space"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-offset-3 col-md-6 text-center"
                                style="margin-top: 20px">
                                <a href="{{route('dishes.index')}}"
                                    class="btn grey-silver radius btn-delete text-right">Hủy</a>
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
