@extends('layouts')
@section('content')
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            Chi tiết Nguyên vật liệu
        </div>
        <div class="row">
            <div class="space"></div>
            <div class="col-sm-8" style="margin-top: 15px">
                <form enctype="multipart/form-data" role="form"
                    action="{{ route('material_detail.store') }}" method="POST">
                    @csrf
                    <label class="col-xs-12 col-sm-2">Thêm mới&nbsp;&nbsp;&nbsp;</label>
                    <input type="text" class="input-sm form-control w-sm inline v-middle col-xs-12 col-sm-6" name="nameAdd" style="margin-right: 3px;margin-top: 3px">
                    <select class="input-sm form-control w-sm inline v-middle col-xs-12 col-sm-3" name="idType" style="margin-right: 3px;margin-top: 3px">
                        @foreach($types as $type)
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                        @endforeach
                    </select>
                    <select class="input-sm form-control w-sm inline v-middle col-xs-6 col-sm-6" name="idUnit" style="margin-right: 3px;margin-top: 3px">
                            @foreach($units as $unit)
                                <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                            @endforeach
                        </select>
                    <input type="submit" class="btn btn-sm btn-info col-xs-6 col-sm-2" value="Thêm mới" style="margin-top: 3px">

                </form>
                <span class="error-message">{{ $errors->first('nameAdd') }}</span>
            </div>

            <div class="col-sm-4" style="margin-top: 15px;">
                <form action="{{ route('material_detail.search') }}" method="POST" style="margin-right: 10px;">
                    @csrf
                    <div class="input-group col-xs-12" style="margin-top: 3px;">
                        <input type="text" class="input-sm form-control" id="nameMaterialDetail" name="nameSearch">
                        <span class="input-group-btn">
                            <input class="btn btn-sm btn-warning" type="submit" value="Tìm kiếm">
                        </span>
                    </div>
                    <span class="error-message">{{ $errors->first('nameSearch') }}</span>
                </form>
            </div>
        </div>
        <div class="space"></div>
        <div class="table-responsive">
            <table class="table table-striped b-t b-light">
                <thead style="background: #ffeeda;">
                    <tr>
                    <tr>
                        <th>STT</th>
                        <th>Tên nguyên vật liệu</th>
                        <th>Thuộc nhóm</th>
                        <th>Cập nhật</th>
                        <th>Xóa</th>
                    </tr>
                    </tr>
                </thead>
                <tbody>
                    @foreach($materialDetails as $key => $materialDetail)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <form method="POST"
                                action="{{ route('material_detail.update',['id' => $materialDetail->id]) }}">
                                @csrf
                                <td>
                                    <input type="hidden" name="AreaId" value="">
                                    <input width="30%" class="form-control" type="text" name="name"
                                        value="{{ $materialDetail->name }}">
                                </td>
                                <td>
                                    <select class="form-control radius" name="type">
                                        <option value="{{ $materialDetail->typeMaterial->id }}">
                                            {{ $materialDetail->typeMaterial->name }}</option>
                                        @foreach($types as $type)
                                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <button type="submit" class="btn default btn-xs yellow-crusta radius"><i
                                            class="fa fa-edit"> Cập nhật</i></button>
                                </td>
                            </form>
                            <td>
                                <a href="{{ route('material_detail.delete',['id' => $materialDetail->id]) }}"
                                    class="btn default btn-xs red radius">
                                    <i class="fa fa-trash-o" onclick="return confirm('Bạn muốn xóa dữ liệu này?')">
                                        Xóa</i>

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
                        <li><a href=""><i class="fa fa-chevron-left"></i></a></li>
                        <li><a href="">1</a></li>
                        <li><a href="">2</a></li>
                        <li><a href="">3</a></li>
                        <li><a href="">4</a></li>
                        <li><a href=""><i class="fa fa-chevron-right"></i></a></li>
                    </ul>
                </div>
            </div>
        </footer>
    </div>
</div>
@endsection
