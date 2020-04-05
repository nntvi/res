@extends('layouts')
<style>
    span.error-message{
        color: red;
        font-size: 12px;
        font-style: italic;
    }
</style>
@section('content')
<div class="mail-w3agile">
    <!-- page start-->
    <div class="row">
        <div class="col-sm-9">
            <div class="table-agile-info">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Topping
                    </div>
                    <div class="row w3-res-tb">
                    <div class="col-sm-5 m-b-xs">
                        <select class="input-sm form-control w-sm inline v-middle">
                            <option value="0">Theo tên</option>
                            <option value="1">Theo giá</option>
                        </select>
                        <button class="btn btn-sm btn-default">Sắp xếp</button>
                    </div>
                    <div class="col-sm-3">
                    </div>
                    <div class="col-sm-4">
                        <div class="input-group">
                        <input type="text" class="input-sm form-control" placeholder="Search">
                        <span class="input-group-btn">
                            <button class="btn btn-sm btn-default" type="button">Tìm kiếm!</button>
                        </span>
                        </div>
                    </div>
                    </div>
                    <div class="table-responsive">
                    <table class="table table-striped b-t b-light">
                        <thead>
                        <tr>
                            <tr>
                                <th>STT</th>
                                <th>Tên topping</th>
                                <th>Giá</th>
                                <th>Nhóm</th>
                                <th>Cập nhật</th>
                                <th>Xóa</th>
                            </tr>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($toppings as $key => $topping)
                            <form class="panel-body create-food" enctype="multipart/form-data"
                                role="form" id="createNews-form" action="{{route('topping.p_update',['id' => $topping->id])}}" method="POST">
                                @csrf
                                <tr>
                                    <td width="5%">{{$key + 1}}</td>
                                    <td width="25%">
                                        <input type="text" size="40" class="form-control"
                                            value="{{$topping->name}}" name="name" maxlength="100">
                                    </td>
                                    <td width="20%">
                                        <input type="number" size="40" class="form-control number"
                                            value="{{ $topping->price}}" name="price">
                                        <div class="errorMessage" id="ToppingForm_toppingPrice_em_"
                                            style="display:none"></div>
                                    </td>
                                    <td width="20%">
                                        <select class="form-control" name="toppingFrom">
                                            <option value="{{$topping->groupMenu->id}}" selected="selected">{{ $topping->groupMenu->name }}
                                            </option>
                                            @foreach ($groupMenus as $groupMenu)
                                                <option value="{{ $groupMenu->id }}">{{$groupMenu->name}}</option>
                                            @endforeach
                                        </select> </td>
                                    <td width="10%">
                                        <button type="submit"
                                            class="btn default btn-xs yellow-crusta radius"><i
                                                class="fa fa-edit"> Cập nhật</i></button>
                                    </td>

                                    <td width="10%">
                                        <a href="{{route('topping.delete',['id' => $topping->id])}}"
                                            class="btn default btn-xs red radius"
                                            onclick="return confirm('Bạn muốn xóa dữ liệu này?')">
                                            <i class="fa fa-trash-o"> Xóa</i>
                                        </a>
                                    </td>
                                </tr>
                            </form>
                            @endforeach
                        </tbody>
                    </table>
                    </div>
                    <footer class="panel-footer">
                    <div class="row">

                        <div class="col-sm-5 text-center">
                        <small class="text-muted inline m-t-sm m-b-sm">showing 20-30 of 50 items</small>
                        </div>
                        <div class="col-sm-7 text-right text-center-xs">
                        <ul class="pagination pagination-sm m-t-none m-b-none">
                            <li><a href=""><i class="fa fa-chevron-left"></i></a></li>
                            <li><a href="">1</a></li>
                            <li><a href="">2</a></li>
                            <li><a href="">3</a></li>
                            <li><a href="">4</a></li>
                            <li><a href=""><i class="fa fa-chevron-right"></i></a></li>
                        </ul>
                        </div>
                    </div>
                    </footer>
                </div>
            </div>
        </div>
        <div class="col-sm-3 com-w3ls">
                <section class="panel">
                    <header class="panel-heading" style="background: indianred;color: white;">
                        Thêm mới Topping
                    </header>
                    <div class="panel-body">
                        <form class="panel-body create-food" enctype="multipart/form-data"
                            role="form" id="createNews-form" action="{{ route('topping.p_store')}}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label class="control-label">Tên Topping<span style="color: #ff0000;"> *</span></label>
                                <input type="text" size="40" class="form-control" name="nameTopping" maxlength="100">

                            </div>
                            <div class="form-group">
                                <label class="control-label">Giá</label>
                                <input type="number" size="40" class="form-control number" name="priceTopping">

                            </div>
                            <div class="form-group">
                                <label class="control-label">Chọn tên nhóm thực đơn<span style="color: #ff0000;"> *</span></label>
                                <select class="form-control radius" name="idGroupMenu" style="margin-top: 15px">
                                    @foreach ($groupMenus as $groupMenu)
                                        <option value="{{ $groupMenu->id }}">{{$groupMenu->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <span class="error-message">{{ $errors->first('nameTopping') }}</span></p>
                            <span class="error-message">{{ $errors->first('priceTopping') }}</span>
                            <input type="submit" class="btn btn-compose" value="Tạo mới" style="background: darkcyan;">
                        </form>
                    </div>
                </section>
        </div>
    </div>

    <!-- page end-->
    </div>
@endsection
