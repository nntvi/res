@extends('layouts')
@section('content')
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            Topping - Ghi chú món
        </div>
        <div class="row">
            <div class="col-xs-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Danh mục</a></li>
                        <li class="breadcrumb-item"><a href="#">Topping, ghi chú món</a></li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="portlet box green-meadow ">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i>
                        Thêm mới topping
                </div>
            </div>
            <div class="portlet-body">
                <form class="panel-body create-food" enctype="multipart/form-data"
                    role="form" id="createNews-form" action="{{ route('topping.p_store')}}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-3 col-sm-4">
                            <label class="control-label">Tên Topping<span style="color: #ff0000;"> *</span></label>
                            <input type="text" size="40" class="form-control" name="nameTopping" maxlength="100">
                            <span class="error-message">{{ $errors->first('nameTopping') }}</span></p>

                        </div>
                        <div class="col-md-3 col-sm-4">
                            <label class="control-label">Giá</label>
                            <input type="number" size="40" class="form-control number" name="priceTopping">
                            <span class="error-message">{{ $errors->first('priceTopping') }}</span></p>

                        </div>
                        <div class="col-md-3 col-sm-4">
                            <label class="control-label"></label>
                            <select class="form-control radius" name="idGroupMenu" style="margin-top: 15px">
                                <option value="">-- Chọn tên nhóm thực đơn --</option>
                                @foreach ($groupMenus as $groupMenu)
                                    <option value="{{ $groupMenu->id }}">{{$groupMenu->name}}</option>
                                @endforeach
                            </select>
                            <span class="error-message">{{ $errors->first('idGroupMenu') }}</span></p>

                        </div>
                        <div class="col-md-3 col-sm-12">
                            <input type="submit" class="btn green-meadow radius" name="create" style="margin-top: 40px"
                                value="Tạo mới"></div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="space"></div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-coffee"></i>
                    Danh sách topping </div>
            </div>

            <div class="portlet-body">
                <div class="row">
                    <div class="col-md-6">
                        @if ($errors->any())
                            <span class="error-message">{{ $errors->first('name') }}</span></p>
                            <span class="error-message">{{ $errors->first('price') }}</span></p>
                        @endif
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Tên topping</th>
                                <th>Giá</th>
                                <th>Nhóm</th>
                                <th>Cập nhật</th>
                                <th>Xóa</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($toppings as $key => $topping)
                            <form class="panel-body create-food" enctype="multipart/form-data"
                                role="form" id="createNews-form" action="{{route('topping.p_update',['id' => $topping->id])}}" method="POST">
                                @csrf
                                <tr>
                                    <td width="5%">{{$key + 1}}</td>
                                    <td width="30%">
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
            </div>
        </div>
        <footer class="panel-footer">
            <div class="row">

                <div class="col-sm-5 text-center">
                    <small class="text-muted inline m-t-sm m-b-sm">showing 20-30 of 50 items</small>
                </div>
                <div class="col-sm-7 text-right text-center-xs">
                    {{ $toppings->links() }}
                </div>
            </div>
        </footer>
    </div>
</div>
@endsection
