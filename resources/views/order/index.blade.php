@extends('layouts')
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    .card {
        border: 2px solid #d7d7d7;
        text-align: center;
        padding: 5px;
        line-height: 29px;
        border-radius: 5px;
        background: rgba(149, 149, 149, 0.09);
        cursor: pointer;
    }
    .card.table{
        line-height: 45px;
    }
    .tab-content .cardDish{
        border-radius: 0px;
    }
    .tab-content .cardDish:hover{
        background: #e6e4e4;
    }
    .tab-content .cardDish .card-title{
        height: 25px;
        overflow: hidden;
    }
    .content-order, .tab-content {
        height: 480px;
        overflow: auto;
    }
    .card-text{
        font-size: 13.5px;
    }
    .card-text.chair{
        font-size: 15px;
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
    div.tab-content::-webkit-scrollbar {
        width: 0px;
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
    .tabbable{
        margin-top: 5px
    }
    li#searchDish{
        text-transform: none;
    }
    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
    }

    /* Firefox */
    input[type=number] {
    -moz-appearance: textfield;
    }
</style>
@section('content')
<div class="form-w3layouts">
    <div class="row">
        <div class="col-md-12">
            <div data-collapsed="0" class="panel">
                {{--  <div class="panel-heading">
                    <div class="panel-title">
                        Màn hình order
                    </div>
                </div>  --}}
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
                            <!-- Custom Tabs -->
                            <div class="nav-tabs-custom panel-heading" style="background: lavender;">
                                <ul class="nav nav-tabs" style="padding-top: 4px" id="main">
                                    <li><a href="#area" data-toggle="tab" >Khu vực</a></li>
                                    <li><a href="#groupmenu" data-toggle="tab" class="groupmenu">Danh mục món ăn</a></li>
                                    <li id="searchDish">
                                        <a href="#search" data-toggle="modal">
                                            <i class="fa fa-search" aria-hidden="true"></i>
                                        </a>
                                        <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="search" class="modal fade" style="display: none;">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                                        <h4 class="modal-title text-left">Tìm kiếm món ăn</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group text-left">
                                                            <label>Nhập tên món ăn cần tìm</label>
                                                            <input type="text" class="form-control" id="inputSearchDish">
                                                        </div>
                                                        <div class="form-group text-left">
                                                            <div class="bs-docs-example">
                                                                <table class="table table-striped">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Tên món</th>
                                                                            <th>Giá bán</th>
                                                                            <th>Đơn vị</th>
                                                                            <th class="text-right"></th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id="tblSearchDish">

                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <button class="btn btn-default" id="btnSubmitSearchDish">Chọn</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-content">
                                <div class="tab-pane fade in m-b-xs" id="area">
                                    <div class="tabbable">
                                        <ul class="nav nav-tabs middle" style="margin-bottom: 20px">
                                                @foreach ($areas as $area)
                                                    <li><a href="#area{{ $area->id }}" data-toggle="tab" >{{ $area->name }}</a></li>
                                                @endforeach
                                        </ul>
                                        <div class="tab-content">
                                            @foreach ($areas as $area)
                                                <div class="tab-pane" id="area{{ $area->id }}">
                                                    @foreach ($area->containTable as $table)
                                                        @php
                                                            $temp = false
                                                        @endphp
                                                        @foreach($activeTables as $activeTable)
                                                            @if($activeTable->id_table == $table->id)
                                                                <div class="col-xs-4 col-sm-3 col-md-3 m-b-xs" style="padding-left: 0px">
                                                                    <div class="card table" data-id="{{ $table->id }}" data-status="1"
                                                                        style="background: rgba(254, 48, 48, 0.55);border: 2px solid #ff6d6d;">
                                                                        <div class="card-body">
                                                                            <input type="hidden" name="idBill" value="{{ $activeTable->id_order }}">
                                                                            <h5 class="card-title" style="overflow: hidden;">{{ $table->name }}</h5>
                                                                            <p class="card-text chair" >{{ $table->chairs }} ghế</p>
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
                                                            <div class="col-xs-4 col-sm-3 col-md-3 m-b-xs" style="padding-left: 0px">
                                                                <div class="card table" data-id="{{ $table->id }}" data-status="0" id="tbl{{ $table->id }}">
                                                                    <div class="card-body">
                                                                        <h5 class="card-title" style="overflow: hidden;">{{ $table->name }}</h5>
                                                                        <p class="card-text chair">{{ $table->chairs }} ghế</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade in" id="groupmenu">
                                    <div class="tabbable">
                                        <ul class="nav nav-tabs middle" style="margin-bottom: 20px">
                                            @foreach($groupmenus as $groupmenu)
                                                <li><a data-toggle="tab" href="#{{ $groupmenu->id }}">{{ $groupmenu->name }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    <div class="tab-content">
                                        @foreach($groupmenus as $groupmenu)
                                            <div class="tab-pane" id="{{ $groupmenu->id }}">
                                                @foreach($groupmenu->dishes as $dish)
                                                    @if ($dish->id_groupmenu == $groupmenu->id)
                                                        <div class="card col-xs-4 col-sm-3 m-b-xs cardDish">
                                                            <img class="card-img-top img-responsive" src="img/{{ $dish->image }}">
                                                            <div class="card-body row">
                                                                <p class="card-title col-xs-12" data-dish="{{ $dish->id }}">{{ $dish->name }}<p>
                                                                <h6 class="card-text col-xs-12">{{ number_format($dish->sale_price) . ' đ' }}</h6>
                                                                <input type="hidden" class="price" value="{{ $dish->sale_price }}">
                                                            </div>
                                                        </div>
                                                    @else
                                                        @continue
                                                    @endif
                                                @endforeach
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                </div>

                            </div>
                        </div>
                            <script>
                                $('ul.nav-tabs li:first-child').addClass('active');
                                $('.tab-content div:first-child').addClass('active');

                            </script>
                            <script>
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
</div>
@endsection
