$(document).ready(function(){
	cms_del_pro_order();
	$('.ft-tabs .tabs-list li a').click(function(){
		$('.ft-tabs .tabs-list li a').removeClass('active');
		$(this).addClass('active');
		var tab = $(this).attr('data');
		if(tab=='listtable'){
			$('#table-list').attr('hidden',false);
			$('#table-list').load('table.php');
			$('#pos').attr('hidden',true);
		}else{
			$('#table-list').attr('hidden',true);
			$('#pos').attr('hidden',false);
		}
	});
	$('#search-menu').keyup(function(){
		var menuname = $(this).val();
		if(menuname==''){
			$('#result-menu-post').css('display','none');
		}
		else{
			$param = {
			type:'POST',
			url:'searchmenu.php',
			dataType:'html',
			data:
			{
				menuname:menuname
			},
			callback: function(data){
					$('#result-menu-post').html(data);
					$('#result-menu-post').css('display','block');
				}
			}
			ajax_adapter($param);
		}
	});
	$('.customer-pay').keyup(function(){
		var customer_pay;
		if($(this).val()==''){
			customer_pay=0;
		}else{
			customer_pay = cms_decode_currency_format($(this).val());
		}
		var total_pay = cms_decode_currency_format($('.total-pay').val());
		var debt = customer_pay - total_pay;
		$(this).val(cms_encode_currency_format(customer_pay));
		$('.excess-cash').html(cms_encode_currency_format(debt));
	});
	$('#customer-infor').keyup(function(){
		var customer = $(this).val();
		if(customer==''){
			$('#result-customer').css('display','none');
		}else{
			$param = {
			type:'POST',
			url:'searchcustomer.php',
			dataType:'html',
			data:
			{
				customer:customer
			},
			callback: function(data){
				$('#result-customer').html(data);
				$('#result-customer').css('display','block');
				}
			}
			ajax_adapter($param);
		}
	});
	$('.del-customer').click(function(){
		$('#customer-infor').val('');
		$('#customer-infor').attr('disabled',false);
		$('#customer-infor').removeAttr('data-id');
		$(this).html('');
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
function cms_load_pos($id_table){
	$param={
		type:'POST',
		url:'cms_load_pos.php',
		dataType:'html',
		data:
		{
			id_table:$id_table
		},
		callback: function(data){
			$('#pro_search_append').html(data);
			cms_load_infor_order();
		}
	}
	ajax_adapter($param);
	$('#table-list').attr('hidden',true);
	$('#pos').attr('hidden',false);
	$('.table-infor').html('<strong data-id="'+$id_table+'" id="table_id">Bàn '+$id_table+'</strong>');
}
function cms_load_cate($id_cate){
	var $param={
		type:'POST',
		url:'cms_load_cate.php',
		dataType:'html',
		data:
			{
				id_cate:$id_cate
			},
			callback: function(data){
				$('.product-list-content').html(data);
			}
		}
		ajax_adapter($param);
}
function cms_select_menu($id_menu){
	if($('#pro_search_append tr').length != 0){
		var flag= 0;
		$('#pro_search_append tr').each(function(){
			var id_temp = $(this).attr('data-id');
			if($id_menu==id_temp){
				var value_input = $(this).find('input.quantity-product-oders');
				value_input.val(parseInt(value_input.val()) + 1);
				flag = 1;
				cms_load_infor_order();
			}
		});
		if(flag==0){
			var $param={
				type:'POST',
				url:'appendproduct.php',
				dataType:'html',
					data:
						{
							id_menu:$id_menu
						},
						callback: function(data){
							$('#pro_search_append').append(data);
							cms_load_infor_order();
						}
				}
			ajax_adapter($param);
		}
	}else{
		var $param={
		type:'POST',
		url:'appendproduct.php',
		dataType:'html',
		data:
			{
				id_menu:$id_menu
			},
			callback: function(data){
				$('#pro_search_append').append(data);
				cms_load_infor_order();
			}
		}
		ajax_adapter($param);
	}
}
function cms_select_customer($idcustomer){
	var customer_name=$('li.data-cus-'+$idcustomer).text();
	$('#customer-infor').val(customer_name);
	$('#customer-infor').attr('data-id',$idcustomer);
	$('.del-customer').html('<i class="fa fa-minus-circle" aria-hidden="true"></i>');
	$('#customer-infor').attr('disabled',true);
	$('#result-customer').css('display','none');
}
function cms_decode_currency_format(obs) {
    if (obs == '')
        return 0;
    else
        return parseInt(obs.replace(/,/g, ''));
}
function cms_encode_currency_format(obs) {
    return obs.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}
function cms_load_infor_order(){
	var $total_money=0;
	$('tbody#pro_search_append tr').each(function () {
        $quantity_product = $(this).find('input.quantity-product-oders').val();
        $price = cms_decode_currency_format($(this).find('input.price-order').val());
        $total = $price * $quantity_product;
        $total_money += $total;
        $(this).find('td.total-money').html(cms_encode_currency_format($total));
        $('input.total-pay').val(cms_encode_currency_format($total_money));
    });
}
function cms_del_pro_order(){
    $('body').on('click', '.del-pro-order', function () {
        $(this).parents('tr').remove();
        cms_load_infor_order();
    });
}
function cms_save_table(){
	if($('tbody#pro_search_append tr').length !=0){
		var customer_id = $('#customer-infor').attr('data-id');
		var table_id = $('#table_id').attr('data-id');
		var note = $('#note-order').val();
		var customer_id = typeof $('#customer-infor').attr('data-id') === 'undefined' ? 0 : $('#customer-infor').attr('data-id');
		var customer_pay = cms_decode_currency_format($('input.total-pay').val());
		var detail = [];
        $('tbody#pro_search_append tr').each(function () {
            var id = $(this).attr('data-id');
            var quantity = $(this).find('input.quantity-product-oders').val();
            var price = cms_decode_currency_format($(this).find('input.price-order').val());
            detail.push(
                {id: id, quantity: quantity, price: price}
            );
        });
        var $data ={
        	'data':{
	        	'table_id':table_id,
	        	'customer_id':customer_id,
	        	'note':note,
	        	'customer_pay':customer_pay,
	        	'detai_oder':detail
        	}
        }
        var $param={
		type:'POST',
		url:'paymentbill.php',
		dataType:'html',
		data:$data,
		callback: function(data){
				var mywindow = window.open('', 'In hóa đơn', 'height=500,width=1000');
			    if (mywindow == null) {
			        alert('Trình duyệt đã ngăn không cho phần mềm In. Vui lòng mở khóa hiển thị In ở góc phải phía trên của trình duyệt');
			    } else {
			        mywindow.document.writeln(data);
			        mywindow.document.close();
			        mywindow.focus();
			        mywindow.print();
			        mywindow.close();
			        location.reload();
				}
			}
		}
		ajax_adapter($param);

	}else{
		$('.alert-login').html('<h3>Thông báo !</h3><p>Vui lòng chọn ít nhất 1 sản phẩm trước khi lưu</p>').fadeIn().delay(1000).fadeOut('slow');
	}
}
function cms_save_oder(){
	if($('tbody#pro_search_append tr').length !=0){
		var customer_id = $('#customer-infor').attr('data-id');
		var table_id = $('#table_id').attr('data-id');
		var note = $('#note-order').val();
		var customer_id = typeof $('#customer-infor').attr('data-id') === 'undefined' ? 0 : $('#customer-infor').attr('data-id');
		var customer_pay = cms_decode_currency_format($('input.total-pay').val());
		var detail = [];
        $('tbody#pro_search_append tr').each(function () {
            var id = $(this).attr('data-id');
            var quantity = $(this).find('input.quantity-product-oders').val();
            var price = cms_decode_currency_format($(this).find('input.price-order').val());
            detail.push(
                {id: id, quantity: quantity, price: price}
            );
        });
        var $data ={
        	'data':{
	        	'table_id':table_id,
	        	'customer_id':customer_id,
	        	'note':note,
	        	'customer_pay':customer_pay,
	        	'detai_oder':detail
        	}
        }
        var $param={
		type:'POST',
		url:'savebill.php',
		dataType:'html',
		data:$data,
		callback: function(data){
				$('.alert-login').html(data).fadeIn().delay(1000).fadeOut('slow').css('background','#599130');
			}
		}
		ajax_adapter($param);

	}else{
		$('.alert-login').html('<h3>Thông báo !</h3><p>Vui lòng chọn ít nhất 1 sản phẩm trước khi lưu</p>').fadeIn().delay(1000).fadeOut('slow');
	}
}