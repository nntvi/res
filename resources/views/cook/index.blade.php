@extends('layouts')
@section('content')
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            Bếp
        </div>
        <div>
            <table class="table table-bordered" ui-jq="footable" ui-options="{
                &quot;paging&quot;: {
                &quot;enabled&quot;: true
                },
                &quot;filtering&quot;: {
                &quot;enabled&quot;: true
                },
                &quot;sorting&quot;: {
                &quot;enabled&quot;: true
                }}">
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
                            <th scope="row">{{ $key + 1 }}</th>
                            <td>{{ $cook->name }}</td>
                            <td>
                                @foreach($cook->groupMenu as $key => $groupmenu)
                                    @if ($groupmenu->status == '1')
                                        {{ $groupmenu->name }}
                                        {{ count($cook->groupMenu) != $key+1 ? ',' : '' }}
                                    @else
                                        @continue
                                    @endif
                                @endforeach
                            </td>
                            <form method="post"
                                action="{{ route('cook.update',['id' => $cook->id]) }}"
                                onsubmit="return confirm('Khi hủy hoạt động, tất cả nhóm thực đơn thuộc bếp sẽ bị hủy. Vui lòng chuyển các nhóm sang bếp khác trước khi thực hiện thao tác này!')">
                                @csrf
                                <td>
                                    @if($cook->status == '1')
                                        <label style="display:inline">Hoạt động</label>
                                        <input value="1" id="cook1" type="radio" name="status"
                                            style="margin-right: 20px" checked>
                                        <label style="display:inline">Không Hoạt động</label>
                                        <input value="0" id="cook2" type="radio" name="status"
                                            style="margin-right: 20px">
                                    @else
                                        <label style="display:inline">Hoạt động</label>
                                        <input value="1" id="cook1" type="radio" name="status"
                                            style="margin-right: 20px">
                                        <label style="display:inline">Không Hoạt động</label>
                                        <input value="0" id="cook2" type="radio" name="status"
                                            style="margin-right: 20px" checked>
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
        </div>
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
