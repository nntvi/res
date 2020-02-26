@extends('layouts')
@section('content')
<div class="panel panel-default">
    <div class="panel-heading">
        Chỉnh sửa Món ăn
    </div>
    <div class="row">
        <div class="col-xs-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Danh mục</a></li>
                    <li class="breadcrumb-item"><a href="#">Đồ uống - món ăn</a></li>
                    <li class="breadcrumb-item"><a href="#">Chỉnh sửa</a></li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="portlet box green-meadow">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-coffee"></i>
                Chỉnh sửa món ăn</div>
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
                        id="createNews-form" action="{{route('dishes.p_update',['id' => $dish->id])}}" method="POST">
                        @csrf
                        <div class="col-md-12">
                            <div class="space"></div>
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="control-label">Tên Món Ăn<span style="color: #ff0000"> *</span></label>
                                    <input type="text" size="40" class="form-control" name="name" maxlength="200" value="{{$dish->name}}">
                                    <span class="error-message">{{ $errors->first('name') }}</span></p>

                                </div>
                                <div class="col-md-3">
                                    <label class="control-label">Nhóm Thực đơn<span style="color: #ff0000"> *</span></label>
                                    <select class="form-control" name="idGroupMenu">
                                        <option value="{{$dish->groupmenu->id}}">{{$dish->groupmenu->name}}</option>
                                        @foreach ($groupmenus as $groupmenu)
                                            <option value="{{ $groupmenu->id }}">{{$groupmenu->name}}</option>
                                        @endforeach
                                    </select>
                                    <span class="error-message">{{ $errors->first('idGroupMenu') }}</span></p>
                                </div>
                                <div class="col-md-3">
                                        <label class="control-label">Nhóm Nguyên Vật Liệu<span style="color: #ff0000"> *</span></label>
                                        <select class="form-control" name="idGroupNVL">
                                            <option value="{{$dish->material->id}}">{{$dish->material->name}}</option>
                                            <option value="">-- Chọn nhóm nguyên vật liệu --</option>
                                                @foreach ($materials as $material)
                                                    <option value="{{ $material->id }}">{{$material->name}}</option>
                                                @endforeach
                                        </select>
                                </div>
                                <div class="col-md-3">
                                        <label class="control-label" for="FoodForm_Đơn_vị_tính">Đơn Vị Tính</label>
                                        <select class="form-control" name="id_dvt">
                                            <option value="{{$dish->unit->id}}">{{$dish->unit->name}}</option>
                                            <div class="cover-role-body" id="filters">
                                                @foreach ($units as $unit)
                                                    <option value="{{ $unit->id }}">{{$unit->name}}</option>
                                                @endforeach
                                            </div>
                                        </select>
                                    </div>

                            </div>
                            <div class="space"></div>
                            <div class="row">
                                    <div class="col-md-3">
                                            <label class="control-label">Giá Bán (*)<span style="color: #ff0000"> *</span></label>
                                            <input type="number" size="40" class="form-control price_food" name="salePrice" value="{{$dish->sale_price}}">
                                            <span class="error-message">{{ $errors->first('salePrice') }}</span></p>
                                    </div>
                                <div class="col-md-3">
                                    <label>Giá vốn</label>
                                    <input class="form-control" name="capitalPrice" type="number" value="{{$dish->capital_price}}">
                                    <span class="error-message">{{ $errors->first('capitalPrice') }}</span></p>
                                </div>
                                <div class="col-md-3">
                                    <label>Mã sản phẩm</label>
                                    <input class="form-control" name="codeDish" type="text" maxlength="40" value="{{$dish->code}}" disabled>
                                </div>
                                <div class="col-md-3">
                                    <label>Thuế</label>
                                    <input class="form-control" maxlength="5" name="tax" type="text" value="{{$dish->tax}}">
                                    <span class="error-message">{{ $errors->first('tax') }}</span></p>
                                </div>
                            </div>
                            <div class="row">
                                    <div class="col-md-3 margin-top-radio" style="margin-left: 0px">
                                            @if ($dish->status == '0')
                                                <label class="control-label">Hiển thị ra menu: &nbsp;</label>
                                                <label class="control-label">Ẩn</label>
                                                <input value="0" id="status1" type="radio" name="status" style="margin-right: 20px" checked>
                                                <label class="control-label">Hiện</label>
                                                <input value="1" id="status2" type="radio" name="status" style="margin-right: 20px">
                                            @else
                                                <label class="control-label">Hiển thị ra menu: &nbsp;</label>
                                                <label class="control-label">Ẩn</label>
                                                <input value="0" id="status1" type="radio" name="status" style="margin-right: 20px">
                                                <label class="control-label">Hiện</label>
                                                <input value="1" id="status2" type="radio" name="status" style="margin-right: 20px" checked>
                                            @endif
                                            <span class="error-message">{{ $errors->first('status') }}</span></p>
                                    </div>
                                    <div class="col-md-3" style="margin-top: 30px">
                                            <label class="container-checkbox">Theo thời giá
                                                @if ($dish->follow_price == '0')
                                                    <input type="hidden" value="0" name="followPrice">
                                                    <input class="role_id" name="followPrice" value="1" type="checkbox">
                                                    <span class="checked check-food"></span>
                                                @else
                                                <input type="hidden" value="0" name="followPrice">
                                                <input class="role_id" name="followPrice" value="1" type="checkbox" checked>
                                                    <span class="checked check-food"></span>
                                                @endif

                                            </label>
                                        </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-5">
                                <div class="col-md-4">
                                    <div class="img-preview" style="margin-top: 20px">
                                        <img style="width:100%; height: 80px; "
                                            src="img/{{$dish->image}}"
                                            class="img-error">
                                    </div>
                                </div>
                                <div class="space"></div>
                                <div class="controls col-md-4 display-table ">
                                    <span class="btn green-meadow radius fileinput-button">
                                        <i class="glyphicon glyphicon-plus"></i>
                                        <span>Chọn tệp</span>
                                        <input type="file" class="show-img-preview" name="file" value="{{$dish->image}}">
                                    </span>
                                    <span class="fileinput-label" style="display: none;"></span>
                                    <span class="error-message">{{ $errors->first('file') }}</span></p>

                                </div>
                            </div>

                            <div class="col-md-7">
                                    <div class="space"></div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label text-right" for="title">
                                        Mô tả:
                                    </label>
                                    <div class="col-md-9">
                                        <textarea type="text" size="40" class="form-control" rows="4"
                                            name="note" value="{{$dish->describe}}">
                                        </textarea>
                                    </div>
                                </div>
                            </div>

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
