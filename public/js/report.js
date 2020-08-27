$(document).ready(function () {
    // report dish
    $("#btnReportDish").click(function () {
        const dateStart = document.getElementById('dateStart').value;
        const dateEnd = document.getElementById('dateEnd').value;
        const idGroupMenu = document.getElementById('groupMenu').value;
        console.log(dateStart,dateEnd,idGroupMenu);

        $.ajax({
            url: 'ajax/report/dish/' + dateStart + '/' + dateEnd + '/' + idGroupMenu, //Trang xử lý
            method: 'GET',
            dataType: 'JSON',
            success: function (results) {
                console.log(results);
                
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            }
        });
    });
});
