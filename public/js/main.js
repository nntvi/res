$(document).ready(function () {
    // ajax get material by id_supplierto import
    $("#idSupplier").change(function () {
        var idSupplier = $(this).val();
        //console.log(id);
        $.ajax({
            url: 'api/getMaterialBySupplier/' + idSupplier, //Trang xử lý
            method: 'GET',
            dataType: 'JSON',
            success: function (data) {
                //console.log(data);
                data.materials.forEach(function (material) {
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
                            '<td><input  type="number" class="qty form-control" name="qty[]"></td>' +
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

    // ajax get object by id_type_export to export
    $("#type_object").change(function () {
        var id = $(this).val();
        // console.log(id);
        $.ajax({
            url: 'api/getOjbectToExport/' + id, //Trang xử lý
            method: 'GET',
            dataType: 'JSON',
            success: function (data) {
                $("#object").empty();
                //console.log(data);
                data.forEach(function (c) {
                    $('#object').append($('<option>', {
                        value: c.id,
                        text: c.name
                    }));
                });
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            }
        });
    });

    // ajax get material by IdType and IdObject
    // $("#type_object").change(function () {
    //     var idType = $(this).val();
    //     //console.log(idType);
    //     $("#object").change(function () {
    //         var idObject = $(this).val();
    //         //console.log(idObject);
    //         $.ajax({
    //             url: 'api/getMaterialToExport/' + idType + '/' + idObject, //Trang xử lý
    //             method: 'GET',
    //             dataType: 'JSON',
    //             success: function (data) {
    //                 switch (data.idType) {
    //                     case 1:
    //                         $('#typesMaterial').empty();
    //                         $('#warehouseCook').empty();
    //                         $('#warehouse').empty();
    //                         $('#submit').empty();
    //                         var tableWarehouseCook = '<h4 class="hdg">NVL của bếp vừa chọn</h4>' +
    //                             '<table class="table table-bordered">' +
    //                             '<thead>' +
    //                             '<tr>' +
    //                             '<th>Tên NVL</th>' +
    //                             '<th>Sl tồn</th>' +
    //                             '<th>Đơn vị</th>' +
    //                             '</tr>' +
    //                             '</thead>' +
    //                             '<tbody>';
    //                         data.materialWarehouseCook.forEach(function (c) {
    //                             tableWarehouseCook += '<tr>' +
    //                                 '<td>' + c.detail_material.name + '</td>' +
    //                                 '<td><span class="badge">' + c.qty + '</span></td>' +
    //                                 '<td>';
    //                             if (c.unit == null) {
    //                                 tableWarehouseCook += 'Rỗng';
    //                             } else {
    //                                 tableWarehouseCook += c.unit.name;
    //                             }
    //                             tableWarehouseCook += '</td>' +
    //                                 '</tr>';
    //                         });
    //                         '</tbody>' +
    //                         '</table>'
    //                         var tableWarehouse = '<h4 class="hdg">Danh sách NVL trong kho chính</h4>' +
    //                             '<table class="table table-bordered">' +
    //                             '<thead>' +
    //                             '<tr>' +
    //                             '<th width=25%>Tên mặt hàng</th>' +
    //                             '<th width=15%>Sl trong kho</th>' +
    //                             '<th width=22%>Sl cần xuất</th>' +
    //                             '<th width=17%>Đơn vị tính</th>' +
    //                             '<th width=2%></th>' +
    //                             '</tr>' +
    //                             '</thead>' +
    //                             '<tbody>';
    //                         data.materialWarehouse.forEach(function (detail) {
    //                             tableWarehouse +=
    //                                 '<tr id="row' + detail.id + '">' +
    //                                 '<td>' +
    //                                 '<input name="id[]" value="' + detail.id + '" hidden>' +
    //                                 '<input name="idMaterial[]" value="' + detail.detail_material.id + '" hidden>' +
    //                                 detail.detail_material.name +
    //                                 '</td>' +
    //                                 '<td><input name="oldQty[]" class="qty form-control" value="' + detail.qty + '" disabled></td>' +
    //                                 '<td><input type="number" step="0.01" class="qty form-control" value="" name="qty[]"></td>' +
    //                                 '<td>';
    //                             if (detail.id_unit == 0) {
    //                                 tableWarehouse += 'Hết hàng';
    //                             } else {
    //                                 tableWarehouse += '<input value="' + detail.unit.id + '" name="id_unit[]" hidden></input>' +
    //                                     '<input class="form-control" value="' + detail.unit.name + '" disabled></input>';
    //                             }
    //                             tableWarehouse += '</td>' +
    //                                 '<td>' +
    //                                 '<span class="input-group-btn" onclick="clickToRemove(' + detail.id + ')">' +
    //                                 '<button class="btn btn-danger" type="button">' +
    //                                 '<i class="fa fa-times" aria-hidden="true"></i>' +
    //                                 '</button>' +
    //                                 '</span>' +
    //                                 '</td>' +
    //                                 '</tr>';
    //                         })
    //                         '</tbody>' +
    //                         '</table>'
    //                         $('#warehouseCook').append(tableWarehouseCook);
    //                         $('#warehouse').append(tableWarehouse);
    //                         $('#submit').append('<button type="submit" class="btn green-meadow radius">Tạo phiếu</button>');
    //                         break;
    //                     case 2:
    //                         $('#typesMaterial').empty();
    //                         $('#warehouseCook').empty();
    //                         $('#warehouse').empty();
    //                         $('#submit').empty();
    //                         var tableWarehouse = '<h4 class="hdg">Danh sách NVL thuộc NSX vừa chọn</h4>' +
    //                             '<table class="table table-bordered">' +
    //                             '<thead>' +
    //                             '<tr>' +
    //                             '<th width=25%>Tên mặt hàng</th>' +
    //                             '<th width=15%>Sl trong kho</th>' +
    //                             '<th width=22%>Sl cần xuất</th>' +
    //                             '<th width=17%>Đơn vị tính</th>' +
    //                             '<th width=2%></th>' +
    //                             '</tr>' +
    //                             '</thead>' +
    //                             '<tbody>';
    //                         data.materialWarehouse.forEach(function (detail) {
    //                             tableWarehouse +=
    //                                 '<tr id="row' + detail.id + '">' +
    //                                 '<td>' +
    //                                 '<input name="id[]" value="' + detail.id + '" hidden>' +
    //                                 '<input name="idMaterial[]" value="' + detail.detail_material.id + '" hidden>' +
    //                                 detail.detail_material.name +
    //                                 '</td>' +
    //                                 '<td><input name="oldQty[]" class="qty form-control" value="' + detail.qty + '" disabled></td>' +
    //                                 '<td><input type="number" step="0.01" class="qty form-control" value="" name="qty[]"></td>' +
    //                                 '<td>';
    //                             if (detail.id_unit == 0) {
    //                                 tableWarehouse += 'Hết hàng';
    //                             } else {
    //                                 tableWarehouse += '<input value="' + detail.unit.id + '" name="id_unit[]" hidden></input>' +
    //                                     '<input class="form-control" value="' + detail.unit.name + '" disabled></input>';
    //                             }
    //                             tableWarehouse += '</td>' +
    //                                 '<td>' +
    //                                 '<span class="input-group-btn" onclick="clickToRemove(' + detail.id + ')">' +
    //                                 '<button class="btn btn-danger" type="button">' +
    //                                 '<i class="fa fa-times" aria-hidden="true"></i>' +
    //                                 '</button>' +
    //                                 '</span>' +
    //                                 '</td>' +
    //                                 '</tr>';
    //                         })
    //                         '</tbody>' +
    //                         '</table>'
    //                         $('#warehouse').append(tableWarehouse);
    //                         $('#submit').append('<button type="submit" class="btn green-meadow radius">Tạo phiếu</button>');
    //                         break;
    //                     default:
    //                         break;
    //                 }
    //             },
    //             error: function (xhr, ajaxOptions, thrownError) {
    //                 alert(xhr.status);
    //                 alert(thrownError);
    //             }
    //         });
    //     });
    // });

    // export by ObjectCook
    $("#objectCook").change(function () {
        let objectCook = $(this).val();
        console.log(objectCook);
        $.ajax({
            url: 'api/getMaterialToExportCook/' + objectCook, //Trang xử lý
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
                data.materialWarehouseCook.forEach(function (c) {
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
                    '<tbody>';
                data.materialWarehouse.forEach(function (detail) {
                    tableWarehouse +=
                        '<tr id="row' + detail.id + '">' +
                        '<td>' +
                        '<input name="id[]" value="' + detail.id + '" hidden>' +
                        '<input name="idMaterial[]" value="' + detail.detail_material.id + '" hidden>' +
                        detail.detail_material.name +
                        '</td>' +
                        '<td><input name="oldQty[]" class="qty form-control" value="' + detail.qty + '" disabled></td>';

                    if (detail.id_unit == 0) {
                        tableWarehouse +='<td><input type="number" step="0.01" class="qty form-control" value="" name="qty[]" disabled></td>' +
                        '<td>'+
                        'Hết hàng';
                    } else {
                        tableWarehouse += '<td><input type="number" step="0.01" class="qty form-control" value="" name="qty[]"></td>' +
                        '<td>'+
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

    // ajax get object by id_type_report to report
    $("#typeReport").change(function () {
        var idType = $(this).val();
        //console.log(idType);
        $.ajax({
            url: 'api/getObjectToReport/' + idType, //Trang xử lý
            method: 'GET',
            dataType: 'JSON',
            success: function (data) {
                //console.log(data);
                $("#objectReport").empty();
                if (data.idData == null) {
                    data.forEach(function (c) {
                        $('#objectReport').append($('<option>', {
                            value: c.id,
                            text: c.name
                        }));
                    })
                } else if (data.idData == 4) {
                    $('#objectReport').append($('<option>', {
                        value: data.idData,
                        text: data.name
                    }));
                }
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
            url: 'api/getDateTimeToReport/' + idTypeDateTime, //Trang xử lý
            method: 'GET',
            dataType: 'JSON',
            success: function (data) {
                if (idTypeDateTime == 1) {
                    var a = document.getElementById("dateStart");
                    a.setAttribute('value', data.dateStart);
                    var b = document.getElementById("dateEnd");
                    b.setAttribute('value', data.dateEnd);
                } else if (idTypeDateTime == 2) {
                    var a = document.getElementById("dateStart");
                    a.setAttribute('value', data.dateStart);
                    var b = document.getElementById("dateEnd");
                    b.setAttribute('value', data.dateEnd);
                } else if (idTypeDateTime == 3) {
                    var a = document.getElementById("dateStart");
                    a.setAttribute('value', data.dateStart);
                    var b = document.getElementById("dateEnd");
                    b.setAttribute('value', data.dateEnd);
                } else if (idTypeDateTime == 4) {
                    var a = document.getElementById("dateStart");
                    a.setAttribute('value', data.dateStart);
                    var b = document.getElementById("dateEnd");
                    b.setAttribute('value', data.dateEnd);
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            }
        });
    });

    // ajax get object by id_type_export to export
    // $("#submitReport").click(function () {
    //     timeStart = $("#dateStart").val();
    //     var timeEnd = $("#dateEnd").val();
    //     console.log(timeStart);
    //     console.log(timeEnd);
    //     $.ajax({
    //         url: 'api/loadReport/' + timeStart + '/' + timeEnd, //Trang xử lý
    //         method: 'GET',
    //         dataType: 'JSON',
    //         success: function (data) {
    //             console.log(data);
    //             var count = 0;

    //             function getValueImport($idMaterialDetail) {
    //                 var temp = 0;
    //                 for (let i = 0; i < data.detailImport.length; i++) {
    //                     if (data.detailImport[i].id_material_detail == $idMaterialDetail) {
    //                         return data.detailImport[i].total;
    //                         break;
    //                     } else {
    //                         temp++;
    //                         continue;
    //                     }
    //                 }
    //                 if (temp == data.detailImport.length)
    //                     return 0;
    //             }

    //             function getValueExport($idMaterialDetail) {
    //                 var temp = 0;
    //                 for (let i = 0; i < data.detailExport.length; i++) {
    //                     if (data.detailExport[i].id_material_detail == $idMaterialDetail) {
    //                         return data.detailExport[i].total;
    //                         break;
    //                     } else {
    //                         temp++;
    //                         continue;
    //                     }
    //                 }
    //                 if (temp == data.detailExport.length)
    //                     return 0;
    //             }

    //             function getTonDauKy($toncuoiky, $xuat, $nhap) {
    //                 return $toncuoiky + $xuat - $nhap;
    //             }
    //             data.warehouse.forEach(function (wh) {
    //                 count++;
    //                 var row = '<tr>' +
    //                     '<td>' + count + '</td>' +
    //                     '<td>' + wh.detail_material.name + '</td>' +
    //                     '<td>' + wh.type_material.name + '</td>' +
    //                     '<td>' + wh.unit.name + '</td>' +
    //                     '<td>' + getTonDauKy(wh.qty, getValueExport(wh.id_material_detail), getValueImport(wh.id_material_detail)) + '</td>' +
    //                     '<td>' + getValueImport(wh.id_material_detail) + '</td>' +
    //                     '<td>' + getValueExport(wh.id_material_detail) + '</td>' +
    //                     '<td>' + wh.qty + '</td>' +
    //                     '<td><a href="#myModal' + wh.id_material_detail + '" data-toggle="modal" class="btn default btn-xs red radius">Xem chi tiết</a></td>' +
    //                     '</tr>';
    //                 let dt = '<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal' + wh.id_material_detail + '" class="modal fade" style="display: none;">' +
    //                     '<div class="modal-dialog">' +
    //                     '<div class="modal-content">' +
    //                     '<div class="modal-header">' +
    //                     '<button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>' +
    //                     '<h4 class="modal-title">Tên NVL: ' + wh.detail_material.name + '</h4>' +
    //                     '</div>' +
    //                     '<div class="modal-body">' +
    //                     '<form role="form">' +
    //                     '<div class="form-group">' +
    //                     '<label for="exampleInputEmail1">Email address</label>' +
    //                     '<input type="email" class="form-control" id="exampleInputEmail3" placeholder="Enter email">' +
    //                     '</div>' +
    //                     '</form>' +
    //                     '</div>' +
    //                     '</div>' +
    //                     '</div>' +
    //                     '</div>'
    //                 $('#contentReport').append(row, dt);
    //             })
    //         },
    //         error: function (xhr, ajaxOptions, thrownError) {
    //             alert(xhr.status);
    //             alert(thrownError);
    //         }
    //     });
    // });

});
