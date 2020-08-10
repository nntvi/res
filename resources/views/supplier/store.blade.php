@extends('layouts')
@section('content')
<div class="form-w3layouts">
        <!-- page start-->
        <!-- page start-->
        <div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Thêm mới Nhà cung cấp
                        </header>
                        <div class="panel-body">
                            <div class="col-xs-1"></div>
                            <div class="col-xs-10">
                                <form role="form" action="{{route('supplier.p_store')}}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label>Mã nhà cung cấp</label>
                                                <input type="text" class="form-control" name="code" maxlength="30" required>
                                                <span class="error-message">{{ $errors->first('code') }}</span></p>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label>Tên nhà cung cấp</label>
                                                <input type="text" class="form-control" name="name" maxlength="60" required>
                                                <span class="error-message">{{ $errors->first('name') }}</span></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input type="email" class="form-control" name="email" maxlength="100" required>
                                                <span class="error-message">{{ $errors->first('email') }}</span></p>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                                <div class="form-group">
                                                        <label>Số điện thoại</label>
                                                        <input type="text" class="form-control" name="phone" id="Account_phone" maxlength="30" required>
                                                        <span class="error-message">{{ $errors->first('phone') }}</span></p>
                                                    </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6">
                                                <div class="form-group">
                                                        <label>Địa chỉ</label>
                                                        <input type="text" class="form-control" name="address" maxlength="150" required>
                                                        <span class="error-message">{{ $errors->first('address') }}</span></p>
                                                    </div>

                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                                <div class="form-group">
                                                        <label>Mã số thuế</label>
                                                        <input type="text" class="form-control" name="mst" min="10" max="20" maxlength="100" required>
                                                        <span class="error-message">{{ $errors->first('mst') }}</span></p>
                                                    </div>

                                        </div>
                                    </div>
                                    <div class="row">
                                            <div class="col-xs-12 col-sm-6">
                                                    <div class="form-group">
                                                            <div class="space"></div>
                                                            <div class="space"></div>
                                                            <label style="display:inline">Hoạt động</label>
                                                                <input value="1" id="status1" type="radio" name="status" style="margin-right: 20px">
                                                            <label style="display:inline">Ngưng hoạt động</label>
                                                                <input  value="0" id="status2" type="radio" name="status">
                                                        </div>
                                                        <span class="error-message">{{ $errors->first('status') }}</span></p>
                                            </div>
                                            <div class="col-xs-12 col-sm-6">
                                                <div class="form-group">
                                                    <label style="display:inline">Danh mục cung cấp</label>
                                                    <select class="form-control m-bot15" name="typeMaterial">
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
                                            <textarea type="text" size="40" class="form-control" rows="2" name="note"></textarea>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 text-right">
                                                <div class="space"></div>
                                                <div class="space"></div>
                                            <a href="{{ route('supplier.index') }}" class="btn btn-default">Trở về</a>
                                            <button type="submit" class="btn btn-info">Thêm mới</button>
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
