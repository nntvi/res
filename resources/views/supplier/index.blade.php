@extends('layouts')
@section('content')
<div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Nhà cung cấp
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Danh mục</a></li>
                            <li class="breadcrumb-item"><a href="#">Nhà cung cấp</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-right">
                    <a class="btn green-meadow radius" data-type="1" onclick="return export_customer()"
                        style="margin-left: 5px">
                        Xuất danh sách nhà cung cấp</a>
                    <input type="hidden" id="data-type" value="1">
                    <a class="btn green-meadow radius" href="{{route('supplier.store')}}">
                        Tạo mới </a>
                </div>
            </div>
            <div class="portlet box green-meadow" style="margin-top: 10px;">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-coffee"></i>
                        Nhà cung cấp </div>

                </div>

                <div class="portlet-body">
                    <div class="row" style="margin: 10px 0px;">

                    </div>
                    <div class="table-responsive">
                        <div id="news-grid" class="grid-view">

                            <table class="table table-bordered table-hover data-table">
                                <thead>
                                    <tr>
                                        <th width="3%" id="news-grid_c1">STT</th>
                                        <th width="15%" id="news-grid_c1">Mã NCC</th>
                                        <th width="20%" id="news-grid_c1">Tên</th>
                                        <th width="15%" id="news-grid_c2">Địa chỉ</th>
                                        <th width="15%" id="news-grid_c3">Số điện thoại</th>
                                        <th width="15%" id="news-grid_c4">Email</th>
                                        <th width="15%" id="news-grid_c4">Ghi chú</th>
                                        <th id="news-grid_c8">Trạng thái</th>
                                        <th width="7%" id="news-grid_c9">Cập nhật</th>
                                        <th width="7%" id="news-grid_c10">Xóa</th>
                                    </tr>
                                </thead>
                                    <tbody>
                                        @foreach ($suppliers as $key => $supplier)
                                            <form action="" method="POST">
                                                <tr class="odd">
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $supplier->code }}</td>
                                                    <td>{{ $supplier->name }}</td>
                                                    <td>{{ $supplier->address }}</td>
                                                    <td>{{ $supplier->phone }}</td>
                                                    <td>{{ $supplier->email }}</td>
                                                    <td>{{ $supplier->note }}</td>
                                                    <td>
                                                        @if ($supplier->status == '0')
                                                        <a href="" class="update_status btn default btn-xs green radius">
                                                            Chưa Hoạt động
                                                        </a>
                                                        @else
                                                        <a href=""  class="update_status btn default btn-xs green radius"><i class="fa fa-check"></i>
                                                            Hoạt động
                                                        </a>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{route('supplier.update',['id' => $supplier->id])}}" class="btn default btn-xs yellow-crusta radius"><i
                                                            class="fa fa-edit"> Cập nhật</i>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a href="{{route('supplier.delete',['id' => $supplier->id])}}"
                                                                    class="btn default btn-xs red radius"
                                                                    onclick="return confirm('Bạn muốn xóa nhà cung cấp này?')">
                                                                    <i class="fa fa-trash-o"> Xóa</i>
                                                                </a>
                                                    </td>
                                                </tr>
                                            </form>
                                        @endforeach
                                    </tbody>
                            </table>

                            <div class="keys" style="display:none"
                                title="/backend/shop/customer?supplier=1"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
