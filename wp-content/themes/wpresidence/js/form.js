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


  $('#agent-register').click(function(e){
    e.preventDefault();
    show_agent_register_form();
  });

    // jQuery('.out').click(function () {
    //  console.log('icicicicic');
    //  jQuery('.out').addClass('killIt');
    // });

    // $('.out').click(function() {
    //     $(this).parent().parent().parent().addClass('killIt');
    // });

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

$('.fa-th').click(function(e){
console.log("grid");
$('.property_united').removeClass('property_listing2');
$('.property_united').addClass('property_listing_bars');
});
$('.fa-bars').click(function(e){
console.log("bar");
$('.property_united').addClass('property_listing2');
$('.property_united').removeClass('property_listing_bars');

});
});