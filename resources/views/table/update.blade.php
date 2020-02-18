@extends('layouts')
@section('content')
        <div class="table-agile-info">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Danh mục
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Danh mục</a></li>
                                <li class="breadcrumb-item"><a href="#">Cập nhật bàn</a></li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="portlet box green-meadow">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-coffee"></i>
                            Thêm mới bàn </div>
                        <div class="tools">
                        </div>
                    </div>
                    <div class="portlet-body">
                        <!-- <div class="row">
                        <div class="col-md-3 col-md-offset-9 text-right">
                            <a href="javascript:history.go(-1)" class="btn grey-silver radius btn-delete text-right"></a>
                        </div>
                    </div> -->
                        <div class="table-responsive">
                            <div class="form">
                                <form class="panel-body" enctype="multipart/form-data" role="form"
                                    action="{{route('table.p_update',['id' => $table->id])}}" method="POST">
                                    @csrf
                                    <div class="col-md-12">
                                        <div class="row">
                                                <div class="col-md-3">
                                                        <label class="control-label">Mã Bàn<span style="color: #ff0000">
                                                                *</span></label> <input type="text" size="40" disabled
                                                            class="form-control" name="codeTable" maxlength="255"
                                                            value="{{$table->code}}"
                                                            >
                                                    </div>
                                            <div class="col-md-3">
                                                <label class="control-label">Tên Bàn<span style="color: #ff0000">
                                                        *</span></label> <input type="text" size="40" value="{{$table->name}}"
                                                    class="form-control" name="nameTable" maxlength="255">
                                                    <span class="error-message">{{ $errors->first('nameTable') }}</span></p>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="control-label">Khu Vực<span style="color: #ff0000"> *</span></label>
                                                <select class="form-control" name="idArea">
                                                    @foreach ($areas as $area)
                                                        <option id="{{$area->id}}" value="{{$area->id}}" >{{$area->name}}</option>
                                                    @endforeach
                                                </select>
                                                <div class="errorMessage" id="Table_area_id_em_"
                                                    style="display:none"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-12 text-right">
                                                <a href="" class="btn grey-silver radius btn-delete text-right">Hủy</a>
                                                <input type="submit" class="btn green-meadow radius"
                                                    style="width:105px" name="yt0" value="Thêm mới"> </div>
                                            <div class="space"></div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
