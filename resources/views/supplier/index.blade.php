@extends('layouts')
@section('content')
<div class="typo-agile">
	<h2 class="w3ls_head">Nhà cung cấp</h2>
            <div class="panel panel-default">
                <div class="panel-heading">

                </div>
                <div class="row w3-res-tb">
                <div class="col-sm-5 m-b-xs">
                    <a href="{{route('supplier.store')}}">
                            <button class="btn btn-sm btn-default">Thêm mới</button>
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
                    <tr style="background: linear-gradient(45deg, #f3bfbf, #0000000d);">
                            <th >STT</th>
                            <th >Mã NCC</th>
                            <th>Tên</th>
                            <th >Địa chỉ</th>
                            <th >Số điện thoại</th>
                            <th >Email</th>
                            <th >Cung cấp</th>
                            <th >Trạng thái</th>
                            <th></th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($suppliers as $key => $supplier)
                            <tr class="odd">
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $supplier->code }}</td>
                                    <td style="font-weight:bold">{{ $supplier->name }}</td>
                                    <td>{{ $supplier->address }}</td>
                                    <td style="font-weight:bold">{{ $supplier->phone }}</td>
                                    <td>{{ $supplier->email }}</td>
                                    <td style="font-weight:bold">{{ $supplier->typeMaterial->name}}</td>
                                    <td>
                                        @if ($supplier->status == '0')
                                            Chưa Hoạt động
                                        @else
                                            Hoạt động
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{route('supplier.update',['id' => $supplier->id])}}" class="active" ui-toggle-class=""><i class="fa fa-pencil-square-o text-success text-active"></i></a>
                                        <a href="{{route('supplier.delete',['id' => $supplier->id])}}" onclick="return confirm('Bạn muốn xóa dữ liệu này?')"><i class="fa fa-times text-danger text"></i></a>
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
