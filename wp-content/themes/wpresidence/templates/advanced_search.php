<?php
global $adv_search_type;
$adv_submit             =   get_adv_search_link();
//  show cities or areas that are empty ?
$args = wpestate_get_select_arguments();
$action_select_list         =   wpestate_get_action_select_list($args);
$categ_select_list          =   wpestate_get_category_select_list($args);
$select_city_list           =   wpestate_get_city_select_list($args); 
$select_area_list           =   wpestate_get_area_select_list($args);
$select_county_state_list   =   wpestate_get_county_state_select_list($args);
?>

<div class="search_wrapper" id="search_wrapper" >       
   
<?php  
    if ( isset($post->ID) && is_page($post->ID) &&  basename( get_page_template() ) == 'contact_page.php' ) {
        //
    }else {
       
        $adv_search_type        =   get_option('wp_estate_adv_search_type','');
        
        if ($adv_search_type==1){
            include(locate_template('templates/advanced_search_type1.php'));
        }else{
     
            if( !is_tax() && basename ( get_page_template() )  !== 'advanced_search_results.php'){
                include(locate_template('templates/advanced_search_type2.php')); 
            }else{
                print '<div class="adv_results_wrapper">';
                include(locate_template('templates/advanced_search_type1.php')); 
                print '<div class="adv-helper"></div>';
                print '</div>';       
            }
        }
        
    }    
?>

</div><!-- end search wrapper--> 
<!-- END SEARCH CODE -->