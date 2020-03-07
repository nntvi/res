@extends('layouts')
@section('content')
<div class="mail-w3agile">
        <!-- page start-->
        <div class="row">
            <div class="col-sm-8 mail-w3agile">
                <section class="panel">
                        <div class="panel-heading">
                                Hóa đơn {{ $idBillTable->id }} --
                                {{ $idBillTable->table->name }}
                        </div>
                    <header class="panel-heading wht-bg">
                       <h5 class="gen-case ">
                            Thời gian: {{ $idBillTable->created_at }}
                       </h5>
                    </header>
                    <hr>
                    <div class="table-responsive">
                            <table class="table table-striped b-t b-light">
                                <thead>
                                <tr>
                                    <th style="width:20px;">
                                        STT
                                    </th>
                                    <th>Tên món</th>
                                    <th>Số lượng</th>
                                    <th>Đơn giá</th>
                                    <th>Thành tiền</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($bill as $key => $item)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{$item->dish->name}}</td>
                                            <td>{{$item->amount}}</td>
                                            <td>{{$item->dish->sale_price}}</td>
                                            <td>{{$item->dish->sale_price * $item->amount}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                    </div>
                    <hr>
                    <div class="bs-example">
                            <table class="table">
                                <div class="panel-heading">
                                    Tổng tiền : {{ $totalPrice }}
                                </div>
                            </table>
                        </div>
                </section>
            </div>
            <div class="col-sm-4 com-w3ls">
                <form action="" method="post">
                    <section class="panel">

                            <div class="panel-body">
                                
                                <a href=""  class="btn btn-compose">
                                    Thanh toán
                                </a>
                                <hr>
                                <div class="form-group">
                                   <div class="row">
                                       <div class="col-xs-6 col-sm-6 col-md-6">
                                           <label for="">Tổng tiền: </label>
                                       </div>
                                       <div class="col-xs-6 col-sm-6 col-md-6 text-right">
                                            <input style="font-weight: bold;
                                            color: red;
                                            font-size: 15px;" class="form-control totalPrice" type="text" value="{{$totalPrice}}" disabled>                                       </div>
                                   </div>
                                   <hr>
                                   <div class="row">
                                       <div class="col-xs-12 col-sm-12 col-md-6">
                                            <label for="">Tiền khách đưa: </label>
                                       </div>
                                       <div class="col-xs-12 col-sm-12 col-md-6 form-group">
                                            <input type="text" class="form-control receive">
                                       </div>
                                   </div>

                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-6">
                                             <label for="">Tiền thừa: </label>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-6 form-group">
                                            <span class="change"></span>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                             <label for="">Ghi chú: </label>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12 form-group" style="margin-top: 5px">
                                            <textarea name="" id="" class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <script>
                                            $('.receive').keyup(function(){
                                                var customer_pay;
                                                if($(this).val()==''){
                                                    customer_pay=0;
                                                }else{
                                                    customer_pay = $(this).val();
                                                }
                                                var total_pay = $('.totalPrice').val();
                                                console.log(total_pay);
                                                var debt = customer_pay - total_pay;
                                                $(this).val((customer_pay));
                                                $('.change').html(debt);
                                            });
                                    </script>
                                </div>
                            </div>
                    </section>
                </form>
            </div>
        </div>
        <!-- page end-->
        </div>
@endsection