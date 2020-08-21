@extends('layouts')
@section('content')
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            Công thức tính hệ số giá bán món ăn
        </div>
        <div>
            <table class="table table-responsive table-striped b-t b-light" id="example">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th class="text-center">Công thức bằng chữ</th>
                        <th class="text-center">Công thức bằng số</th>
                        <th class="text-center">Kết quả</th>
                        <th class="text-center">Trạng thái</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($methods as $key => $method)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td class="text-center">({{ $method->textTuso }}) / ({{ $method->textMauso }})</td>
                            <td class="text-center">({{ $method->tuso }}) / ({{ $method->mauso  }})</td>
                            <td class="text-center">{{ $method->result }}</td>
                            <td class="text-center">{{ $method->status == '1' ? 'Đang sử dụng' : 'Chưa được sử dụng' }}</td>
                            <td>
                                @if ($method->status == '0')
                                    <a href="{{ route('method.update',['id' => $method->id ]) }}" class="active" ui-toggle-class="" onclick="return confirm('Bạn muốn kích hoạt công thức này?')">
                                        <i class="fa fa-check text-success text-active"></i>
                                    </a>
                                    <a href="{{ route('method.delete',['id' => $method->id ]) }}" class="active" ui-toggle-class="" onclick="return confirm('Bạn muốn xóa công thức này?')">
                                            <i class="fa fa-times text-danger"></i>
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
    <script>
            @if(session('success'))
                toastr.success('{{ session('success') }}')
            @endif
            @if(session('warning'))
                toastr.warning('{{ session('warning') }}')
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
                `<a href="#myModal" data-toggle="modal" class="btn btn-sm btn-default">
                        Tạo mới
                    </a>
                    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade" style="display: none;">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                        <h4 class="modal-title">Tạo công thức tính hệ số giá bán</h4>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('method.storyQty') }}" method="get">
                                            @csrf
                                            <div class="form-group row">
                                                <div class="col-xs-6">
                                                    <label>Số lượng phần tử trên tử</label>
                                                    <input type="number" min="1" class="form-control" name="qtyTu" required>
                                                </div>
                                                <div class="col-xs-6">
                                                    <label>Số lượng phần tử dưới mẫu</label>
                                                    <input type="number" min="1" class="form-control" name="qtyMau" required>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-default">Tạo</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                    </div>
                <a href="{{ route('method.reset') }}" onclick="return confirm('Bạn có chắc muốn hủy kích hoạt các hệ số hiện tại?')" class="btn btn-sm btn-default">
                    Reset
                </a>`
            );
        } );
    </script>
@endsection
