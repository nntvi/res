@extends('layouts')
@section('content')
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Chi tiết nguyên vật liệu
            </div>
            <div class="portlet box green-meadow" style="margin-top: 20px;">
                    {{--  <a href="{{route('material_action.store')}}" class="btn radius btn btn-warning btn-add"  style="margin: 10px 10px; background:orange; color:black">Thêm mới</a>  --}}
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-coffee"></i>
                        Danh sách chi tiết nguyên vật liệu</div>
                </div>
                <div class="portlet-body">
                        <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">STT</th>
                                            <th scope="col">Thuộc nhóm NVL</th>
                                            <th scope="col">Tên nguyên vật liệu</th>
                                            <th scope="col">Xem chi tiết</th>
                                            <th> Thêm chi tiết</th>
                                            </tr>
                                    </thead>
                                    <tbody>

                                            @foreach($materials as $key => $material)
                                            <tr>
                                                <th scope="row">{{ $key + 1}}</th>
                                                <td>{{$material->name}}</td>
                                                <td>
                                                    @foreach ($material->materialAction as $key => $item)
                                                        {{ $item->materialDetail->name }} {{ count($material->materialAction) != $key+1 ? ',' : '' }}
                                                    @endforeach
                                                </td>
                                                <td>
                                                    <a href="{{route('material_action.detail',['id' => $material->id])}}">Xem chi tiết</a>
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{route('material_action.store',['id' => $material->id])}}">
                                                        <i class="fa fa-plus-circle" aria-hidden="true" style="font-size: 17px; color: darkgreen"></i>
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

                                  </div>
                                </div>
                        </footer>
                </div>
             </div>
            </div>
        </div>
    </div>
@endsection
