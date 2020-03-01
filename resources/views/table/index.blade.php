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
                            <li class="breadcrumb-item"><a href="#">Phòng bàn</a></li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="portlet box green-meadow">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-coffee"></i>
                       Thêm mới bàn
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-responsive">
                        <div class="form">
                            <form class="panel-body" enctype="multipart/form-data" role="form"
                                action="{{route('table.p_store')}}" method="POST">
                                @csrf
                                <div class="col-md-12">
                                    <div class="row">
                                            <div class="col-md-3">
                                                    <label class="control-label">Mã Bàn<span style="color: #ff0000">
                                                            *</span></label> <input type="text" size="40"
                                                        class="form-control" name="codeTable" maxlength="255"
                                                        value="">
                                                        <span class="error-message">{{ $errors->first('codeTable') }}</span></p>
                                            </div>
                                        <div class="col-md-3">
                                            <label class="control-label">Tên Bàn<span style="color: #ff0000">
                                                    *</span></label> <input type="text" size="40" value=""
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
                                        <div class="col-md-3">
                                            <input type="submit" class="btn green-meadow radius"
                                                style="width:105px; margin-top: 40px;" name="yt0" value="Thêm mới">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-coffee"></i>
                        Danh sách bàn
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row" style="margin: 10px 2px;">
                        <div class="col-md-6">

                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Mã bàn</th>
                                    <th>Tên bàn</th>
                                    <th>Khu vực</th>
                                    <th>Cập nhật</th>
                                    <th>Xóa</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- @foreach ($areatables as $areatable)
                                    @foreach($areatable->hasTable as $key => $hasTable)
                                        {{ $hasTable->belongsToTable->name }}
                                    @endforeach

                                @endforeach --}}
                                @foreach ($tables as $key => $table)
                                    <tr>
                                        <td style="width: 10px">{{$key+1}}</td>
                                        <td>{{$table->code}}</td>
                                        <td>{{$table->name}}</td>
                                        <td>{{$table->getArea->name}}</td>
                                        <td>
                                            <a href="{{route('table.update',['id' => $table->id])}}"
                                                class="btn default btn-xs yellow-crusta radius">
                                                <i class="fa fa-edit"> Cập nhật</i>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{route('table.delete',['id'=>$table->id])}}"
                                                class="btn default btn-xs red radius" onclick="return confirm('Bạn muốn xóa dữ liệu này?')">
                                                <i class="fa fa-trash-o"> Xóa</i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    <footer class="panel-footer">
                            <div class="row">
                              <div class="col-sm-5 text-center">
                                <small class="text-muted inline m-t-sm m-b-sm">showing 20-30 of 50 items</small>
                              </div>
                              <div class="col-sm-7 text-right text-center-xs">
                                <ul class="pagination pagination-sm m-t-none m-b-none">
                                  {{ $tables->links() }}
                                </ul>
                              </div>
                            </div>
                    </footer>
                </div>
            </div>
    </div>
</div>
@endsection
