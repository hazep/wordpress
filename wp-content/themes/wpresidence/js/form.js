jQuery(document).ready(function(){
	var $ = jQuery;
	$('#login').click(function(e){
		e.preventDefault();
		show_login_form();
	});

	$('#register').click(function(e){
		e.preventDefault();
		show_register_form();
	});

});

