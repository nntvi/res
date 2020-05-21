$(document).ready(function () {
    $('.pagination').addClass('pagination-sm');
    // ajax get material by id_supplierto import
    $("#idSupplier").change(function () {
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
    $("#objectCook").change(function () {
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
                    let option = `<option value="`+ x.code +`">Mã phiếu: `+ x.code +` - Ngày nhập: `+ x.created_at +`</option>`;
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
        console.log(codeCoupon);

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
                    tableMaterialExportSupplier += '<tr id="row'+ detail.id +'">' +
                                    '<td><input name="idMaterial[]" value="' + detail.material_detail.id + '" hidden>'+ detail.material_detail.name + '</td>' +
                                    '<td><input type="hidden" name="oldQty[]" class="oldQty form-control" value="' + detail.qty + '">' + detail.qty + '</td>' +
                                    '<td><input type="number" step="0.01" min="0.01" class="qty form-control" name="qty[]" required></td>' +
                                    '<td><input name="id_unit[]" value="' + detail.unit.id + '" hidden>' + detail.unit.name + '</td>'+
                                    '<td><input name="price[]" value="' + detail.price + '" hidden>' + detail.price +'</td>'+
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
                console.log(materials);

            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            }
        });
    });

    // get time to report
    $("#timeReport").change(function () {
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
    $("#searchMaterial").click(function() {
        const name = document.getElementById('nameMaterial').value;
        $.ajax({
            url: 'ajax/getMaterial/destroy/warehouse/' + name, //Trang xử lý
            method: 'GET',
            dataType: 'JSON',
            success: function(data) {
                if (data.length == 0) {
                    alert("Không có sp này");
                }
                else{
                    data.map(function (detail) {
                       let row = '<tr id="row'+ detail.id +'">' +
                                    '<td><input name="idMaterial[]" value="' + detail.detail_material.id + '" hidden>'+ detail.detail_material.name + '</td>' +
                                    '<td><input type="number" name="oldQty[]" class="oldQty form-control" value="' + detail.qty + '" disabled></td>' +
                                    '<td><input type="number" step="0.01" min="0.01" class="qty form-control" name="qty[]"></td>' +
                                    '<td><input value="' + detail.unit.id + '" name="id_unit[]" hidden></input>'+ detail.unit.name + '</td>' +
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
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            }
        });
    });

    // search Material to Destroy in Cook
    $("#searchDestroyCook").click(function() {
        const idCook = document.getElementById('idCookDestroy').value;
        const nameMaterial = document.getElementById('nameMaterial').value;
        if(nameMaterial == null || nameMaterial == ""){
            alert("Chưa nhập tên NVL");
        }
        else{
            $.ajax({
                url: 'ajax/getMaterial/destroy/cook/' + idCook + '/' + nameMaterial, //Trang xử lý
                method: 'GET',
                dataType: 'JSON',
                success: function(data) {
                    if (data.length == 0) {
                        alert("Không có sp vừa nhập trong bếp này");
                    }
                    if (data.length == null) {
                        alert("Không có sp vừa nhập trong bếp này");
                    }
                    else{
                        data.map(function (detail) {
                           let row = '<tr id="row'+ detail.id +'">' +
                                        '<td><input name="idMaterial[]" value="' + detail.detail_material.id + '" hidden>'+ detail.detail_material.name + '</td>' +
                                        '<td><input type="number" name="oldQty[]" class="oldQty form-control" value="' + detail.qty + '" disabled></td>' +
                                        '<td><input type="number" step="0.01" min="0.01" class="qty form-control" name="qty[]"></td>' +
                                        '<td>';
                                        if (detail.unit == null) {
                                            row += '<input value="0" name="id_unit[]" hidden></input> Rỗng';
                                        } else {
                                            row += '<input value="'+ detail.unit.id +'" name="id_unit[]" hidden></input> '+ detail.unit.name +'';
                                        }
                                        row += '</td>'+
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
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                }
            });
        }
    });

    // get capital Price
    $("#idMaterial").change(function () {
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
                data.map(function(item){
                    $("span#revenue").text(item.total + ' đ');
                    $("span#bill").text(item.bill);
                    $("span.servingBill").text(item.serving);
                    $("span.paidBill").text(item.paid);
                });
            }
        });
    });

    $("#supplierPayment").change(function () {
        let idSupplier = $(this).val();
        $.ajax({
            url: 'ajax/getImportCoupon/' + idSupplier ,
            method: 'GET',
            dataType: 'JSON',
            success: function (imports) {
                imports.map(function (coupon) {
                    let row =   '<tr id="row'+ coupon.id +'">'+
                                    '<td>'+ coupon.created_at +'</td>'+
                                    '<td>'+ coupon.code +'</td>'+
                                    '<td>'+ coupon.total +'</td>'+
                                    '<td><input type"number" class="form-control" name="payCash[]" required value="'+ coupon.total +'"></td>'+
                                    '<td>'+
                                        '<span class="input-group-btn" onclick="clickToRemove(' + coupon.id + ')">' +
                                            '<button class="btn btn-danger" type="button"><i class="fa fa-times" aria-hidden="true"></i></button>' +
                                        '</span>'
                                    '</td>'+
                                '</tr>';
                    $("#tablePayment").append(row);
                })
            }
        });
    });

    // get tuso mauso
    $(".card").click(function () { // chọn bàn
        const idTable = $(this).attr('data-id'); // lấy id bàn đó
        const nameTableOrder = $(this).find('h6.card-title').text(); // lấy cả tên
        var statusTable = $(this).attr('data-status'); // lấy status có khách or not
        if(statusTable == "0"){ // ko có khách
            $('#tableOrder').empty();
            var order = `<form id="orderForm">
                            <div class="panel panel-default">
                                <div class="panel-heading nameTableOrder" style="background: #ff00003b!important">
                                    ` + nameTableOrder +`
                                </div>
                                <input type="hidden" name="idTableOrder" value="`+ idTable +`">
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
                                        <tbody id="tableOrder">
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
            $('.card.cardDish').click(function () {
                var idDish = $(this).find('h5[data-dish]').data('dish'); // id dish
                var nameDish = $(this).find('.card-title').text();
                var priceDish = $(this).find('.card-text').text();
                let row =   `<tr id="row`+ idDish +`" data-row="`+ idDish +`">
                                <td><input type="hidden" class="idDish" name="idDish[]" value="`+ idDish +`">`+ nameDish+`</td>
                                <td>
                                    <div class="input-group">
                                        <span class="input-group-btn" onclick="clickToMinus(`+ idDish +`)">
                                            <button type="button" class="btn btn-xs btn-danger btn-number">
                                                <span class="glyphicon glyphicon-minus"></span>
                                            </button>
                                        </span>
                                        <input type="text" name="qty[]" class="form-control input-number qty" value="1" id="count`+ idDish +`">
                                        <span class="input-group-btn btn-xs" onclick="clickToPlus(`+ idDish +`)">
                                            <button type="button" class="btn btn-xs btn-success btn-number">
                                                <span class="glyphicon glyphicon-plus"></span>
                                            </button>
                                        </span>
                                    </div>
                                </td>
                                <td><input type="text" name="note[]" class="form-control qty"></td>
                                <td>`+ priceDish +`</td>
                                <td style="width:5px; cursor:pointer">
                                    <a  onclick="clickToRemove(`+ idDish +`)">
                                        <i class="fa fa-times text-danger text"></i>
                                    </a>
                                </td>
                            </tr>`
                $('tbody#tableOrder').append(row);
            });
            $('#orderForm').submit(function(){
                var arrDishes = $("input[name='idDish[]']").map(function(){return $(this).val();}).get();
                var arrQties = $("input[name='qty[]']").map(function(){return $(this).val();}).get();
                var arrNotes = $("input[name='note[]']").map(function(){return $(this).val();}).get();
                $.ajax({
                  url: "",
                  type:"POST",
                  data:{
                    "_token": "{{ csrf_token() }}",

                  },
                  success:function(response){
                    console.log(response);
                  },
                 });
            });
        }
        else if(statusTable == "1"){
            $('div.nameTableOrder').text(nameTableOrder);
            $('#idTableOrder').val(idTable);
            $.ajax({
                url: 'ajax/orderTable/' + idTable ,
                method: 'GET',
                dataType: 'JSON',
                success: function (dishes) {
                    $('#tableOrder').empty();
                    dishes.map(function (dish) {
                        var row =   `<tr>
                                <td>`+ dish.dish.name+`</td>
                                <td class="text-center">`+ dish.qty +`</td>
                                <td>`;
                                    if (dish.note == null) {
                                        row += `-`;
                                    } else {
                                        row += dish.note;
                                    }
                        row += `</td>
                                <td>`+ dish.price +`</td>
                                <td>`;
                                    if(dish.status == '-1'){
                                        row += `<i class="fa fa-pause text-danger" aria-hidden="true"></i>`;
                                    }
                                    else if(dish.status == '0'){ // chưa thực hiện
                                        row += `<i class="fa fa-battery-empty text-warning" aria-hidden="true"></i>`;
                                    }else if(dish.status == '1'){
                                        row += `<i class="fa fa-battery-half text-info" aria-hidden="true"></i>`;
                                    }else if(dish.status == '2'){
                                        row += `<i class="fa fa-battery-full text-success" aria-hidden="true"></i>`;
                                    }
                        row += `</td>
                            </tr>`
                        $('#tableOrder').append(row);
                    })
                }
            });
            $('.card.cardDish').click(function () {
                var idDish = $(this).find('h5[data-dish]').data('dish'); // id dish
                // let table = document.getElementById('tableOrder');
                // if(table.rows.length != 0){
                //     for(var i = 0, row; row = table.rows[i]; i++){
                //         console.log((row).find('tr').attr('data-row'));


                //     }
                // }
                var nameDish = $(this).find('.card-title').text();
                var priceDish = $(this).find('.card-text').text();
                let row =   `<tr id="row`+ idDish +`" data-row="`+ idDish +`">
                                <td><input type="hidden" name="idDish[]" value="`+ idDish +`">`+ nameDish+`</td>
                                <td>
                                    <div class="input-group">
                                        <span class="input-group-btn" onclick="clickToMinus(`+ idDish +`)">
                                            <button type="button" class="btn btn-xs btn-danger btn-number">
                                                <span class="glyphicon glyphicon-minus"></span>
                                            </button>
                                        </span>
                                        <input type="text" name="qty[]" class="form-control input-number" value="1" id="count`+ idDish +`">
                                        <span class="input-group-btn btn-xs" onclick="clickToPlus(`+ idDish +`)">
                                            <button type="button" class="btn btn-xs btn-success btn-number">
                                                <span class="glyphicon glyphicon-plus"></span>
                                            </button>
                                        </span>
                                    </div>
                                </td>
                                <td><input type="text" name="note[]" class="form-control"></td>
                                <td>`+ priceDish +`</td>
                                <td style="width:5px; cursor:pointer">
                                    <a  onclick="clickToRemove(`+ idDish +`)">
                                        <i class="fa fa-times text-danger text"></i>
                                    </a>
                                </td>
                            </tr>`
                $('#tableOrder').append(row);
            });
        }
    });



});

