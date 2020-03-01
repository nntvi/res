@extends('layouts')
@section('content')
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Bếp
            </div>
            <div class="portlet box green-meadow" style="margin-top: 20px;">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-coffee"></i>
                            Chi tiết bếp
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">STT</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Chi tiết </th>
                                        <th scope="col">Trạng thái</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cooks as $key => $cook)
                                      <tr>
                                        <th scope="row">{{ $key + 1}}</th>
                                        <td>{{$cook->name}}</td>
                                        <td>
                                        @foreach($cook->groupMenu as $key => $groupmneu)
                                            {{ $groupmneu->name }} {{ count($cook->groupMenu) != $key+1 ? ',' : '' }}
                                        @endforeach
                                        </td>
                                        <form method="post" action="{{route('cook.update',['id' => $cook->id])}}">
                                            @csrf
                                            <td>
                                                @if ($cook->status == '1')
                                                <label style="display:inline">Hoạt động</label>
                                                <input value="1" id="cook1" type="radio" name="status" style="margin-right: 20px" checked>
                                                <label style="display:inline">Không Hoạt động</label>
                                                <input value="0" id="cook2" type="radio" name="status" style="margin-right: 20px">
                                                @else
                                                <label style="display:inline">Hoạt động</label>
                                                <input value="1" id="cook1" type="radio" name="status" style="margin-right: 20px">
                                                <label style="display:inline">Không Hoạt động</label>
                                                <input value="0" id="cook2" type="radio" name="status" style="margin-right: 20px" checked>
                                                @endif
                                            </td>
                                            <td>
                                                <button type="submit" class="btn default btn-xs yellow-crusta radius"><i
                                                    class="fa fa-edit"> Cập nhật</i>
                                                </button>
                                            </td>
                                        </form>
                                      </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{-- {{ $permissions->links() }} --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

