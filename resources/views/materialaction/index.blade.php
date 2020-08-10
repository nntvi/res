@extends('layouts')
@section('content')
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            Cấu tạo NVL từng món
        </div>
        <div class="row w3-res-tb">
                <div class="col-sm-4 m-b-xs">

                </div>
                <div class="col-sm-3">
                </div>
                <div class="col-sm-5">
                    <form action="{{ route('material_action.search') }}" method="post">
                        @csrf
                        <div class="input-group">
                        <input type="text" min="3" max="40" class="input-sm form-control" name="nameSearch" required>
                        <span class="input-group-btn">
                            <button class="btn btn-sm btn-danger" type="submit">Search!</button>
                        </span>
                        </div>
                    </form>
                </div>
                </div>
        <div>
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Thuộc nhóm NVL</th>
                        <th>Tên nguyên vật liệu</th>
                        <th class="text-center">Xem chi tiết</th>
                        <th class="text-center">Thêm chi tiết</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        @foreach($materials as $key => $material)
                    <tr>
                        <th scope="row">{{ $key + 1 }}</th>
                        <td>{{ $material->name }}</td>
                        <td>
                            @foreach($material->materialAction as $key => $item)
                                {{ $item->materialDetail->name }}
                                {{ count($material->materialAction) != $key+1 ? ',' : '' }}
                            @endforeach
                        </td>
                        <td class="text-center">
                            <a
                                href="{{ route('material_action.detail',['id' => $material->id]) }}">Xem
                                chi tiết</a>
                        </td>
                        <td class="text-center">
                            <a
                                href="{{ route('material_action.store',['id' => $material->id]) }}">
                                <i class="fa fa-plus-circle" aria-hidden="true"
                                    style="font-size: 17px; color: darkgreen">&nbsp;Thêm mới</i>
                            </a>
                        </td>
                    </tr>

                    @endforeach

                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
