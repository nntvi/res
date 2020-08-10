@extends('layouts')
@section('content')
<div class="form-w3layouts">
        <!-- page start-->
        <!-- page start-->
        <div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Chỉnh sửa thông tin Nhà cung cấp
                        </header>
                        <div class="panel-body">
                            <div class="col-xs-1"></div>
                            <div class="col-xs-10">
                                <form role="form" action="{{route('supplier.p_update',['id' => $supplier->id])}}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label>Mã nhà cung cấp</label>
                                                <input type="text" size="40" class="form-control" name="code" value="{{$supplier->code}}" disabled>
                                                <span class="error-message">{{ $errors->first('code') }}</span></p>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label>Tên nhà cung cấp</label>
                                                <input type="text" size="40" class="form-control" name="name" value="{{$supplier->name}}" disabled>
                                                <span class="error-message">{{ $errors->first('name') }}</span></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input type="email" size="40" class="form-control" name="email" maxlength="100" value="{{$supplier->email}}" disabled>
                                                <span class="error-message">{{ $errors->first('email') }}</span></p>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                                <div class="form-group">
                                                    <label>Số điện thoại</label>
                                                    <input type="text" min="10" max="10" class="form-control" name="phone" id="Account_phone" value="{{$supplier->phone}}" required>
                                                    <span class="error-message">{{ $errors->first('phone') }}</span></p>
                                                </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6">
                                                <div class="form-group">
                                                        <label>Địa chỉ</label>
                                                        <input type="text" size="40" class="form-control" name="address" maxlength="150" value="{{$supplier->address}}" required>
                                                        <span class="error-message">{{ $errors->first('address') }}</span></p>
                                                </div>

                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                                <div class="form-group">
                                                        <label>Mã số thuế</label>
                                                        <input type="text" size="40" class="form-control" name="mst" min="10" max="20"  value="{{$supplier->mst}}" required>
                                                        <span class="error-message">{{ $errors->first('mst') }}</span></p>
                                                </div>

                                        </div>
                                    </div>
                                    <div class="row">
                                            <div class="col-xs-12 col-sm-6">
                                                <div class="form-group">
                                                        @if ($supplier->status == '0')
                                                        <label style="display:inline">Hoạt động</label>
                                                            <input value="1" id="status1" type="radio" name="status" style="margin-right: 20px">
                                                        <label style="display:inline">Ngưng hoạt động</label>
                                                            <input  value="0" id="status2" type="radio" name="status" checked>
                                                        @else
                                                        <label style="display:inline">Hoạt động</label>
                                                            <input value="1" id="status1" type="radio" name="status" style="margin-right: 20px" checked>
                                                        <label style="display:inline">Ngưng hoạt động</label>
                                                            <input  value="0" id="status2" type="radio" name="status" >
                                                        @endif
                                                </div>
                                                <span class="error-message">{{ $errors->first('status') }}</span></p>
                                            </div>
                                            <div class="col-xs-12 col-sm-6">
                                                <div class="form-group">
                                                    <label style="display:inline">Danh mục cung cấp</label>
                                                    <select class="form-control m-bot15" name="typeMaterial">
                                                        <option value="{{$supplier->typeMaterial->id}}">{{$supplier->typeMaterial->name}}</option>
                                                            @foreach ($types as $type)
                                                                <option value="{{$type->id}}">{{$type->name}}</option>
                                                            @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6">
                                            <label style="display:inline">Ghi chú</label>
                                            <textarea type="text" size="40" class="form-control" rows="2" value="{{$supplier->note}}" name="note"></textarea>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 text-right">
                                                <div class="space"></div>
                                                <div class="space"></div>
                                            <a href="{{ route('supplier.index') }}" class="btn btn-default">Trở về</a>
                                            <button type="submit" class="btn btn-danger">Chỉnh sửa</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-xs-1"></div>
                        </div>
                    </section>

            </div>

        </div>
</div>
@endsection
