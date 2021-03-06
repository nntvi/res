@extends('layouts')
@section('content')
<div class="table-agile-info">
    <div class="space"></div>
    <div class="panel panel-default">
        <div class="panel-heading" style="margin-bottom: 15px">
            Chi tiết công thức món: <b>{{ $material->name }}</b>
        </div>
        <div>
            <table class="table" ui-jq="footable" ui-options="{
                &quot;paging&quot;: {
                &quot;enabled&quot;: true
                },
                &quot;filtering&quot;: {
                &quot;enabled&quot;: true
                },
                &quot;sorting&quot;: {
                &quot;enabled&quot;: true
                }}" id="example">
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
                    @foreach($material->materialAction as $key => $item)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $item->materialDetail->name }}</td>
                            <td>{{ $item->qty }}</td>
                            <td>{{ $item->unit->name }}</td>
                            <td>
                                <a href="#update{{ $item->id }}" data-toggle="modal">
                                    <button class="btn btn-xs btn-success">Cập nhật</button>
                                </a>
                                <div aria-hidden="true" aria-labelledby="update" role="dialog" tabindex="-1"
                                    id="update{{ $item->id }}" class="modal fade" style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button aria-hidden="true" data-dismiss="modal" class="close"
                                                    type="button">×</button>
                                                <h4 class="modal-title">Cập nhật công thức</h4>
                                            </div>
                                            <div class="modal-body">
                                                <form role="form"
                                                    action="{{ route('material_action.p_update',['id' => $item->id]) }}"
                                                    method="POST">
                                                    @csrf
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-xs-6">
                                                                <label>Tên món</label>
                                                                <input class="form-control"
                                                                    value="{{ $item->material->name }}" disabled>
                                                            </div>
                                                            <div class="col-xs-6">
                                                                <label>Tên NVL</label>
                                                                <input class="form-control"
                                                                    value="{{ $item->materialDetail->name }}"
                                                                    disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-xs-6">
                                                                <label>Đơn vị</label>
                                                                <input class="form-control"
                                                                    value="{{ $item->unit->name }}" disabled>
                                                            </div>
                                                            <div class="col-xs-6">
                                                                <label>Số lượng</label>
                                                                @if ($item->unit->name == "Lon" || $item->unit->name == "Chai" )
                                                                    <input class="form-control" name="qty" type="number" min="1" value="{{ $item->qty }}" required>
                                                                @else
                                                                    <input class="form-control" name="qty" type="number" min="0" step="any" value="{{ $item->qty }}" required>
                                                                @endif

                                                            </div>
                                                        </div>
                                                        <div class="space"></div>
                                                        <div class="space"></div>
                                                        <div class="form-group">
                                                            <div class="col-xs-12 text-center">
                                                                <button type="submit" class="btn btn-default">Chỉnh
                                                                    sửa</button>
                                                            </div>
                                                        </div>
                                                        <div class="space"></div>

                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <a href="{{ route('material_action.delete',['id' => $item->id]) }}"
                                    class="btn default btn-xs red radius"
                                    onclick="return confirm('Bạn muốn xóa dữ liệu này?')">
                                    <i class="fa fa-trash-o"> Xóa</i>
                                </a>
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
            $('input[type="search"]').addClass('form-control');
            $('.dataTables_length').html(`<a href="{{ route('material.index') }}" class="btn btn-default btn-sm  radius">
                Trở về
            </a>`)
        } );
    </script>
@endsection
