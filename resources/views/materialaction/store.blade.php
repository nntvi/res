@extends('layouts')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Thiết lập công thức món ăn
            </header>
            <div class="pannel-body">
                <div class="position-center">
                    <div class="form">
                        <form class="panel-body" role="form" onsubmit="return validateFormMaterialAction()"
                        action="{{route('material_action.p_store',['id' => $material->id])}}" method="POST">
                            @csrf
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="control-label">Tên nhóm NVL<span style="color: #ff0000"> *</span></label>
                                        <div class="space"></div>
                                        <input type="text" name="id_groupnvl" value="{{$material->id}}" hidden>
                                        <input type="text" size="40" class="form-control" name="" maxlength="200" value="{{$material->name}}" disabled>
                                        <span class="error-message">{{ $errors->first('name') }}</span></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="space"></div>
                                <div class="row">
                                    <div class="col-xs-6">
                                            <label class="control-label">NVL cấu thành sản phẩm<span style="color: #ff0000"> *</span></label>
                                    </div>
                                    <div class="col-xs-6 text-right">
                                        <button class="btn btn-info" id="addMaterialDetail" type="button">Add</button>
                                    </div>
                                </div>
                                <div class="space"></div>
                                <div id="material-detail">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th width=65%>Tên NVL / Đơn vị</th>
                                                <th width=25%>Số lượng</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="list" id="bodyMaterialAction">

                                        </tbody>
                                    </table>
                                </div>

                                <script>
                                    var addBtn = $('#addMaterialDetail'),
                                    removeBtns = $('.removeItem');
                                    var options = {
                                        valueNames: [
                                            { data: ['id'] },
                                            'itemId',
                                            { attr: 'value', name: 'id_material' },
                                            { attr: 'value', name: 'qty' },
                                        ],
                                        item: `<tr class="id" data-id="">
                                                    <td>
                                                        <select class="device form-control" name="id_material[]">
                                                            @foreach ($materialDetails as $item)
                                                                <option class="deviceType" value="{{$item->id }}">{{ $item->name }} / {{ $item->unit->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td><input type="number" step=".01" class="qty form-control" name="qty[]"></td>

                                                    <td class="remove">
                                                        <button class="removeItem btn btn-xs btn-danger"><span class="glyphicon glyphicon-remove" style="color:white" aria-hidden="true"></span></button>
                                                    </td>
                                                </tr>`
                                    };

                                                // Create user list
                                                var materialDetailList = new List('material-detail', options);

                                                // Get size of list (except headers)
                                                var size = materialDetailList.size();

                                                // Sets callbacks to the buttons and other elements in the list
                                                refreshCallbacks();

                                                function refreshCallbacks() {
                                                    // Trigger event for new generated row/object
                                                    removeBtns = $(removeBtns.selector);
                                                        removeBtns.click(function() {
                                                            var itemId = $(this).closest('tr').data('id');
                                                            materialDetailList.remove('id', itemId);
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
                                                    materialDetailList.add({
                                                    id: ++size,
                                                    itemId: `#${size}`,
                                                    name: "",
                                                    qty: "",
                                                });
                                                refreshCallbacks();
                                            });

                                </script>
                            </div>

                            <div class="row">
                                <div class="col-xs-12 text-center">
                                    <button type="submit" class="btn green-meadow radius">Lưu</button>
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
