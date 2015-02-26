// jQuery(document).ready(function($)
// {
// 	var img = $('.vc_single_image-img');
// 	var img_directory_uri = object.templateUri + '/img/assetsImmo/Calque-46.png';
// 	img.hover
// 	(
// 		function() 
// 		{
// 			$('.vc_single_image-wrapper').css("position","relative");
// 			$(this).addClass("img-fade");
// 			$(this).after("<img src="+ img_directory_uri +' class="imgonhover">');
// 		}, function() 
// 		{
// 			$( this ).removeClass( "img-fade" );
// 			$('.imgonhover').remove();
// 			//$('.imgonhover').remove();

// 		}
// 	);
// });

jQuery(document).ready(function(){
	jQuery('.vc_single_image-wrapper').mouseenter(function(){
		jQuery(this).prepend("<div class='hoverinus'></div>");
	})
	jQuery('.vc_single_image-wrapper').mouseleave(function(){
		jQuery('.hoverinus').remove();
	})
});