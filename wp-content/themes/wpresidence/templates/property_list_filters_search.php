<?php

global $args;

$current_name      =   '';
$current_slug      =   '';
$listings_list     =   '';


$selected_order         = __('Sort by','wpestate');
$listing_filter         = get_post_meta($post->ID, 'listing_filter',true );
$listing_filter_array   = array(
                            "1"=>__('Price High to Low','wpestate'),
                            "2"=>__('Price Low to High','wpestate'),
                            "0"=>__('Default','wpestate')
                        );

foreach($listing_filter_array as $key=>$value){
    $listings_list.= '<li role="presentation" data-value="'.$key.'">'.$value.'</li>';

    if($key==$listing_filter){
        $selected_order=$value;
    }
}   

$order_class=' order_filter_single ';  



?>


    <div class="adv_listing_filters_head advanced_filters"> 
        <input type="hidden" id="page_idx" value="<?php print $post->ID?>">
        <input type="hidden" id="searcharg" value='<?php echo json_encode ($args); ?>'>
     
        <div class="dropdown listing_filter_select order_filter <?php print $order_class;?>">
             <div data-toggle="dropdown" id="a_filter_order" class="filter_menu_trigger" data-value="1"> <?php print $selected_order; ?> <span class="caret caret_filter"></span> </div>           
             <ul id="filter_order" class="dropdown-menu filter_menu" role="menu" aria-labelledby="a_filter_order">
                 <?php print $listings_list; ?>                   
             </ul>        
        </div> 


        <div class="listing_filter_select listing_filter_views">
            <div id="grid_view" class="icon_selected"> 
                <i class="fa fa-th"></i>
            </div>
        </div>

        <div class="listing_filter_select listing_filter_views">
             <div id="list_view">
                 <i class="fa fa-bars"></i>                   
             </div>
        </div>
        
    </div>  