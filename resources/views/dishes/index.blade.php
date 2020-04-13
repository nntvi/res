@extends('layouts')
@section('content')
<div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Đồ uống - Món Ăn
            </div>
            <div class="row">
                    <div class="col-md-4 col-sm-12" style=" margin-top: 25px;">
                        <a class="btn btn-info" href="{{route('dishes.store')}}" role="button" style="margin-left: 15px">Thêm mới món ăn</a>
                    </div>
                    <div class="col-md-8 col-sm-12">
                        <div class="form mr-3 text-right">
                            <form class="panel-body" enctype="multipart/form-data" role="form" id="searchFood-form"
                                action="{{route('dishes.search')}}" method="POST" >
                                @csrf
                                    <div class="row">
                                        <div class="col-md-5 col-sm-12">
                                            <input type="text" size="40" class="form-control radius" placeholder="Tên món ăn"
                                                name="nameSearch">
                                        </div>
                                        <div class="col-md-5 col-sm-12">
                                            <select class="form-control radius" name="idGroupMenuSearch">
                                                    <option value="">-- Vui lòng chọn nhóm thực đơn --</option>
                                                    @foreach ($groupmenus as $groupmenu)
                                                        <option value="{{ $groupmenu->id }}">{{ $groupmenu->name }}</option>
                                                    @endforeach
                                            </select>
                                            <span class="error-message">{{ $errors->first('idGroupMenuSearch') }}</span></p>

                                        </div>
                                            <div class="col-md-2 col-sm-12">
                                                <input type="submit" class="btn btn-danger radius" name="yt0"
                                                    value="Tìm kiếm">
                                            </div>
                                    </div>
                            </form>
                        </div>
                    </div>
            </div>
            <div class="table-responsive">
                    <table class="table table-striped b-t b-light">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Hình minh họa</th>
                                <th>Mã sản phẩm</th>
                                <th>Tên món</th>
                                <th>Bếp</th>
                                <th>Nhóm thực đơn</th>
                                <th>Giá bán</th>
                                <th>Đơn vị tính</th>
                                <th>Trạng thái</th>
                                <th style="width:30px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dishes as $key => $dish)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td><img height="80px" width="90px" src="img/{{$dish->image}}"></td>
                                    <td>{{$dish->code}}</td>
                                    <td>{{ $dish->name }}</td>
                                    <td>{{$dish->groupMenu->cookArea->name}}</td>
                                    <td class="text-center">{{$dish->groupMenu->name}}</td>
                                    <td>{{ number_format("$dish->sale_price") . ' đ'}}</td>
                                    <td class="text-center" >{{$dish->unit->name}}</td>
                                    <td class="text-center">
                                        @if ($dish->status == '0')
                                            Ẩn
                                        @else
                                            Hiện
                                        @endif
                                    </td>

                                    <td>
                                        <a href="{{route('dishes.update',['id' => $dish->id])}}" class="active" ui-toggle-class=""><i
                                                class="fa fa-pencil-square-o text-success text-active"></i></a>
                                        <a href="{{route('dishes.delete',['id' => $dish->id])}}" onclick="return confirm('Bạn muốn xóa dữ liệu này?')"><i class="fa fa-times text-danger text"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            <footer class="panel-footer">
            <div class="row">

                <div class="col-sm-5 text-center">
                <small class="text-muted inline m-t-sm m-b-sm">showing 20-30 of 50 items</small>
                </div>
                <div class="col-sm-7 text-right text-center-xs">
                <ul class="pagination pagination-sm m-t-none m-b-none">
                    <li><a href=""><i class="fa fa-chevron-left"></i></a></li>
                    <li><a href="">1</a></li>
                    <li><a href="">2</a></li>
                    <li><a href="">3</a></li>
                    <li><a href="">4</a></li>
                    <li><a href=""><i class="fa fa-chevron-right"></i></a></li>
                </ul>
                </div>
            </div>
            </footer>
        </div>
    </div>
@endsection
