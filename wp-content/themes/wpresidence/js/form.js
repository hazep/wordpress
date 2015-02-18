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


    // jQuery('.out').click(function () {
    //  console.log('icicicicic');
    //  jQuery('.out').addClass('killIt');
    // });

    $('.out').click(function() {
console.log("okokok");
        $(this).parent().parent().parent().addClass('killIt');
    });

  $('#rangeslider2').slider({
    range: true,
    min: 0,
    max: 3000,
    values: [ 0, 3000 ],
    slide: function( event, ui ) {
      $('#rangeval2').html(ui.values[0]+" - "+ui.values[1]);
  
      $('#surface_low_widget').val(ui.values[0]);
      $('#surface_max_widget').val(ui.values[1]);
    }
  });
});


