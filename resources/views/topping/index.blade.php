@extends('layouts')
<style>
    span.error-message {
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
                        <div class="col-sm-4 m-b-xs">
                            <select class="input-sm form-control w-sm inline v-middle">
                                <option value="0">Theo tên</option>
                                <option value="1">Theo giá</option>
                            </select>
                            <button class="btn btn-sm btn-default">Sắp xếp</button>
                        </div>
                        <div class="col-sm-4">
                            <span class="error-message">{{ $errors->first('nameToppingUpdate') }}</span></p>
                        </div>
                        <div class="col-sm-4">
                            <form action="{{ route('topping.search') }}" method="GET">
                                <div class="input-group">
                                    <input type="text" class="input-sm form-control" required name="nameSearch">
                                    <span class="input-group-btn">
                                        <button class="btn btn-sm btn-default" type="submit">Tìm kiếm!</button>
                                    </span>
                                </div>
                            </form>
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
                                    <th>Xóa</th>
                                </tr>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($toppings as $key => $topping)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            <a href="#myModal{{ $topping->id }}" data-toggle="modal"
                                                ui-toggle-class="">
                                                <i class="fa fa-pencil-square-o text-success text-active"></i>
                                            </a>
                                            <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog"
                                                tabindex="-1" id="myModal{{ $topping->id }}" class="modal fade"
                                                style="display: none;">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button aria-hidden="true" data-dismiss="modal"
                                                                class="close" type="button">×</button>
                                                            <h4 class="modal-title">Chỉnh sửa tên topping</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form role="form" action="{{ route('topping.p_updatename',['id' => $topping->id ]) }}" method="POST">
                                                                @csrf
                                                                <div class="form-group">
                                                                    <label>Tên cũ</label>
                                                                    <input type="text" class="form-control"
                                                                        value="{{ $topping->name }}" disabled>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Giá cần sửa<span style="color: #ff0000">
                                                                            *</span></label>
                                                                    <input type="text" size="40" class="form-control"
                                                                        required="required" name="nameToppingUpdate"
                                                                        maxlength="255" value="{{ $topping->name }}">
                                                                </div>
                                                                <button type="submit"
                                                                    class="btn btn-default">Lưu</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{ $topping->name }}
                                        </td>
                                        <td>
                                            <a href="#price{{ $topping->id }}" data-toggle="modal"
                                                ui-toggle-class="">
                                                <i class="fa fa-pencil-square-o text-warning text-active"></i>
                                            </a>
                                            <div aria-hidden="true" aria-labelledby="priceLabel" role="dialog"
                                                tabindex="-1" id="price{{ $topping->id }}" class="modal fade"
                                                style="display: none;">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button aria-hidden="true" data-dismiss="modal"
                                                                class="close" type="button">×</button>
                                                            <h4 class="modal-title">Chỉnh sửa giá topping</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form role="form" action="{{ route('topping.p_updateprice',['id' => $topping->id]) }}" method="POST">
                                                                @csrf
                                                                <div class="form-group">
                                                                    <label>Tên topping</label>
                                                                    <input type="text" class="form-control"
                                                                        value="{{ $topping->name }}" disabled>
                                                                </div>
                                                                <div class="form-group">
                                                                        <label>Giá cũ</label>
                                                                        <input type="text" class="form-control"
                                                                            value="{{ number_format($topping->price) .' đ' }}" disabled>
                                                                    </div>
                                                                <div class="form-group">
                                                                    <label>Giá cần sửa <span style="color: #ff0000">
                                                                            *</span></label>
                                                                    <input type="number" min="1" class="form-control"
                                                                        required="required" name="priceTopping"
                                                                        value="{{$topping->price}}">
                                                                </div>
                                                                <button type="submit"
                                                                    class="btn btn-default">Lưu</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{ number_format($topping->price) .' đ' }}
                                        </td>
                                        <td>
                                            <a href="#groupmenu{{ $topping->id }}" data-toggle="modal"
                                                ui-toggle-class="">
                                                <i class="fa fa-pencil-square-o text-info text-active"></i>
                                            </a>
                                            <div aria-hidden="true" aria-labelledby="groupmenuLabel" role="dialog"
                                                tabindex="-1" id="groupmenu{{ $topping->id }}" class="modal fade"
                                                style="display: none;">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button aria-hidden="true" data-dismiss="modal"
                                                                class="close" type="button">×</button>
                                                            <h4 class="modal-title">Chỉnh sửa nhóm thực đơn</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form role="form" action="{{ route('topping.p_updategroup',['id' => $topping->id]) }}" method="POST">
                                                                @csrf
                                                                <div class="form-group">
                                                                    <label>Tên topping</label>
                                                                    <input type="text" class="form-control"
                                                                        value="{{ $topping->name }}" disabled>
                                                                </div>
                                                                <div class="form-group">
                                                                        <label>Nhóm thực đơn cũ</label>
                                                                        <input type="text" class="form-control"
                                                                            value="{{ $topping->groupMenu->name }}" disabled>
                                                                    </div>
                                                                <div class="form-group">
                                                                    <label>Nhóm cần sửa <span style="color: #ff0000">
                                                                            *</span></label>
                                                                    <select class="form-control" name="idGroupMenu">
                                                                        @foreach ($groupMenus as $groupmenu)
                                                                            <option value="{{ $groupmenu->id }}">{{ $groupmenu->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <button type="submit"
                                                                    class="btn btn-default">Lưu</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{ $topping->groupMenu->name }}
                                        </td>
                                        <td>
                                            <a href="{{ route('topping.delete',['id' => $topping->id]) }}"
                                                class="btn default btn-xs red radius"
                                                onclick="return confirm('Bạn muốn xóa dữ liệu này?')">
                                                <i class="fa fa-trash-o"> Xóa</i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <footer class="panel-footer">
                        <div class="row">
                            <div class="col-sm-5 text-center">
                            </div>
                            <div class="col-sm-7 text-right text-center-xs">
                                <ul class="pagination pagination-sm m-t-none m-b-none">
                                    {{ $toppings->links() }}
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
                    <form class="panel-body create-food" enctype="multipart/form-data" role="form" id="createNews-form"
                        action="{{ route('topping.p_store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label class="control-label">Tên Topping<span style="color: #ff0000;"> *</span></label>
                            <input type="text" size="40" class="form-control" name="nameTopping" maxlength="100" required>
                            <span class="error-message">{{ $errors->first('nameTopping') }}</span></p>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Giá</label>
                            <input type="number" size="40" class="form-control number" name="priceTopping" required>

                        </div>
                        <div class="form-group">
                            <label class="control-label">Chọn tên nhóm thực đơn<span style="color: #ff0000;">
                                    *</span></label>
                            <select class="form-control radius" name="idGroupMenu" style="margin-top: 15px">
                                @foreach($groupMenus as $groupMenu)
                                    <option value="{{ $groupMenu->id }}">{{ $groupMenu->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <input type="submit" class="btn btn-compose" value="Tạo mới" style="background: darkcyan;">
                    </form>
                </div>
            </section>
        </div>
    </div>

    <!-- page end-->
</div>
@endsection
