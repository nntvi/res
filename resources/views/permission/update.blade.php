@extends('layouts')
@section('content')
    <form action="edit-post-permission/{{$permission->id}}" method="POST">
        @csrf
        <div class="form-group">
          <label for="name">Name</label>
          <input type="text" class="form-control" name="name" aria-describedby="name" value="{{$permission->name}}">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
