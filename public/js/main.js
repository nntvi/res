$(document).ready(function() {
    $("#type_object").change(function() {
        var id = $(this).val();
        // console.log(id);

        $.ajax({
            url: 'api/getOjbectToExport/' + id, //Trang xử lý
            method: 'GET',
            dataType: 'JSON',
            success: function(data) {
                $("#object").empty();
                data.forEach(function(c) {
                    $('#object').append($('<option>', { value: c.id, text: c.name }));
                });
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            }
        });
    });
});
