@extends('layouts')
@section('content')
<div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Danh mục
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Danh mục</a></li>
                            <li class="breadcrumb-item"><a href="#">Phòng bàn</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="row">
                <div class="col-md-9 col-sm-12">
                    <a class="btn btn-primary" href="#" role="button" style="margin-left: 19px">Nhập liệu
                        file excel</a>
                    <a class="btn btn-primary" href="{{route('table.store')}}" role="button"
                        style="margin-left: 5px">Tạo mới</a>
                </div>
            </div>
            <div class="portlet box green-meadow " style="margin-top: 20px;">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-coffee"></i>
                        Thêm mới khu vực
                    </div>
                </div>

                <div class="portlet-body">
                    <div class="row" style="margin: 10px 2px;">
                        <div class="col-md-6">
                            <button class="btn red radius btn-delete" id="deleteList_area">Xóa danh
                                sách</button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" name="checkall" id="delete_checkbox"></th>
                                    <th>STT</th>
                                    <th>Mã bàn</th>
                                    <th>Tên bàn</th>
                                    <th>Khu vực</th>
                                    <th>Cập nhật</th>
                                    <th>Xóa</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- @foreach ($areatables as $areatable)
                                    @foreach($areatable->hasTable as $key => $hasTable)
                                        {{ $hasTable->belongsToTable->name }}
                                    @endforeach

                                @endforeach --}}
                                @foreach ($tables as $key => $table)
                                    <tr>
                                        <td><input class="delete_checkbox_item" type="checkbox"
                                                name="delete_checkbox_item[]" value="235080">
                                        </td>
                                        <td style="width: 10px">{{$key+1}}</td>
                                        <td>{{$table->code}}</td>
                                        <td>{{$table->name}}</td>
                                        <td>{{$table->getArea->name}}</td>
                                        <td>
                                            <a href="{{route('table.update',['id' => $table->id])}}"
                                                class="btn default btn-xs yellow-crusta radius">
                                                <i class="fa fa-edit"> Cập nhật</i>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{route('table.delete',['id'=>$table->id])}}"
                                                class="btn default btn-xs red radius" onclick="return confirm('Bạn muốn xóa dữ liệu này?')">
                                                <i class="fa fa-trash-o"> Xóa</i>
                                            </a>
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
        </div>
    </div>
@endsection
