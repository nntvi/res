@extends('layouts')
<style>
    div#example_length {
        display: none;
    }
</style>
@section('content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Thiết lập công thức món ăn <b>"{{ $material->name }}"</b>
            </header>
            <div class="pannel-body">
                <div class="position-center">
                    <div class="form">
                        <form class="panel-body" role="form" onsubmit="return validateFormMaterialAction()"
                            action="{{ route('material_action.p_store',['id' => $material->id]) }}"
                            method="POST">
                            @csrf
                            <div class="col-md-12">
                                <input type="text" name="id_groupnvl" value="{{ $material->id }}" hidden>
                            </div>
                            @if(count($ingredients) > 0)
                                <div class="col-md-12">
                                    <div class="bs-docs-example">
                                        <label class="control-label">NVL đã tạo cho món<span
                                                style="color: #ff0000"></label>
                                        <div class="space"></div>
                                        <table class="table table-bordered" id="example">
                                            <thead>
                                                <tr>
                                                    <th>Stt</th>
                                                    <th>Tên NVL</th>
                                                    <th>Số lượng</th>
                                                    <th>Đơn vị tính</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($ingredients as $key => $item)
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>{{ $item->materialDetail->name }}</td>
                                                        <td>{{ $item->qty }}</td>
                                                        <td>{{ $item->unit->name }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endif
                            <div class="col-md-12">
                                    <div class="space"></div>
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <label class="control-label">Chọn danh mục nguyên vật liệu<span style="color: #ff0000">
                                                    *</span></label>
                                        </div>
                                        <div class="col-xs-6 text-right">
                                            <a href="#myModal" data-toggle="modal" class="btn btn-success">
                                                Chọn
                                            </a>
                                            <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade" style="display: none;">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                                                <h4 class="modal-title text-left">Chọn nguyên vật liệu từ danh mục</h4>
                                                            </div>
                                                            <div class="modal-body text-left">
                                                                    <div class="form-group">
                                                                        <label>Chọn danh mục</label>
                                                                        <select class="form-control" id="idTypeMaterialDetail">
                                                                            @foreach ($typeMaterialDetails as $detail)
                                                                                <option value="{{ $detail->id }}">{{ $detail->name }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="space"></div>
                                                                    <div class="form-group row" id="areaNVL">

                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-xs-12 text-center">
                                                                            <span id="getNVL" class="btn btn-default">Chọn</span>
                                                                        </div>
                                                                    </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="space"></div>
                                    <div id="material-detail">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th width=65%>Tên NVL  (Đơn vị) </th>
                                                    <th width=25%>Số lượng</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody class="list" id="bodyMaterialAction">

                                            </tbody>
                                        </table>
                                    </div>
                            </div>
                            <script>
                                function clickToRemove(id){
                                    var row = document.getElementById('row'+id);
                                    row.remove();
                                }
                                $(document).ready( function () {
                                    $('#example').dataTable({
                                        "info":     false,
                                        "filter" : false,
                                    });
                                });
                            </script>
                            <div class="row">
                                <div class="col-xs-12 text-center">
                                    <a href="{{ route('material.index') }}" class="btn btn-default">Trở về</a>
                                    <button type="submit" class="btn green-meadow radius">Lưu</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
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
@endsection
