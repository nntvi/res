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
                    <form class="panel-body" role="form" onsubmit="return validateFormDestroyCook()"
                                action="{{ route('exportcoupon.p_destroywarehousecook') }}" method="POST">
                        @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="control-label">Mã xuất hủy<span style="color: #ff0000">*</span></label>
                                    <input type="text" value="{{ $code }}" class="form-control" name="code" id="codeDestroyCook">
                                    <input name="id_kind" value="4" hidden>
                                    <input name="type_object" value="{{ $cook->id }}" hidden>
                                </div>
                                <div class="col-md-6">
                                    <label class="control-label">Bếp</label>
                                    <input type="text" class="form-control" value="{{ $cook->name }}" disabled>
                                    <input value="{{ $cook->id }}" hidden id="idCookDestroy">
                                </div>
                            </div>
                            <div class="space"></div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="control-label">Lý do hủy<span style="color: #ff0000"> *</span></label>
                                    <textarea type="text" size="40" class="form-control" rows="2" name="note"></textarea>
                                </div>
                            </div>
                            <div class="space"></div>
                            <div class="row">
                                <div class="col-xs-8 col-sm-9">

                                    <label class="control-label">Chọn mặt hàng trong bếp cần hủy</label>
                                </div>
                                <div class="col-xs-4 col-sm-3 text-right">
                                    <a href="#myModal" data-toggle="modal" class="btn btn-sm btn-success" id="chooseMaterial">
                                        Chọn
                                    </a>
                                    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
                                        <div class="modal-dialog">
                                            <div class="modal-content text-left">
                                                <div class="modal-header">
                                                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                                    <h4 class="modal-title text-left">Chọn nguyên vật liệu bếp vừa chọn</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            @foreach ($materials as $material)
                                                                <div class="col-xs-6 col-sm-3">
                                                                    <input type="checkbox" name="nvl[]" value="{{ $material->id_material_detail }}">
                                                                    <label>{{ $material->detailMaterial->name }}</label>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xs-12 text-center">
                                                            <span id="getNVLToDestroyCook" class="btn btn-default">Chọn</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="space"></div>
                            <div class="row">
                                    <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Tên mặt hàng</th>
                                                    <th>Sl trong bếp</th>
                                                    <th>Số lượng xuất</th>
                                                    <th>Đơn vị</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody id="tableDestroyWarehouseCook">

                                            </tbody>
                                        </table>
                                    <script>
                                        function clickToRemove($id) {
                                            var row = document.getElementById('row' + $id);
                                            row.remove();
                                        }

                                    </script>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 text-center">
                                    <a href="{{ route('warehousecook.index') }}" class="btn btn-default">Trở về</a>
                                    <button type="submit" class="btn green-meadow radius">Tạo phiếu xuất</button>
                                <div class="space"></div>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
