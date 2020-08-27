@extends('layouts')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Lịch làm việc của nhân viên
            </header>
            <div class="pannel-body">
                <div class="position-center">
                    <div class="form">
                        <form class="panel-body" action="{{ route('user.p_shift',['id' => $user->id]) }}" method="GET">
                            @csrf
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="control-label">Username<span style="color: #ff0000">
                                                *</span></label>
                                        <div class="space"></div>
                                        <input type="text" name="iduser" value="{{ $user->id }}" hidden>
                                        <input type="text" size="40" class="form-control" name="" maxlength="200"
                                            value="{{ $user->name }}" disabled>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="control-label">Email<span style="color: #ff0000"> *</span></label>
                                        <div class="space"></div>
                                        <input type="text" name="id_groupnvl" value="" hidden>
                                        <input type="text" size="40" class="form-control" name="" maxlength="200"
                                            value="{{ $user->email }}" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="page-header">
                                    <h3 class="bars text-center">Ca làm việc</h3>
                                </div>
                                <div class="bs-docs-example">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                @foreach($weekdays as $weekday)
                                                    <th>{{ $weekday->name }}</th>
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($count <= 0 )
                                                @foreach ($shifts as $shift)
                                                    <tr>
                                                        <td class="text-center"><b>{{ $shift->name }}</b><br>
                                                            <small><i class="fa fa-clock-o" aria-hidden="true"></i> {{ $shift->hour_start }}</small><br>
                                                            <small><i class="fa fa-stop-circle-o" aria-hidden="true"></i> {{ $shift->hour_end }}</small>
                                                        </td>
                                                        @foreach($weekdays as $weekday)
                                                            <td class="text-center">
                                                                <input type="checkbox" name="shift[]" value="{{ $shift->id }}-{{ $weekday->id }}">
                                                            </td>
                                                        @endforeach
                                                    <tr>
                                                @endforeach
                                            @else
                                                @foreach ($shifts as $shift)
                                                    <tr>
                                                        <td class="text-center"><b>{{ $shift->name }}</b><br>
                                                            <small><i class="fa fa-clock-o" aria-hidden="true"></i> {{ $shift->hour_start }}</small><br>
                                                            <small><i class="fa fa-stop-circle-o" aria-hidden="true"></i> {{ $shift->hour_end }}</small>
                                                        </td>
                                                        @foreach($weekdays as $weekday)
                                                            @php
                                                                $temp = false
                                                            @endphp
                                                            @foreach ($user->userSchedule as $item)
                                                                @if(($item->id_shift == $shift->id) &&
                                                                    ($item->id_weekday == $weekday->id))
                                                                    <td class="text-center">
                                                                        <input type="checkbox" name="shift[]" value="{{ $shift->id }}-{{ $weekday->id }}" checked>
                                                                    </td>
                                                                    @php $temp = true @endphp
                                                                @break
                                                                @endif
                                                            @endforeach
                                                            @if ($temp == false)
                                                                <td class="text-center">
                                                                    <input type="checkbox" name="shift[]" value="{{ $shift->id }}-{{ $weekday->id }}" >
                                                                </td>
                                                            @endif
                                                        @endforeach
                                                    <tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 text-center">
                                    <a href="{{ route('user.index') }}" class="btn btn-default radius">Trở về</a>
                                    <button type="submit" class="btn green-meadow radius">Lưu</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
<script>
    @if(session('success'))
        toastr.success('{{ session('success') }}')
    @endif
    @if(session('info'))
        toastr.info('{{ session('info') }}')
    @endif
</script>
@endsection
