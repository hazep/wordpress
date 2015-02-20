<?php 
global $post;


$show_adv_search_visible    =   get_option('wp_estate_show_adv_search_visible','');
$close_class                =   '';
$adv_submit                 =   get_adv_search_link();

if($show_adv_search_visible=='no'){
    $close_class='adv-search-1-close';
}
if(isset( $post->ID)){
    $post_id = $post->ID;
}else{
    $post_id = '';
}




?>




<div class="adv-search-1  adv-search-2 <?php echo $close_class;?>" id="adv-search-2" data-postid="<?php echo $post_id; ?>"> 
    <div class="transparent-wrapper">
    </div> 
    <form role="search" method="get" class="visible-wrapper"  action="<?php print $adv_submit; ?>" >

        <input type="text" id="adv_location" class="form-control autocomp" name="adv_location"  placeholder="<?php _e('Search State, City or Area','wpestate');?>" value="">      


        <div class="dropdown form-control" >
            <div data-toggle="dropdown" id="adv_actions" class="filter_menu_trigger" data-value="<?php //echo $adv_actions_value1; ?>"> 
                <?php _e('Achat','wpestate');?> 
                <span class="caret caret_filter"></span> </div>           

                <input type="hidden" name="filter_search_action[]" value="<?php if(isset($_GET['filter_search_action'][0])){echo $_GET['filter_search_action'][0];}?>">
                <ul  class="dropdown-menu filter_menu" role="menu" aria-labelledby="adv_actions">
                    <?php print $action_select_list;?>
                </ul>        
            </div>



            <div class="dropdown form-control" >
                <div data-toggle="dropdown" id="adv_categ" class="filter_menu_trigger" data-value="<?php //echo  $adv_categ_value1;?>"> 
                    <?php 
                    echo  __('Type de bien','wpestate');
                    ?> 
                    <span class="caret caret_filter"></span> </div>           
                    <input type="hidden" name="filter_search_type[]" value="<?php if(isset($_GET['filter_search_type'][0])){echo $_GET['filter_search_type'][0];}?>">
                    <ul  class="dropdown-menu filter_menu" role="menu" aria-labelledby="adv_categ">
                        <?php print $categ_select_list;?>
                    </ul>        
                </div> 
                
                
                <div class="dropdown form-control" >
                    <div data-toggle="dropdown" id="adv_rooms" class="filter_menu_trigger" data-value="<?php //echo $adv_actions_value1; ?>"> 
                        <?php _e('Nombre de pieces','wpestate');?> 
                        <span class="caret caret_filter"></span> </div>           

                        <input type="hidden" name="adv_rooms" value="<?php if(isset($_GET['adv_rooms'][0])){echo $_GET['adv_rooms'][0];}?>">
                        <ul  class="dropdown-menu filter_menu" role="menu" aria-labelledby="adv_rooms">
                            <?php print $room_select_list;?>
                        </ul>        
                    </div>
                    <div class="dropdown form-control" >
                        <div data-toggle="dropdown" id="adv_bedrooms" class="filter_menu_trigger" data-value="<?php //echo $adv_actions_value1; ?>"> 
                            <?php _e('Nombre de chambres','wpestate');?> 
                            <span class="caret caret_filter"></span> </div>           

                            <input type="hidden" name="adv_bedrooms" value="<?php if(isset($_GET['adv_bedrooms'][0])){echo $_GET['adv_bedrooms'][0];}?>">
                            <ul  class="dropdown-menu filter_menu" role="menu" aria-labelledby="adv_bedrooms">
                                <?php print $bedroom_select_list;?>
                            </ul>        
                        </div>
                        <input type="text" name="size_min" value ="<?php if(isset($_GET['size_min'][0])){echo $_GET['size_min'][0];}?>" placeholder="Surface minimum">

                        <input type="text" name="price_max" value ="<?php if(isset($_GET['price_max'][0])){echo $_GET['price_max'][0];}?>" placeholder="Budget maximum">
                        <input name="submit" type="submit" class="wpb_button  wpb_btn-info wpb_btn-large vc_button" id="advanced_submit_22" value="<?php _e('SEARCH PROPERTIES','wpestate');?>">
                        <input type="hidden" name="is2" value="1">



                    </form> 


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
                jQuery("#adv_location").autocomplete({
                    source: availableTags
                });
});
                       //]]>
</script>';

?>