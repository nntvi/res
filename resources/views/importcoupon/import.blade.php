@extends('layouts')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Nhập Hàng
            </header>
            <div class="panel-body">
                <div class="position-center">
                    <form action="{{ route('importcoupon.importtemp') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group">
                                    <label>Mã phiếu nhập</label>
                                    <input class="form-control" name="code" value="{{ $code }}" required>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group">
                                    <label>Ghi chú</label>
                                    <textarea name="note" rows="1" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12">
                                <div class="form-group">
                                    <label>Nhà cung cấp</label>
                                    <select class="form-control m-bot15" name="idSupplier" id="idSupplier">
                                        @foreach($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="content" id="content">

                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
