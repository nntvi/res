@extends('layouts')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Thêm mới kế hoạch
            </header>
            <div class="panel-body">
                <form action="{{ route('importplan.store') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <div class="row">
                            <div class="col-xs-6 col-sm-4">
                                <label>Ngày nhập hàng</label>
                                <input class="date form-control" name="dateStart" type="date" required>
                            </div>
                            <div class="col-xs-6 col-sm-4">
                                <label>Nhà cung cấp</label>
                                <select class="form-control" name="idSupplier" id="idSupplierPlan">
                                    @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-xs-12 col-sm-4">
                                <label>Ghi chú</label>
                                <textarea id="my-textarea" class="form-control" name="note" rows="1"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="position-center" id="materialToPlan">

                    </div>
                </form>
            </div>
        </section>
    </div>
</div>
@endsection
