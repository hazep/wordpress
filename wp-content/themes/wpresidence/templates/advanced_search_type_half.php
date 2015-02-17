<?php 
global $post;
global $adv_search_type;
$adv_submit                 =   get_adv_search_link();
$adv_search_what            =   get_option('wp_estate_adv_search_what','');
$show_adv_search_visible    =   get_option('wp_estate_show_adv_search_visible','');
$close_class                =   '';
if($show_adv_search_visible=='no'){
    $close_class='adv-search-1-close';
}
if(isset( $post->ID)){
    $post_id = $post->ID;
}else{
    $post_id = '';
}

$extended_search    =   get_option('wp_estate_show_adv_search_extended','');
$extended_class     =   '';

if ( $extended_search =='yes' ){
    $extended_class='adv_extended_class';
    if($show_adv_search_visible=='no'){
        $close_class='adv-search-1-close-extended';
    }
       
}
    
?>

 


<div class="adv-search-1 <?php echo $close_class.' '.$extended_class;?>" id="adv-search-1" data-postid="<?php echo $post_id; ?>"> 
    
    <form role="search" method="get"   action="<?php print $adv_submit; ?>" >
            
        <div class="row">
        
        <?php
        $custom_advanced_search= get_option('wp_estate_custom_advanced_search','');
        if ( $custom_advanced_search == 'yes'){
            foreach($adv_search_what as $key=>$search_field){
                wpestate_show_search_field_half($search_field,$action_select_list,$categ_select_list,$select_city_list,$select_area_list,$key,$select_county_state_list);
            }
        }else{
        ?>
         

            
        <?php 
        if(isset($_GET['filter_search_action'][0]) && $_GET['filter_search_action'][0]!='' && $_GET['filter_search_action'][0]!='all'){
            $full_name = get_term_by('slug',$_GET['filter_search_action'][0],'property_action_category');
            $adv_actions_value=$adv_actions_value1= $full_name->name;
        }else{
            $adv_actions_value=__('All Actions','wpestate');
            $adv_actions_value1='all';
        }?>     
        <div class=" col-md-3">    
            <div class=" dropdown form-control" >
                <div data-toggle="dropdown" id="adv_actions" class="filter_menu_trigger" data-value="<?php echo $adv_actions_value1; ?>"> 
                    <?php 
                    echo $adv_actions_value; 
                    ?> 
                <span class="caret caret_filter"></span> </div>           
                <input type="hidden" name="filter_search_action[]" value="<?php if(isset($_GET['filter_search_action'][0])){echo $_GET['filter_search_action'][0];}?>">
                <ul  class="dropdown-menu filter_menu" role="menu" aria-labelledby="adv_actions">
                    <?php print $action_select_list;?>
                </ul>        
            </div>
        </div>
            
        <?php 
        
        if( isset($_GET['filter_search_type'][0]) && $_GET['filter_search_type'][0]!=''&& $_GET['filter_search_type'][0]!='all'  ){
            $full_name = get_term_by('slug',$_GET['filter_search_type'][0],'property_category');
            $adv_categ_value= $adv_categ_value1=$full_name->name;
        }else{
            $adv_categ_value    = __('All Types','wpestate');
            $adv_categ_value1   ='all';
        }
        ?>    
            
        <div class="col-md-3">      
            <div class=" dropdown form-control" >
                <div data-toggle="dropdown" id="adv_categ" class="filter_menu_trigger" data-value="<?php echo  $adv_categ_value1;?>"> 
                    <?php 
                    echo  $adv_categ_value;
                    ?> 
                <span class="caret caret_filter"></span> </div>           
                <input type="hidden" name="filter_search_type[]" value="<?php if(isset($_GET['filter_search_type'][0])){echo $_GET['filter_search_type'][0];}?>">
                <ul  class="dropdown-menu filter_menu" role="menu" aria-labelledby="adv_categ">
                    <?php print $categ_select_list;?>
                </ul>        
            </div> 
        </div>    

            
            
            
        <?php
        if(isset($_GET['advanced_city']) && $_GET['advanced_city']!='' && $_GET['advanced_city']!='all'){
            $full_name = get_term_by('slug',$_GET['advanced_city'],'property_city');
            $advanced_city_value= $advanced_city_value1=$full_name->name;
        }else{
            $advanced_city_value=__('All Cities','wpestate');
            $advanced_city_value1='all';
        }
        ?>    
            
        <div class="col-md-3">     
            <div class=" dropdown form-control" >
                <div data-toggle="dropdown" id="advanced_city" class="filter_menu_trigger" data-value="<?php echo $advanced_city_value1; ?>"> 
                    <?php
                    echo $advanced_city_value;
                    ?> 
                    <span class="caret caret_filter"></span> </div>           
                <input type="hidden" name="advanced_city" value="<?php if(isset($_GET['advanced_city'])){echo $_GET['advanced_city'];}?>">
                <ul  class="dropdown-menu filter_menu" role="menu"  id="adv-search-city" aria-labelledby="advanced_city">
                    <?php print $select_city_list;?>
                </ul>        
            </div>  
        </div>     

            
        <?php 
        if(isset($_GET['advanced_area']) && $_GET['advanced_area']!=''&& $_GET['advanced_area']!='all'){
            $full_name = get_term_by('slug',$_GET['advanced_area'],'property_area');
            $advanced_area_value=$advanced_area_value1= $full_name->name;
        }else{
            $advanced_area_value=__('All Areas','wpestate');
            $advanced_area_value1='all';
        }
        ?>     
            
            
        <div class="col-md-3">    
            <div class="  dropdown form-control" >
                <div data-toggle="dropdown" id="advanced_area" class="filter_menu_trigger" data-value="<?php echo $advanced_area_value1;?>">
                    <?php 
                    echo $advanced_area_value;
                    ?>
                    <span class="caret caret_filter"></span> </div>           
                <input type="hidden" name="advanced_area" value="<?php if(isset($_GET['advanced_area'])){echo $_GET['advanced_area'];}?>">
                <ul class="dropdown-menu filter_menu" role="menu" id="adv-search-area"  aria-labelledby="advanced_area">
                    <?php print $select_area_list;?>
                </ul>        
            </div> 
        </div> 
            
        <div class="col-md-3">    
            <input type="text" id="adv_rooms" class="form-control" name="advanced_rooms"  placeholder="<?php _e('Type Bedrooms No.','wpestate');?>" 
               value="<?php if ( isset ( $_GET['advanced_rooms'] ) ) {echo $_GET['advanced_rooms'];}?>">       
        </div>
            
        <div class="col-md-3">    
            <input type="text" id="adv_bath"  class="form-control" name="advanced_bath"   placeholder="<?php _e('Type Bathrooms No.','wpestate');?>"   
               value="<?php if (isset($_GET['advanced_bath'])) {echo $_GET['advanced_bath'];}?>">
        </div>
        
        <?php
        $show_slider_price      =   get_option('wp_estate_show_slider_price','');
        $where_currency         =   esc_html( get_option('wp_estate_where_currency_symbol', '') );
        $currency               =   esc_html( get_option('wp_estate_currency_symbol', '') );
         
        
        if ($show_slider_price==='yes'){
                $min_price_slider= ( floatval(get_option('wp_estate_show_slider_min_price','')) );
                $max_price_slider= ( floatval(get_option('wp_estate_show_slider_max_price','')) );
                
                if(isset($_GET['price_low'])){
                     $min_price_slider=  floatval($_GET['price_low']) ;
                }
                
                if(isset($_GET['price_low'])){
                     $max_price_slider=  floatval($_GET['price_max']) ;
                }

                if ($where_currency == 'before') {
                     $price_slider_label = $currency . number_format($min_price_slider).' '.__('to','wpestate').' '.$currency . number_format($max_price_slider);
                } else {
                     $price_slider_label =  number_format($min_price_slider).$currency.' '.__('to','wpestate').' '.number_format($max_price_slider).$currency;
                }    
        ?>
            <div class="col-md-6 adv_search_slider">
                <p>
                    <label for="amount"><?php _e('Price range:','wpestate');?></label>
                    <span id="amount"  style="border:0; color:#f6931f; font-weight:bold;"><?php print $price_slider_label;?></span>
                </p>
                <div id="slider_price"></div>
                <input type="hidden" id="price_low"  name="price_low"  value="<?php echo $min_price_slider;?>" />
                <input type="hidden" id="price_max"  name="price_max"  value="<?php echo $max_price_slider;?>" />
            </div>
        <?php
        }else{
        ?>  
            <div class="col-md-3">   
                <input type="text" id="price_low" class="form-control advanced_select" name="price_low"  placeholder="<?php _e('Type Min. Price','wpestate');?>" value=""/>
            </div>
            
            <div class="col-md-3">   
                <input type="text" id="price_max" class="form-control advanced_select" name="price_max"  placeholder="<?php _e('Type Max. Price','wpestate');?>" value=""/>
            </div>
        <?php
        }
        ?>
   
     
        <?php
        }
       /* 
        if($extended_search=='yes'){
            print '<div class="col-md-12">   ';
            show_extended_search('adv');
            print '</div>';
        }
        */
        
        
        ?>
    
        
        </div>
       
     <!--
         <input name="submit" type="submit" class="wpb_button  wpb_btn_adv_submit wpb_btn-large" id="advanced_submit_2" value="<?php _e('SEARCH PROPERTIES','wpestate');?>">
       -->
        
        <?php if ($adv_search_type!=2) { ?>
        <div id="results">
            <?php _e('We found ','wpestate'); print $adv_search_type.'cc';?> <span id="results_no">0</span> <?php _e('results.','wpestate'); ?>  
            <span id="showinpage"> <?php _e('Do you want to load the results now ?','wpestate');?> </span>
        </div>
        <?php } ?>

    </form>   
</div>  



<?php


         
 function  wpestate_show_search_field_half($search_field,$action_select_list,$categ_select_list,$select_city_list,$select_area_list,$key,$select_county_state_list){
            $adv_search_what        =   get_option('wp_estate_adv_search_what','');
            $adv_search_label       =   get_option('wp_estate_adv_search_label','');
            $adv_search_how         =   get_option('wp_estate_adv_search_how','');

      
            $return_string='';
            if($search_field=='none'){
                $return_string=''; 
            }
            else if($search_field=='types'){
                
                if(isset($_GET['filter_search_action'][0]) && $_GET['filter_search_action'][0]!='' && $_GET['filter_search_action'][0]!='all'){
                    $full_name = get_term_by('slug',$_GET['filter_search_action'][0],'property_action_category');
                    $adv_actions_value=$adv_actions_value1= $full_name->name;
                }else{
                    $adv_actions_value=__('All Actions','wpestate');
                    $adv_actions_value1='all';
                } 

                $return_string='
                <div class="col-md-3">   
                    <div class="dropdown form-control">
                        <div data-toggle="dropdown" id="adv_actions" class="filter_menu_trigger" data-value='.$adv_actions_value1.'>';

                        $return_string.= $adv_actions_value; 


                        $return_string.='
                        <span class="caret caret_filter"></span>
                        </div>           
                        <input type="hidden" name="filter_search_action[]" value="';
                        if(isset($_GET['filter_search_action'][0])){
                            $return_string.= $_GET['filter_search_action'][0];
                        }

                        $return_string.='">

                        <ul class="dropdown-menu filter_menu" role="menu" aria-labelledby="adv_actions">
                            '.$action_select_list.'
                        </ul>        
                    </div>
                </div>';
                    
            }else if($search_field=='categories'){
                if( isset($_GET['filter_search_type'][0]) && $_GET['filter_search_type'][0]!=''  && $_GET['filter_search_type'][0]!='all' ){
                    $full_name = get_term_by('slug',$_GET['filter_search_type'][0],'property_category');
                    $adv_categ_value= $adv_categ_value1=$full_name->name;
                }else{
                    $adv_categ_value    = __('All Types','wpestate');
                    $adv_categ_value1   ='all';
                }
                $return_string='
                <div class="col-md-3">    
                    <div class="dropdown  form-control">
                        <div data-toggle="dropdown" id="adv_categ" class="filter_menu_trigger" data-value="'.$adv_categ_value1.'">';
                        $return_string.=$adv_categ_value;
                        $return_string.='
                        <span class="caret caret_filter"></span>
                        </div>           
                        <input type="hidden" name="filter_search_type[]"value="';
                        if ( isset( $_GET['filter_search_type'][0] ) ){
                            $return_string.= $_GET['filter_search_type'][0];
                        }
                        $return_string.='">
                        <ul class="dropdown-menu filter_menu" role="menu" aria-labelledby="adv_categ">
                          '.$categ_select_list.'
                        </ul>        
                    </div>
                </div>';

            }  else if($search_field=='cities'){
                if(isset($_GET['advanced_city']) && $_GET['advanced_city']!='' && $_GET['advanced_city']!='all'){
                    $full_name = get_term_by('slug',$_GET['advanced_city'],'property_city');
                    $advanced_city_value= $advanced_city_value1=$full_name->name;
                }else{
                    $advanced_city_value=__('All Cities','wpestate');
                    $advanced_city_value1='all';
                } 
                $return_string='
                <div class="col-md-3">    
                    <div class="dropdown  form-control">
                        <div data-toggle="dropdown" id="advanced_city" class="filter_menu_trigger" data-value="'.$advanced_city_value1.'">';

                        $return_string.=$advanced_city_value;

                        $return_string.=' 
                        <span class="caret caret_filter"></span>
                        </div>           
                        <input type="hidden" name="advanced_city" value="';
                        if(isset($_GET['advanced_city'])){
                            $return_string.= $_GET['advanced_city'];
                        }
                        $return_string.='">
                        <ul  id="adv-search-city" class="dropdown-menu filter_menu" role="menu" aria-labelledby="advanced_city">
                            '.$select_city_list.'
                        </ul>        
                    </div>
                </div>';
                
            }   else if($search_field=='areas'){

                if(isset($_GET['advanced_area']) && $_GET['advanced_area']!=''  && $_GET['advanced_area']!='all'){
                    $full_name = get_term_by('slug',$_GET['advanced_area'],'property_area');
                    $advanced_area_value=$advanced_area_value1= $full_name->name;
                }else{
                    $advanced_area_value=__('All Areas','wpestate');
                    $advanced_area_value1='all';
                }
        
                $return_string='
                <div class="col-md-3">        
                    <div class="dropdown  form-control">
                        <div data-toggle="dropdown" id="advanced_area" class="filter_menu_trigger" data-value="'.$advanced_area_value1.'">';
                        $return_string.=$advanced_area_value;

                        $return_string.= '       
                        <span class="caret caret_filter"></span>
                        </div>           
                        <input type="hidden" name="advanced_area"  value="';
                        if(isset($_GET['advanced_area'])){
                            $return_string.= $_GET['advanced_area'];

                        } 
                        $return_string.='">
                        <ul id="adv-search-area" class="dropdown-menu filter_menu" role="menu" aria-labelledby="advanced_area">
                            '.$select_area_list.'
                        </ul>        
                    </div>
                </div>';
            }else if($search_field=='county / state'){
                if(isset($_GET['advanced_contystate']) && $_GET['advanced_contystate']!='' && $_GET['advanced_contystate']!='all' ){
                        $full_name = get_term_by('slug',$_GET['advanced_contystate'],'property_county_state');
                        $advanced_county_value = $advanced_county_value1= $full_name->name;
                    }else{
                        $advanced_county_value = __('All Counties/States','wpestate');
                        $advanced_county_value1 = 'all';
                    }
                    
                $return_string='
                <div class="col-md-3">  
                    <div class="dropdown  form-control">
                        <div data-toggle="dropdown" id="county-state" class="filter_menu_trigger" data-value="'.$advanced_county_value1.'">';
                        $return_string.=$advanced_county_value;

                        $return_string.='<span class="caret caret_filter"></span>
                        </div>           
                        <input type="hidden" name="advanced_contystate" value="';
                        if(isset($_GET['advanced_contystate'])){
                            $return_string.= $_GET['advanced_contystate'];
                        } 
                        $return_string.='">
                        <ul id="adv-search-countystate" class="dropdown-menu filter_menu" role="menu" aria-labelledby="county-state">
                            '.$select_county_state_list.'
                        </ul>        
                    </div>
                </div>';
             
            }   else {
              
                //$slug       =   wpestate_limit45 ( sanitize_title ( $search_field )); 
                //$slug       =   sanitize_key($slug);            
                $string       =   wpestate_limit45 ( sanitize_title ($adv_search_label[$key]) );              
                $slug         =   sanitize_key($string);
                
                $label=$adv_search_label[$key];
                if (function_exists('icl_translate') ){
                    $label     =   icl_translate('wpestate','wp_estate_custom_search_'.$label, $label ) ;
                }
              
             //   $return_string='<input type="text" id="'.$slug.'"  name="'.$slug.'" placeholder="'.$label.'" value=""  class="advanced_select  form-control" />';

                if ( $adv_search_what[$key]=='property price'){
                    $show_slider_price            =   get_option('wp_estate_show_slider_price','');
                    if ($show_slider_price==='yes'){
                            $min_price_slider= ( floatval(get_option('wp_estate_show_slider_min_price','')) );
                            $max_price_slider= ( floatval(get_option('wp_estate_show_slider_max_price','')) );
                
                            if(isset($_GET['price_low'])){
                                $min_price_slider=  floatval($_GET['price_low']) ;
                            }

                            if(isset($_GET['price_low'])){
                                $max_price_slider=  floatval($_GET['price_max']) ;
                            }
                            
                            $where_currency         =   esc_html( get_option('wp_estate_where_currency_symbol', '') );
                            $currency               =   esc_html( get_option('wp_estate_currency_symbol', '') );

                            if ($where_currency == 'before') {
                                $price_slider_label = $currency . number_format($min_price_slider).' '.__('to','wpestate').' '.$currency . number_format($max_price_slider);
                            } else {
                                $price_slider_label =  number_format($min_price_slider).$currency.' '.__('to','wpestate').' '.number_format($max_price_slider).$currency;
                            } 
                            
                            $return_string=' <div class="col-md-6 adv_search_slider">
                                <p>
                                    <label for="amount">'. __('Price range:','wpestate').'</label>
                                    <span id="amount"  style="border:0; color:#f6931f; font-weight:bold;">'.$price_slider_label.'</span>
                                </p>
                                <div id="slider_price"></div>
                                <input type="hidden" id="price_low"  name="price_low"  value="'.$min_price_slider.'"/>
                                <input type="hidden" id="price_max"  name="price_max"  value="'.$max_price_slider.'"/>
                            </div>';
                    }else{
                        $return_string='<div class="col-md-3"><input type="text" id="'.$slug.'"  name="'.$slug.'" placeholder="'.$label.'" value="';
                        if (isset($_GET[$slug])) {
                            $return_string.= $_GET[$slug];
                        }
                        $return_string.='" class="advanced_select form-control" /></div>';
                    }
                 // if is property price    
                }else{ 
                     $return_string='<div class="col-md-3"><input type="text" id="'.$slug.'"  name="'.$slug.'" placeholder="'.$label.'" value="';
                        if (isset($_GET[$slug])) {
                            $return_string.= $_GET[$slug];
                        }
                        $return_string.='" class="advanced_select form-control" /></div>';
                }
                
                if ( $adv_search_how[$key]=='date bigger' || $adv_search_how[$key]=='date smaller'){
                    print '<script type="text/javascript">
                          //<![CDATA[
                          jQuery(document).ready(function(){
                                  jQuery("#'.$slug.'").datepicker({
                                          dateFormat : "yy-mm-dd"
                                  });
                          });
                          //]]>
                          </script>';
                }
           

            } 
            print $return_string;
         }


?>