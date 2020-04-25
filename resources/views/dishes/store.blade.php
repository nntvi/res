@extends('layouts')
@section('content')
<div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Thêm mới món ăn
                </header>
                <div class="panel-body">
                    <div class="space"></div>
                    <form role="form" action="{{route('dishes.p_store')}}" enctype="multipart/form-data" method="POST">
                        @csrf
                        <div class="form-group">
                            <div class="row">
                                <div class="col-xs-6 col-sm-3">
                                    <label>Mã sản phẩm <span style="color: #ff0000"> *</span></label>
                                    <input class="form-control" name="codeDish" type="text" maxlength="40" required>
                                </div>
                                <div class="col-xs-6 col-sm-3">
                                    <label>Tên món ăn <span style="color: #ff0000"> *</span></label>
                                    <select class="form-control" name="idMaterial" id="idMaterial">
                                        @foreach ($materials as $material)
                                            <option value="{{ $material->id }}">{{ $material->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-xs-6 col-sm-3">
                                    <label>Giá vốn</label>
                                    <input name="capitalPriceHidden" id="capitalPriceHidden" value="" hidden>
                                    <input class="form-control" id="capitalPrice" value="" disabled>
                                </div>
                                <div class="col-xs-6 col-sm-3">
                                    <label>Giá bán <span style="color: #ff0000"> *</span></label>
                                    <input type="number" class="form-control" id="salePrice" name="salePrice" value="" required>
                                </div>
                            </div>
                        </div>
                        <div class="space"></div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-xs-6 col-sm-3">
                                    <label>Đơn vị tính</label>
                                    <select class="form-control" name="idUnit">
                                        @foreach ($units as $unit)
                                            <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-xs-12 col-sm-6">
                                    <label>Mô tả</label>
                                    <textarea class="form-control" rows="1" name="describe"></textarea>
                                </div>
                                <div class="col-xs-6 col-sm-3 ">
                                    <span class="error-message">{{ $errors->first('status') }}</span>
                                    <div class="space"></div>
                                    <label class="control-label">Trạng thái: &nbsp;&nbsp;</label>
                                    <label class="control-label">Ẩn</label>
                                    <input value="0" id="status1" type="radio" name="status" style="margin-right: 20px">
                                    <label class="control-label">Hiện</label>
                                    <input value="1" id="status2" type="radio" name="status" style="margin-right: 20px">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="space"></div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-6">
                                    <label for="exampleInputFile">Chọn hình ảnh</label>
                                    <input type="file" name="file">
                                    <span class="error-message">{{ $errors->first('file') }}</span></p>
                                    @if (session('mes_error'))
                                        <span class="error-message">{{ session('mes_error') }}</span></p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-xs-12 text-center">
                                <a href="{{ route('dishes.index') }}" class="btn btn-default">Trở về</a>
                                <button type="submit" class="btn btn-info">Thêm mới</button>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>
@endsection
