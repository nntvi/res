@extends('layouts')
@section('content')
		<div class="w3layouts-glyphicon">
            <div class="grid_3 grid_4">
                    <form action="{{route('order.p_addmore',['id' => $order->id])}}" method="post">
                        @csrf
                        <h2 class="w3ls_head">Thêm món -
                                {{ $order->table->name }}
                        </h2>
                        <div class="row">
                            <input type="submit" class="btn green-meadow radius col-xs-12" value="Lưu">
                        </div>
                            @foreach ($groupmenus as $groupmenu)
                                <h3 class="page-header icon-subheading">{{$groupmenu->name}}</h3>
                                    <div class="row">
                                        @foreach ($groupmenu->dishes as $dish)
                                            <div class="col-lg-4">
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <input type="checkbox" value="{{$dish->id}}" name="idDish[]">
                                                    </span>
                                                    <input type="text" class="form-control" name="nameDish" value="{{$dish->name}}">
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                            @endforeach
                     </form>
                <div class="clearfix"></div>
            </div>
		</div>
@endsection
