// bắt lỗi form thêm NVL cho món
function validateFormMaterialAction() {
    const table = document.getElementById('bodyMaterialAction');
    const data = [];
    if (table.rows.length != 0) {
        for (var i = 0, row; row = table.rows[i]; i++) {
            for (var j = 0, col; col = row.cells[j]; j++) {
                if (j == 1) {
                    $('input[type="number"].qty').each(function (index) {
                        if (index == i) {
                            var cot = i + 1;
                            if ($(this).val() == null || $(this).val() == "") {
                                let emptyInput = "Hàng " + cot + " cột " + j + " trống sl nhập \n";
                                data.push(emptyInput);
                            }
                        }
                    });
                }
            }
        }
    } else {
        const tableNull = "Chưa có NVL nào cho món";
        data.push(tableNull);
    }
    if (data.length > 0) {
        alert(data);
        return false;
    } else {
        return true;
    }
}
// bắt lỗi form nhập kho chính
function validateFormImportCoupon() {
    const code = document.getElementById('codeImportCoupon').value;
    var qty, price;
    const table = document.getElementById('myTable');
    const data = [];
    if (code == null || code == "") {
        const codeError = "Không để trống mã phiếu nhập \n";
        data.push(codeError);
    }
    if (table.rows.length != 0) {
        for (var i = 0, row; row = table.rows[i]; i++) {
            for (var j = 0, col; col = row.cells[j]; j++) {
                if (j == 2) {
                    $('input[type="number"].qty').each(function (index) {
                        if (index == i) {
                            var cot = i + 1;
                            if ($(this).val() == null || $(this).val() == "") {
                                let emptyInput = "Hàng " + cot + " cột " + j + " trống sl nhập \n";
                                data.push(emptyInput);
                            }
                        }
                    });
                }
                if (j == 4) {
                    $('input[type="number"].price').each(function (index) {
                        price = ($(this).val());
                        if (index == i) {
                            var cot = i + 1;
                            if ($(this).val() == null || $(this).val() == "") {
                                let emptyInput = "Hàng " + cot + " cột " + j + " trống giá \n";
                                data.push(emptyInput);
                            }
                        }
                    });
                }
            }
        }
    } else {
        const tableNull = "Chưa có mặt hàng nào trong bảng";
        data.push(tableNull);
    }

    if (data.length > 0) {
        alert(data);
        return false;
    } else {
        return true;
    }

}
// bắt lỗi form xuất bếp
function validateFormExportCook() {
    const code = document.getElementById('codeExportCook').value;
    var oldQty, qty;
    const table = document.getElementById('bodyWarehouseExportCook');
    const data = [];
    var tempOldQty;
    if (code == null || code == "") {
        const codeError = "Không để trống mã phiếu xu \n";
        data.push(codeError);
    }
    for (var i = 0, row; row = table.rows[i]; i++) {
        for (var j = 0, col; col = row.cells[j]; j++) {
            if (j == 1) {
                $('input[type="number"].oldQty').each(function (index) {
                    if (index == i) {
                        tempOldQty = $(this).val();
                    }
                });
            }
            if (j == 2) {
                $('input[type="number"].qty').each(function (index) {
                    if (index == i) {
                        var cot = i + 1;
                        if ($(this).val() == null || $(this).val() == "") {
                            let emptyInput = "Hàng " + cot + " cột " + j + " trống sl nhập \n";
                            data.push(emptyInput);
                        } else if ($(this).val() > tempOldQty){
                            let compareInput = "Hàng " + cot + " cột " + j + " sl xuất > sl có \n";
                            data.push(compareInput);
                        }
                    }
                });
            }
        }

    }
    if (data.length > 0) {
        alert(data);
        return false;
    } else {
        return true;
    }
}
// bắt lỗi form xuất trả hàng cho nhà cung cấp
function validateFormExportSupplier() {
    const codeExport = document.getElementById('codeExportSupplier').value;
    const table = document.getElementById('bodyExportSupplier');
    var tempOldQty;
    const data = [];
    if (codeExport == null || codeExport == "") {
        var error = "Không để trống mã phiếu xuất \n";
        data.push(error);
    }
    for (var i = 0, row; row = table.rows[i]; i++) {
        for (var j = 0, col; col = row.cells[j]; j++) {
            if (j == 1) {
                $('input[type="number"].oldQty').each(function (index) {
                    if (index == i) {
                        tempOldQty = $(this).val();
                    }
                });
            }
            if (j == 2) {
                $('input[type="number"].qty').each(function (index) {
                    if (index == i) {
                        var cot = i + 1;
                        if ($(this).val() == null || $(this).val() == "") {
                            let emptyInput = "Hàng " + cot + " cột " + j + " trống sl nhập \n";
                            data.push(emptyInput);
                        } else if ($(this).val() > tempOldQty){
                            var compare = "Hàng " + cot + " cột " + j + " sl xuất > sl có trong kho \n";
                            var compare = "Hàng " + cot + " cột " + j + " sl xuất > sl có trong kho \n";
                            data.push(temp);
                        }
                    }
                });
            }
        }

    }
    if (data.length > 0) {
        alert(data);
        return false;
    } else {
        return true;
    }
}
// bắt lỗi form xuất hủy kho
function validateFormDestroyWarehouse() {
    const codeDestroy = document.getElementById('codeDestroy').value;
    const table = document.getElementById('tableDestroyWarehouse');
    var tempOldQty;
    const data = [];
    if (codeDestroy == null || codeDestroy == "") {
        var error = "Không để trống mã phiếu xuất \n";
        data.push(error);
    }
    if (table.rows.length != 0) {
        for (var i = 0, row; row = table.rows[i]; i++) {
            for (var j = 0, col; col = row.cells[j]; j++) {
                if (j == 1) {
                    $('input[type="number"].oldQty').each(function (index) {
                        if (index == i) {
                            tempOldQty = $(this).val();
                        }
                    });
                }
                if (j == 2) {
                    $('input[type="number"].qty').each(function (index) {
                        if (index == i) {
                            var cot = i + 1;
                            if ($(this).val() == null || $(this).val() == "") {
                                let emptyInput = "Hàng " + cot + " cột " + j + " trống sl xuất \n";
                                data.push(emptyInput);
                            } else if ($(this).val() > tempOldQty){
                                let compareInput = "Hàng " + cot + " cột " + j + " sl xuất > sl có \n";
                                data.push(compareInput);
                            }
                        }
                    });
                }
            }
        }
    }
    else {
        data.push("Chưa có NVL nào để xuất");
    }
    if(data.length >0){
        alert(data);
        return false;
    }else{
        return true;
    }
}
// bắt lỗi form xuất bếp
function validateFormDestroyCook() {
    const codeDestroyCook = document.getElementById('codeDestroyCook').value;
    const table = document.getElementById('tableDestroyWarehouseCook');
    var tempOldQty;
    const data = [];
    if (codeDestroyCook == null || codeDestroyCook == "") {
        var error = "Không để trống mã phiếu xuất \n";
        data.push(error);
    }
    if (table.rows.length != 0) {
        for (var i = 0, row; row = table.rows[i]; i++) {
            for (var j = 0, col; col = row.cells[j]; j++) {
                if (j == 1) {
                    $('input[type="number"].oldQty').each(function (index) {
                        if (index == i) {
                            tempOldQty = $(this).val();
                        }
                    });
                }
                if (j == 2) {
                    $('input[type="number"].qty').each(function (index) {
                        if (index == i) {
                            var cot = i + 1;
                            if ($(this).val() == null || $(this).val() == "") {
                                let emptyInput = "Hàng " + cot + " cột " + j + " trống sl xuất \n";
                                data.push(emptyInput);
                            } else if ($(this).val() > tempOldQty){
                                let compareInput = "Hàng " + cot + " cột " + j + " sl xuất > sl có \n";
                                data.push(compareInput);
                            }
                        }
                    });
                }
            }
        }
    }
    else {
        data.push("Chưa có NVL nào để xuất");
    }
    if(data.length >0){
        alert(data);
        return false;
    }else{
        return true;
    }
}

function validateSearchGroupMenu() {
    const name = document.getElementById('searchGroupMenu').value;
    if(name == null || name == ""){
        alert('Tên tìm kiếm rỗng');
        return false;
    }
    return true;
}
function validateUpdateGroupMenu() {

}
