@extends('layouts')
@section('content')
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="fa fa-home"></i> Thiết lập công thức
        </div>
        <div class="panel-body">
            <form action="{{ route('method.p_storeText') }}" method="post">
                @csrf
                <input type="hidden" name="qtyTu" value="{{ $qtyTu }}">
                <input type="hidden" name="qtyMau" value="{{ $qtyMau }}">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 text-center">
                        <h3 class="hdg">Tử số bằng chữ</h3>
                            @for ($i = 0; $i < $qtyTu; $i++)
                                @if($i == 0)
                                    <div class="row" style="margin-bottom: 5px;">
                                        <div class="col-sm-1"></div>
                                        <div class="col-xs-12 col-sm-10">
                                            <input type="text" name="textTu[]" class="form-control" required>
                                        </div>
                                        <div class="col-sm-1"></div>
                                    </div>
                                @else
                                    <div class="row">
                                        <div class="col-sm-1"></div>
                                        <div class="col-xs-3 col-sm-2 m-b-xs">
                                            <select name="calTu[]" class="form-control">
                                                <option value="0">+</option>
                                                <option value="1">-</option>
                                                <option value="2">*</option>
                                                <option value="3">/</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-9 col-sm-8 m-b-xs">
                                            <input type="text" name="textTu[]" class="form-control" required>
                                        </div>
                                        <div class="col-sm-1"></div>
                                    </div>
                                @endif
                            @endfor
                    </div>
                    <div class="col-xs-12 col-sm-6 text-center">
                        <h3 class="hdg">Mẫu số bằng chữ</h3>
                        @for ($i = 0; $i < $qtyMau; $i++)
                                @if($i == 0)
                                    <div class="row" style="margin-bottom: 5px;">
                                        <div class="col-sm-1"></div>
                                        <div class="col-xs-12 col-sm-10">
                                            <input type="text" name="textMau[]" class="form-control" required>
                                        </div>
                                        <div class="col-sm-1"></div>
                                    </div>
                                @else
                                    <div class="row">
                                        <div class="col-sm-1"></div>
                                        <div class="col-xs-3 col-sm-2 m-b-xs">
                                            <select name="calMau[]" id="" class="form-control">
                                                    <option value="0">+</option>
                                                    <option value="1">-</option>
                                                    <option value="2">*</option>
                                                    <option value="3">/</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-9 col-sm-8 m-b-xs">
                                            <input type="text" name="textMau[]" class="form-control" required>
                                        </div>
                                        <div class="col-sm-1"></div>
                                    </div>
                                @endif
                            @endfor
                    </div>
                </div>
                <div class="space"></div>
                <div class="space"></div>
                <div class="space"></div>
                <div class="row">
                    <div class="col-xs-12 text-center">
                        <a href="{{ route('method.index') }}" class="btn btn-default">Trở về</a>
                        <button type="submit" class="btn green-meadow">Lưu Công thức</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
