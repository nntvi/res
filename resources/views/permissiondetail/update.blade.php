@extends('layouts')
@section('content')
<div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Phân quyền
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Phân quyền</a></li>
                            <li class="breadcrumb-item"><a href="#">Chi tiết quyền</a></li>
                            <li class="breadcrumb-item"><a href="#">Chỉnh sửa</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="portlet box green-meadow">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-gift"></i>
                        Chỉnh sửa chi tiết quyền</div>
                </div>
                <div class="portlet-body">
                    <div class="form">
                        <form class="panel-body"
                            id="createNews-form" action="{{route('perdetail.p_update',['id' => $permissionDetails->id])}}" method="POST">
                            @csrf
                            <div class="row margin-top">
                                <div class="form-group">
                                    <label class="col-md-3 control-label text-right">
                                        Action Name <span style="color: #ff0000"> *</span>
                                    </label>
                                    <div class="col-md-5">
                                        <input type="text" size="40" class="form-control"
                                            required="required" name="action_name"
                                            maxlength="255" value="{{ $permissionDetails->name }}">
                                    </div>
                                    <div class="errorMessage" id="ShopCustomer_name_em_"
                                        style="display:none"></div>
                                </div>
                            </div>
                            <div class="col-md-12 text-right">
                                <a class="btn grey-silver radius btn-delete text-righ"
                                    href="{{route('perdetail.index')}}">Hủy</a>
                                <input type="submit" class="btn green-meadow radius" name="yt0"
                                    value="Cập nhật"> </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
