@extends('layouts')
<style>
    div::-webkit-scrollbar {
        width: 10px;
        background: #f1f1f1;
    }
</style>
@section('content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Xuất hủy
            </header>
            <div class="pannel-body">
                <div class="position-center">
                        <div class="form">
                                <form class="panel-body" role="form" onsubmit="return validateFormDestroyWarehouse()"
                                action="{{ route('exportcoupon.p_destroywarehouse') }}" method="POST">
                                    @csrf
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="control-label">Mã xuất hủy<span style="color: #ff0000">
                                                        *</span></label>
                                                <div class="space"></div>
                                                <input type="text" value="{{ $code }}" class="form-control" name="code" id="codeDestroy" required>
                                                <input name="id_kind" value="3" hidden>
                                                <input name="type_object" value="1" hidden>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="control-label">Lý do hủy<span style="color: #ff0000"> *</span></label>
                                                <div class="space"></div>
                                                <textarea type="text" size="40" class="form-control" rows="1" name="note">
                                                </textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="space"></div>
                                        <div class="space"></div>
                                        <div class="row">
                                            <div class="col-xs-9">
                                                <label class="control-label">Chọn mặt hàng trong kho cần hủy</label>
                                            </div>
                                            <div class="col-xs-3 text-right">
                                                <a href="#myModal" data-toggle="modal" class="btn btn-sm btn-success">
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
                                                                        @foreach ($types as $type)
                                                                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="space"></div>
                                                                <div class="form-group row" id="areaNVL">

                                                                </div>
                                                                <div class="row">
                                                                <div class="col-xs-12 text-center">
                                                                <span id="getNVLToDestroy" class="btn btn-default">Chọn</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                            <div class="space"></div>
                                        <div id="material" style="height:350px; overflow:auto;">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Tên mặt hàng</th>
                                                        <th>Sl trong kho</th>
                                                        <th>Số lượng xuất</th>
                                                        <th>Đơn vị</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody class="list" id="tableDestroyWarehouse">

                                                </tbody>
                                            </table>
                                        </div>
                                        <script>
                                            function clickToRemove($id) {
                                                var row = document.getElementById('row' + $id);
                                                row.remove();
                                            }

                                        </script>
                                    </div>

                                    <div class="row">
                                        <div class="col-xs-12 text-center">
                                            <a href="{{ route('warehouse.index') }}" class="btn btn-default">Trở về</a>
                                            <button type="submit" class="btn green-meadow radius">Tạo phiếu xuất</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                </div>
            </div>
    </div>
    </section>
</div>
</div>
@endsection
