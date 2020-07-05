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
                console.log(data);
                    $('.list').empty();
                    data.type_material.warehouse.forEach(function (detail) {
                        if (detail.detail_material.status != 0) {
                            var row = `<tr id="row` + detail.id + `">
                                        <td><input name="id[]" value=" ` + detail.id + `" hidden>
                                            <input name="idMaterial[]" value="` + detail.id_material_detail + `" hidden>
                                                `+ detail.detail_material.name + `
                                        </td>
                                        <td>` + detail.qty + `</td>
                                        <td><input  type="number" step="0.01" class="qty form-control" name="qty[]" ></td>
                                        <td><input value="` + detail.detail_material.unit.id + `" name="id_unit[]" hidden></input>
                                            ` +detail.detail_material.unit.name + `
                                        </td>
                                        <td><input type="number" class="price form-control" name="price[]" value=""></td>
                                        <td>
                                            <span class="input-group-btn" onclick="clickToRemove(` + detail.id + `)">
                                                <button class="btn btn-sm btn-danger" type="button"><i class="fa fa-times" aria-hidden="true"></i></button>' +
                                            </span>
                                        </td>
                                    </tr>`;
                        $('.list').append(row);
                        }
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
                let tableWarehouseCook = `<h4 class="hdg">NVL của bếp vừa chọn</h4>
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                    <th>Tên NVL</th>
                                                    <th>Sl tồn</th>
                                                    <th>Đơn vị</th>
                                                    </tr>
                                                </thead>
                                                <tbody>`;
                data.materialWarehouseCook.map(function (c) {
                    if (c.detail_material.status == '1') {
                        tableWarehouseCook += `<tr>
                                                <td>` + c.detail_material.name + `</td>
                                                <td><span class="badge">` + c.qty + `</span></td>
                                                <td>`+ c.unit.name +`</td>
                                            </tr>`;
                    }
                });
                tableWarehouseCook += `</tbody></table>`;

                let tableWarehouse = `<h4 class="hdg">Danh sách NVL của bếp trong kho chính</h4>
                                        <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                            <th width=25%>Tên mặt hàng</th>
                                            <th width=15%>Sl trong kho</th>
                                            <th width=22%>Sl cần xuất</th>
                                            <th width=17%>Đơn vị tính</th>
                                            <th width=2%></th>
                                            </tr>
                                        </thead>
                                        <tbody id="bodyWarehouseExportCook">`;
                data.materialWarehouse.map(function (detail) {
                    if (detail.detail_material.status == '1') {
                        tableWarehouse +=
                        `<tr id="row` + detail.id + `">
                            <td><input name="id[]" value="` + detail.id + `" hidden>
                                <input name="idMaterial[]" value="` + detail.detail_material.id + `" hidden>`+ detail.detail_material.name + `</td>
                            <td>` + detail.qty + `</td>
                            <td><input type="number" step="0.01" class="qty form-control" value="" name="qty[]" required></td>
                            <td><input value="`+detail.unit.id+`" name="id_unit[]" hidden>` + detail.unit.name + `</td>
                            <td><span class="input-group-btn" onclick="clickToRemove(` + detail.id + `)">
                                    <button class="btn btn-xs btn-danger" type="button">
                                        <i class="fa fa-times" aria-hidden="true"></i>
                                    </button>
                                </span>
                            </td>
                        </tr>`;
                    }
                })
                tableWarehouse += `</tbody></table>`;

                $('#warehouseCook').append(tableWarehouseCook);
                $('#warehouse').append(tableWarehouse);
                $('#submit').append('<a href="warehouse/index" class="btn btn-default">Trở về</a>&nbsp;<button type="submit" class="btn green-meadow radius">Tạo phiếu</button>');
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
                $('#submit').append('<a href="warehouse/index" class="btn btn-default">Trở về</a>&nbsp;<button type="submit" class="btn green-meadow radius">Tạo phiếu</button>');
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
    $(".clickUpdatePrice").click(function () {
        const idMaterial = this.id;
        $.ajax({
            url: 'ajax/getCapitalPrice/' + idMaterial, //Trang xử lý
            method: 'GET',
            dataType: 'JSON',
            success: function (data) {
                $('#newCapitalPriceHidden' + idMaterial).empty();
                $("#newCapitalUpdate" + idMaterial).empty();
                $("#newSalePriceUpdate" + idMaterial).empty();
                $('input#newCapitalPriceHidden'  + idMaterial).val(data.capitalPrice);
                $('input#newCapitalUpdate' + idMaterial).val(data.capitalPrice);
                $('input#newSalePriceUpdate' + idMaterial).val(data.salePrice);
                console.log(data);

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

    function makeCode(length) {
        var result           = 'PCN';
        var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        var charactersLength = characters.length;
        for ( var i = 0; i < length; i++ ) {
           result += characters.charAt(Math.floor(Math.random() * charactersLength));
        }
        return result;
    }

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
                        <h3 class="typoh2 text-center">Phiếu nhập trong thời gian và Nhà Cung Cấp vừa chọn</h3>
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
                    </table>
                    <div class="row">
                        <div class="col-xs-12 text-center " data-toggle="collapse">
                            <a class="btn btn-default" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                                Tạo phiếu chi nợ &nbsp;
                                <i class="fa fa-chevron-circle-down text-danger" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>`;
                    $('#leftTable').append(tableImportCoupons);
                    let code = makeCode(5);
                    let formSubmit =
                        `<div class="list-group list-group-alternate">
                            <div class="form-group">
                                <label class="col-xs-12 col-sm-2 control-label">Mã phiếu chi</label>
                                <div class="col-xs-12 col-sm-10">
                                    <input type="text" class="form-control" name="code" value="`+ code +`" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12 col-sm-2 control-label">Nhà cung cấp</label>
                                <div class="col-xs-12 col-sm-10">
                                    <input type="hidden" name="idSupplierChoosen" value="`+ idSupplier +`">
                                    <input type="hidden" name="dateStart" value="`+ dateStart +`">
                                    <input type="hidden" name="dateEnd" value="`+ dateEnd +`">
                                    <input type="hidden" value="`+ data.conclusion.unPaid +`" id="unPaid">
                                    <input class="form-control" disabled value="`+ nameSupplier +`">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12 col-sm-2 control-label">Số tiền trả: </label>
                                <div class="col-xs-12 col-sm-10">
                                    <input class="form-control" type="number" name="pay_cash" id="payCash" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12 col-sm-2 control-label">Ghi chú: </label>
                                <div class="col-xs-12 col-sm-10">
                                    <textarea class="form-control" name="note"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12 text-right">
                                    <button type="submit" class="btn green-meadow radius">Tạo phiếu</button>
                                </div>
                            </div>
                        </div>`;
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
                    let noneResult = `<tr><td colspan="9" class="text-center">Không tìm thấy kết quả</<td><tr>`;
                    $('#bodyPaymentVc').append(noneResult);
                }else{
                    $('#bodyPaymentVc').empty();
                    let count = 0;
                    results.map(function (result) {
                        console.log(result);
                        let row =
                        `<tr>
                            <td>`+ (count+1) +`</td>
                            <td>`+ result.code +`</td>`;
                            if (result.type == '1') {
                                row += `<td>Chi nợ NCC</<td>`;
                            } else {
                                row += `<td>Mua Gấp NVL</td>`;
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
                            `<td>` + result.created_by + `</td>`;
                            if (result.type == '1') {
                                row += `<td></td>`;
                            } else if(result.type == '0') {
                                row +=
                                `<td>
                                    <a href="#payment`+ result.id +`" data-toggle="modal">
                                        <i class="fa fa-pencil text-success" aria-hidden="true"></i>
                                    </a>
                                    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="payment`+ result.id +`" class="modal fade" style="display: none;">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                                        <h4 class="modal-title">Chi tiết phiếu chi `+ result.code +`</h4>
                                                    </div>
                                                    <div class="modal-body" >
                                                        <div class="titleImportCoupon">
                                                            <div class="row bold">
                                                                <div class="col-xs-6">
                                                                    Lý do Chi:`;
                                                                    if (result.type == 1) {
                                                                        row += `Chi nợ NCC`;
                                                                    } else {
                                                                        row += `Mua gấp NVL`;
                                                                    }
                                                            row +=`    </div>
                                                                <div class="col-xs-6">
                                                                    Đối tượng: `+ result.name +` - Người tạo: `+ result.created_by +`
                                                                </div>
                                                            </div>
                                                            <div class="row bold">
                                                                <div class="col-xs-6">
                                                                    Tổng tiền: `+ result.pay_cash +`
                                                                </div>
                                                                <div class="col-xs-6">
                                                                    Ngày tạo: `+ result.created_at +`
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-xs-12">
                                                                <div class="bs-docs-example">
                                                                    <table class="table table-striped">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>STT</th>
                                                                                <th>Tên NVL</th>
                                                                                <th>Số lượng nhập</th>
                                                                                <th>Đơn vị tính</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>`;
                                                                            var dem = 0;
                                                                            result.detail_payment_vc.map(function (detail) {
                                                                                row +=
                                                                                `<tr>
                                                                                    <td>`+ ( ++dem ) +`</td>
                                                                                    <td>`+ detail.detail_material.name +`</td>
                                                                                    <td>`+ detail.qty +`</td>
                                                                                    <td>`+ detail.detail_material.unit.name +`</td>
                                                                                </tr>`
                                                                            })
                                                                    row +=` </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                </td>`;
                            }
                            row += `<td class="text-right">` + result.created_at + `</td>
                        </tr>`;
                        $('#bodyPaymentVc').append(row);
                    });
                }
            }
        });
    })

    $('#btnProfit').click(function () {
        const start = document.getElementById('dateStart').value;
        const end = document.getElementById('dateEnd').value;
        $.ajax({
            url: 'ajax/report/profit/' + start + '/' + end,
            method: 'GET',
            dataType: 'JSON',
            success: function (results) {
                $("div#revenue").text(results.revenue);
                $("div#expense").text(results.expense);
                $("div#profit").text(results.profit);
            }
        });
    })

    $('#cookEmergency').click(function () {
        const idCook = $(this).val();
        $.ajax({
            url: 'ajax/getMaterial/cookemergency/' + idCook ,
            method: 'GET',
            dataType: 'JSON',
            success: function (materialDetail) {
                $('#cookEmergencyTable').empty();
                materialDetail.map(function (data) {
                    let row =   `<tr id="row`+ data.id +`">
                                    <td><input type="hidden" name="idMaterialDetail[]" value="`+ data.detail_material.id +`">`+ data.detail_material.name +`</td>
                                    <td>`+ data.qty +`</td>
                                    <td><input type="number" class="form-control" name="qty[]" required></td>
                                    <td>`+ data.unit.name +`</td>
                                    <td>
                                        <span class="input-group-btn" onclick="clickToRemove(`+ data.id +`)">
                                            <button class="btn btn-danger" type="button"><i class="fa fa-times" aria-hidden="true"></i></button>
                                        </span>
                                    </td>
                                </tr>`;
                    $('#cookEmergencyTable').append(row);
                })

            }
        });
    })

    $(".checkNVL").click(function (e) {
        const idDishOrder = this.id;
        $.ajax({
            url: 'ajax/checkNVL/' + idDishOrder, //Trang xử lý
            method: 'GET',
            dataType: 'JSON',
            success: function (data) {
                console.log(data);
                $('input#DqtyOrder'  + idDishOrder).val(data.qtyOrder);
                $('input#DqtyEmptyCook' + idDishOrder).val(data.qtyEmptyCook);
                $('input#DqtyEmptyWh' + idDishOrder).val(data.qtyEmptyWarehouse);
                $('input#qtyOrder'  + idDishOrder).val(data.qtyOrder);
                $('input#qtyEmptyCook' + idDishOrder).val(data.qtyEmptyCook);
                $('input#qtyEmptyWh' + idDishOrder).val(data.qtyEmptyWarehouse);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            }
        });
    });

});
