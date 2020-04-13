@extends('layouts')
@section('content')
<div class="table-agile-info">
        <div class="panel panel-default">
           <div class="panel-heading">
                Cấu tạo NVL từng món
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
                            <th scope="row">{{ $key + 1}}</th>
                            <td>{{$material->name}}</td>
                            <td>
                                @foreach ($material->materialAction as $key => $item)
                                    {{ $item->materialDetail->name }} {{ count($material->materialAction) != $key+1 ? ',' : '' }}
                                @endforeach
                            </td>
                            <td class="text-center">
                                <a href="{{route('material_action.detail',['id' => $material->id])}}">Xem chi tiết</a>
                            </td>
                            <td class="text-center">
                                <a href="{{route('material_action.store',['id' => $material->id])}}">
                                    <i class="fa fa-plus-circle" aria-hidden="true" style="font-size: 17px; color: darkgreen">&nbsp;Thêm mới</i>
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
