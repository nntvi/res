@extends('layouts')
@section('content')
<div class="typo-agile">
    <div class="panel panel-default">
        <div class="panel-heading">
            Nhà cung cấp
        </div>
        <div class="table-responsive">
            <table class="table table-striped b-t b-light" id="example">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Mã NCC</th>
                        <th>Tên Nhà cung cấp</th>
                        <th>Địa chỉ</th>
                        <th>Số điện thoại</th>
                        <th>Email</th>
                        <th>Cung cấp</th>
                        <th>Trạng thái</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="tableSuppliers">
                    @foreach($suppliers as $key => $supplier)
                        <tr class="odd">
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $supplier->code }}</td>
                            <td style="font-weight:bold">
                                <a href="#updateName{{ $supplier->id }}" data-toggle="modal">
                                    <i class="fa fa-pencil-square-o text-info" aria-hidden="true"></i>
                                </a>
                                <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="updateName{{ $supplier->id }}" class="modal fade" style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                                <h4 class="modal-title">Chỉnh sửa tên NCC</h4>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('supplier.p_updatename',['id' => $supplier->id ]) }}" method="POST">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label>Tên hiện tại</label>
                                                        <input class="form-control" value="{{ $supplier->name }}" disabled>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Tên cần chỉnh sửa</label>
                                                        <input class="form-control" name="name" value="{{ $supplier->name }}" required>
                                                    </div>
                                                    <div class="space"></div>
                                                    <div class="row">
                                                        <div class="col-xs-12 text-center">
                                                            <button type="submit" class="btn btn-default">Cập nhật</button>
                                                        </div>
                                                    </div>
                                                    <div class="space"></div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{ $supplier->name }}
                            </td>
                            <td>{{ $supplier->address }}</td>
                            <td style="font-weight:bold">{{ $supplier->phone }}</td>
                            <td>{{ $supplier->email }}</td>
                            <td style="font-weight:bold">{{ $supplier->typeMaterial->name }}</td>
                            <td>
                                @if($supplier->status == '0')
                                    Ngưng Hoạt động
                                @else
                                    Hoạt động
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('supplier.update',['id' => $supplier->id]) }}"
                                    class="active" ui-toggle-class=""><i
                                        class="fa fa-pencil-square-o text-success text-active"></i></a>
                                {{--  <a href="{{ route('supplier.delete',['id' => $supplier->id]) }}"
                                    onclick="return confirm('Bạn muốn xóa dữ liệu này?')"><i
                                        class="fa fa-times text-danger text"></i></a>  --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <script>
        @if(session('success'))
            toastr.success('{{ session('success') }}')
        @endif
        @if(session('info'))
            toastr.info('{{ session('info') }}')
        @endif
    </script>
    <script type="text/javascript" language="javascript" src="{{ asset('js/data.table.js') }}"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>
    <script>
        $(document).ready( function () {
            $('#example').dataTable();
            $('#example_info').addClass('text-muted');
            $('input[type="search"]').addClass('form-control');
            $('#example_length').html(
                `<a href="{{ route('supplier.store') }}">
                        <button class="btn btn-sm btn-default">Thêm mới</button>
                </a>`
            );
        });
    </script>
</div>
@endsection
