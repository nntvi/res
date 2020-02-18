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
                <div class="col-md-6">

                </div>
                <div class="col-md-6">
                        <div class="form mr-3">
                                <form class="panel-body" enctype="multipart/form-data" role="form"
                                    id="searchFood-form" action="{{route('groupmenu.search')}}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6 col-sm-4">
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
            </div>
            <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Tên thực đơn</th>
                                <th>Cập nhật</th>
                                <th>Xóa</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($groupmenus as $key => $groupmenu)
                                <tr>
                                    <td width="10%">{{$key+1}}</td>
                                    <form method="post" action="">
                                        @csrf
                                        <td width="30%">
                                            <input type="hidden" name="AreaId" value="">
                                            <input width="20%" class="form-control" type="text"
                                                name="AreaName" value="{{$groupmenu->name}}">
                                        </td>
                                    <td width="10%">
                                        <button type="submit"
                                            class="btn default btn-xs yellow-crusta radius"><i
                                                class="fa fa-edit"> Cập nhật</i></button>
                                    </td>
                                </form>
                                    @csrf
                                    <td width="10%">
                                        <a href="">
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
@endsection
