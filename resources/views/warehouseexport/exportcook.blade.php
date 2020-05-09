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
                         action="{{route('exportcoupon.p_export')}}" method="POST">
                            @csrf
                            <div class="col-md-12" style="margin-bottom: 20px">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label class="control-label">Mã phiếu xuất<span style="color: #ff0000"> *</span></label>
                                        <div class="space"></div>
                                        <input type="text" size="40" class="form-control" name="code" maxlength="200" id="codeExportCook">
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
                                        <textarea type="text" size="40" class="form-control" rows="1"
                                            name="note">
                                        </textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="grid_3 grid_5 wthree">
                                <div class="col-md-4 agileits-w3layouts" id="warehouseCook">

                                </div>
                                <div class="col-md-8" id="warehouse">

                                </div>
                                <script type="text/javascript">
                                    function clickToRemove($id){
                                        var row = document.getElementById('row'+$id);
                                        row.remove();
                                    }
                                </script>
                               <div class="clearfix"> </div>
                            </div>
                            <div class="col-xs-12 text-center" id="submit">

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
