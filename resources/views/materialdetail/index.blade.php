@extends('layouts')
@section('content')
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Phân quyền
            </div>
            <div class="portlet box green-meadow" style="margin-top: 20px;">
                    <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-gift"></i>
                                Thêm mới và tìm kiếm nguyên vật liệu
                            </div>
                    </div>
                        <div class="portlet-body">
                                <div class="row">
                                        <div class="col-md-6 col-sm-12" style=" margin-top: 25px;">
                                            <form action="{{route('material_detail.search')}}" method="POST">
                                                @csrf
                                                <div class="col-md-6 col-sm-4">
                                                    <input type="text" size="40" class="form-control radius" placeholder="Tên món ăn" name="nameSearch">
                                                </div>
                                                <div class="col-md-2 col-sm-12 text-center">
                                                        <input type="submit" class="btn green-meadow radius" name="yt0"
                                                            value="Tìm kiếm">
                                                </div>
                                            </form>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <div class="form mr-3 text-right">
                                                <form class="panel-body" enctype="multipart/form-data" role="form" id="searchFood-form"
                                                    action="{{route('material_detail.store')}}" method="POST" >
                                                    @csrf
                                                        <div class="row">
                                                            <div class="col-md-8 col-sm-4">
                                                                <input type="text" size="40" class="form-control radius" placeholder="Tên món ăn"
                                                                    name="name">
                                                            </div>
                                                            <div class="col-md-2 col-sm-12 text-center">
                                                                <input type="submit" class="btn green-meadow radius" name="yt0"
                                                                    value="Thêm mới">
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
                                        Danh sách nguyên vật liệu
                                    </div>
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
                                                    <th>Tên nguyên vật liệu</th>
                                                    <th>Cập nhật</th>
                                                    <th>Xóa</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($materialDetails as $key => $materialDetail)
                                                    <tr>
                                                        <td width="20%">{{$key + 1}}</td>
                                                        <form method="POST" action="{{route('material_detail.update',['id' => $materialDetail->id])}}">
                                                                @csrf
                                                                <td width="50%">
                                                                    <input type="hidden" name="AreaId" value="">
                                                                    <input width="30%" class="form-control" type="text"
                                                                        name="name" value="{{$materialDetail->name}}">
                                                                </td>
                                                        <td width="10%">
                                                            <button type="submit"
                                                                class="btn default btn-xs yellow-crusta radius"><i
                                                                    class="fa fa-edit"> Cập nhật</i></button>
                                                        </td>
                                                        </form>
                                                        <td width="10%">
                                                            <a href="{{route('material_detail.delete',['id' => $materialDetail->id])}}"
                                                                class="btn default btn-xs red radius">
                                                                    <i class="fa fa-trash-o" onclick="return confirm('Bạn muốn xóa dữ liệu này?')"> Xóa</i>

                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                                <footer class="panel-footer">
                                        <div class="row">

                                            <div class="col-sm-5 text-center">
                                                <small class="text-muted inline m-t-sm m-b-sm">showing 20-30 of 50 items</small>
                                            </div>
                                            <div class="col-sm-7 text-right text-center-xs">
                                               {{ $materialDetails->links() }}
                                            </div>
                                        </div>
                                    </footer>
                        </div>
             </div>
            </div>
        </div>
    </div>
@endsection
