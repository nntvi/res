@extends('layouts')
@section('content')
<div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Nhà cung cấp
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Danh mục</a></li>
                            <li class="breadcrumb-item"><a href="#">Nhà cung cấp</a></li>
                            <li class="breadcrumb-item"><a href="#">Thêm mới</a></li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="portlet box green-meadow" style="border-top:1px solid #2ae0bb">
                <div class="portlet-title hold-tab">
                    <div class="caption">
                        <i class="fa fa-gift"></i>
                            Thêm mới nhà cung cấp
                    </div>
                </div>
                <div class="portlet-body">
                    <div id="bootstrap_alerts_demo"></div>
                    <div style="padding: 20px">
                        <form class="no-margin form form-horizontal" enctype="multipart/form-data"
                            id="create-timetracker-form" action="{{route('supplier.p_store')}}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="title">
                                        Mã nhà cung cấp:
                                    </label>
                                    <div class="col-md-4">
                                        <input type="text" size="40" class="form-control col-md-7 required"
                                            name="code" maxlength="30">
                                            <span class="error-message">{{ $errors->first('code') }}</span></p>

                                    </div>
                                    <label class="col-md-2 control-label" for="title">
                                        Tên nhà cung cấp:
                                    </label>
                                    <div class="col-md-4">
                                        <input type="text" size="40" class="form-control"
                                            name="name" maxlength="60">
                                            <span class="error-message">{{ $errors->first('name') }}</span></p>

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="title">
                                        Email:
                                    </label>
                                    <div class="col-md-4">
                                        <input type="email" size="40" class="form-control"
                                            name="email" maxlength="100">
                                            <span class="error-message">{{ $errors->first('email') }}</span></p>
                                    </div>
                                    <label class="col-md-2 control-label" for="title">
                                        Địa chỉ:
                                    </label>
                                    <div class="col-md-4">
                                        <input type="text" size="40" class="form-control"
                                            name="address" maxlength="150">
                                        <span class="error-message">{{ $errors->first('address') }}</span></p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group">
                                    <label class="col-md-2 control-label">
                                        Số điện thoại:
                                    </label>
                                    <div class="col-md-4">
                                        <input type="text" size="40" class="form-control"
                                            name="phone" id="Account_phone" maxlength="30">
                                            <span class="error-message">{{ $errors->first('phone') }}</span></p>
                                    </div>
                                    <label class="col-md-2 control-label">
                                        Trạng thái:
                                    </label>
                                    <div class="col-md-4" style="margin-top: 15px">
                                        <label style="display:inline">Hoạt động</label>
                                            <input value="0" id="status1" type="radio" name="status" style="margin-right: 20px">
                                        <label style="display:inline">Chưa hoạt động</label>
                                            <input  value="1" id="status2" type="radio" name="status">
                                    </div>
                                    <span class="error-message">{{ $errors->first('status') }}</span></p>

                                </div>
                            </div>

                            <div class="row">
                                    <div class="form-group">
                                        <label class="col-md-2 control-label" for="title">
                                            Mã số thuế:
                                        </label>
                                        <div class="col-md-4">
                                            <input type="text" size="40" class="form-control"
                                                name="mst" maxlength="100">
                                            <span class="error-message">{{ $errors->first('mst') }}</span></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                        <div class="form-group">
                                            <label class="col-md-2 control-label" for="title">
                                                 Ghi chú:
                                            </label>
                                            <div class="col-md-8">
                                                <textarea type="text" size="40" class="form-control" rows="4"
                                                    name="note">
                                                </textarea>
                                            </div>
                                        </div>
                                    </div>
                            <div class="row" style="margin-top: 20px">
                                    <div class="form-group">
                                        <div class="col-md-5 col-md-offset-5">
                                            <input type="submit" id="btn-create " style="width:105px"
                                                class="btn green-meadow radius" name="yt1" value="Tạo mới">
                                        </div>
                                    </div>
                                </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
