@extends('layouts')
@section('content')
<div class="table-agile-info">
    <div class="panel-heading">
        {{ $cook->name }}
    </div>
    <div class="table-responsive">
        <table class="table table-striped b-t b-light">
        <thead>
            <tr>
            <th data-breakpoints="xs">STT</th>
            <th>Tên món</th>
            <th>Số lượng</th>
            <th>Ghi chú</th>
            <th class="text-center" >Thời gian</th>
            <th>Duyệt món</th>
            <th>Công thức</th>
            <th>Cập nhật</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $key => $dish)
                    <form action="{{route('cook_screen.p_update',['id' => $dish->id])}}" method="post">
                        @csrf
                        <input type="text" name="idCook" value="{{$cook->id}}" hidden>
                        <tr data-expanded="true">
                            <td>{{$key+1}}</td>
                            <td>{{ $dish->dish->name }}</td>
                            <td class="text-center">{{$dish->qty}}</td>
                            @if ($dish->note != null)
                                <td>
                                    {{ $dish->note }}
                                </td>
                            @else
                                <td class="text-center">- - -</td>
                            @endif
                            <td>{{$dish->created_at}}</td>
                            <td>
                                @if ($dish->status == '0')
                                    <input value="1" type="radio" name="status">
                                    <label style="display:inline; color: red;">Đang thực hiện</label>
                                @endif
                                @if ($dish->status == '1')
                                    <input value="2" type="radio" name="status">
                                    <label style="display:inline; color: red;">Hoàn thành</label>
                                @endif
                                @if($dish->status == '2')
                                    <label style="display:inline; color: darkgreen;">
                                        <i class="fa fa-check" aria-hidden="true"></i>
                                        Đã Hoàn thành
                                    </label>
                                @endif
                            </td>
                            <td>
                                <a href="{{route('material_action.detail',['id' => $dish->dish->id_groupnvl])}}">Xem công thức</a>
                            </td>
                            <td>
                                @if ($dish->status == '0')
                                    <button type="submit" class="btn default btn-xs yellow-crusta radius">
                                        <i class="fa fa-edit"> Cập nhật</i>
                                    </button>
                                @endif
                                @if ($dish->status == '1')
                                    <button type="submit" class="btn default btn-xs yellow-crusta radius">
                                        <i class="fa fa-edit"> Cập nhật</i>
                                    </button>
                                @endif
                                @if ($dish->status == '2')
                                    --
                                @endif

                            </td>
                        </tr>
                    </form>
            @endforeach
        </tbody>
        </table>
    </div>
</div>



@endsection
