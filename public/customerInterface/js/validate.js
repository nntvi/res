function validateBooking() {
    let arrError = [];
    let today = new Date().toJSON().slice(0, 10).replace(/-/g, '/');
    let bookingDay = document.getElementById('date').value;
    let phoneNumber = document.getElementById('phone').value;

    const vnf_regex = /((09|03|07|08|05)+([0-9]{8})\b)/g;

    if (vnf_regex.test(phoneNumber) == false) {
        arrError.push("Số điện thoại của bạn không đúng định dạng! \n");
    }
    if (Date.parse(bookingDay) < Date.parse(today)) {
        arrError.push("Ngày đặt bàn đã qua so với ngày hiện tại. Vui lòng nhập lại! \n");
    }

    if(arrError.length > 0){
        alert(arrError);
        return false;
    }else{
        alert("Bạn đã đặt bàn thành công. Cám ơn bạn đã quan tâm đến chúng tôi");
        return true;
    }
}
