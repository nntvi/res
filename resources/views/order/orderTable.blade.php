@extends('layouts')
@section('content')
		<div class="w3layouts-glyphicon">
            <div class="grid_3 grid_4">
                        <form action="{{route('order.temporder')}}" method="post">
                            @csrf
                        <h2 class="w3ls_head">Tạo Order</h2>
                        <div class="row">
                            <input type="submit" class="btn green-meadow radius col-xs-12" value="Lưu">
                        </div>
                        <div class="row">
                            <div class="col-sm-6 col-md-3 ">
                                    <h3 class="page-header icon-subheading" style="font-weight: bold">Chọn bàn</h3>
                            </div>
                            <div class="col-sm-6 col-md-3 ">
                                <select class="form-control" name="idTable" style="padding-left: 0px; margin-top: 27px;">
                                    @foreach ($tables as $table)
                                        <option value="{{$table->id}}">{{$table->name}}</option>
                                    @endforeach
                                </select>
                            </div>

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
