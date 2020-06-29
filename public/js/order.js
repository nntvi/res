$(document).ready(function () {
    function loadOrder(idBill, status, nameTableOrder, idTable) {
        let table = document.getElementById('bodyTableOrder');
        $.ajax({
            url: 'ajax/order/table/' + idBill + '/' + idTable,
            method: 'GET',
            dataType: 'JSON',
            success: function (data) {
                $('#tableOrder').empty();
                let ordered = `<form id="orderedForm">
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading nameTableOrder" style="background: #ff00003b!important">`;
                                                            data.tableOrder.map(function (table) {
                                                                ordered += ` ` + table.table.name;
                                                            })
                                            ordered += `</div>
                                                        <input type="hidden" name="idTableOrder" value="` + idTable + `">
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
                                                                <tbody id="bodyTableOrder">`;
                $('#bodyTableOrdered').empty();
                data.dishes.map(function (dish) {
                    ordered += `<tr>
                                                        <td>` + dish.dish.name + `</td>
                                                        <td class="text-center">` + dish.qty + `</td>
                                                        <td>`;
                    if (dish.note == null) {
                        ordered += `-`;
                    } else {
                        ordered += dish.note;
                    }
                    ordered += `</td>
                                                        <td>` + dish.price + `</td>
                                                        <td class="text-right">`;
                    if (dish.status == '-3') {
                        ordered += `Kho hết NVL`;
                    } else if (dish.status == '-2') {
                        ordered += `Đã hủy`;
                    } else if (dish.status == '-1') {
                        ordered += `Bếp hết NVL`;
                    } else if (dish.status == '0') { // chưa thực hiện
                        ordered += `<a href="order/deletedish/` + dish.id + `" onclick="return confirm ('Bạn muốn hủy món này?')"><i class="fa fa-trash text-danger" aria-hidden="true"></i></a>`;
                    } else if (dish.status == '1') {
                        ordered += `<i class="fa fa-battery-half text-info" aria-hidden="true"></i>`;
                    } else if (dish.status == '2') {
                        ordered += `<i class="fa fa-battery-full text-success" aria-hidden="true"></i>`;
                    }
                    ordered += `</td>
                                                    </tr>`
                    $('#bodyTableOrder').append(ordered);
                });
                ordered += `</tbody>
                                                            </table>
                                                        </div>
                                                        <div class="activities">
                                                            <div class="row">
                                                                <div class="col-xs-6" style="padding-right: 0px">
                                                                    <button  class="btn btn-success" style="width:100%; height: 40px;">Lưu</button>
                                                                </div>
                                    </form>
                                                                <div class="col-xs-6" style="padding: 0px 0px">
                                                                    <a href="pay/index/` + idBill + `" class="btn btn-danger" style="width:100%; height: 40px;">Thanh toán</a>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-xs-6" style="padding-right: 0px">
                                                                    <a href="#myModal`+ idBill +`" data-toggle="modal" class="btn btn-warning matchTable" id="`+ idBill +`" style="width:100%; height: 40px;">Ghép bàn</a>
                                                                    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal`+ idBill +`" class="modal fade" style="display: none;">
                                                                        <div class="modal-dialog">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                                                                    <h4 class="modal-title">Chọn bàn ghép với: <strong>`+ nameTableOrder +` </strong>-<b>`+ data.nameArea +`</b></h4>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <form id="matchTableForm">
                                                                                        <div class="form-group">
                                                                                            <label>Những bàn hiện còn trống của `+ data.nameArea +`</label>
                                                                                        </div>
                                                                                        <div class="row">`
                                                                                        data.tableNotActives.map(function (table) {
                                                                                            ordered += `<div class="col-xs-3">
                                                                                                            <div class="custom-control custom-checkbox">
                                                                                                                <input type="checkbox" value="`+ table.id +`" name="idTableMatch[]">
                                                                                                                <label style="font-weight: normal">`+ table.name +`</label>
                                                                                                            </div>
                                                                                                        </div>`
                                                                                        })
                                                                            ordered +=  `</div>
                                                                                        <div class="space"></div>
                                                                                        <div class="space"></div>
                                                                                        <div class="form-group row">
                                                                                            <div class="col-xs-12 text-center">
                                                                                                <button id="btnMatchTable" class="btn btn-default">Ghép bàn</button>
                                                                                            </div>
                                                                                        </div>
                                                                                    </form>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xs-6" style="padding: 0px 0px">
                                                                    <a href="#delete`+ idBill +`" data-toggle="modal" class="btn btn-default" style="width:100%; height: 40px;">Hủy order/bàn</a>
                                                                    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="delete`+ idBill +`" class="modal fade" style="display: none;">
                                                                        <div class="modal-dialog">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                                                                    <h4 class="modal-title">Hủy order hoặc bàn đã ghép</b></h4>
                                                                                </div>
                                                                                <div class="modal-body">`
                                                                                    if (data.tableOrder.length == 1) {
                                                                                        ordered += `<div class="form-group">
                                                                                                        <label>Mã order: <b>`+ data.code +`</b> -------- Khu vực: <b>`+ data.nameArea +`</b> -------- <b>`+ nameTableOrder +`</b></label>
                                                                                                    </div>
                                                                                                    <i>Order chỉ có một bàn, không có bàn ghép. Bạn có chắc muốn hủy order?</i>
                                                                                                    <div class="space"></div>
                                                                                                    <div class="form-group row">
                                                                                                        <div class="col-xs-12 text-center">
                                                                                                            <a href="order/delete/`+ idBill +`" class="btn btn-default">Hủy bàn</a>
                                                                                                        </div>
                                                                                                    </div>`
                                                                                    } else {
                                                                                        ordered += `<form id="destroyTableForm">
                                                                                                        <div class="form-group">
                                                                                                            <label>Mã order: <b>`+ data.code +`</b> ---------- Khu vực: <b>`+ data.nameArea +`</b></label>
                                                                                                        </div>
                                                                                                        <div class="form-group">
                                                                                                            <label>Các bàn thuộc order</label>
                                                                                                        </div>
                                                                                                        <div class="bs-docs-example">
                                                                                                            <table class="table table-striped">
                                                                                                                <thead>
                                                                                                                    <tr>
                                                                                                                        <th></th>
                                                                                                                        <th class="text-center">Tên Bàn</th>
                                                                                                                        <th class="text-right">Thời gian tạo</th>
                                                                                                                    </tr>
                                                                                                                </thead>
                                                                                                                <tbody>`;
                                                                                                                data.tableOrder.map(function (table) {
                                                                                                                    ordered += `<tr>
                                                                                                                                    <td><input type="checkbox" name="idTableDestroy[]" value="`+ table.id_table +`"></td>
                                                                                                                                    <td class="text-center">`+ table.table.name +`</td>
                                                                                                                                    <td class="text-right">`+ table.created_at +`</td>
                                                                                                                                </tr>`
                                                                                                                })
                                                                                                    ordered +=  `</tbody>
                                                                                                            </table>
                                                                                                        </div>
                                                                                                        <div class="space"></div>
                                                                                                        <div class="form-group row">
                                                                                                            <div class="col-xs-12 text-center">
                                                                                                                <button class="btn btn-default" id="destroyTable">Hủy bàn bàn</button>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </form>`
                                                                                    }

                                                                    ordered += `</div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                `;
                $('#tableOrder').append(ordered);
                $('#destroyTableForm').on('submit', function (e) {
                    e.preventDefault();
                    let token = $('meta[name="csrf-token"]').attr('content');
                    let idDestroyTables = $("input[name='idTableDestroy[]']:checked").map(function () {
                        return $(this).val();
                    }).get();
                    if (idDestroyTables.length == 0) {
                        alert('Chưa chọn bàn để hủy');
                    } else {
                        $.ajax({
                            url: 'ajax/order/destroy/' + idBill,
                            type: "POST",
                            data: {
                                _token: token,
                                idDestroyTables: idDestroyTables,
                                lengthDestroyTables : idDestroyTables.length,
                            },
                            success: function (data) {
                                if(data == 1){
                                    toastr.success('Hủy order thành công');
                                    location.reload();
                                }else{
                                    $('#delete'+idBill).remove;
                                    $("body").removeClass('modal-open');
                                    $('div').removeClass('modal-backdrop');
                                    toastr.success('Hủy bàn thành công');
                                    loadOrder(idBill,status,nameTableOrder,idTable);
                                    setTimeout(function(){
                                        location.reload();
                                    }, 2000);

                                }
                            },
                        });
                    }
                });
                $('#matchTableForm').on('submit', function (e) {
                    e.preventDefault();
                    let token = $('meta[name="csrf-token"]').attr('content');
                    let idMatchTables = $("input[name='idTableMatch[]']:checked").map(function () {
                        return $(this).val();
                    }).get();
                    const lengthMatchTable = idMatchTables.length;
                    if (lengthMatchTable == 0) {
                        alert('Vui lòng chọn ít nhất 1 bàn để ghép');
                    } else {
                        $.ajax({
                            url: 'ajax/order/match/' + idBill,
                            type: "POST",
                            data: {
                                _token: token,
                                idMatchTables: idMatchTables,
                                lengthMatchTable : lengthMatchTable,
                            },
                            success: function (data) {
                                $('#modal'+idBill).remove;
                                $("body").removeClass('modal-open');
                                $('div').removeClass('modal-backdrop');
                                toastr.success('Ghép bàn thành công');
                                loadOrder(idBill,status,nameTableOrder,idTable);
                                setTimeout(function(){
                                    location.reload();
                                }, 2000);
                            },
                        });
                    }
                });
                $('#orderedForm').on('submit', function (e) {
                    e.preventDefault();
                    let token = $('meta[name="csrf-token"]').attr('content');
                    let arrDishes = $("input[name='idDish[]']").map(function () {
                        return $(this).val();
                    }).get();
                    let arrQties = $("input[name='qty[]']").map(function () {
                        return $(this).val();
                    }).get();
                    let arrNotes = $("input[name='note[]']").map(function () {
                        return $(this).val();
                    }).get();
                    if (arrDishes == null || arrDishes == "") {
                        alert('Vui lòng chọn thêm món cho bàn');
                        return false;
                    } else {
                        $.ajax({
                            url: 'ajax/order/update/' + idBill,
                            type: "POST",
                            data: {
                                _token: token,
                                idTableOrder: idTable,
                                idDish: arrDishes,
                                qty: arrQties,
                                note: arrNotes,
                            },
                            success: function () {
                                loadOrder(idBill,status,nameTableOrder,idTable);
                                toastr.success('Thêm món cho ' + nameTableOrder + ' thành công')
                            },
                        });
                    }
                });
            }
        });

    }

    $(".card").click(function () { // chọn bàn
        const idTable = $(this).attr('data-id');
        const nameTableOrder = $(this).find('h6.card-title').text();
        let statusTable = $(this).attr('data-status'); // lấy status có khách or not
        if (statusTable == "0") { // ko có khách
            $('#tableOrder').empty();
            let order = `<form id="orderForm">
                            <div class="panel panel-default">
                                <div class="panel-heading nameTableOrder" style="background: #ff00003b!important">
                                    ` + nameTableOrder + `
                                </div>
                                <input type="hidden" name="idTableOrder" value="` + idTable + `">
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
                                        <tbody id="bodyTableOrder">
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row activities">
                                    <div class="col-xs-12">
                                        <button id="submitNewOrder" class="btn btn-success" style="width:100%">Lưu</button>
                                    </div>

                                </div>
                            </div>
                        </form>`;
            $('#tableOrder').append(order);
            $('#orderForm').on('submit', function (e) {
                e.preventDefault();
                let token = $('meta[name="csrf-token"]').attr('content');
                let arrDishes = $("input[name='idDish[]']").map(function () {
                    return $(this).val();
                }).get();
                let arrQties = $("input[name='qty[]']").map(function () {
                    return $(this).val();
                }).get();
                let arrNotes = $("input[name='note[]']").map(function () {
                    return $(this).val();
                }).get();
                let table = document.getElementById('bodyTableOrder');
                if (table.rows.length == 0) {
                    alert('Vui lòng chọn món cho bàn');
                    return false;
                } else {
                    $.ajax({
                        url: "ajax/order/store",
                        type: "POST",
                        data: {
                            _token: token,
                            idTableOrder: idTable,
                            idDish: arrDishes,
                            qty: arrQties,
                            note: arrNotes,
                        },
                        success: function (data) {
                            const idBill = data.idOrderTable;
                            const status = data.status;
                            if (status == '1') {
                                loadOrder(idBill, status, nameTableOrder, idTable);
                            }
                            $('#tbl' + idTable).css('background-color', 'rgba(254, 48, 48, 0.55)');
                            toastr.success('Order ' + nameTableOrder + ' thành công');
                        },
                    });
                }
            });
        } else if (statusTable == "1") {
            const idBill = $(this).find('input[name="idBill"]').val();
            loadOrder(idBill, statusTable, nameTableOrder, idTable);
        }
    });
});
