@extends('layouts')
@section('content')
		<div class="w3layouts-glyphicon">
            <div class="grid_3 grid_4">
                    <h2 class="w3ls_head">Order</h2>
                    @foreach ($areas as $area)
                    <h3 class="page-header icon-subheading">{{$area->name}}</h3>
                        <div class="bs-glyphicons">
                            <ul class="bs-glyphicons-list">
                                @foreach ($area->containTable as $table)
                                    <li>
                                        <span class="glyphicon-class">{{$table->name}}</span>
                                        <a href="{{route('order.order',['id' => $table->id])}}">
                                            Chọn món ăn
                                        </a>
                                    </li>
                                @endforeach
                            <ul>
                        </div>
                        <div class="space"></div>
                    @endforeach
                <div class="clearfix"></div>
            </div>
		</div>
@endsection
