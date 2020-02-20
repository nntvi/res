@extends('layouts')
@section('content')
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Hàng hóa
            </div>
            <div class="portlet box green-meadow" style="margin-top: 20px;">
                    <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-coffee"></i>
                                Thêm mới nhóm thực đơn</div>
                        </div>
                        <div class="portlet-body">
                            <div class="row">
                            </div>
                            <div class="table-responsive">
                                <div class="form">
                                    <form class="panel-body"
                                        id="createNews-form" action="{{route('groupmenu.store')}}" method="POST">
                                        @csrf
                                        <div class="row">
                                                <div class="col-md-4">
                                                    <label class="control-label"
                                                        for="">Nhập tên nhóm thực đơn<span style="color: #ff0000"></span></label>
                                                    <input type="text" class="form-control" name="name">
                                                        <span class="error-message">{{ $errors->first('name') }}</span></p>

                                                </div>
                                                <div class="col-md-4">
                                                    <label class="control-label"  style="display:block; margin-bottom: 16px" for="">Chọn bếp<span style="color: #ff0000"></span></label>
                                                    @foreach ($cook_active as $item)
                                                        <label style="display:inline">{{$item->name}}</label>
                                                        <input value="{{$item->id}}" id="cook{{$item->id}}" type="radio" name="idCook" style="margin-right: 20px">
                                                    @endforeach
                                                </div>
                                                <div class="col-md-4 text-right" style=" margin: 23px 0px;">
                                                    <a class="btn grey-silver radius btn-delete text-right"
                                                        href="{{route('groupmenu.index')}}">Hủy</a>
                                                    <input type="submit" class="btn green-meadow radius btn-w-min"
                                                        style="margin-left:10px" value="Tạo mới">
                                                </div>
                                        </div>
                                        <div class="space"></div>
                                    </form>
                                </div>
                            </div>
                        </div>
            </div>
        </div>
    </div>
@endsection

