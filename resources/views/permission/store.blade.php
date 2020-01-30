@extends('layouts')
@section('content')
    <form action="{{ URL::to('/add-permission')}}" method="POST">
        @csrf
        <div class="form-group">
          <label for="name">Name</label>
          <input type="text" class="form-control" name="name" aria-describedby="name" placeholder="name">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection