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

var range = $('.graphiqueI'),
    value = $('.range-value'),
    val = value.attr('value');
    value.html(val);
    
    if (val >= 0 && val <= 50)
    {
      range.css({'top': '9%'});
    }
    else if (val >= 51 && val <= 90)
    {
      range.css({'top': '20%'});
    }
    else if (val >= 91 && val <= 150)
    {
      range.css({'top': '31%'});
    }
    else if (val >= 151 && val <= 230)
    {
      range.css({'top': '41.6%'});
    }
    else if (val >= 231 && val <= 330)
    {
      range.css({'top': '53%'});
    }
    else if (val >= 331 && val <= 450)
    {
      range.css({'top': '64%'});
    }
    else if (val > 450)
    {
      range.css({'top': '75%'});
    }

 var range2 = $('.graphiqueI2'),
     value2 = $('.range-value2'),
     val2 = value2.attr('value');
     value2.html(val2);

    if (val2 >= 0 && val2 <= 5)
    {
      range2.css({'top': '-5%'});
    }
    else if (val2 >= 6 && val2 <= 10)
    {
      range2.css({'top': '5.5%'});
    }
    else if (val2 >= 11 && val2 <= 20)
    {
      range2.css({'top': '16.5%'});
    }
    else if (val2 >= 21 && val2 <= 35)
    {
      range2.css({'top': '27.6%'});
    }
    else if (val2 >= 36 && val2 <= 55)
    {
      console.log(val2);
      range2.css({'top': '38.6%'});
    }
    else if (val2 >= 56 && val2 <= 80)
    {
      range2.css({'top': '49.6%'});
    }
    else if (val2 > 80)
    {
      range2.css({'top': '75%'});
    }
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
