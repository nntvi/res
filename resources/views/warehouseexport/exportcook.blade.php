@extends('layouts')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Xuất cho Bếp
            </header>
            <div class="pannel-body">
                    <div class="form">
                        <form class="panel-body" role="form" onsubmit="return validateFormExportCook()"
                         action="{{route('exportcoupon.p_chooseexport')}}" method="POST">
                            @csrf
                            <div class="col-md-12" style="margin-bottom: 20px">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label class="control-label">Mã phiếu xuất<span style="color: #ff0000"> *</span></label>
                                        <div class="space"></div>
                                        <input type="text" class="form-control" name="code" maxlength="200" id="codeExportCook" value="{{ $code }}" required>
                                    </div>
                                    <div class="col-md-3">
                                        <input name="id_kind" value="1" hidden>
                                        <label class="control-label">Chọn loại bếp<span style="color: #ff0000"> *</span></label>
                                        <div class="space"></div>
                                        <select class="form-control m-bot15" name="type_object" id="objectCook">
                                            @foreach ($cooks as $cook)
                                                <option value="{{$cook->id}}">{{$cook->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="control-label">Ghi chú</label>
                                        <div class="space"></div>
                                        <textarea type="text" class="form-control" rows="1"
                                            name="note">
                                        </textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="position-center" id="content">

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
