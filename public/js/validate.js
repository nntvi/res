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

function removeAscent (str) {
    if (str === null || str === undefined) return str;
    str = str.toLowerCase();
    str = str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g, "a");
    str = str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g, "e");
    str = str.replace(/ì|í|ị|ỉ|ĩ/g, "i");
    str = str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g, "o");
    str = str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g, "u");
    str = str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g, "y");
    str = str.replace(/đ/g, "d");
    return str;
}
function isValid (string) {
    return !/[~`!#$%\^&*+=\-\[\]\\';,./{}|\\":<>\?0-9]/g.test(removeAscent(string));
}
function checkSpecialCharacter(arr) {
    var temp = 0;
    for (let i = 0; i < arr.length; i++) {
        if(isValid(arr[i]) == false)
        temp +=1 ;
    }
    return temp;
}
// bắt lỗi công thức
function validateMethod() {
    let textTu = $("input[name='textTu[]']").map(function () {
        return $(this).val();
    }).get();
    let textMau = $("input[name='textMau[]']").map(function () {
        return $(this).val();
    }).get();
    let tempTu = checkSpecialCharacter(textTu);
    let tempMau = checkSpecialCharacter(textMau);
    if(tempTu == 0 && tempMau == 0){
        return true;
    }else{
        alert('Tên công thức không được chứa số hoặc ký tự đặc biệt')
        return false;
    }
}
// bắt lỗi form nhập kho chính
function validateFormImportCoupon() {
    const code = document.getElementById('codeImportCoupon').value;
    let table = document.getElementById('myTable');
    let name;let emptyInput;
    let data = [];
    if (code == null || code == "") {
        data.push("Không để trống mã phiếu nhập \n");
    }
    if (table.rows.length != 0) {
        for (var i = 0, row; row = table.rows[i]; i++) {
            for (var j = 0, col; col = row.cells[j]; j++) {
                if(j == 0){
                    $('input[type="hidden"].nameMat').each(function (index) {
                        if (index == i) {
                            name = $(this).val();
                        }
                    });
                }
                if (j == 2) {
                    $('input[type="number"].qty').each(function (index) {
                        if (index == i) {
                            if ($(this).val() == null || $(this).val() == "") {
                               emptyInput = name + " trống sl nhập";
                            }else{
                                emptyInput = '';
                            }
                        }
                    });
                }
                if (j == 4) {
                    $('input[type="number"].price').each(function (index) {
                        if (index == i) {
                            price = $(this).val();
                            if(emptyInput != ''){ // sl nhập trống
                                if (price == null || price == "") { // giá trống
                                    data.push(emptyInput + " và giá \n");
                                }else{ // sl trống giá ko trống
                                    data.push(name + " trống số lượng nhập \n");
                                }
                            }else{ // sl ko trống
                                if (price == null || price == "") { // giá trống
                                    data.push(name + " trống giá \n");
                                }
                            }
                        }
                    });
                }
            }
        }
    }
    else {
        data.push("Chưa có mặt hàng nào trong bảng");
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
    var table = document.getElementById('bodyWarehouseExportCook');
    var nameMatDet;
    if(table.rows.length != 0){
        for (var i = 0, row; row = table.rows[i]; i++) {
            var tempOldQty;
            for (var j = 0, col; col = row.cells[j]; j++) {
                if (j == 0) {
                    $('input[type="hidden"].nameMatDet').each(function (index) {
                        if (index == i) {
                            nameMatDet = $(this).val();
                        }
                    });
                }
                if (j == 2) {
                    $('input[type="number"].oldQty').each(function (index) {
                        if (index == i) {
                            tempOldQty = parseFloat($(this).val());
                        }
                    });
                }
                if (j == 3) {
                    $('input[type="number"].qty').each(function (index) {
                        if (index == i) {
                            if (parseFloat( tempOldQty ) < parseFloat( $(this).val())) {
                                let compareInput = 'Số lượng xuất của ' + nameMatDet + ' > số lượng trong kho \n';
                                data.push(compareInput);
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
    var tempOldQty; let data = []; let name;
    for (var i = 0, row; row = table.rows[i]; i++) {
        for (var j = 0, col; col = row.cells[j]; j++) {
            if (j == 0) {
                $('input[type="hidden"].nameMatDet').each(function (index) {
                    if (index == i) {
                        name = $(this).val();
                    }
                });
            }
            if (j == 1) { // sl đã nhập
                $('input[type="hidden"].oldQty').each(function (index) {
                    if (index == i) {
                        tempOldQty = parseFloat($(this).val()); // sl đã nhập trong phiếu
                    }
                });
            }
            if (j == 2) { // sl đã trả trước đó
                $('input[type="hidden"].returnQty').each(function (index) {
                    if (index == i) {
                        tempReturnQty = parseFloat($(this).val()); // sl hiện có trong kho
                    }
                });
            }
            if (j == 3) { // sl trong kho
                $('input[type="hidden"].qtyWh').each(function (index) {
                    if (index == i) {
                        tempQtyWh = parseFloat($(this).val()); // sl hiện có trong kho
                    }
                });
            }
            if (j == 3) {
                $('input[type="number"].qty').each(function (index) {
                    if (index == i) {
                        returnQty = parseFloat($(this).val());
                        if(tempReturnQty == 0){
                            if (parseFloat($(this).val()) > parseFloat(tempOldQty)) { // sl trả > sl đã nhập
                                if (parseFloat($(this).val()) > parseFloat(tempQtyWh)) { // sl trả > kho
                                    data.push("Số lượng trả của " + name + " lớn hơn số lượng đã nhập và trong kho \n");
                                }else{ // chỉ > sl nhập
                                    data.push("Số lượng trả của " + name + " lớn hơn số lượng đã nhập \n");
                                }
                            }else if(parseFloat($(this).val()) < parseFloat(tempOldQty) && parseFloat($(this).val()) > parseFloat(tempQtyWh)){ // sl trả < sl nhập
                                // sl trả < sl phiếu nhưng > sl trong kho
                                data.push("Số lượng trả của " + name + " lớn hơn số lượng trong kho \n");
                            }else if(parseFloat($(this).val()) == parseFloat(tempOldQty) && parseFloat($(this).val()) > parseFloat(tempQtyWh)){
                                // sl trả = sl đã nhập nhưng > sl hiện có trong kho
                                data.push("Số lượng trả của " + name + " lớn hơn số lượng trong kho \n");
                            }
                        }else if(tempReturnQty > 0){
                            if((parseFloat($(this).val()) + tempReturnQty) > tempOldQty){ // sl trả sau + sl trả trước > sl nhập
                                data.push("Tổng sl lượng trả của " + name + " và sl trả trước đó không khớp với sl nhập \n");
                            }else{
                                if (parseFloat($(this).val()) > parseFloat(tempOldQty)) { // sl trả > sl đã nhập
                                    if (parseFloat($(this).val()) > parseFloat(tempQtyWh)) { // sl trả > kho
                                        data.push("Số lượng trả của " + name + " lớn hơn số lượng đã nhập và trong kho \n");
                                    }else{ // chỉ > sl nhập
                                        data.push("Số lượng trả của " + name + " lớn hơn số lượng đã nhập \n");
                                    }
                                }else if(parseFloat($(this).val()) < parseFloat(tempOldQty) && parseFloat($(this).val()) > parseFloat(tempQtyWh)){ // sl trả < sl nhập
                                    // sl trả < sl phiếu nhưng > sl trong kho
                                    data.push("Số lượng trả của " + name + " lớn hơn số lượng trong kho \n");
                                }else if(parseFloat($(this).val()) == parseFloat(tempOldQty) && parseFloat($(this).val()) > parseFloat(tempQtyWh)){
                                    // sl trả = sl đã nhập nhưng > sl hiện có trong kho
                                    data.push("Số lượng trả của " + name + " lớn hơn số lượng trong kho \n");
                                }
                            }
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
    var tempOldQty; let data = []; let arrSame = []; let name; let arrTempName = [];
    if (table.rows.length != 0) {
        for (var i = 0, row; row = table.rows[i]; i++) {
            for (var j = 0, col; col = row.cells[j]; j++) {
                if (j == 0) {
                    $('input[type="hidden"].nameMatDet').each(function (index) {
                        if (index == i) {
                            name = $(this).val();
                            arrSame.push(name);
                            arrTempName.push(name);
                        }
                    });
                }
                if (j == 1) {
                    $('input[type="hidden"].oldQty').each(function (index) {
                        if (index == i) {
                            tempOldQty = parseFloat($(this).val());
                        }
                    });
                }
                if (j == 2) {
                    $('input[type="number"].qty').each(function (index) {
                        if (index == i) {
                            if (parseFloat($(this).val()) > tempOldQty) {
                                data.push(name + " số lượng xuất > số lượng trong kho \n");
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
    const uniqueSet = new Set(arrSame);
    arrSame = [...uniqueSet];
    if(arrSame.length < arrTempName.length){
        data.push("Có nguyên liệu bị trùng trong bảng \n");
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
    let table = document.getElementById('tableDestroyWarehouseCook');
    var tempOldQty; let data = []; let arrSame = []; let name; let arrTempName = [];
    if (table.rows.length != 0) {
        for (var i = 0, row; row = table.rows[i]; i++) {
            for (var j = 0, col; col = row.cells[j]; j++) {
                if (j == 0) {
                    $('input[type="hidden"].nameMatDet').each(function (index) {
                        if (index == i) {
                            name = $(this).val();
                            arrSame.push(name);
                            arrTempName.push(name);
                        }
                    });
                }
                if (j == 1) {
                    $('input[type="hidden"].oldQty').each(function (index) {
                        if (index == i) {
                            tempOldQty = parseFloat($(this).val());
                        }
                    });
                }
                if (j == 2) {
                    $('input[type="number"].qty').each(function (index) {
                        if (index == i) {
                            if (parseFloat($(this).val()) > tempOldQty) {
                                data.push(name + " số lượng xuất > số lượng trong bếp \n");
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
    const uniqueSet = new Set(arrSame);
    arrSame = [...uniqueSet];
    if(arrSame.length < arrTempName.length){
        data.push("Có nguyên liệu bị trùng trong bảng \n");
    }

    if(data.length >0){
        alert(data);
        return false;
    }else{
        return true;
    }
}

function validateImportPlan() {
    let table = document.getElementById('bodyImportPlan');
    var temp = false;  var name; let data = []; let count = 0;
    if(table.rows.length !=0) {
        for (var i = 0, row; row = table.rows[i]; i++) {
            for (var j = 0, col; col = row.cells[j]; j++) {
                if (j == 0) {
                    $('input[type="checkbox"].idmatdetail').each(function (index) {
                        if (index == i) {
                            if($(this).is(":checked")){
                                temp = true;
                                count++;
                            }else{
                                temp = false;
                            }
                        }
                    });
                }
                if (j == 2) {
                    $('input[type="hidden"].namematdetail').each(function (index) {
                        if (index == i) {
                            name = $(this).val();
                        }
                    });
                }
                if(j == 2){
                    $('input[type="number"]').each(function (index) {
                        if(index == i ){
                            if(temp == true){
                                if($(this).val() == null || $(this).val() == ""){
                                    data.push("Không để trống số lượng mặt hàng " + name + "\n");
                                }
                            }
                        }
                    });
                }
            }
        }
    }else {
        data.push("Chưa có NVL để lập kế hoạch");
    }
    if (count == 0) {
        alert('Vui lòng chọn mặt hàng cho kế hoạch')
        return false;
    }else{
        if(data.length > 0){
            alert(data);
            return false;
        }else{
            return true;
        }
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

function checkPriceStoreDish() {
    let capitalPrice = document.getElementById('capitalPriceHidden').value;
    let salePrice = document.getElementById('salePrice').value;
    if (parseFloat(capitalPrice) > parseFloat(salePrice)) { // giá vốn > giá bán
        alert("Giá bán phải lớn hơn giá vốn");
        return false;
    }else{
        return true;
    }
}

function checkPriceUpdateDish(id) {
    let capitalPrice = document.getElementById('newCapitalPriceHidden'+ id).value;
    let salePrice = document.getElementById('newSalePriceUpdate'+id).value;
    if (parseFloat(capitalPrice) > parseFloat(salePrice)) { // giá vốn > giá bán
        alert("Giá bán phải lớn hơn giá vốn");
        return false;
    }else{
        return true;
    }
}
