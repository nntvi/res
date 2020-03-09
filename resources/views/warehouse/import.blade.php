@extends('layouts')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                       Nhập Kho
            </header>
                    <div class="panel-body">
                        <div class="position-center">
                            <form action="{{route('warehouse.p_import')}}" method="POST">
                                @csrf
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nhà cung cấp</label>
                                <select class="form-control m-bot15" name="supplier">
                                    @foreach ($suppliers as $supplier)
                                        <option  value="{{$supplier->id}}">{{$supplier->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Mặt hàng</label>
                                <select class="form-control m-bot15" name="good">
                                    @foreach ($goods as $good)
                                        <option value="{{$good->id}}">{{$good->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Số lượng</label>
                                <div class="form-group">
                                        <input type="number" class="form-control" name="qty">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Đơn vị</label>
                                <select class="form-control m-bot15" name="unit">
                                    @foreach ($units as $unit)
                                        <option value="{{$unit->id}}">{{$unit->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Giá</label>
                                <input type="text" class="form-control" name="price">
                            </div>

                            <button type="submit" class="btn btn-info">Lưu</button>
                        </form>
                        </div>

                    </div>
                </section>

    </div>
</div>
@endsection
