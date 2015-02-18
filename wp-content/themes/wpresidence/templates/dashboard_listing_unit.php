<?php
global $edit_link;
global $token;
global $processor_link;
global $paid_submission_status;
global $submission_curency_status;
global $price_submission;
global $floor_link;


$post_id                    =   get_the_ID();
$preview                    =   wp_get_attachment_image_src(get_post_thumbnail_id($post_id), 'property_listings');
$edit_link                  =   add_query_arg( 'listing_edit', $post_id, $edit_link ) ;
$floor_link                 =   add_query_arg( 'floor_edit', $post_id, $floor_link ) ;
$post_status                =   get_post_status($post_id);
$property_address           =   esc_html ( get_post_meta($post_id, 'property_address', true) );
$property_city              =  get_post_meta($post_id, 'property_city', true) ;
$property_category          =   get_the_term_list($post_id, 'property_category', '', ', ', '');
$property_action_category   =   get_the_term_list($post_id, 'property_action_category', '', ', ', '');
$price_label                =   esc_html ( get_post_meta($post_id, 'property_label', true) );
$price                      =   intval( get_post_meta($post->ID, 'property_price', true) );
$currency                   =   esc_html( get_option('wp_estate_submission_curency', '') );
$currency_title             =   esc_html( get_option('wp_estate_currency_symbol', '') );
$where_currency             =   esc_html( get_option('wp_estate_where_currency_symbol', '') );
$property_size                  =   intval   ( get_post_meta($post_id, 'property_size', true) ); 
$property_rooms                 =   intval   ( get_post_meta($post_id, 'property_rooms', true) );
$status                     =   '';
$link                       =   '';
$pay_status                 =   '';
$is_pay_status              =   '';
$paid_submission_status     =   esc_html ( get_option('wp_estate_paid_submission','') );
$price_submission           =   floatval( get_option('wp_estate_price_submission','') );
$price_featured_submission  =   floatval( get_option('wp_estate_price_featured_submission',''));
$property_address               =  get_post_meta($post_id, 'property_address', true);
$property_zip                   =   get_post_meta($post_id, 'property_zip', true);
$property_title                 =   get_post_meta($post->ID, 'title', true);

if ($price != 0) {
   $price = number_format($price);
   
   if ($where_currency != 'before') {
       $price_title =   $currency_title . ' ' . $price;
       $price       =   $currency . ' ' . $price;
   } else {
       $price_title = $price . ' ' . '€';
       $price       = $price . ' ' . $currency;
     
   }
}else{
    $price='';
    $price_title='';
}



if($post_status=='expired'){ 
    $status='<span class="label label-danger">'.__('Expired','wpestate').'</span>';
}else if($post_status=='publish'){ 
    $link=get_permalink();
    $status='<span class="label label-success">'.__('Published','wpestate').'</span>';
}else{
    $link='';
    $status='<span class="label label-info">'.__('Waiting for approval','wpestate').'</span>';
}


if ($paid_submission_status=='per listing'){
    $pay_status    = get_post_meta(get_the_ID(), 'pay_status', true);
    if($pay_status=='paid'){
        $is_pay_status.='<span class="label label-success">'.__('Paid','wpestate').'</span>';
    }
    if($pay_status=='not paid'){
        $is_pay_status.='<span class="label label-info">'.__('Not Paid','wpestate').'</span>';
    }
}
$featured  = intval  ( get_post_meta($post->ID, 'prop_featured', true) );
    
?>





<div class="col-md-6 bloc_TIO marg_l responsivBlocs">
   <div class="blog_listing_image blog_listing_image_tio">
       <?php
        if (has_post_thumbnail($post_id)){
        ?>
        <img  src="<?php  print $preview[0]; ?>"  alt="slider-thumb" class="blog_listing_image_tio"/>
        <?php 
        } 
        ?>
   </div>       
   <div class="pCnt">
    <h4 class="<?php echo (strlen($post->post_title) > 13 ? 'listing_title_TIO_14' : 'listing_title_TIO'); ?>"><?php the_title(); ?></h4>
        <div>
            <?php print '<h4 class="price_TIO"> '. preg_replace('#\,#', ' ', $price_title).'</h4>';?>
        </div>
        <div class="listing_infos_ann_TIO">
            <ul class="list_info">
                <li class="li_TIO"><?php print $property_rooms. ' pièces';?></li>
                <li class="li_TIO"><?php print $property_size. ' m²';?></li>
                <li class="li_TIO"><?php print $property_address;?></li>
                <li class="li_TIO"><?php print $property_zip; if($property_city) print ',' . $property_city; else print '';?></li>
            </ul>
        </div>
    </div>
    <?php print '<a class="button_profil" href="'.$link.'">';
                    ?>
                    <span class="spPropertyInfo">+ de détails</span>
                    <?php print '</a>'; ?>
                </div>