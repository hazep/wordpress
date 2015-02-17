<?php
// Index Page
// Wp Estate Pack
get_header();
global $current_user;
global $feature_list_array;
global $propid ;
get_currentuserinfo();
$propid                     =   $post->ID;
$options                    =   wpestate_page_details($post->ID);
$gmap_lat                   =   esc_html( get_post_meta($post->ID, 'property_latitude', true));
$gmap_long                  =   esc_html( get_post_meta($post->ID, 'property_longitude', true));
$unit                       =   esc_html( get_option('wp_estate_measure_sys', '') );
$currency                   =   esc_html( get_option('wp_estate_currency_symbol', '') );
$use_floor_plans            =   intval( get_post_meta($post->ID, 'use_floor_plans', true) );      

if (function_exists('icl_translate') ){
  $where_currency             =   icl_translate('wpestate','wp_estate_where_currency_symbol', esc_html( get_option('wp_estate_where_currency_symbol', '') ) );
  $property_description_text  =   icl_translate('wpestate','wp_estate_property_description_text', esc_html( get_option('wp_estate_property_description_text') ) );
  $property_details_text      =   icl_translate('wpestate','wp_estate_property_details_text', esc_html( get_option('wp_estate_property_details_text') ) );
  $property_features_text     =   icl_translate('wpestate','wp_estate_property_features_text', esc_html( get_option('wp_estate_property_features_text') ) );
  $property_adr_text          =   icl_translate('wpestate','wp_estate_property_adr_text', esc_html( get_option('wp_estate_property_adr_text') ) );    
}else{
  $where_currency             =   esc_html( get_option('wp_estate_where_currency_symbol', '') );
  $property_description_text  =   esc_html( get_option('wp_estate_property_description_text') );
  $property_details_text      =   esc_html( get_option('wp_estate_property_details_text') );
  $property_features_text     =   esc_html( get_option('wp_estate_property_features_text') );
  $property_adr_text          =   stripslashes ( esc_html( get_option('wp_estate_property_adr_text') ) );
}


$agent_id                   =   '';
$content                    =   '';
$userID                     =   $current_user->ID;
$user_option                =   'favorites'.$userID;
$curent_fav                 =   get_option($user_option);
$favorite_class             =   'isnotfavorite'; 
$favorite_text              =   __('Add to favorite','wpestate');
$feature_list               =   esc_html( get_option('wp_estate_feature_list') );
$feature_list_array         =   explode( ',',$feature_list);
$pinteres                   =   array();
$property_city              =   get_the_term_list($post->ID, 'property_city', '', ', ', '') ;
$property_area              =   get_the_term_list($post->ID, 'property_area', '', ', ', '');
$property_category          =   get_the_term_list($post->ID, 'property_category', '', ', ', '') ;
$property_action            =   get_the_term_list($post->ID, 'property_action_category', '', ', ', '');   
$slider_size                =   'small';
$thumb_prop_face            =   wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'property_full');
$post_date                  =   get_the_date( 'd/m/Y', $post_id );
$author                     =   get_the_author();



if($curent_fav){
  if ( in_array ($post->ID,$curent_fav) ){
    $favorite_class =   'isfavorite';     
    $favorite_text  =   __('Favoris','wpestate');
  } 
}

if (has_post_thumbnail()){
  $pinterest = wp_get_attachment_image_src(get_post_thumbnail_id(),'property_full_map');
}


if($options['content_class']=='col-md-12'){
  $slider_size='full';
}
wp_register_script( 'theme-js', get_template_directory_uri() . '/js/theme.js', array( 'jquery') );
wp_enqueue_script('properties');

?>

<div class="square">
  <div class="marge">
    <div class="row background_annonce">
      <div class="col-md-2">
      </div>
      <div class=" col-md-8 background_annonce_content white">
        <?php get_template_part('templates/breadcrumbs'); ?>

        <?php get_template_part('templates/ajax_container'); ?>
        <?php
        while (have_posts()) : the_post();
        $price          =   intval   ( get_post_meta($post->ID, 'property_price', true) );
        $price_label    =   esc_html ( get_post_meta($post->ID, 'property_label', true) );  
        $image_id       =   get_post_thumbnail_id();
        $image_url      =   wp_get_attachment_image_src($image_id, 'property_full_map');
        $full_img       =   wp_get_attachment_image_src($image_id, 'full');
        $image_url      =   $image_url[0];
        $full_img       =   $full_img [0];     
        if ($price != 0) {
         $price = number_format($price);
         if ($where_currency == 'before') {
           $price = $currency . ' ' . $price;
         } else {
           $price = $price . ' ' . $currency;
         }           
       }else{
         $price='';
       }
       ?>

       <h1 class="entry-title entry-prop"><?php the_title(); ?></h1>   
       <span class="price_area"><?php print $price; ?><?php print ' '.$price_label; ?></span>
       <div class="single-content listing-content">

        <ul class="nav nav-tabs">
          <li role="presentation" id="slider_enable_slider" class="tabs active"><a href="#">PHOTOS</a></li>
          <li role="presentation" id="slider_enable_map" class="tabs"><a href="#">CARTE</a></li>
          <li role="presentation" id="slider_enable_street" class="tabs"><a href="#" id="stree-view">STREET VIEW</a></li>
        </ul>
        <div class="slider" id="photos">
          <?php get_template_part('templates/listingslider'); ?>
          
        </div>
        <div class="slider" id="carte">
          <?php get_template_part('templates/google_maps_property'); ?>
        </div>
        <!-- <div class="slider" id="streetview"></div> -->   

        <div class="panel-group property-panel" id="accordion_prop_addr">
          <div class="panel panel-default">
           <div class="panel-heading">
             <a data-toggle="collapse" data-parent="#accordion_prop_addr" href="#collapseTwo">
               <h4 class="panel-title">  
                 <?php if($property_adr_text!=''){
                   echo $property_adr_text;
                 } else{
                   _e('Property Address','wpestate');
                 }
                 ?>
               </h4>    
             </a>
           </div>
           <div id="collapseTwo" class="panel-collapse collapse in">
             <div class="panel-body">
               <?php print estate_listing_address($post->ID); ?>
             </div>
           </div>
         </div>            
       </div>     



       <div class="panel-group property-panel" id="accordion_prop_details">  
        <div class="panel panel-default">
          <div class="panel-heading">
           <?php                      
           if($property_details_text=='') {
             print'<a data-toggle="collapse" data-parent="#accordion_prop_details" href="#collapseOne"><h4 class="panel-title" id="prop_det">'.__('Property Details', 'wpestate').'  </h4></a>';
           }else{
             print'<a data-toggle="collapse" data-parent="#accordion_prop_details" href="#collapseOne"><h4 class="panel-title"  id="prop_det">'.$property_details_text.'  </h4></a>';
           }
           ?>
         </div>
         <div id="collapseOne" class="panel-collapse collapse in">
          <div class="panel-body">
            <?php print estate_listing_details($post->ID);?>
          </div>
        </div>
      </div>
    </div>

    <div class="notice_area"> 

<!--       <div class="property_categs">
        <?php print $property_category .' '.__('in','wpestate').' '.$property_action?>


      </div>   -->
      <span class="adres_area">
        <?php print esc_html( get_post_meta($post->ID, 'property_address', true) ). ', ' . $property_city.', '.$property_area; ?>
      </span>

      <div class="download_pdf">

      </div>
    </div> 

        <?php
          $content = get_the_content();
          $content = apply_filters('the_content', $content);
          $content = str_replace(']]>', ']]&gt;', $content);

          if($content!=''){                            
            print $content;     
          }

          // get_template_part ('/templates/download_pdf');

          ?>      
              <?php // floor plans
              if ( $use_floor_plans==1 ){ 
                ?>

                <div class="panel-group property-panel" id="accordion_prop_features">  
                  <div class="panel panel-default">
                    <div class="panel-heading">
                      <a data-toggle="collapse" data-parent="#accordion_prop_features" href="#collapseFour">
                        <?php
                        print '<h4 class="panel-title" id="prop_ame">'.__('Floor Plans', 'wpestate').'</h4>';
                        ?>
                      </a>
                    </div>

                    <div id="collapseFour" class="panel-collapse collapse in">
                      <div class="panel-body">
                        <?php print estate_floor_plan($post->ID); ?>
                      </div>
                    </div>
                  </div>
                </div>  
                <?php
              }
              ?>
              <?php 
              wp_reset_query();
              ?>  
              <?php
          endwhile; // end of the loop
          $show_compare=1;
          get_template_part ('/templates/agent_area');

          ?>
          <hr>
          <div id="add_favorites" class="<?php print $favorite_class;?> col-md-4" data-postid="<?php the_ID();?>"><?php echo $favorite_text;?></div>                 
          <div class="dislike col-md-4" data-postid="<?php the_ID();?>">Dislike</div>                 

          <div class="prop_social col-md-4">
            <div style="float:left">Share : </div>
            <a href="http://www.facebook.com/sharer.php?u=<?php the_permalink(); ?>&amp;t=<?php echo urlencode(get_the_title()); ?>" target="_blank" class="share_facebook"><i class="fa fa-facebook fa-2"></i></a>

            <a href="http://twitter.com/home?status=<?php echo urlencode(get_the_title() .' '. get_permalink()); ?>" class="share_tweet" target="_blank"><i class="fa fa-twitter fa-2"></i></a>
            <a href="https://plus.google.com/share?url=<?php the_permalink(); ?>" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" target="_blank" class="share_google"><i class="fa fa-google-plus fa-2"></i></a> 
            <?php if (isset($pinterest[0])){ ?>
            <a href="http://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&amp;media=<?php echo $pinterest[0];?>&amp;description=<?php echo urlencode(get_the_title()); ?>" target="_blank" class="share_pinterest"> <i class="fa fa-pinterest fa-2"></i> </a>      
            <?php } ?>
            <i class="fa fa-print" id="print_page" data-propid="<?php print $post->ID;?>"></i>
          </div>



        </div><!-- end single content -->
      </div><!-- end 9col container-->
      <div class="col-md-2 alignCenter">
        <br>
        <?php
        echo get_avatar( $author ) . " Par : " . $author;
        ?>
        <br>
        <a href="#" class="buttons">Contact</a>
        <hr>
        <a href="#" class="buttons">Afficher le numéro</a>
        <hr>
        Annonce parue le : <?php echo $post_date;?>
        <hr>
        <h2>Disponibilité</h2>
        <hr>
        <?php the_widget( 'WP_Widget_Calendar'); ?>

      </div>
    </div>  
  </div>
</div>
<script type="text/javascript">

  jQuery('.nav-tabs li').click(function(e) {

    var li = jQuery(this);

    var lien = li.children('a');
    var div = lien.text().toLowerCase().replace(" ", "");
    var cId = null;
    var count = 0;
    var cur_lat, cur_long, myLatLng;

    cur_lat     =   jQuery('#googleMap').attr('data-lat');
    cur_long    =   jQuery('#googleMap').attr('data-lng');
    console.log(cur_lat);
    console.log(cur_long);
    myLatLng    =   new google.maps.LatLng(cur_lat, cur_long);
    jQuery('.nav-tabs li').each(function() {
      if(count > 0)
        return;


      var liEach = jQuery(this);
      var c = liEach.attr('class');


      cId = liEach.children('a').text().toLowerCase().replace(" ", "");

      if(c.indexOf('active') > -1) {
        jQuery(this).attr('class' , 'tabs');
        li.attr('class', 'tabs active');
        count++;


      }
    })
    if(div === 'streetview') {
      toggleStreetView();
      count = 0;
      return ;
    }

    jQuery('#' + cId).css('display', 'none')
    jQuery('#' + div).css('display', 'block');
    if(div === 'carte')
      if(panorama.visible) {
        toggleStreetView();
      }
      else {
        google.maps.event.trigger(map, 'resize');
        map.setCenter(myLatLng);
        map.panBy(100,-150);
      }

      count = 0;

      e.preventDefault();
    });

</script>

<?php get_footer(); ?>