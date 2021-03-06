@extends('layouts')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Xuất Kho
            </header>
            <div class="pannel-body">
                <div class="position-center">
                    <div class="form">
                        <form class="panel-body" role="form" action="{{route('warehouse_export.p_export')}}" method="POST">
                            @csrf
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="control-label">Mã phiếu xuất<span style="color: #ff0000"> *</span></label>
                                        <div class="space"></div>
                                        <input type="text" size="40" class="form-control" name="code" maxlength="200">
                                        <span class="error-message">{{ $errors->first('name') }}</span></p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="control-label">Loại xuất<span style="color: #ff0000"> *</span></label>
                                        <div class="space"></div>
                                        <select class="form-control m-bot15" name="id_kind" id="type_object">
                                            <option value="">-- Chọn loại xuất --</option>
                                            @foreach ($kinds as $kind)
                                                <option value="{{$kind->id}}">{{$kind->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                                <label class="control-label">Ghi chú</label>
                                                <div class="space"></div>
                                                <textarea type="text" size="40" class="form-control" rows="1"
                                                    name="note">
                                                </textarea>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="control-label">Đối tượng<span style="color: #ff0000"> *</span></label>
                                            <div class="space"></div>

                                            <select class="form-control m-bot15" name="type_object" id="object">

                                            </select>
                                        </div>

                                    </div>
                                </div>
                            <div class="col-md-12">
                                <div class="space"></div>
                                <div class="space"></div>
                                <div class="row">
                                    <div class="col-xs-3">
                                        <label class="control-label">Tìm mặt hàng hiện có trong kho</label>
                                    </div>
                                    <div class="col-xs-9">
                                        <div class="input-group m-bot15">
                                            <input type="text" class="form-control" id="nameMaterial" value="">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-success" type="button" id="searchMaterial">Search!</button>
                                                </span>
                                            </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">

                                    <div class="space"></div>
                                    <div id="material">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th width=23%>Tên mặt hàng</th>
                                                    <th width=25%>Sl trong kho</th>
                                                    <th width=24%>Số lượng xuất</th>
                                                    <th width=15%>Đơn vị xuất</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody class="list">
                                                <input type="text" hidden>
                                            </tbody>
                                        </table>
                                    </div>
                                    <script>
                                        function clickToRemove($id){
                                           var row = document.getElementById('row'+$id);
                                           row.remove();
                                        }
                                    </script>
                                </div>

                            <div class="row">
                                <div class="col-xs-12 text-center">
                                    <button type="submit" class="btn green-meadow radius">Tạo phiếu xuất</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
