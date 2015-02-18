<?php
global $curent_fav;
global $currency;
global $where_currency;
global $show_compare;
global $show_compare_only;
global $show_remove_fav;
global $options;
global $isdashabord;
global $align;
global $align_class;
global $is_shortcode;
global $row_number_col;

$pinterest          =   '';
$previe             =   '';
$compare            =   '';
$extra              =   '';
$property_size      =   '';
$property_bathrooms =   '';
$property_rooms     =   '';
$property_address   =   '';
$measure_sys        =   '';

$col_class  =   'col-md-6';
$col_org    =   4;
if($options['content_class']=='col-md-12' && $show_remove_fav!=1){
    $col_class  =   'col-md-3';
    $col_org    =   3;
}
// if template is vertical
if($align=='col-md-12'){
   $col_class  =  'col-md-12';
   $col_org    =  12;
}

if(isset($is_shortcode) && $is_shortcode==1 ){
    $col_class='col-md-'.$row_number_col.' shortcode-col';
     //$col_class=' shortcode-col';
}

$link           =   get_permalink();
$preview        =   array();
$preview[0]     =   '';
$favorite_class =   'icon-fav-off';
$fav_mes        =   __('add to favorites','wpestate');
if($curent_fav){
    if ( in_array ($post->ID,$curent_fav) ){
        $favorite_class =   'icon-fav-on';   
        $fav_mes        =   __('remove from favorites','wpestate');
    } 
}

?>  



<div class="<?php echo $col_class;?> listing_wrapper responsivBloc" data-org="<?php echo $col_org;?>" > 
    <div class="property_listing2" data-link="<?php echo $link;?>">
        <?php
        if ( has_post_thumbnail() ):
            $pinterest = wp_get_attachment_image_src(get_post_thumbnail_id(), 'property_full_map');
        $preview   = wp_get_attachment_image_src(get_post_thumbnail_id(), 'property_listings');
        $compare   = wp_get_attachment_image_src(get_post_thumbnail_id(), 'slider_thumb');
        $extra= array(
            'data-original' =>  $preview[0],
            'class'         =>  'lazyload img-responsive imgClass',    
            );



        $thumb_prop             =   get_the_post_thumbnail($post->ID, 'property_listings',$extra);
        $prop_stat              =   esc_html( get_post_meta($post->ID, 'property_status', true) );
        $featured               =   intval  ( get_post_meta($post->ID, 'prop_featured', true) );
        $property_rooms         =   get_post_meta($post->ID, 'property_rooms', true);
        if($property_rooms!=''){
            $property_rooms=intval($property_rooms);
        }

        $property_size          =   get_post_meta($post->ID, 'property_size', true) ;
        if($property_size){
            $property_size=number_format(intval($property_size));
        }




        $measure_sys            = esc_html ( get_option('wp_estate_measure_sys','') ); 

        print   '<div class="listing-unit-img-wrapper">';
        print   '<a href="'.$link.'">'.$thumb_prop.'</a>';
        print   '<div class="listing-cover"></div>
        <span class="listing-cover-plus">';

            ?>
            <span id="add" class="icon-fav <?php echo $favorite_class;?>" data-original-title="<?php print $fav_mes; ?>" data-postid="<?php echo $post->ID; ?>"></span>
            <span id="out" class="out"></span>
            <?php
            print   '</span>';

            // if($featured==1){
            //     print '<div class="featured_div"></div>';
            // }
            print   '</div>';
            if ($prop_stat != 'normal') {
                $ribbon_class = str_replace(' ', '-', $prop_stat);
                if (function_exists('icl_translate') ){
                    $prop_stat     =   icl_translate('wpestate','wp_estate_property_status'.$prop_stat, $prop_stat );
                }
                print'<a href="' . $link . '"><div class="ribbon-wrapper-default ribbon-wrapper-' . $ribbon_class . '"><div class="ribbon-inside ' . $ribbon_class . '">' . $prop_stat . '</div></div></a>';
            }

            endif;


            $price = intval( get_post_meta($post->ID, 'property_price', true) );
            if ($price != 0) {
             $price = number_format($price);

             if ($where_currency == 'before') {
                 $price = $currency . ' ' . $price;
             } else {
                 $price = $price . ' ' . '€';
             }
         }else{
            $price='';
        }

        $property_address   =   esc_html ( get_post_meta($post->ID, 'property_address', true) );
        $property_city      =   get_the_term_list($post->ID, 'property_city', '', ', ', '') ;
        $property_area      =   get_the_term_list($post->ID, 'property_area', '', ', ', '');
        $property_category          =   get_the_term_list($post->ID, 'property_category', '', ', ', '');
        $price_label        =   '<span class="price_label">'.esc_html ( get_post_meta($post->ID, 'property_label', true) ).'</span>';

        if ( isset($show_remove_fav) && $show_remove_fav==1 ) {
            print '<span class="icon-fav icon-fav-on-remove" data-postid="'.$post->ID.'"> '.$fav_mes.'</span>';
        }
        ?>

        <div class="postCnt">
            <h4><a href="<?php the_permalink(); ?>"><?php the_title();?></a> </h4>
            <div class="property_location"><?php // print $property_area.', '.$property_city; ?>
                <?php 
                if ($price!='')
                {
                    print '<bold><span class="infosis">'.$price.'</span></bold>' ;
                }
                ?>
                <ul class="infoUl">
                    <?php
                    if($property_rooms!=''){
                        print ' <li>'.$property_rooms.'pièces</li>';
                    }
                    if($property_size!=''){
                        print ' <li class="infosi">'.$property_size.' m<sup>2</sup></li>';
                    }
                    if($property_address!=''){
                        print '<li class="info">'.$property_address.'</li>';
                    }
                    if($property_city!=''){
                        print '<li class="info">'.$property_city.'</li>';
                    }
                    ?>
                </ul>
                <?php
                    if( $show_compare_only!='no') { ?>
                    <?php print '<a class="buttons valignBottom" href="'.$link.'">';
                    ?>
                    <span class="spPropertyInfo">+ de détails</span>
                    <?php print '</a>'; ?>
                    
                    <?php  }
                    ?>
            </div>



            <div class="listing_prop_details">

            </div>

            <?php
            if( !isset($show_compare) || $show_compare!=0  ){ ?>
            <div class="listing_actions">

                <div class="share_unit">
                    <a href="http://www.facebook.com/sharer.php?u=<?php the_permalink(); ?>&amp;t=<?php echo urlencode(get_the_title()); ?>" target="_blank" class="social_facebook"></a>
                    <a href="http://twitter.com/home?status=<?php echo urlencode(get_the_title().' '.the_permalink()); ?>" class="social_tweet" target="_blank"></a>
                    <a href="https://plus.google.com/share?url=<?php the_permalink(); ?>" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" target="_blank" class="social_google"></a> 
                    <a href="http://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&amp;media=<?php if (isset( $pinterest[0])){ echo $pinterest[0]; }?>&amp;description=<?php echo urlencode(get_the_title()); ?>" target="_blank" class="social_pinterest"></a>
                    <span class="compare-action" data-original-title="<?php  _e('compare','wpestate');?>" data-pimage="<?php if( isset($compare[0])){echo $compare[0];} ?>" data-pid="<?php echo $post->ID; ?>"></span>

                </div>
            </div>
            <?php
        } 
        ?>
    </div>
</div>
</div>