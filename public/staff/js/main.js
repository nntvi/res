$(document).ready(function () {
    $('.idArea').click(function (e) {
        var a = $(this).val();
        console.log(a);

        var setting = {
            url: "http://localhost/res/public/api/getTableById/" + a,
            dataType: "JSON",
            method: 'GET',
            success: function (data, textStatus, jqXHR) {
                data.forEach(function(c) {
                    $('#table').append($('<li>', { value: c.id, text: c.name }));
                });
                console.log(data);

            }
        };
        $.ajax(setting);

    });

});
