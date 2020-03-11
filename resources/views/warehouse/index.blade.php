@extends('layouts')
@section('content')
<div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
            Nhập xuất Kho
            </div>
            <div class="row w3-res-tb">
            <div class="col-sm-5 m-b-xs">
                <a href="{{route('warehouse.import')}}">
                    <button class="btn btn-md btn-info">Nhập Kho</button>
                </a>
                <a href="">
                    <button class="btn btn-md btn-success">Xuất Kho</button>
                </a>
            </div>
            <div class="col-sm-4">
            </div>
            <div class="col-sm-3">
                <div class="input-group">
                <input type="text" class="input-sm form-control" placeholder="Search">
                <span class="input-group-btn">
                    <button class="btn btn-sm btn-default" type="button">Go!</button>
                </span>
                </div>
            </div>
            </div>
            <div class="table-responsive">
            <table class="table table-striped b-t b-light">
                <thead>
                <tr>
                    <th>STT</th>
                    <th>Mã phiếu</th>
                    <th>Tổng tiền</th>
                    <th>Nhà cung cấp</th>
                    <th>Ghi chú</th>
                    <th>Ngày tạo</th>
                    <th>Chi tiết</th>

                </tr>
                </thead>
                <tbody>
                    @foreach ($listImports as $key => $import)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$import->code}}</td>
                        <td>{{ number_format($import->total) . ' đ'}}</td>
                        <td>{{$import->supplier->name}}</td>
                        <td>{{$import->note}}</td>
                        <td>{{$import->created_at}}</td>
                        <td><a href="{{route('warehouse.detail',['code' => $import->code])}}">Xem chi tiết</a></td>
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
