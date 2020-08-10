@extends('layouts')
<style>
    .table-responsive {
        overflow-x: inherit !important;
    }
    #example_length{
        display: none;
    }
    input[type="search"] {
        height: 29px;
    }
</style>
@section('content')
<div class="form-w3layouts">
    <!-- page start-->
    <!-- page start-->
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading" style="margin-bottom: 20px">
                    Chọn mặt hàng cần nhập cho kế hoạch
                </header>
                <div class="panel-body">
                    <div class="position-center">
                        <form action="{{ route('importplan.p_detail') }}" method="POST" onsubmit="return validateImportPlan()">
                            @csrf
                            <div class="row form-group">
                                <div class="col-xs-12 col-sm-6">
                                    <label>Kế hoạch ngày</label>
                                    <input type="hidden" name="id_plan" value="{{ $id }}">
                                    <input class="form-control" value="{{ $plan->date_create }}" disabled>
                                </div>
                                <div class="col-xs-12 col-sm-6">
                                    <label>Nhà cung cấp</label>
                                    <input class="form-control" value="{{ $plan->supplier->name }}" disabled>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="page-header">
                                    <h3 class="bars text-center">Các mặt hàng cần nhập trong kế hoạch này</h3>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table" id="example">
                                    <thead>
                                        <tr>
                                            <th style="width:20px;">
                                                <label class="i-checks m-b-none">
                                                    <input type="checkbox" id="checkAll"<i></i>
                                                </label>
                                            </th>
                                            <th class="text-center">Tên Nguyên Vật Liệu</th>
                                            <th class="text-center">Đơn vị</th>
                                            <th class="text-right">Số lượng dự tính</th>
                                        </tr>
                                    </thead>
                                    <tbody id="bodyImportPlan">
                                        @foreach ($materialDetails->typeMaterial->materialDetail as $detail)
                                            @php
                                                $temp = false;
                                            @endphp
                                            @foreach ($materialChoosen as $item)
                                                @if ($item->id_material_detail == $detail->id && $detail->status == '1')
                                                    <tr>
                                                        <td>
                                                            <label class="i-checks m-b-none">
                                                                <input type="checkbox" class="idmatdetail" value="{{ $detail->id }}" name="idMaterialDetail[]" checked><i></i>
                                                            </label>
                                                        </td>
                                                        <td class="text-center">
                                                            <input type="hidden" class="namematdetail" value="{{ $detail->name }}">
                                                            {{ $detail->name }}
                                                        </td>
                                                        <td class="text-center">
                                                            {{ $detail->unit->name }}
                                                        </td>
                                                        <td class="text-right">
                                                            <input type="number" name="qty[]" min="1" value="{{ $item->qty }}">
                                                        </td>
                                                    </tr>
                                                    @php
                                                        $temp = true;
                                                    @endphp
                                                    @break
                                                @endif
                                            @endforeach
                                            @if ($temp == false)
                                                @if ($detail->status == '1')
                                                    <tr>
                                                        <td>
                                                            <label class="i-checks m-b-none">
                                                                <input type="checkbox" class="idmatdetail" value="{{ $detail->id }}" name="idMaterialDetail[]"><i></i>
                                                            </label>
                                                        </td>
                                                        <td class="text-center">
                                                            <input type="hidden" class="namematdetail" value="{{ $detail->name }}">
                                                            {{ $detail->name }}
                                                        </td>
                                                        <td class="text-center">
                                                            {{ $detail->unit->name }}
                                                        </td>
                                                        <td class="text-right">
                                                            <input type="number" name="qty[]" min="1">
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="space"></div>
                                <div class="space"></div>
                                <div class="col-xs-12 text-center">
                                    @if ($plan->date_create > $today)
                                        @if ($plan->status == '0')
                                            <a href="{{ route('importplan.index') }}" class="btn btn-default">Trở về</a>
                                            <button type="submit" class="btn green-meadow">Lưu Thông Tin</button>
                                        @else
                                            <a href="{{ route('importplan.index') }}" class="btn btn-default">Trở về</a>
                                        @endif
                                    @else
                                        <a href="{{ route('importplan.index') }}" class="btn btn-default">Trở về</a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <!-- page end-->
    <script>
            @if(session('success'))
                toastr.success('{{ session('success') }}')
            @endif
            @if(session('warning'))
                toastr.warning('{{ session('warning') }}')
            @endif
    </script>
    <script type="text/javascript" language="javascript" src="{{ asset('js/data.table.js') }}"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>
    <script>
        $(document).ready( function () {
            $('#example').dataTable();
            $('#example_info').addClass('text-muted');
            $('input[type="search"]').addClass('form-control');
        });
        $("#checkAll").click(function(){
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
    </script>
</div>
@endsection
