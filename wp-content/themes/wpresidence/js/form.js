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

$('.postCntSelector').addClass('postCnt2');
$('.postCntSelector').removeClass('postCnt');
});
$('.fa-bars').click(function(e){
console.log("bar");
$('.property_united').addClass('property_listing2');
$('.property_united').removeClass('property_listing_bars');

$('.postCntSelector').addClass('postCnt');
$('.postCntSelector').removeClass('postCnt2');
});



// function adding_remove_favorite(icon) {
//     "use strict";

//     var post_id, securitypass, ajaxurl;
//     post_id         =  icon.attr('data-postid');
//     securitypass    =  jQuery('#security-pass').val();
//     ajaxurl         =  ajaxcalls_vars.admin_url + 'admin-ajax.php';
  
//     if (parseInt(ajaxcalls_vars.userid, 10) === 0 ) {
//         show_login_form();
//     } else {
//         icon.toggleClass('icon-fav-off');
//         icon.toggleClass('icon-fav-on');

//         jQuery.ajax({
//             type: 'POST',
//             url: ajaxurl,
//             dataType: 'json',
//               data: {
//                   'action'            :   'wpestate_ajax_add_fav',
//                   'post_id'           :   post_id
//                   },
//            success: function (data) {          
//                if (data.added) {
//                     icon.removeClass('icon-fav-off').addClass('icon-fav-on');
//                } else {
//                     icon.removeClass('icon-fav-on').addClass('icon-fav-off');
//                }
//            },
//            error: function (errorThrown) {

//            }
//          });//end ajax
//     }// end login use
// }
});