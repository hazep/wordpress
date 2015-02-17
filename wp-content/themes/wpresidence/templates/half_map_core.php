<?php
global $prop_selection ;
global $post;
global $is_col_md_12;
$args = wpestate_get_select_arguments();
$action_select_list         =   wpestate_get_action_select_list($args);
$categ_select_list          =   wpestate_get_category_select_list($args);
$select_city_list           =   wpestate_get_city_select_list($args); 
$select_area_list           =   wpestate_get_area_select_list($args);
$select_county_state_list   =   wpestate_get_county_state_select_list($args);
$top_bar_style              =   "";    
if(esc_html ( get_option('wp_estate_show_top_bar_user_menu','') )=="no"){
    $top_bar_style              =   ' half_no_top_bar ';          
}
?>

<div class="row">
    <div  id="google_map_prop_list_wrapper" class="google_map_prop_list <?php echo $top_bar_style?>"  >
        <?php get_template_part('templates/google_maps_base'); ?>
    </div>    
    
    
    <div id="google_map_prop_list_sidebar" class="<?php echo $top_bar_style?>">
        <?php 
        $show_adv_search_general    =   get_option('wp_estate_show_adv_search_general','');
        if($show_adv_search_general ==  'yes' ){
            $show_mobile=1;
            print '<div class="search_wrapper" id="search_wrapper" >  ';
                include(locate_template('templates/advanced_search_type_half.php'));
            print '</div>';
        }
        ?>
        
        
   
        <?php if (esc_html( get_post_meta($post->ID, 'page_show_title', true) ) == 'yes') { ?>
              <h1 class="entry-title title_prop"><?php the_title(); ?></h1>
        <?php } ?>
              
              
        <?php  get_template_part('templates/compare_list'); ?>    
                        <?php  get_template_part('templates/spiner'); ?> 
        <div id="listing_ajax_container" class="ajax-map"> 
            
                  

           <?php
            $counter = 0;

            $is_col_md_12=1;    
            if ( $prop_selection->have_posts() ) {
                while ($prop_selection->have_posts()): $prop_selection->the_post(); 
                    get_template_part('templates/property_unit_half');
                endwhile;                
            }else{
                print '<h4>'.__('You don\'t have any properties yet!','wpestate').'</h4>';
            }

            wp_reset_query();               
        ?>
        </div>
        <!-- Listings Ends  here --> 
        
        
        <div class="half-pagination">
        <?php kriesi_pagination($prop_selection->max_num_pages, $range =2); ?>       
        </div>    
    </div><!-- end 8col container-->

</div>  