$(document).ready(function () {
    $('.pagination').addClass('pagination-sm');
    // ajax get material by id_supplierto import
    $("#idSupplier").click(function () {
        var idSupplier = $(this).val();
        //console.log(id);
        $.ajax({
            url: 'ajax/getMaterial/bySupplier/' + idSupplier,
            method: 'GET',
            dataType: 'JSON',
            success: function (data) {
                //console.log(data);
                data.materials.map(function (material) {
                    // console.log(material);
                    $('.list').empty();
                    //console.log(material.type_material.material_detail);
                    material.type_material.warehouse.forEach(function (detail) {
                        //console.log(detail.name);
                        var row = '<tr id="row' + detail.id + '">' +
                            '<td>' +
                            '<input name="id[]" value="' + detail.id + '" hidden>' +
                            '<input name="idMaterial[]" value="' + detail.id_material_detail + '" hidden>' +
                            detail.detail_material.name +
                            '</td>' +
                            '<td><input  type="number" class="form-control" value="' + detail.qty + '" disabled></td>' +
                            '<td><input  type="number" step="0.01" class="qty form-control" name="qty[]"></td>' +
                            '<td>';
                        if (detail.id_unit == 0) {
                            row += '<select class="device form-control" name="id_unit[]">';
                            data.units.forEach(function (unit) {
                                row += '<option value="' + unit.id + '">' + unit.name + '</option>';
                            });
                            row += '</select>';
                        } else {
                            row += '<input value="' + detail.unit.id + '" name="id_unit[]" hidden></input>' +
                                '<input class="form-control" value="' + detail.unit.name + '" disabled></input>';
                        }
                        row += '</td>' +
                            '<td><input type="number" class="price form-control" name="price[]" value=""></td>' +
                            '<td>' +
                            '<span class="input-group-btn" onclick="clickToRemove(' + detail.id + ')">' +
                            '<button class="btn btn-danger" type="button">' +
                            '<i class="fa fa-times" aria-hidden="true"></i>' +
                            '</button>' +
                            '</span>' +
                            '</td>' +
                            '</tr>';
                        $('.list').append(row);
                    })
                });
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            }
        });
    });

    // export by ObjectCook
    $("#objectCook").click(function () {
        const objectCook = $(this).val();
        $.ajax({
            url: 'ajax/getMaterial/export/cook/' + objectCook, //Trang xử lý
            method: 'GET',
            dataType: 'JSON',
            success: function (data) {
                $('#warehouseCook').empty();
                $('#warehouse').empty();
                $('#submit').empty();
                let tableWarehouseCook = '<h4 class="hdg">NVL của bếp vừa chọn</h4>' +
                    '<table class="table table-bordered">' +
                    '<thead>' +
                    '<tr>' +
                    '<th>Tên NVL</th>' +
                    '<th>Sl tồn</th>' +
                    '<th>Đơn vị</th>' +
                    '</tr>' +
                    '</thead>' +
                    '<tbody>';
                data.materialWarehouseCook.map(function (c) {
                    tableWarehouseCook += '<tr>' +
                        '<td>' + c.detail_material.name + '</td>' +
                        '<td><span class="badge">' + c.qty + '</span></td>' +
                        '<td>';
                    if (c.unit == null) {
                        tableWarehouseCook += 'Rỗng';
                    } else {
                        tableWarehouseCook += c.unit.name;
                    }
                    tableWarehouseCook += '</td>' +
                        '</tr>';
                });
                '</tbody>' +
                '</table>'
                let tableWarehouse = '<h4 class="hdg">Danh sách NVL của bếp trong kho chính</h4>' +
                    '<table class="table table-bordered">' +
                    '<thead>' +
                    '<tr>' +
                    '<th width=25%>Tên mặt hàng</th>' +
                    '<th width=15%>Sl trong kho</th>' +
                    '<th width=22%>Sl cần xuất</th>' +
                    '<th width=17%>Đơn vị tính</th>' +
                    '<th width=2%></th>' +
                    '</tr>' +
                    '</thead>' +
                    '<tbody id="bodyWarehouseExportCook">';
                data.materialWarehouse.map(function (detail) {
                    tableWarehouse +=
                        '<tr id="row' + detail.id + '">' +
                        '<td>' +
                        '<input name="id[]" value="' + detail.id + '" hidden>' +
                        '<input name="idMaterial[]" value="' + detail.detail_material.id + '" hidden>' +
                        detail.detail_material.name +
                        '</td>' +
                        '<td><input type="number" name="oldQty[]" class="oldQty form-control" value="' + detail.qty + '" disabled></td>';

                    if (detail.id_unit == 0) {
                        tableWarehouse += '<td><input type="number" step="0.01" class="qty form-control" value="" name="qty[]" disabled></td>' +
                            '<td>' +
                            'Hết hàng';
                    } else {
                        tableWarehouse += '<td><input type="number" step="0.01" class="qty form-control" value="" name="qty[]" required></td>' +
                            '<td>' +
                            '<input value="' + detail.unit.id + '" name="id_unit[]" hidden></input>' +
                            '<input class="form-control" value="' + detail.unit.name + '" disabled></input>';
                    }
                    tableWarehouse += '</td>' +
                        '<td>' +
                        '<span class="input-group-btn" onclick="clickToRemove(' + detail.id + ')">' +
                        '<button class="btn btn-danger" type="button">' +
                        '<i class="fa fa-times" aria-hidden="true"></i>' +
                        '</button>' +
                        '</span>' +
                        '</td>' +
                        '</tr>';
                })
                '</tbody>' +
                '</table>'
                $('#warehouseCook').append(tableWarehouseCook);
                $('#warehouse').append(tableWarehouse);
                $('#submit').append('<button type="submit" class="btn green-meadow radius">Tạo phiếu</button>');
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            }
        });
    });

    // export by ObjectSupplier
    $("#objectSupplier").change(function () {
        const objectSupplier = $(this).val();
        $.ajax({
            url: 'ajax/getMaterial/export/supplier/' + objectSupplier, //Trang xử lý
            method: 'GET',
            dataType: 'JSON',
            success: function (importCoupons) {
                $('#importCoupons').empty();
                importCoupons.map(function (x) {
                    let option = `<option value="` + x.code + `">Mã phiếu: ` + x.code + ` - Ngày nhập: ` + x.created_at + `</option>`;
                    $('#importCoupons').append(option);
                })
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            }
        });
    });

    // get materials by ImportCoupon to Export
    $("#importCoupons").change(function () {
        const codeCoupon = $(this).val();
        $.ajax({
            url: 'ajax/material/' + codeCoupon, //Trang xử lý
            method: 'GET',
            dataType: 'JSON',
            success: function (materials) {
                $('#tableMaterialExportSupplier').empty();
                $('#submit').empty();
                let tableMaterialExportSupplier = '<h4 class="hdg">Danh sách NVL thuộc Phiếu nhập vừa chọn</h4>' +
                    '<table class="table table-bordered">' +
                    '<thead>' +
                    '<tr>' +
                    '<th>Tên mặt hàng</th>' +
                    '<th>Sl nhập</th>' +
                    '<th>Sl xuất trả</th>' +
                    '<th>Đơn vị tính</th>' +
                    '<th>Giá</th>' +
                    '<th></th>' +
                    '</tr>' +
                    '</thead>' +
                    '<tbody id="bodyExportSupplier">';
                materials.map(function (detail) {
                    tableMaterialExportSupplier += '<tr id="row' + detail.id + '">' +
                        '<td><input name="idMaterial[]" value="' + detail.material_detail.id + '" hidden>' + detail.material_detail.name + '</td>' +
                        '<td><input type="hidden" name="oldQty[]" class="oldQty form-control" value="' + detail.qty + '">' + detail.qty + '</td>' +
                        '<td><input type="number" step="0.01" min="0.01" class="qty form-control" name="qty[]" required></td>' +
                        '<td><input name="id_unit[]" value="' + detail.unit.id + '" hidden>' + detail.unit.name + '</td>' +
                        '<td><input name="price[]" value="' + detail.price + '" hidden>' + detail.price + '</td>' +
                        '<td>' +
                        '<span class="input-group-btn" onclick="clickToRemove(' + detail.id + ')">' +
                        '<button class="btn btn-danger" type="button">' +
                        '<i class="fa fa-times" aria-hidden="true"></i>' +
                        '</button>' +
                        '</span>' +
                        '</td>' +
                        '</tr>';
                });
                '</tbody>' +
                '</table>';
                $('#tableMaterialExportSupplier').append(tableMaterialExportSupplier);
                $('#submit').append('<button type="submit" class="btn green-meadow radius">Tạo phiếu</button>');
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            }
        });
    });

    // get time to report
    $("#timeReport").click(function () {
        var idTypeDateTime = $(this).val();
        $.ajax({
            url: 'ajax/report/getDateTime/' + idTypeDateTime, //Trang xử lý
            method: 'GET',
            dataType: 'JSON',
            success: function (data) {
                $('#dateStart').val(data.dateStart);
                $('#dateEnd').val(data.dateEnd);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            }
        });
    });

    // search Material to Destroy In Warehouse
    $("#searchMaterial").click(function () {
        const name = document.getElementById('nameMaterial').value;
        $.ajax({
            url: 'ajax/getMaterial/destroy/warehouse/' + name, //Trang xử lý
            method: 'GET',
            dataType: 'JSON',
            success: function (data) {
                if (data.length == 0) {
                    alert("Không có sp này");
                } else {
                    data.map(function (detail) {
                        let row = '<tr id="row' + detail.id + '">' +
                            '<td><input name="idMaterial[]" value="' + detail.detail_material.id + '" hidden>' + detail.detail_material.name + '</td>' +
                            '<td><input type="number" name="oldQty[]" class="oldQty form-control" value="' + detail.qty + '" disabled></td>' +
                            '<td><input type="number" step="0.01" min="0.01" class="qty form-control" name="qty[]"></td>' +
                            '<td><input value="' + detail.unit.id + '" name="id_unit[]" hidden></input>' + detail.unit.name + '</td>' +
                            '<td>' +
                            '<span class="input-group-btn" onclick="clickToRemove(' + detail.id + ')">' +
                            '<button class="btn btn-danger" type="button">' +
                            '<i class="fa fa-times" aria-hidden="true"></i>' +
                            '</button>' +
                            '</span>' +
                            '</td>' +
                            '</tr>';
                        $('.list').append(row);
                    })
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            }
        });
    });

    // search Material to Destroy in Cook
    $("#searchDestroyCook").click(function () {
        const idCook = document.getElementById('idCookDestroy').value;
        const nameMaterial = document.getElementById('nameMaterial').value;
        if (nameMaterial == null || nameMaterial == "") {
            alert("Chưa nhập tên NVL");
        } else {
            $.ajax({
                url: 'ajax/getMaterial/destroy/cook/' + idCook + '/' + nameMaterial, //Trang xử lý
                method: 'GET',
                dataType: 'JSON',
                success: function (data) {
                    if (data.length == 0) {
                        alert("Không có sp vừa nhập trong bếp này");
                    }
                    if (data.length == null) {
                        alert("Không có sp vừa nhập trong bếp này");
                    } else {
                        data.map(function (detail) {
                            let row = '<tr id="row' + detail.id + '">' +
                                '<td><input name="idMaterial[]" value="' + detail.detail_material.id + '" hidden>' + detail.detail_material.name + '</td>' +
                                '<td><input type="number" name="oldQty[]" class="oldQty form-control" value="' + detail.qty + '" disabled></td>' +
                                '<td><input type="number" step="0.01" min="0.01" class="qty form-control" name="qty[]"></td>' +
                                '<td>';
                            if (detail.unit == null) {
                                row += '<input value="0" name="id_unit[]" hidden></input> Rỗng';
                            } else {
                                row += '<input value="' + detail.unit.id + '" name="id_unit[]" hidden></input> ' + detail.unit.name + '';
                            }
                            row += '</td>' +
                                '<td>' +
                                '<span class="input-group-btn" onclick="clickToRemove(' + detail.id + ')">' +
                                '<button class="btn btn-danger" type="button">' +
                                '<i class="fa fa-times" aria-hidden="true"></i>' +
                                '</button>' +
                                '</span>' +
                                '</td>' +
                                '</tr>';
                            $('.list').append(row);
                        })
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                }
            });
        }
    });

    // get capital Price
    $("#idMaterial").click(function () {
        const idMaterial = $(this).val();
        $.ajax({
            url: 'ajax/getCapitalPrice/' + idMaterial, //Trang xử lý
            method: 'GET',
            dataType: 'JSON',
            success: function (data) {
                $('input#capitalPriceHidden').empty();
                $("#capitalPrice").empty();
                $("#salePrice").empty();
                $('input#capitalPriceHidden').val(data.capitalPrice);
                $('input#capitalPrice').val(data.capitalPrice);
                $('input#salePrice').val(data.salePrice);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            }
        });
    });

    // capitalPrice
    $("#clickUpdatePrice").click(function () {
        const idMaterial = document.getElementById('idMaterialUpdatePrice').value;
        $.ajax({
            url: 'ajax/getCapitalPrice/' + idMaterial, //Trang xử lý
            method: 'GET',
            dataType: 'JSON',
            success: function (data) {
                $('#newCapitalPriceHidden').empty();
                $("#newCapitalUpdate").empty();
                $("#newSalePriceUpdate").empty();
                $('input#newCapitalPriceHidden').val(data.capitalPrice);
                $('input#newCapitalUpdate').val(data.capitalPrice);
                $('input#newSalePriceUpdate').val(data.salePrice);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            }
        });
    });

    // overView
    $("#btnOverview").click(function () {
        let dateStart = document.getElementById('dateStart').value;
        let dateEnd = document.getElementById('dateEnd').value;
        $.ajax({
            url: 'ajax/report/overview/' + dateStart + '/' + dateEnd,
            method: 'GET',
            dataType: 'JSON',
            success: function (data) {
                data.map(function (item) {
                    $("span#revenue").text(item.total + ' đ');
                    $("span#bill").text(item.bill);
                    $("span.servingBill").text(item.serving);
                    $("span.paidBill").text(item.paid);
                });
            }
        });
    });

    $("#supplierPayment").click(function () {
        let idSupplier = $(this).val();
        $.ajax({
            url: 'ajax/getImportCoupon/' + idSupplier,
            method: 'GET',
            dataType: 'JSON',
            success: function (imports) {
                $("#tablePayment").empty();
                imports.map(function (coupon) {
                    let row = '<tr id="row' + coupon.id + '">' +
                        '<td>' + coupon.created_at + '</td>' +
                        '<td>' + coupon.code + '</td>' +
                        '<td>' + coupon.total + '</td>' +
                        '<td><input type"number" class="form-control" name="payCash[]" required value="' + coupon.total + '"></td>' +
                        '<td>' +
                        '<span class="input-group-btn" onclick="clickToRemove(' + coupon.id + ')">' +
                        '<button class="btn btn-danger" type="button"><i class="fa fa-times" aria-hidden="true"></i></button>' +
                        '</span>'
                    '</td>' +
                    '</tr>';
                    $("#tablePayment").append(row);
                })
            }
        });
    });

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
                        success: function () {
                            alert('Order hoàn tất');
                            location.reload()
                        },
                    });
                }
            });
        } else if (statusTable == "1") {
            const idBill = $(this).find('input[name="idBill"]').val();
            $.ajax({
                url: 'ajax/order/table/' + idBill,
                method: 'GET',
                dataType: 'JSON',
                success: function (dishes) {
                    $('#tableOrder').empty();
                    let ordered = `<form id="orderedForm">
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
                                                <tbody id="bodyTableOrder">`;
                    $('#bodyTableOrdered').empty();
                    dishes.map(function (dish) {
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
                                                                <td>`;
                        if (dish.status == '-1') {
                            ordered += `<i class="fa fa-pause text-danger" aria-hidden="true"></i>`;
                        } else if (dish.status == '0') { // chưa thực hiện
                            ordered += `<i class="fa fa-battery-empty text-warning" aria-hidden="true"></i>`;
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
                                        <div class="row activities">
                                            <div class="col-xs-6">
                                                <button  class="btn btn-success" style="width:100%">Lưu</button>
                                            </div>
                                            <div class="col-xs-6">
                                                <a href="pay/index/` + idBill + `" class="btn btn-danger" style="width:100%">Thanh toán</a>
                                            </div>
                                        </div>
                                    </div>
                                </form>`;
                    $('#tableOrder').append(ordered);
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
                                    alert('Thêm món hoàn tất');
                                    location.reload();
                                },
                            });
                        }
                    });
                }
            });

        }
    });

    $('#paymentVoucherForm').on('submit', function (e) {
        e.preventDefault();
        const dateStart = document.getElementById('dateStart').value;
        const dateEnd = document.getElementById('dateEnd').value;
        const idSupplier = document.getElementById('idSupplier').value;
        const nameSupplier = $("#idSupplier option:selected").text();
        if ((dateStart == null || dateStart == "") || (dateEnd == null || dateEnd == "")) {
            alert('Vui lòng không để trống ngày tìm kiếm');
            return false;
        } else {
            $.ajax({
                url: "ajax/getImportCoupon/" + dateStart + "/" + dateEnd + "/" + idSupplier,
                method: 'GET',
                dataType: 'JSON',
                success: function (data) {
                    $('#leftTable').empty();
                    $('#formPaymentVoucherSupplier').empty();
                    let tableImportCoupons =
                    `<table class="table table-bordered" id="infoImportCoupons">
                        <h3 class="typoh2">Phiếu nhập trong thời gian và NCC vừa chọn</h3>
                        <thead>
                            <tr>
                                <th>Mã phiếu nhập</th>
                                <th>Ngày nhập</th>
                                <th>Tổng tiền</th>
                                <th>Đã trả</th>
                                <th>Phải trả</th>
                                <th>Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody`;
                            data.coupons.map(function (coupon) {
                                tableImportCoupons +=
                                `<tr>
                                    <td>`+ coupon.code+`</td>
                                    <td>`+ coupon.created_at +`</td>
                                    <td><span class="badge badge-success">`+ coupon.total +`</span></td>
                                    <td><span class="badge badge-primary">`+ coupon.paid +`</span></td>
                                    <td><span class="badge">`+ ((coupon.total) - (coupon.paid)) +`</span></td>`;
                                    switch (coupon.status) {
                                        case '0':
                                            tableImportCoupons += `<td style="color:red">Chưa thanh toán</td>`;
                                            break;
                                        case '1':
                                            tableImportCoupons += `<td style="color:darkblue">Chưa hoàn tất</td>`;
                                            break;
                                        case '2':
                                            tableImportCoupons += `<td style="color:darkgreen">Hoàn tất</td>`;
                                            break;
                                        default:
                                            break;
                                    }
                                tableImportCoupons += `</tr>`;
                            });
                            tableImportCoupons +=
                            `<tr class="bold">
                                <td colspan="2" class="text-right">TỔNG: </td>
                                <td>`+ data.conclusion.sumTotal +`</td>
                                <td>`+ data.conclusion.paid +`</td>
                                <td>`+ data.conclusion.unPaid +`</td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>`;
                    $('#leftTable').append(tableImportCoupons);
                    let formSubmit =
                    `<h3 class="typoh2 text-right">Tạo phiếu chi</h3>
                        <div class="list-group list-group-alternate">
                            <div class="form-group">
                                <label class="col-xs-12 col-sm-4 control-label">Mã phiếu chi</label>
                                <div class="col-xs-12 col-sm-8">
                                    <input type="text" class="form-control" name="code" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12 col-sm-4 control-label">Nhà cung cấp</label>
                                <div class="col-xs-12 col-sm-8">
                                    <input type="hidden" name="idSupplierChoosen" value="`+ idSupplier +`">
                                    <input type="hidden" name="dateStart" value="`+ dateStart +`">
                                    <input type="hidden" name="dateEnd" value="`+ dateEnd +`">
                                    <input type="hidden" value="`+ data.conclusion.unPaid +`" id="unPaid">
                                    <input class="form-control" disabled value="`+ nameSupplier +`">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12 col-sm-4 control-label">Số tiền trả: </label>
                                <div class="col-xs-12 col-sm-8">
                                    <input class="form-control" type="number" name="pay_cash" id="payCash" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12 col-sm-4 control-label">Ghi chú: </label>
                                <div class="col-xs-12 col-sm-8">
                                    <textarea class="form-control" name="note"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12 text-right">
                                    <button type="submit" class="btn btn-success">Tạo phiếu</button>
                                </div>
                            </div>
                        </div> `;
                    $('#formPaymentVoucherSupplier').append(formSubmit);
                }
            });
        }
    });

    $('#btnSearchPaymentVc').click(function () {
        const codePaymentVc = document.getElementById('codeSearchPaymentVc').value;
        $.ajax({
            url: 'ajax/search/paymentvoucher/' + codePaymentVc,
            method: 'GET',
            dataType: 'JSON',
            success: function (results) {
                if(results.length == 0){
                    $('#bodyPaymentVc').empty();
                    let a = `<tr><td colspan="8" class="text-center">Không tìm thấy kết quả</<td><tr>`;
                    $('#bodyPaymentVc').append(a);
                }else{
                    $('#bodyPaymentVc').empty();
                    results.map(function (result) {
                        let count = 0;
                        let row =
                        `<tr>
                            <td>`+ (count+1) +`</td>
                            <td>`+ result.code +`</td>`;
                            if (result.type == '1') {
                                row += `<td>Chi nợ NCC</<td>`;
                            } else {
                                row += `<td>Khác</td>`;
                            }
                        row +=
                            `<td>`+ result.name +`</td>
                            <td>`+ result.pay_cash + `</td>`;
                            if (result.note == null) {
                                row += `<td></td>`;
                            } else {
                                row += `<td>` + result.note + `</td>`;
                            }
                            row +=
                            `<td>` + result.created_by + `</td>
                            <td class="text-right">` + result.created_at + `</td>
                        </tr>`;
                        $('#bodyPaymentVc').append(row);
                    });
                }
            }
        });
    })
});
