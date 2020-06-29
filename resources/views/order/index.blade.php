@extends('layouts')
<meta name="csrf-token" content="{{ csrf_token() }}">
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
    .tab-content .cardDish{
        border-radius: 0px;
    }
    .tab-content .cardDish:hover{
        background: #e6e4e4;
    }
    .tab-content .cardDish .card-title{
        height: 25px;
    }
    .content-order, .tab-content {
        height: 500px;
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
    ul.nav-tabs li>a{
        color: unset;
    }
    .activities .btn{
        border-radius: 0px;
    }
    .activities .btn button.btn{
        height: 50px;
    }
    /* width */
::-webkit-scrollbar {
    width: 10px;
  }

  /* Track */
  ::-webkit-scrollbar-track {
    background: #f1f1f1;
  }

  /* Handle */
  ::-webkit-scrollbar-thumb {
    background: #888;
  }

  /* Handle on hover */
  ::-webkit-scrollbar-thumb:hover {
    background: #555;
  }
</style>
@section('content')
<div class="form-w3layouts">
    <!-- page start-->
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-9">Chọn bàn &nbsp;
                            <span class="tools">
                                <a class="fa fa-chevron-down" href="javascript:;"></a>
                            </span>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-3 text-right" style="margin: 10px 0px">
                            <input type="text" id="searchTable" class="form-control">
                        </div>
                    </div>

                </header>
                <div class="panel-body tables">
                    @foreach($tables  as $table)
                        @php
                            $temp = false
                        @endphp
                        @foreach($activeTables as $activeTable)
                            @if($activeTable->id_table == $table->id)
                                <div class="col-xs-4 col-sm-2 col-md-2 col-lg-1 m-b-xs" style="padding-right: 0px">
                                    <div class="card" data-id="{{ $table->id }}" data-status="1"
                                        style="background: rgba(254, 48, 48, 0.55);border: 3px solid #ff6d6d;">
                                        <div class="card-body">
                                            <input type="hidden" name="idBill" value="{{ $activeTable->id_order }}">
                                            <h6 class="card-title" style="height: 12px; overflow: hidden;">{{ $table->name }}</h6>
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
                            <div class="col-xs-4 col-sm-2 col-md-2 col-lg-1 m-b-xs" style="padding-right: 0px">
                                <div class="card" data-id="{{ $table->id }}" data-status="0" id="tbl{{ $table->id }}">
                                    <div class="card-body">
                                        <h6 class="card-title" style="height: 12px; overflow: hidden;">{{ $table->name }}</h6>
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
                                <div class="panel panel-default">
                                    <div class="panel-heading nameTableOrder" style="background: #ff00003b!important">
                                        Bàn ...
                                    </div>
                                    <div class="content-order">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Món</th>
                                                    <th width="27%" class="text-center">Số lượng</th>
                                                    <th>Ghi chú</th>
                                                    <th>Giá</th>
                                                    <th style="width:3px;"></th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
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
                                            @if ($dish->stt == '1' && $dish->status == '1')
                                                <div class="card col-xs-4 col-sm-2 m-b-xs cardDish">
                                                    <img class="card-img-top img-responsive" src="img/{{ $dish->image }}">
                                                    <div class="card-body row">
                                                        <p class="card-title col-xs-12" data-dish="{{ $dish->id }}">{{ $dish->name }}<p>
                                                        <h6 class="card-text col-xs-12">{{ $dish->sale_price }}</h6>
                                                    </div>
                                                </div>
                                            @endif
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
                                function clickToPlus(id){
                                    var sl = document.getElementById('count'+ id).value;
                                    if(sl < 20){
                                        sl++;
                                        document.getElementById('count' + id).value = sl;
                                    }else if(sl == 20){
                                        document.getElementById('count' + id).value = 20;
                                    }
                                }
                                function clickToMinus($id){
                                    var sl = document.getElementById('count'+$id).value;
                                    if(sl > 1){
                                        sl--;
                                        document.getElementById('count' + $id).value = sl;
                                    }else if(sl == 1){
                                        document.getElementById('count' + $id).value = 1;
                                    }
                                }
                                $('.card.cardDish').click(function () {
                                    var table = document.getElementById('bodyTableOrder');
                                    if(table == null || table == ""){
                                        alert('Vui lòng chọn bàn');
                                    }
                                    var idDish = $(this).find('p[data-dish]').data('dish'); // id dish
                                    if(table.rows.length == 0){
                                        var nameDish = $(this).find('.card-title').text();
                                        var priceDish = $(this).find('.card-text').text();
                                        let row =   `<tr id="row`+ idDish +`" data-row="`+ idDish +`">
                                                        <td><input type="hidden" class="idDish" name="idDish[]" value="`+ idDish +`">`+ nameDish+`</td>
                                                        <td>
                                                            <div class="input-group">
                                                                <span class="input-group-btn" onclick="clickToMinus(`+ idDish +`)">
                                                                    <button type="button" class="btn btn-xs btn-danger btn-number">
                                                                        <span class="glyphicon glyphicon-minus"></span>
                                                                    </button>
                                                                </span>
                                                                <input type="text" name="qty[]" class="form-control input-number qty" value="1" id="count`+ idDish +`">
                                                                <span class="input-group-btn btn-xs" onclick="clickToPlus(`+ idDish +`)">
                                                                    <button type="button" class="btn btn-xs btn-success btn-number">
                                                                        <span class="glyphicon glyphicon-plus"></span>
                                                                    </button>
                                                                </span>
                                                            </div>
                                                        </td>
                                                        <td><input type="text" name="note[]" class="form-control"></td>
                                                        <td>`+ priceDish +`</td>
                                                        <td style="width:5px; cursor:pointer">
                                                            <a  onclick="clickToRemove(`+ idDish +`)">
                                                                <i class="fa fa-times text-danger text"></i>
                                                            </a>
                                                        </td>
                                                    </tr>`
                                        $('#bodyTableOrder').append(row);
                                    }else{
                                        var temp = 0;
                                        for (var i = 0, row; row = table.rows[i]; i++) {
                                            for (var j = 0, col; col = row.cells[j]; j++) {
                                                if(j == 0){
                                                    $('input[type="hidden"].idDish').each(function (index) {
                                                        if(idDish == $(this).val() && index == i){
                                                            temp++;
                                                            var x = document.getElementById('count'+ idDish).value;
                                                            x++;
                                                            document.getElementById('count'+ idDish).value = x;
                                                        }
                                                    });
                                                }
                                            }
                                        }
                                        if(temp == 0){
                                            var nameDish = $(this).find('.card-title').text();
                                            var priceDish = $(this).find('.card-text').text();
                                            let row =   `<tr id="row`+ idDish +`" data-row="`+ idDish +`">
                                                            <td><input type="hidden" class="idDish" name="idDish[]" value="`+ idDish +`">`+ nameDish+`</td>
                                                                <td>
                                                                    <div class="input-group">
                                                                        <span class="input-group-btn" onclick="clickToMinus(`+ idDish +`)">
                                                                            <button type="button" class="btn btn-xs btn-danger btn-number">
                                                                                <span class="glyphicon glyphicon-minus"></span>
                                                                            </button>
                                                                        </span>
                                                                        <input type="text" name="qty[]" class="form-control input-number qty" value="1" id="count`+ idDish +`">
                                                                        <span class="input-group-btn btn-xs" onclick="clickToPlus(`+ idDish +`)">
                                                                            <button type="button" class="btn btn-xs btn-success btn-number">
                                                                                <span class="glyphicon glyphicon-plus"></span>
                                                                            </button>
                                                                        </span>
                                                                    </div>
                                                                </td>
                                                                <td><input type="text" name="note[]" class="form-control"></td>
                                                                <td>`+ priceDish +`</td>
                                                                <td style="width:5px; cursor:pointer">
                                                                    <a  onclick="clickToRemove(`+ idDish +`)">
                                                                        <i class="fa fa-times text-danger text"></i>
                                                                    </a>
                                                                </td>
                                                        </tr>`
                                            $('#bodyTableOrder').append(row);
                                        }
                                    }
                                });

                            </script>
                            <script>
                                @if($errors->any())
                                    @foreach($errors->all() as $error)
                                        toastr.error('{{ $error }}')
                                    @endforeach
                                @endif
                                @if(session('success'))
                                    toastr.success('{{ session('success') }}')
                                @endif
                                @if(session('warning'))
                                    toastr.warning('{{ session('warning') }}')
                                @endif
                            </script>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- page end-->
    </div>
    @endsection
