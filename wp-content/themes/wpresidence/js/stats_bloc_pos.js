jQuery(document).ready(function(){
	var obj = null;
	jQuery('#svg_Stats').load(function(){
		obj = jQuery(jQuery(this).children().children());
		obj.attr('transform', "translate(75, 0)");
		// jQuery(window).resize(function(e){
		// 	e.preventDefault();
		// 	// jQuery('#svg_Stats').children().children().attr('transform', 'translate(75, 0)');
		// 	console.log(jQuery('#svg_Stats').children().children().attr('transform'));
		// 	e.stopPropagation();
		// });
	});
});