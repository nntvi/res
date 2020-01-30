@extends('layouts')
@section('content')
 <h1>List Permission</h1>
 <a href="{{URL::to('/view-add-permission')}}" class="btn btn-primary">Primary</a>
 <table class="table">
    <thead>
      <tr>
        <th scope="col">STT</th>
        <th scope="col">Names</th>
       
      </tr>
    </thead>
    <tbody>
        @foreach($permissions as $key => $permission)
      <tr>
        <th scope="row">{{ $key + 1}}</th>
        <td>{{ $permission->name}}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
@endsection