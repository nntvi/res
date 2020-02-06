@extends('layouts')
@section('content')
 <h1>List Permission</h1>
 <a href="{{URL::to('/view-add-permission')}}" class="btn btn-primary"> Add Permission </a>
 <table class="table">
    <thead>
      <tr>
        <th scope="col">STT</th>
        <th scope="col">Names</th>
        <th scope="col"></th>
        <th scope="col"></th>
      </tr>
    </thead>
    <tbody>
        @foreach($permissions as $key => $permission)
      <tr>
        <th scope="row">{{ $key + 1}}</th>
        <td>{{ $permission->name}}</td>
        <td>
            <a href="edit-permission/{{$permission->id}}" class="btn default btn-xs red radius" >
                <i class="fa fa-edit"> Sửa </i>
            </a>
        </td>
        <td>
            <a href="delete-permission/{{$permission->id}}" class="btn default btn-xs red radius" >
                <i class="fa fa-trash-o"> Xóa </i>
            </a>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
@endsection
