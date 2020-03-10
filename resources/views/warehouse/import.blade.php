@extends('layouts')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                       Nhập Kho
            </header>
            <div class="pannel-body">
                <div class="position-center">
                    <div class="form">
                        <form class="panel-body" role="form" action="{{route('warehouse.p_import')}}" method="POST">
                            @csrf
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="control-label">Mã phiếu nhập<span style="color: #ff0000"> *</span></label>
                                        <div class="space"></div>
                                        <input type="text" size="40" class="form-control" name="code" maxlength="200">
                                        <span class="error-message">{{ $errors->first('name') }}</span></p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="control-label">Nhà cung cấp<span style="color: #ff0000"> *</span></label>
                                        <div class="space"></div>
                                        <select class="form-control m-bot15" name="supplier">
                                            @foreach ($suppliers as $supplier)
                                                <option value="{{$supplier->id}}">{{$supplier->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <label class="control-label">Ghi chú</label>
                                        <div class="space"></div>
                                        <textarea type="text" size="40" class="form-control" rows="3"
                                            name="note">
                                        </textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="space"></div>
                                <div class="row">
                                    <div class="col-xs-6">
                                            <label class="control-label">Những mặt hàng cần nhập<span style="color: #ff0000"> *</span></label>
                                    </div>
                                    <div class="col-xs-6 text-right">
                                            <button class="btn btn-info" id="addMaterial" type="button">Add</button>
                                    </div>
                                </div>


                                <div class="space"></div>
                                <div id="material">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th width=35%>Tên mặt hàng</th>
                                                <th width=15%>Số lượng</th>
                                                <th width=20%>Đơn vị tính</th>
                                                <th width=20%>Giá</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="list">

                                        </tbody>
                                    </table>
                                </div>

                                <script>
                                    var addBtn = $('#addMaterial'),
                                    removeBtns = $('.removeItem');
                                    var options = {
                                        valueNames: [
                                            { data: ['id'] },
                                            'itemId',
                                            { attr: 'value', name: 'nameMaterial' },
                                            { attr: 'value', name: 'qty' },
                                            { attr: 'value', name: 'id_unit'},
                                            { attr: 'value', name: 'price'},
                                        ],
                                        item: `<tr class="id" data-id="">
                                                    <td>
                                                        <select class="device form-control" name="id_material[]">
                                                            @foreach ($material_details as $item)
                                                                <option class="deviceType" value="{{$item->id }}">{{ $item->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td><input type="number" class="qty form-control" value="" name="qty[]"></td>
                                                    <td>
                                                        <select class="device form-control" name="id_unit[]">
                                                            @foreach ($units as $unit)
                                                                <option class="deviceType" value="{{ $unit->id }}">{{$unit->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td><input type="number" class="price form-control" name="price[]" value=""></td>
                                                    <td class="remove">
                                                        <button class="removeItem btn btn-xs btn-danger"><span class="glyphicon glyphicon-remove" style="color:white" aria-hidden="true"></span></button>
                                                    </td>
                                                    </tr>`
                                    };

                                                // Create user list
                                                var materialList = new List('material', options);

                                                // Get size of list (except headers)
                                                var size = materialList.size();

                                                // Sets callbacks to the buttons and other elements in the list
                                                refreshCallbacks();

                                                function refreshCallbacks() {
                                                // Trigger event for new generated row/object
                                                removeBtns = $(removeBtns.selector);
                                                    removeBtns.click(function() {
                                                        var itemId = $(this).closest('tr').data('id');
                                                        materialList.remove('id', itemId);
                                                });

                                                // Re-set device of each select
                                                let deviceOptions = $('.deviceType');
                                                deviceOptions.each(function() {
                                                    let parentSelect = $(this).closest('select').data('value');
                                                    if (parentSelect === this.value) {
                                                    $(this).attr('selected','selected');
                                                    }
                                                });
                                                }

                                                // Add new blank row into tables if click button Add
                                                addBtn.click(function() {
                                                    materialList.add({
                                                    id: ++size,
                                                    itemId: `#${size}`,
                                                    name: "",
                                                    qty: "",
                                                    price: ""
                                                });
                                                refreshCallbacks();
                                                });
                                </script>
                            </div>

                            <div class="row">
                                <div class="col-xs-12 text-center">
                                    <button type="submit" class="btn green-meadow radius">Tạo phiếu</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
