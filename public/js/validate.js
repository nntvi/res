// bắt lỗi form thêm NVL cho món
function validateFormMaterialAction() {
    let table = document.getElementById('bodyMaterialAction');
    let data = [];
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
    let table = document.getElementById('myTable');
    let data = [];
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
    var data = [];
    var code = document.getElementById('codeExportCook').value;
    var table = document.getElementById('bodyWarehouseExportCook');
    if(code.length == null || code.length == ""){
        data.push("Không để trống mã phiếu xuất \n");
    }
    if(table.rows.length != 0){
        for (var i = 0, row; row = table.rows[i]; i++) {
            let tempOldQty;
            for (var j = 0, col; col = row.cells[j]; j++) {
                if (j == 1) {
                    $('input[type="number"].oldQty').each(function (index) {
                        if (index == i) {
                            tempOldQty = parseFloat($(this).val());
                        }
                    });
                }
                if (j == 2) {
                    $('input[type="number"].qty').each(function (index) {
                        if (index == i) {
                            var hang = i + 1;
                            if (parseFloat( tempOldQty ) < parseFloat( $(this).val())) {
                                let compareInput = "Hàng " + hang + " cột " + (j+1) + " sl xuất > sl trong kho \n";
                                data.push(compareInput);
                                data.push(tempOldQty + '<' + $(this).val() + '\n');
                            }
                        }
                    });
                }
            }
        }
    }else{
        data.push("Chưa có NVL nào để xuất");
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
    let table = document.getElementById('bodyExportSupplier');
    var tempOldQty;
    let data = [];
    if (codeExport == null || codeExport == "") {
        var error = "Không để trống mã phiếu xuất \n";
        data.push(error);
    }
    for (var i = 0, row; row = table.rows[i]; i++) {
        for (var j = 0, col; col = row.cells[j]; j++) {
            if (j == 1) {
                $('input[type="number"].oldQty').each(function (index) {
                    if (index == i) {
                        tempOldQty = parseFloat($(this).val());
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
    let table = document.getElementById('tableDestroyWarehouse');
    var tempOldQty;
    let data = [];
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
                            tempOldQty = parseFloat($(this).val());
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
                            } else if (parseFloat($(this).val()) > tempOldQty){
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
// bắt lỗi form hủy bếp
function validateFormDestroyCook() {
    const codeDestroyCook = document.getElementById('codeDestroyCook').value;
    let table = document.getElementById('tableDestroyWarehouseCook');
    var tempOldQty;
    let data = [];
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
                            tempOldQty = parseFloat($(this).val());
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
                            } else if (parseFloat($(this).val()) > tempOldQty){
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

// bắt lỗi tạo order
function saveOrder() {
    let tableOrder = document.getElementById('tableOrder');
    let data = [];
    if(tableOrder.rows.length == 0){
        alert("Vui lòng chọn món cho bàn");
        return false;
        //data.push("Vui lòng chọn món cho bàn");
    }else{
        for (let i = 0,row; row = tableOrder.rows[i]; i++) {
            for (let j = 0, col; col = row.cells[j]; j++){
                if(j == 1){
                    if(col[j].is('input')){
                        alert("Yes");
                        return false;
                    }
                }
            }
        }
        alert('No');
        return false;
    }
}

// bắt lỗi form trả tiền NCC
function validatePaymentVoucher() {
    let unPaid = document.getElementById('unPaid').value;
    let payCash = document.getElementById('payCash').value;
    if(parseFloat(payCash) > parseFloat(unPaid)){
        alert('Số tiền nhập vào không được lớn hơn số tiền cần trả');
        return false;
    }else{
        return true;
    }
}

function validateCookEmer() {
    let tableCookEmer = document.getElementById('cookEmergencyTable');
    if(tableCookEmer.rows.length == 0){
        alert('Chưa có NVL để tạo phiếu');
        return false;
    }else{
        return true;
    }
}
