<?php
$adv_submit             =   get_adv_search_link();

//  show cities or areas that are empty ?
$args = wpestate_get_select_arguments();

$action_select_list =   wpestate_get_action_select_list($args);
$categ_select_list  =   wpestate_get_category_select_list($args);
$select_city_list   =   wpestate_get_city_select_list($args); 
$select_area_list   =   wpestate_get_area_select_list($args);
$select_county_state_list   =   wpestate_get_county_state_select_list($args);
$home_small_map_status              =   esc_html ( get_option('wp_estate_home_small_map','') );
$show_adv_search_map_close          =   esc_html ( get_option('wp_estate_show_adv_search_map_close','') );
$class                              =   'hidden';
$class_close                        =   '';

?>


<div id="adv-search-header-mobile"> 
    <i class="fa fa-search"></i>  
    <?php _e('Advanced Search','wpestate');?> 
</div>   




<div class="adv-search-mobile"  id="adv-search-mobile"> 
   
    <form role="search" method="get"   action="<?php print $adv_submit; ?>" >
         
        <?php
        $adv_search_type        =   get_option('wp_estate_adv_search_type','');
        if ( $adv_search_type==1 ){       
            ?>
            <?php
            $custom_advanced_search= get_option('wp_estate_custom_advanced_search','');
            $adv_search_what        =   get_option('wp_estate_adv_search_what','');
            if ( $custom_advanced_search == 'yes'){
                foreach($adv_search_what as $key=>$search_field){
                    wpestate_show_search_field_mobile($search_field,$action_select_list,$categ_select_list,$select_city_list,$select_area_list,$key,$select_county_state_list);
                }
            }else{
            ?>


            <div class="dropdown form-control" >
                <div data-toggle="dropdown" id="adv_actions_mobile" class="filter_menu_trigger" data-value="all"> <?php _e('All Actions','wpestate');?> <span class="caret caret_filter"></span> </div>           
                <input type="hidden" name="filter_search_action[]" value="">
                <ul  class="dropdown-menu filter_menu" role="menu" aria-labelledby="adv_actions_mobile">
                    <?php print $action_select_list;?>
                </ul>        
            </div>


            <div class="dropdown form-control" >
                <div data-toggle="dropdown" id="adv_categ_mobile" class="filter_menu_trigger" data-value="all"> <?php _e('All Types','wpestate');?> <span class="caret caret_filter"></span> </div>           
                <input type="hidden" name="filter_search_type[]" value="">
                <ul class="dropdown-menu filter_menu" role="menu" aria-labelledby="adv_categ_mobile">
                    <?php print $categ_select_list;?>
                </ul>        
            </div> 

            <div class="dropdown form-control" >
                <div data-toggle="dropdown" id="advanced_city_mobile" class="filter_menu_trigger" data-value="all"> <?php _e('All Cities','wpestate');?> <span class="caret caret_filter"></span> </div>           
                <input type="hidden" name="advanced_city" value="">
                <ul  class="dropdown-menu filter_menu" id="mobile-adv-city" role="menu" aria-labelledby="advanced_city_mobile">
                    <?php print $select_city_list;?>
                </ul>        
            </div>  

            <div class="dropdown form-control" >
                <div data-toggle="dropdown" id="advanced_area_mobile" class="filter_menu_trigger" data-value="all"><?php _e('All Areas','wpestate');?><span class="caret caret_filter"></span> </div>           
                <input type="hidden" name="advanced_area" value="">
                <ul class="dropdown-menu filter_menu" id="mobile-adv-area" role="menu" aria-labelledby="advanced_area_mobile">
                    <?php print $select_area_list;?>
                </ul>        
            </div> 

            <input type="text" id="adv_rooms_mobile" class="form-control" name="advanced_rooms"  placeholder="<?php _e('Type Bedrooms No.','wpestate');?>" value="" >       
            <input type="text" id="adv_bath_mobile"  class="form-control" name="advanced_bath"   placeholder="<?php _e('Type Bathrooms No.','wpestate');?>" value="">

                <?php
                $show_slider_price            =   get_option('wp_estate_show_slider_price','');
                if ($show_slider_price==='yes'){
                    $where_currency         =   esc_html( get_option('wp_estate_where_currency_symbol', '') );
                    $currency               =   esc_html( get_option('wp_estate_currency_symbol', '') );

                    $min_price_slider= ( floatval(get_option('wp_estate_show_slider_min_price','')) );
                    $max_price_slider= ( floatval(get_option('wp_estate_show_slider_max_price','')) );

                    if ($where_currency == 'before') {
                         $price_slider_label = $currency . number_format($min_price_slider).' '.__('to','wpestate').' '.$currency . number_format($max_price_slider);
                    } else {
                         $price_slider_label =  number_format($min_price_slider).$currency.' '.__('to','wpestate').' '.number_format($max_price_slider).$currency;
                    } 
                ?>
                    <div class="adv_search_slider slide_mobile">
                        <p>
                            <label for="amount"><?php _e('Price range:','wpestate');?></label>
                            <span id="amount_mobile"  style="border:0; color:#f6931f; font-weight:bold;"><?php print $price_slider_label;?></span>
                        </p>
                        <div id="slider_price_mobile"></div>
                        <input type="hidden" id="price_low_mobile"  name="price_low"  value="<?php echo $min_price_slider;?>"/>
                        <input type="hidden" id="price_max_mobile"  name="price_max"  value="<?php echo $max_price_slider;?>" />
                    </div>
                <?php
                }else{
                ?>
                    <input type="text" id="price_low_mobile" class="form-control  advanced_select" name="price_low"  placeholder="<?php _e('Type Min. Price','wpestate');?>" value=""/>
                    <input type="text" id="price_max_mobile" class="form-control  advanced_select" name="price_max"  placeholder="<?php _e('Type Max. Price','wpestate');?>" value=""/>
                <?php
                }
                ?>
            
            
           
        <?php
        }
        
        $extended_search= get_option('wp_estate_show_adv_search_extended','');
        if($extended_search=='yes'){            
            show_extended_search('mobile');
        }
        ?>
      
        <?php } else {
        ?>
            <input type="text" id="adv_location_mobile" class="form-control" name="adv_location"  placeholder="<?php _e('Search State, City or Area','wpestate');?>" value="">      


            <div class="dropdown form-control" >
                <div data-toggle="dropdown" id="adv_categ" class="filter_menu_trigger" data-value="<?php // echo  $adv_categ_value1;?>"> 
                    <?php 
                    echo  __('All Types','wpestate');
                    ?> 
                <span class="caret caret_filter"></span> </div>           
                <input type="hidden" name="filter_search_type[]" value="<?php if(isset($_GET['filter_search_type'][0])){echo $_GET['filter_search_type'][0];}?>">
                <ul  class="dropdown-menu filter_menu" role="menu" aria-labelledby="adv_categ">
                    <?php print $categ_select_list;?>
                </ul>        
            </div> 

            <div class="dropdown form-control" >
                <div data-toggle="dropdown" id="adv_actions" class="filter_menu_trigger" data-value="<?php // echo $adv_actions_value1; ?>"> 
                    <?php _e('All Actions','wpestate');?> 
                    <span class="caret caret_filter"></span> </div>           

                <input type="hidden" name="filter_search_action[]" value="<?php if(isset($_GET['filter_search_action'][0])){echo $_GET['filter_search_action'][0];}?>">
                <ul  class="dropdown-menu filter_menu" role="menu" aria-labelledby="adv_actions">
                    <?php print $action_select_list;?>
                </ul>        
            </div>
            
        <?php    
        

            $availableTags='';
            $args = array( 'hide_empty=0' );
            $terms = get_terms( 'property_city', $args );
            foreach ( $terms as $term ) {
               $availableTags.= '"'.$term->name.'",';
            }

            $terms = get_terms( 'property_area', $args );
            foreach ( $terms as $term ) {
               $availableTags.= '"'.$term->name.'",';
            }

            $terms = get_terms( 'property_county_state', $args );
            foreach ( $terms as $term ) {
               $availableTags.= '"'.$term->name.'",';
            }

            print '<script type="text/javascript">
                       //<![CDATA[
                       jQuery(document).ready(function(){
                            var availableTags = ['.$availableTags.'];
                            jQuery("#adv_location_mobile").autocomplete({
                                source: availableTags
                            });
                       });
                       //]]>
                    </script>';
 

        }
        ?>
        
        <button class="wpb_button  wpb_btn-info wpb_btn-large" id="advanced_submit_2_mobile"><?php _e('Search Properties','wpestate');?></button>
        <button class="wpb_button  wpb_btn-info wpb_btn-large" id="showinpage_mobile"><?php _e('See first results here ','wpestate');?></button>
        
        
            <span id="results_mobile"> <?php _e('we found','wpestate')?> <span id="results_no_mobile">0</span> <?php _e('results','wpestate')?> </span>
    </form>   
</div>       