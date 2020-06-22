@extends('layouts')
@section('content')
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="fa fa-home"></i> Thiết lập công thức
        </div>
        <div class="panel-body">
                <div class="panel-body">
                        <div class="position-center">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Công thức</th>
                                        </tr>
                                    </thead>
                                        <tbody>
                                            <tr>
                                                <td class="text-center">{{ $stringTu }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">{{ $stringMau }}</td>
                                            </tr>
                                        </tbody>
                                </table>
                        </div>
                </div>
            <form action="{{ route('method.p_storeNumber',['id' => $idMethod]) }}" method="post">
                @csrf
                <input type="hidden" name="qtyTu" value="{{ $qtyTu }}">
                <input type="hidden" name="qtyMau" value="{{ $qtyMau }}">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 text-center">
                        <h3 class="hdg">Tử số bằng số</h3>
                            @for ($i = 0; $i < $qtyTu; $i++)
                                @if($i == 0)
                                    <div class="row" style="margin-bottom: 5px;">
                                        <div class="col-sm-1"></div>
                                        <div class="col-xs-12 col-sm-10">
                                            <input type="number" name="numTu[]" min="1" class="form-control" required>
                                        </div>
                                        <div class="col-sm-1"></div>
                                    </div>
                                @else
                                    <div class="row">
                                        <div class="col-sm-1"></div>
                                        <div class="col-xs-3 col-sm-2 m-b-xs">
                                            @switch($arrCalTu[$i-1])
                                                @case('0')
                                                    <input value="0" name="calNumTu[]" hidden>
                                                    <input class="form-control" value="+" disabled>
                                                    @break
                                                @case('1')
                                                    <input value="1" name="calNumTu[]" hidden>
                                                    <input class="form-control" value="-" disabled>
                                                    @break
                                                @case('2')
                                                    <input value="2" name="calNumTu[]" hidden>
                                                    <input class="form-control" value="*" disabled>
                                                    @break
                                                @default
                                                    <input value="3" name="calNumTu[]" hidden>
                                                    <input class="form-control" value="/" disabled>
                                                    @break
                                            @endswitch
                                        </div>
                                        <div class="col-xs-9 col-sm-8 m-b-xs">
                                            <input type="number" name="numTu[]" min="1" class="form-control" required>
                                        </div>
                                        <div class="col-sm-1"></div>
                                    </div>
                                @endif
                            @endfor
                    </div>
                    <div class="col-xs-12 col-sm-6 text-center">
                        <h3 class="hdg">Mẫu số bằng số</h3>
                        @for ($i = 0; $i < $qtyMau; $i++)
                                @if($i == 0)
                                    <div class="row" style="margin-bottom: 5px;">
                                        <div class="col-sm-1"></div>
                                        <div class="col-xs-12 col-sm-10">
                                            <input type="number" name="numMau[]" min="1" class="form-control" required>
                                        </div>
                                        <div class="col-sm-1"></div>
                                    </div>
                                @else
                                    <div class="row">
                                        <div class="col-sm-1"></div>
                                        <div class="col-xs-3 col-sm-2 m-b-xs">
                                            @switch($arrCalMau[$i-1])
                                                @case('0')
                                                    <input value="0" name="calNumMau[]" hidden>
                                                    <input class="form-control" value="+" disabled>
                                                    @break
                                                @case('1')
                                                    <input value="1" name="calNumMau[]" hidden>
                                                    <input class="form-control" value="-" disabled>
                                                    @break
                                                @case('2')
                                                    <input value="2" name="calNumMau[]" hidden>
                                                    <input class="form-control" value="*" disabled>
                                                    @break
                                                @default
                                                    <input value="3" name="calNumMau[]" hidden>
                                                    <input class="form-control" value="/" disabled>
                                                    @break
                                            @endswitch
                                        </div>
                                        <div class="col-xs-9 col-sm-8 m-b-xs">
                                            <input type="number" name="numMau[]" min="1" class="form-control" required>
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
    <script>
        @if($errors->any())
            @foreach($errors->all() as $error)
                toastr.error('{{ $error }}')
            @endforeach
        @endif
        @if(session('success'))
            toastr.success('{{ session('success') }}')
        @endif
        @if(session('warning'))
            toastr.warning('{{ session('warning') }}')
        @endif
    </script>
@endsection
