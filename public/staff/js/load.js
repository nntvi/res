$(document).ready(function(){
	$('.result-content').load('dashboard.php');
	$('#sidebar ul li a').click(function(){
		var url = $(this).attr('href');
		$('#sidebar ul li a').removeClass('active');
		$(this).addClass('active');
		$('.result-content').load(''+url+'.php');
		return false;
	});
	$('#searchproduct').keyup(function(){
		var key = $(this).val();
		$param = {
				type:'POST',
				url:'backend/searchproduct.php',
				data:{
					key:key
				},
				dataType:'html',
				callback:function(result){
					alert(result);
				}
			}
		ajax_adapter($param);
	});
});
function ajax_adapter($param){
	$.ajax({
            type:$param.type,
            url:$param.url,
            data:$param.data,
            dataType:$param.dataType,
            async:true,
            success:$param.callback
    });
}
function cms_addprodcut(){
	alert("ok");
}
function cms_addcateproduct(){
	var name = $('input[name="txtcategory"]').val();
	$param = {
		type:'POST',
		url:'controller/addcategorymenu.php',
		data:{
			name:name
		},
		dataType:'html',
		callback:function(result){
			if(result=='1'){
				$('.result-content').load('product.php');
			}else{

			}
		}
	}
	ajax_adapter($param);

}
function tab_click_act(act){
	$('.act').not(this).hide();
	$('.'+act+'-act').show();
}
function cms_load_importware(){
	$('.result-content').load('importwarehosing.php');
}
function cms_load_stockimport(){
	$('.result-content').load('stockimport.php');
}
function cms_cancel_import(){
	$('.result-content').load('warehousing.php');
}
function cms_add_table(){
	var tablename = $('input[name="tablename"]').val();
	var idarea = $('select[name="areas-id"]').val();
	if(tablename==''){
		$('.alert-login').html('<h3>Thông báo !</h3><p>Tên phòng/bàn không để trống</p>').fadeIn().delay(1000).fadeOut('slow');
	}else{
		$param = {
			type:'POST',
			url:'backend/addtable.php',
			data:{
				tablename:tablename,
				idarea:idarea
			},
			dataType:'html',
			callback:function(result){
				if(result=='0'){
					$('.alert-login').html('<h3>Thông báo !</h3><p>Tên bàn đã tồn tại</p>').fadeIn().delay(1000).fadeOut('slow');
				}else{
					$('.alert-login').html('<h3>Thông báo !</h3><p>Thêm thành công</p>').fadeIn().delay(1000).fadeOut('slow').css('background','#37822A');
					$('#ModalAddTable').modal('hide');
					$('.result-content').load('table.php');
				}
			}
		}
	ajax_adapter($param);
	}
}
function cms_add_grouptable(){
	var namegroup = $('input[name="namgrouptable"]').val();
	if(namegroup==''){
		$('.alert-login').html('<h3>Thông báo !</h3><p>Tên nhóm không để trống</p>').fadeIn().delay(1000).fadeOut('slow');
	}else{
		$param = {
			type:'POST',
			url:'backend/addgrouptable.php',
			data:{
				namegroup:namegroup
			},
			dataType:'html',
			callback:function(result){
				if(result=='0'){
					$('.alert-login').html('<h3>Thông báo !</h3><p>Tên nhóm đã tồn tại</p>').fadeIn().delay(1000).fadeOut('slow');
				}else{
					$('.alert-login').html('<h3>Thông báo !</h3><p>Thêm thành công</p>').fadeIn().delay(1000).fadeOut('slow').css('background','#37822A');
					$('#ModalAddGroup').modal('hide');
				}
			}
		}
	ajax_adapter($param);
	}
}
function cms_pagination($current_page){
	$param = {
			type:'POST',
			url:'backend/pagination-table.php',
			data:{
				current_page:$current_page,
			},
			dataType:'html',
			callback:function(result){
				$('#load_pagination_table').html(result);
			}
		}
	ajax_adapter($param);
}
function cms_add_customer(){
	var codecus = $('input[name="txtcodecus"]').val();
	var namecus = $('input[name="txtnamecus"]').val();
	var phonecus = $('input[name="txtphonecus"]').val();
	var emailcus = $('input[name="txtemailcus"]').val();
	var addresscus = $('input[name="txtaddrescus"]').val();
	var notecus = $('textarea[name=txtnotecus]').val();
	if(namecus==''){
		$('.alert-login').html('<h3>Thông báo !</h3><p>Tên khách hàng không được để trống</p>').fadeIn().delay(1000).fadeOut('slow');
	}else{
		$param = {
			type:'POST',
			url:'backend/addcustomer.php',
			data:{
				codecus:codecus,
				namecus:namecus,
				phonecus:phonecus,
				emailcus:emailcus,
				addresscus:addresscus,
				notecus:notecus
			},
			dataType:'html',
			callback:function(result){
				if(result=='1'){
					$('.alert-login').html('<h3>Thông báo !</h3><p>Thêm thành công</p>').fadeIn().delay(1000).fadeOut('slow').css('background','#37822A');
					$('#AddCustomerModal').model('hide');
					$('.result-content').load('customer.php');
				}
				else{
					$('.alert-login').html('<h3>Thông báo !</h3><p>Lỗi</p>').fadeIn().delay(1000).fadeOut('slow');
				}
			}
		}
		ajax_adapter($param);
	}
}