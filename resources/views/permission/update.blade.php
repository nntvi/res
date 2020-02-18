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
                                <li class="breadcrumb-item"><a href="#">Cập nhật quyền</a></li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="portlet box green-meadow">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-coffee"></i>
                            Cập nhật</div>
                        <div class="tools">
                        </div>
                    </div>
                    <div class="portlet-body">
                        <!-- <div class="row">
                        <div class="col-md-3 col-md-offset-9 text-right">
                            <a href="" class="btn grey-silver radius btn-delete text-right"></a>
                        </div>
                    </div> -->
                        <div class="table-responsive">
                                <div class="form">
                                    <form class="panel-body" enctype="multipart/form-data" role="form"
                                            id="createNews-form" action="{{ route('permission.p_update',['id' => $permission->id])}}" method="POST">
                                        @csrf
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label class="control-label"
                                                            for="">Tên quyền cũ<span style="color: #ff0000"> *</span></label> <input
                                                            type="text" size="40" class="form-control"
                                                            disabled="disabled" name="oldName"
                                                            id="" value="{{$permission->name}}">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label class="control-label" for="">Nhập tên quyền mới<span style="color: #ff0000">*</span></label>
                                                        <input type="text" size="40" class="form-control" name="name" maxlength="255" value="{{$permission->name}}">
                                                    </div>
                                                    <div class="col-md-3">
                                                            <label class="control-label"
                                                            for="">Cập nhật quyền<span style="color: #ff0000"> *</span></label>
                                                            <div class="role">
                                                                    <ul>
                                                                        <li>
                                                                            <div class="cover-role">
                                                                                <div class="cover-role-title"><label class="control-label"
                                                                                    for="">Cập nhật quyền<span style="color: #ff0000"></span></label> <i class="fa fa-caret-down" aria-hidden="true"></i></div>
                                                                                <div class="cover-role-body" id="filters">
                                                                                    <ul>
                                                                                        @foreach ($data as $value)
                                                                                            @if ($value['flag'] == true)
                                                                                            <li><input id="{{$value['id'] . 'check'}}" value="{{$value['id']}}" type="checkbox" name="permissiondetail[]" checked/>
                                                                                            <label style="display:inline; margin-right:10px;" for="{{$value['id'] . 'check'}}">{{ $value['name'] }}</label></li>
                                                                                        @else
                                                                                            </li><input id="{{$value['id'] . 'check'}}" value="{{$value['id']}}" type="checkbox" name="permissiondetail[]" />
                                                                                            <label style="display:inline; margin-right:10px;" for="{{$value['id'] . 'check'}}">{{ $value['name'] }}</label></li>
                                                                                        @endif
                                                                                        @endforeach
                                                                                    </ul>
                                                                                </div>
                                                                            </div>
                                                                        </li>
                                                                        <li>
                                                                        </li>
                                                                    </ul>
                                                            </div>
                                                    </div>

                                                </div>
                                            </div>
                                            {{--  <div class="row">
                                                <div class="col-md-12">
                                                        <div class="row margin-top">
                                                                <label class="control-label" for="" style="margin-right: 40px;">Chứa chi tiết quyền:      </label>
                                                                @foreach ($data as $value)
                                                                    @if ($value['flag'] == true)
                                                                    <input id="{{$value['id'] . 'check'}}" value="{{$value['id']}}" type="checkbox" name="permissiondetail[]" checked/>
                                                                    @else
                                                                    <input id="{{$value['id'] . 'check'}}" value="{{$value['id']}}" type="checkbox" name="permissiondetail[]" />
                                                                    @endif
                                                                    <label style="display:inline; margin-right:10px;" for="{{$value['id'] . 'check'}}">{{ $value['name'] }}</label>
                                                                @endforeach

                                                                <div class="errorMessage" id="ShopCustomer_priceplan_em_"
                                                                    style="display:none"></div>
                                                                </div>
                                                            </div>
                                                </div>
                                            </div>  --}}
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-12 text-right">
                                                        <a href="{{route('permission.index')}}" class="btn grey-silver radius btn-delete
                                                        text-right">Hủy</a>
                                                        <input type="submit" class="btn green-meadow radius"
                                                            style="width:105px" name="yt0" value="Cập nhật">
                                                    </div>
                                                    <div class="space"></div>
                                                </div>
                                            </div>
                                            <div class="space"></div>
                                    </form>
                                </div>
                        </div>
                </div>
            </div>
        </div>
@endsection
