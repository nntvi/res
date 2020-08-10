@extends('layouts')
@section('content')
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            Nguyên vật liệu {{ $cook->name }}
        </div>
        <div class="table-responsive">
            <table class="table table-striped b-t b-light" id="example">
                <thead>
                    <tr>
                        <th> Stt </th>
                        <th>Tên Nguyên Vật Liệu</th>
                        <th>Đơn vị</th>
                        <th>Số lượng</th>
                        <th class="text-center">Báo nhập gấp</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($materials as $key =>  $material)
                        @if ($material->detailMaterial != null)
                            @switch($material->status)
                                @case('1')
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $material->detailMaterial->name }}</td>
                                        <td>{{ $material->unit->name }}</td>
                                        <td>{{ $material->qty }}</td>
                                        <td class="text-center">
                                            <a href="{{route('cook_screen.p_updatematerial',['idMaterial' => $material->detailMaterial->id, 'idCook' => $cook->id])}}"
                                                onclick="return confirm('Bạn có chắc muốn nhập thêm [ {{ $material->detailMaterial->name }} ] ?')">
                                                <i class="fa fa-check-circle-o text-success" aria-hidden="true"></i> Click nhập thêm
                                            </a>
                                        </td>
                                    </tr>

                                @break
                                @case('0')
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $material->detailMaterial->name }}</td>
                                        <td>{{ $material->unit->name }}</td>
                                        <td>{{ $material->qty }}</td>
                                        <td class="text-center bold" style="color:red">Cần nhập thêm</td>
                                    </tr>
                                @break
                                @default
                            @endswitch
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
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
            $('#example_length').html(`<a href="{{ route('cook_screen.detail',['id' => $cook->id]) }}" class="btn btn-sm btn-default">
                                            Trở về
                                        </a>`);
            $('input[type="search"]').addClass('form-control');
        } );
    </script>
@endsection
