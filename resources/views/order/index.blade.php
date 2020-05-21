@extends('layouts')
<style>
    .card {
        border: 3px solid #d7d7d7;
        text-align: center;
        padding: 5px;
        line-height: 29px;
        border-radius: 5px;
        background: rgba(149, 149, 149, 0.09);
        cursor: pointer;
    }

    .content-order {
        height: 400px;
        overflow: auto;
    }
    .card-text{
        font-size: 13.5px;
    }
    button .btn-number{
        border-radius: 50%;
    }
    .form-control.input-number{
        border: none;
        border-bottom: 1px solid #000;
        background: 0 0;
    }
    span.input-group-btn span{
        color:whitesmoke;
    }
    .input-group{
        margin-bottom: 0px!important;
    }
</style>
@section('content')
<div class="form-w3layouts">
    <!-- page start-->
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Chọn bàn &nbsp;
                    <span class="tools">
                        <a class="fa fa-chevron-down" href="javascript:;"></a>
                    </span>
                </header>
                <div class="panel-body">
                    @foreach($tables  as $table)
                        @php
                            $temp = false
                        @endphp
                        @foreach($activeTables as $activeTable)
                            @if($activeTable->id_table == $table->id)
                                <div class="col-xs-3 col-sm-2 col-md-1 col-lg-1 m-b-xs" style="padding-right: 0px">
                                    <div class="card" data-id="{{ $table->id }}" data-status="1"
                                        style="background: rgba(254, 48, 48, 0.55);border: 3px solid #ff6d6d;">
                                        <div class="card-body">
                                            <h6 class="card-title">{{ $table->name }}</h6>
                                            <p class="card-text" >Có</p>
                                        </div>
                                    </div>
                                </div>
                                @php
                                    $temp = true
                                @endphp
                                @break
                            @endif
                        @endforeach
                        @if($temp == false)
                            <div class="col-xs-3 col-sm-2 col-md-1 col-lg-1 m-b-xs" style="padding-right: 0px">
                                <div class="card" data-id="{{ $table->id }}" data-status="0">
                                    <div class="card-body">
                                        <h6 class="card-title">{{ $table->name }}</h6>
                                        <p class="card-text">Trống</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach

                </div>
            </section>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div data-collapsed="0" class="panel">
                <div class="panel-heading">
                    <div class="panel-title">
                        Gọi món
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-5 form-group " id="tableOrder">


                        </div>
                        <div class="col-md-7 form-group">
                            <ul class="nav nav-tabs">
                                @foreach($groupmenus as $groupmenu)
                                    <li><a data-toggle="tab" href="#{{ $groupmenu->id }}">{{ $groupmenu->name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="space"></div>
                            <div class="tab-content">
                                @foreach($groupmenus as $groupmenu)
                                    <div id="{{ $groupmenu->id }}" class="tab-pane fade in ">
                                        @foreach($groupmenu->dishes as $dish)
                                            <div class="card col-xs-4 col-sm-2 m-b-xs cardDish" style="margin-right: 5px">
                                                <img class="card-img-top" style="width:100%; height: 60px"
                                                    src="img/{{ $dish->image }}">
                                                <div class="card-body row">
                                                    <div class="space"></div>
                                                    <h5 class="card-title col-xs-12" data-dish="{{ $dish->id }}">{{ $dish->name }}</h5>
                                                    <p class="card-text col-xs-12">{{ $dish->sale_price }}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                            <script>
                                $('ul.nav-tabs li:first-child').addClass('active');
                                $('.tab-content div:first-child').addClass('active');
                                function clickToRemove($id){
                                    var row = document.getElementById('row' + $id);
                                    row.remove();
                                }
                                function clickToPlus($id){
                                    var sl = document.getElementById('count'+$id).value;
                                    if(sl < 20){
                                        sl++;
                                        document.getElementById('count' + $id).value = sl;
                                        document.getElementById('qty' + $id).value = sl;
                                    }else if(sl == 20){
                                        document.getElementById('count' + $id).value = 20;
                                        document.getElementById('qty' + $id).value = 20;
                                    }
                                }
                                function clickToMinus($id){
                                    var sl = document.getElementById('count'+$id).value;
                                    if(sl > 1){
                                        sl--;
                                        document.getElementById('count' + $id).value = sl;
                                        document.getElementById('qty' + $id).value = sl;
                                    }else if(sl == 1){
                                        document.getElementById('count' + $id).value = 1;
                                        document.getElementById('qty' + $id).value = 1;
                                    }
                                }
                            </script>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- page end-->

    </div>
    @endsection
