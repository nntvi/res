$(document).ready(function(){
	$('#login').click(function(){
		var user = $('input[name="txtuser"]').val();
		var pass = $('input[name="txtpass"]').val();
		if(user =='' || pass ==''){
			$('.alert-login').html('<h3>Thông báo !</h3><p>Vui lòng điền đầy đủ thông tin đăng nhập</p>').fadeIn().delay(1000).fadeOut('slow');
		}else{
			$.ajax({
            type:'POST',
            url:'checklogin.php',
            data:{
            	'user':user,
            	'pass':pass
            },
            dataType:'html'
	    	}).done(function(ketqua){
	    		if(ketqua=='1'){
	    			window.location.replace("http://localhost/fasttrack/");
	    		}else{
	    			$('.alert-login').html('<h3>Thông báo !</h3><p>Tên đăng nhập hoặc mật khẩu không chính xác</p>').fadeIn().delay(1000).fadeOut('slow');
	    		}
	    	});
		}
	});
});