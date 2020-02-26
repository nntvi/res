@extends('layouts')
@section('content')
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Chi tiết nguyên vật liệu
            </div>
            <div class="portlet box green-meadow" style="margin-top: 20px;">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-coffee"></i>
                        Danh sách chi tiết món :
                        @foreach ($materials as $material)
                            {{ $material->name }}
                        @endforeach
                    </div>
                </div>
                <div class="portlet-body">
                        <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">STT</th>
                                            <th scope="col">Tên nguyên vật liệu</th>
                                            <th scope="col">Số lượng</th>
                                            <th scope="col">Đơn vị tính</th>
                                            <th scope="col">Cập nhật</th>
                                            <th scope="col">Xóa</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($materials as $material)
                                            @foreach ($material->materialAction as $key => $item)
                                            <tr>
                                                <td>{{$key+1}}</td>
                                                <td>{{ $item->materialDetail->name }}</td>
                                                <td>{{ $item->qty}}</td>
                                                <td>{{ $item->unit->name}}</td>
                                                <td>
                                                    <a href="{{route('material_action.update',['id' => $item->id])}}" class="btn default btn-xs yellow-crusta radius"><i
                                                        class="fa fa-edit"> Cập nhật</i>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="{{route('material_action.delete',['id' => $item->id])}}"  class="btn default btn-xs red radius"
                                                        onclick="return confirm('Bạn muốn xóa dữ liệu này?')">
                                                            <i class="fa fa-trash-o"> Xóa</i>
                                                    </a>
                                                </td>
                                            </tr>
                                            @endforeach
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

                                  </div>
                                </div>
                        </footer>
                </div>
             </div>
            </div>
        </div>
    </div>
@endsection
