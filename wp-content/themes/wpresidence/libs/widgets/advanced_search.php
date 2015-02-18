<?php
class Advanced_Search_widget extends WP_Widget {
    
    function Advanced_Search_widget(){
        $widget_ops = array('classname' => 'advanced_search_sidebar', 'description' => 'Advanced Search Widget');
        $control_ops = array('id_base' => 'advanced_search_widget');
        $this->WP_Widget('advanced_search_widget', 'Wp Estate: Advanced Search', $widget_ops, $control_ops);
    }
    
    function form($instance){
        $defaults = array('title' => 'Advanced Search' );
        $instance = wp_parse_args((array) $instance, $defaults);
        $display='
        <p>
            <label for="'.$this->get_field_id('title').'">Title:</label>
        </p><p>
        <input id="'.$this->get_field_id('title').'" name="'.$this->get_field_name('title').'" value="'.$instance['title'].'" />
    </p>';
    print $display;
}


function update($new_instance, $old_instance){
  $instance = $old_instance;
  $instance['title'] = $new_instance['title'];

  return $instance;
}



function widget($args, $instance){
  extract($args);
  $display='';
  $select_tax_action_terms='';
  $select_tax_category_terms='';

  $title = apply_filters('widget_title', $instance['title']);

  print $before_widget;

$adv_submit=get_adv_search_link();

                //  show cities or areas that are empty ?
$args = wpestate_get_select_arguments();
$action_select_list =   wpestate_get_action_select_list($args);
$categ_select_list  =   wpestate_get_category_select_list($args);
$select_city_list   =   wpestate_get_city_select_list($args); 
$select_area_list   =   wpestate_get_area_select_list($args);
$select_county_state_list   =   wpestate_get_county_state_select_list($args);


$adv_search_what        =   get_option('wp_estate_adv_search_what','');
$adv_search_label       =   get_option('wp_estate_adv_search_label','');
$adv_search_how         =   get_option('wp_estate_adv_search_how','');

$custom_advanced_search =   get_option('wp_estate_custom_advanced_search','');
print '<form role="search" method="get"   action="'.$adv_submit.'" >';
                            // if($custom_advanced_search=='yes'){
                            //        $this->custom_fields_widget($adv_search_what,$action_select_list,$categ_select_list,$select_city_list,$select_area_list,$adv_search_how,$adv_search_label,$select_county_state_list);
                            // }else{ // not custom search
                            //        $this->normal_fields_widget($action_select_list,$categ_select_list,$select_city_list,$select_area_list);

                            // }
?>
<input type="text" id="google-default-search" name="google-default-search" placeholder="Google Maps Search" value="" class="advanced_select  form-control" autocomplete="off">

<h3>TYPES DE TRANSACTION</h3>

<form role="search" class="searchSide" method="get" action="http://localhost/wordpress/?page_id=6">
    <input type="hidden" name="page_id" value="5">
    <select class="selected" name="filter_search_action[]" style="text-align: center;">
        <option></option>
        <option value="achat">Achat</option>
        <option value="vente">Vente</option>
        <option value="location">Location</option>
    </select>

<h3>TYPES DE BIENS</h3>
    <div class="rememberme2">
        <input type="radio" id="checkbox1" name="filter_search_type[]" value="apartments">
        <label for="checkbox1">Appartement</label>
    </div>
    <div class="rememberme2">
        <input type="radio" id="checkbox12" name="filter_search_type[]" value="Houses">
        <label for="checkbox12">Maison</label>
    </div>
    <div class="rememberme2">
        <input type="radio" id="checkbox3" name="filter_search_type[]" value="Land">
        <label for="checkbox3">Terrain</label>
    </div>
    <div class="rememberme2">
        <input type="radio" id="checkbox4" name="filter_search_type[]" value="Retails">
        <label for="checkbox4">Parking</label>
    </div>
    <div class="rememberme2">
        <input type="radio" id="checkbox5" name="filter_search_type[]" value="Duplexes">
        <label for="checkbox5">Immeuble</label>
    </div>


<h3>NOMBRE DE PIECES</h3>
    <label for="piecesSelect" id="tM">Nombres de pièces: </label>
    <select class="selected sW" id="piecesSelect" style="text-align: center;" name="nombres-de-pieces">
        <option value=""></option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
    </select>

    <label for="chambresSelect">Nombres de chambres: </label>
    <select class="selected sW" id="chambresSelect" style="text-align: center;" name="nombre-de-chambres">
        <option value=""></option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
    </select>

<h3>PRIX</h3>
    <div class="adv_search_widget">
        <p>
            <label for="amount_wd">De: </label>
            <span id="amount_wd" readonly style="border:0; font-weight:bold;">0€ a 7,000,000,000€</span>
        </p>
        <div id="slider_price_widget"></div>
        <input type="hidden" id="price_low_widget"  name="price_low"  value="0"/>
        <input type="hidden" id="price_max_widget"  name="price_max"  value="7000000000"/>
    </div>

    <div class="clr"></div>

<h3>SURFACE</h3>
        <div id="rangedval2">
            <label for="rangeval2">De: </label>
            <span id="rangeval2">0 - 3000</span> m²
            <input type="hidden" id="surface_low_widget"  name="size_low"  value="0"/>
            <input type="hidden" id="surface_max_widget"  name="size_max"  value="7000000000"/>
        </div>
        <div id="rangeslider2"></div>



        <div class="clr"></div>

<h3>ANNONCE</h3>

   <!--  <div class="rememberme2">
        <input name="rememberme" type="radio" id="checkboxR" value="forever">
        <label for="checkboxR">Particulier</label>
    </div>
    <div class="rememberme2">
        <input name="rememberme" type="radio" id="checkboxT" value="forever">
        <label for="checkboxT">Professionels</label>
    </div>
    <div class="rememberme2">
        <input name="rememberme" type="radio" id="checkboxI" value="forever">
        <label for="checkboxI">Toutes les annonces</label>
    </div>

-->
<!-- <input type="checkbox" value="mem"> Memoriser mes choix -->
<input type="submit" class="subButtonForm" id="advanced_submit_widget" value="Rechercher">
</form>

<?php


$extended_search = get_option('wp_estate_show_adv_search_extended','');
if($extended_search=='yes'){            
    show_extended_search('widget');
}

// print'<button class="wpb_button  wpb_btn-info wpb_btn-large" id="advanced_submit_widget">'.__('Search','wpestate').'</button>
// </form>  
// '; 
print $after_widget;

}








function custom_fields_widget($adv_search_what,$action_select_list,$cate_select_list,$select_city_list,$select_area_list,$adv_search_how,$adv_search_label,$select_county_state_list){

    foreach($adv_search_what as $key=>$search_field){
        if($search_field=='none'){
            $return_string=''; 
        }
        else if($search_field=='types'){
            $return_string='
            <div class="dropdown form-control" >
                <div data-toggle="dropdown" id="sidebar_filter_action" class="sidebar_filter_menu"> '.__('All Actions','wpestate').' <span class="caret caret_sidebar"></span> </div>           
                <input type="hidden" name=" " value="">
                <ul id="list_sidebar_filter_action" class="dropdown-menu filter_menu" role="menu" aria-labelledby="sidebar_filter_action">
                    '.$action_select_list.'
                </ul>        
            </div>';

        }else if($search_field=='categories'){
            $return_string='                                            
            <div class="dropdown form-control" >
                <div data-toggle="dropdown" id="a_sidebar_filter_categ" class="sidebar_filter_menu"> '. __('All Types','wpestate').' <span class="caret caret_sidebar"></span> </div>           
                <input type="hidden" name="filter_search_type[]" value="">
                <ul id="sidebar_filter_categ" class="dropdown-menu filter_menu" role="menu" aria-labelledby="a_sidebar_filter_categ">
                    '.$cate_select_list.'
                </ul>        
            </div>';

        }else if($search_field=='cities'){
            $return_string='
            <div class=" dropdown form-control" >
                <div data-toggle="dropdown" id="sidebar_filter_cities" class="sidebar_filter_menu"> '. __('All Cities','wpestate').' <span class="caret caret_sidebar"></span> </div>           
                <input type="hidden" name="advanced_city" value="">
                <ul id="sidebar_filter_city" class="dropdown-menu filter_menu" role="menu" aria-labelledby="sidebar_filter_cities">
                   '. $select_city_list.'
               </ul>        
           </div>  ';

       }else if($search_field=='areas'){
        $return_string='
        <div class="dropdown form-control" >
            <div data-toggle="dropdown" id="sidebar_filter_areas" class="sidebar_filter_menu">'. __('All Areas','wpestate').'<span class="caret caret_sidebar"></span> </div>           
            <input type="hidden" name="advanced_area" value="">
            <ul id="sidebar_filter_area" class="dropdown-menu filter_menu" role="menu" aria-labelledby="sidebar_filter_areas">
                '.$select_area_list.'
            </ul>        
        </div>
        ';
    }else if($search_field=='county / state'){
        $return_string='
        <div class="dropdown form-control" >
            <div data-toggle="dropdown" id="sidebar_filter_county_state" class="sidebar_filter_menu">'. __('All Counties/States','wpestate').'<span class="caret caret_sidebar"></span> </div>           
            <input type="hidden" name="advanced_contystate" value="">
            <ul id="sidebar_filter_area" class="dropdown-menu filter_menu" role="menu" aria-labelledby="sidebar_filter_county_state">
                '.$select_county_state_list.'
            </ul>        
        </div>
        ';
    }else {
        $slug=str_replace(' ','_',$search_field);
        $string       =   wpestate_limit45 ( sanitize_title ($adv_search_label[$key]) );              
        $slug         =   sanitize_key($string);

        $label=$adv_search_label[$key];
        if (function_exists('icl_translate') ){
            $label     =   icl_translate('wpestate','wp_estate_custom_search_'.$label, $label ) ;
        }

        if ( $adv_search_what[$key]=='property price'){
           $show_slider_price  =   get_option('wp_estate_show_slider_price','');
           if ($show_slider_price == 'yes'){
            $min_price_slider= ( floatval(get_option('wp_estate_show_slider_min_price','')) );
            $where_currency         =   esc_html( get_option('wp_estate_where_currency_symbol', '') );
            $currency               =   esc_html( get_option('wp_estate_currency_symbol', '') );
            $max_price_slider       = ( floatval(get_option('wp_estate_show_slider_max_price','')) );

            if ($where_currency == 'before') {
             $price_slider_label = $currency . number_format($min_price_slider).' '.__('to','wpestate').' '.$currency . number_format($max_price_slider);
         } else {
             $price_slider_label =  number_format($min_price_slider).$currency.' '.__('to','wpestate').' '.number_format($max_price_slider).'€';
         }  

         $return_string='
         <div class="adv_search_widget">
            <p>
                <label for="amount_wd">'.__('Price range:','wpestate').'</label>
                <span id="amount_wd" readonly style="border:0; font-weight:bold;">'.$price_slider_label.'</span>
            </p>
            <div id="slider_price_widget"></div>
            <input type="hidden" id="price_low_widget"  name="price_low"  value="'.$min_price_slider.'"/>
            <input type="hidden" id="price_max_widget"  name="price_max"  value="'.$max_price_slider.'"/>
        </div>';
    }else{
        $return_string='  <input type="text" id="'.$slug.'_wid"  name="'.$slug.'"  placeholder="'.$label.'"  class="advanced_select form-control">';
    }
                                             // if is property price    
}else{ 
    $return_string='  <input type="text" id="'.$slug.'_wid"  name="'.$slug.'"  placeholder="'.$label.'"  class="advanced_select form-control">';
}



                                           // $return_string='<input type="text" id="'.$slug.'_wid"  name="'.$slug.'"  placeholder="'.$label.'"  class="advanced_select form-control">';
if ( $adv_search_how[$key]=='date bigger' || $adv_search_how[$key]=='date smaller'){
    print '<script type="text/javascript">
                                                      //<![CDATA[
    jQuery(document).ready(function(){
      jQuery("#'.$slug.'_wid").datepicker({
          dateFormat : "yy-mm-dd"
      });
});
                                                      //]]>
</script>';
}
} 
print $return_string;
                    } // enf foreach
                    
            }//end custom fields function


            function normal_fields_widget($action_select_list,$cate_select_list,$select_city_list,$select_area_list){
                if( !empty($action_select_list) ){
                    print'
                    <div class="dropdown form-control" >
                        <div data-toggle="dropdown" id="sidebar_filter_action" class="sidebar_filter_menu"> '.__('All Actions','wpestate').' <span class="caret caret_sidebar"></span> </div>           
                        <input type="hidden" name="filter_search_action[]" value="">
                        <ul id="list_sidebar_filter_action" class="dropdown-menu filter_menu" role="menu" aria-labelledby="sidebar_filter_action">
                            '.$action_select_list.'
                        </ul>        
                    </div>';
                }

                if( !empty($cate_select_list) ){
                 print'                                            
                 <div class="dropdown form-control" >
                    <div data-toggle="dropdown" id="a_sidebar_filter_categ" class="sidebar_filter_menu"> '. __('All Types','wpestate').' <span class="caret caret_sidebar"></span> </div>           
                    <input type="hidden" name="filter_search_type[]" value="">
                    <ul id="sidebar_filter_categ" class="dropdown-menu filter_menu" role="menu" aria-labelledby="a_sidebar_filter_categ">
                        '.$cate_select_list.'
                    </ul>        
                </div>';
            }

            if( !empty($select_city_list) ){
                print'
                <div class=" dropdown form-control" >
                    <div data-toggle="dropdown" id="sidebar_filter_cities" class="sidebar_filter_menu"> '. __('All Cities','wpestate').' <span class="caret caret_sidebar"></span> </div>           
                    <input type="hidden" name="advanced_city" value="">
                    <ul id="sidebar_filter_city" class="dropdown-menu filter_menu" role="menu" aria-labelledby="sidebar_filter_cities">
                        '. $select_city_list.'
                    </ul>        
                </div>  ';
            }

            if( !empty($select_area_list) ){
                print'
                <div class="dropdown form-control" >
                    <div data-toggle="dropdown" id="sidebar_filter_areas" class="sidebar_filter_menu">'. __('All Areas','wpestate').'<span class="caret caret_sidebar"></span> </div>           
                    <input type="hidden" name="advanced_area" value="">
                    <ul id="sidebar_filter_area" class="dropdown-menu filter_menu" role="menu" aria-labelledby="sidebar_filter_areas">
                        '.$select_area_list.'
                    </ul>        
                </div>';
            }
            print'    
            <input type="text" id="adv_rooms_widget" name="advanced_rooms" placeholder="'.__('Type Bedrooms No.','wpestate').'"      class="advanced_select form-control">
            <input type="text" id="adv_bath_widget"  name="advanced_bath"  placeholder="'.__('Type Bathrooms No.','wpestate').'"  class="advanced_select form-control">';


            $show_slider_price  =   get_option('wp_estate_show_slider_price','');

            if ($show_slider_price =='yes'){
                $where_currency     =   esc_html( get_option('wp_estate_where_currency_symbol', '') );
                $currency           =   esc_html( get_option('wp_estate_currency_symbol', '') );
                $min_price_slider   = ( floatval(get_option('wp_estate_show_slider_min_price','')) );
                $max_price_slider   = ( floatval(get_option('wp_estate_show_slider_max_price','')) );

                if ($where_currency == 'before') {
                 $price_slider_label = $currency . number_format($min_price_slider).' '.__('to','wpestate').' '.$currency . number_format($max_price_slider);
             } else {
                 $price_slider_label =  number_format($min_price_slider).$currency.' '.__('to','wpestate').' '.number_format($max_price_slider).$currency;
             }
             print'
             <div class="adv_search_widget">
                <p>
                    <label for="amount_wd">'.__('Price range:','wpestate').'</label>
                    <span id="amount_wd" readonly style="border:0; font-weight:bold;">'.$price_slider_label.'</span>
                </p>
                <div id="slider_price_widget"></div>
                <input type="hidden" id="price_low_widget"  name="price_low"  value="'.$min_price_slider.'"/>
                <input type="hidden" id="price_max_widget"  name="price_max"  value="'.$max_price_slider.'"/>
            </div>';

        }else{
            print '
            <input type="text" id="price_low_widget" name="price_low"  class="advanced_select form-control" placeholder="'.__('Type Min. Price','wpestate').'"/>
            <input type="text" id="price_max_widget" name="price_max"  class="advanced_select form-control" placeholder="'.__('Type Max. Price','wpestate').'"/>';
        }

    }
    
}// end class
?>