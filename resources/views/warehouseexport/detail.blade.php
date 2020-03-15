@extends('layouts')
@section('content')
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            Chi tiết phiếu xuất {{ $code }}
            <div class="print text-right">
                <a href="{{route('warehouse_export.detail',['code' => $code])}}">
                    <i class="fa fa-print" aria-hidden="true"></i>
                </a>
            </div>
        </div>
        <div>
        <table class="table" ui-jq="footable" ui-options='{
            "paging": {
            "enabled": true
            },
            "filtering": {
            "enabled": true
            },
            "sorting": {
            "enabled": true
            }}'>
            <thead>
            <tr>
                <th>STT</th>
                <th>Tên mặt hàng</th>
                <th>Số lượng xuất</th>
                <th>Đơn vị tính</th>
                <th style="width:30px;"></th>
            </tr>
            </thead>
            <tbody>
                @foreach ($detailExports as $key => $item)
                    <tr data-expanded="true">
                        <td>{{$key+1}}</td>
                        <td>{{$item->materialDetail->name}}</td>
                        <td>{{ $item->qty }}</td>
                        <td>{{ $item->unit->name}}</td>
                        {{--  <td>
                            <a href="#myModal{{$item->id}}" data-toggle="modal" class="active" ui-toggle-class=""><i class="fa fa-pencil-square-o text-success text-active"></i></a>
                            <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal{{$item->id}}" class="modal fade">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                                <h4 class="modal-title">Cập nhật chi tiết mặt hàng</h4>
                                            </div>
                                            <div class="modal-body">
                                                <form role="form" action="{{route('warehouse.p_detail',['id' => $item->id])}}" method="POST">
                                                    @csrf
                                                    <div class="form-group">
                                                        <div class="col-xs-12">
                                                            <label>Tên mặt hàng</label>
                                                            <input type="text" class="form-control" value="{{ $item->materialDetail->name }}" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-xs-6">
                                                            <div class="space"></div>
                                                            <label >Số lượng nhập</label>
                                                            <input type="number" class="form-control" value="{{ $item->qty }}" name="qty">
                                                        </div>
                                                        <div class="col-xs-6">
                                                            <div class="space"></div>
                                                            <label >Đơn vị tính</label>
                                                            <select class="device form-control" name="id_unit" >
                                                                <option class="deviceType" value="{{ $item->unit->id }}">{{$item->unit->name}}</option>
                                                                @foreach ($units as $unit)
                                                                    <option class="deviceType" value="{{ $unit->id }}">{{$unit->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-xs-12">
                                                            <label>Giá nhập</label>
                                                            <input type="number" class="form-control" value="{{ $item->price }}" name="price">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xs-12 text-center">
                                                                <div class="space"></div>
                                                                <button type="submit" class="btn btn-default">Submit</button>
                                                        </div>

                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <a href="" onclick="return confirm('Bạn muốn xóa dữ liệu này?')"><i class="fa fa-times text-danger text"></i></a>
                        </td>  --}}
                    </tr>
                @endforeach
            </tbody>
        </table>

        </div>
    </div>
    <a href="{{route('warehouse.index')}}"">
        <button  class="btn btn-info">Trở về</button>
    </a>

</div>
@endsection
