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

<<<<<<< HEAD
$(document).ready(function() {
    $("#searchMaterial").click(function() {
        var name = $("#nameMaterial").val();
        console.log(name);
        $.ajax({
            url: 'api/searchMaterialExport/' + name, //Trang xử lý
            method: 'GET',
            dataType: 'JSON',
            success: function(data) {
                data.detailMaterial.forEach(function(result) {
                    var all = '<tr id="row'+result.id+'">' +
                                '<td><input name="id_material_detail[]" value="'+result.id_material_detail+'" hidden>'+ result.material_detail.name +'</td>' +
                                '<td>'+
                                    '<div class="input-group m-bot15">' +
                                        '<input type="text" class="form-control" value="'+ result.qty +'" disabled>'+
                                        '<span class="input-group-addon btn-warning">'+ result.unit.name +'</span>'+
                                    '</div>'+
                                '</td>'+
                                '<td><input type="number" min="1" max="'+ result.qty +'" class="qty-export form-control" name="qtyExport[]" value=""></td>'+
                                '<td class="text-center">' +
                                '<input name="id_unit[]" value="'+result.unit.id+'" hidden>'+ result.unit.name +
                                    // '<select class="form-control m-bot15" name="id_unit[]">';
                                    //     data.units.forEach(function(unit) {
                                    //         all+= '<option value="'+ unit.id +'">'+unit.name +'</option>';
                                    //     });
                                    // all+= '</select>'+
                                '</td>' +
                                '<td>' +
                                    '<span class="input-group-btn" onclick="clickToRemove('+ result.id +')">'+
                                        '<button class="btn btn-danger" type="button">'+
                                            '<i class="fa fa-times" aria-hidden="true"></i>'+
                                        '</button>'+
                                    '</span>'+
                                '</td>'+
                            '</tr>';
                    $('.list').append(all);
                });
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            }
        });
    });
});
=======
// $(document).ready(function() {
//     $("#btnSearchMaterialDetail").click(function() {
//         var name = $('#nameMaterialDetail').val();
//         //console.log(name);

//         $.ajax({
//             url: 'api/searchMaterialDetail/' + name, //Trang xử lý
//             method: 'GET',
//             dataType: 'JSON',
//             success: function(data) {
//                 $("#searchMaterial").empty();
//                 data.forEach(function(c) {
//                     $('#searchMaterial');
//                 });
//             },
//             error: function(xhr, ajaxOptions, thrownError) {
//                 alert(xhr.status);
//                 alert(thrownError);
//             }
//         });
//     });
// });

>>>>>>> dc4e8fa9ea94cd99af62aaadcba0b4c50a8581ef
