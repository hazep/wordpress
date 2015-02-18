<?php
global $action;
global $edit_id;
$images='';
$thumbid='';
$attachid='';
$floor_link                     =   get_dasboard_floor_plan();
$floor_link                     =   add_query_arg( 'floor_edit', $edit_id, $floor_link ) ;
$use_floor_plans                =   get_post_meta($edit_id, 'use_floor_plans', true);
   
if ($action=='edit'){
    $arguments = array(
          'numberposts' => -1,
          'post_type' => 'attachment',
     
          'post_parent' => $edit_id,
          'post_status' => null,
          'exclude' => get_post_thumbnail_id(),
          'orderby' => 'menu_order',
          'order' => 'ASC'
      );
    $post_attachments = get_posts($arguments);
    $post_thumbnail_id = $thumbid = get_post_thumbnail_id( $edit_id );
 
   
    foreach ($post_attachments as $attachment) {
        $preview =  wp_get_attachment_image_src($attachment->ID, 'thumbnail');    
        
        if($preview[0]!=''){
            $images .=  '<div class="uploaded_images" data-imageid="'.$attachment->ID.'"><img src="'.$preview[0].'" alt="thumb" /><i class="fa fa-trash-o"></i>';
            if($post_thumbnail_id == $attachment->ID){
                $images .='<i class="fa thumber fa-star"></i>';
            }
        }else{
            $images .=  '<div class="uploaded_images" data-imageid="'.$attachment->ID.'"><img src="'.get_template_directory_uri().'/img/pdf.png" alt="thumb" /><i class="fa fa-trash-o"></i>';
            if($post_thumbnail_id == $attachment->ID){
                $images .='<i class="fa thumber fa-star"></i>';
            }
        }
        
        
        $images .='</div>';
        $attachid.= ','.$attachment->ID;
    }
}

?>
    <div class="col-md-12">
        <div class="row">
        <div class="col-md-6 marg_t">
            <div class="submit_container_header"><?php _e('AJOUTER VOS PHOTOS','wpestate');?></div>
            <label for="prop_action_category"> <?php _e('En cliquant sur le << + >>','wpestate'); $prop_action_category;?>
        </div>
        <div class="col-md-6">
            <p>
        </div>
        </div>
        <div id="upload-container">                 
            <div id="aaiu-upload-container">                 
                <div id="aaiu-upload-imagelist">
                    <ul id="aaiu-ul-list" class="aaiu-upload-list"></ul>
                </div>

                <div id="imagelist">
                <?php 
                    if($images!=''){
                        print $images;
                    }
                ?>  
                </div>
                <div class="property-submit-upload">
                    <div class="property-submit-upload-img"></div>  
                    <div class="property-submit-upload-img"></div>  
                    <div class="property-submit-upload-img"></div>              
                    <div class="property-submit-upload-img"></div>  
                    <div class="property-submit-upload-img"></div>  
                </div>
                <div class="property-submit-upload">
                    <p>
                        OPTEZ POUR LA FOMURLE PREMIUM ET AJOUTEZ JUSQU'A<br>
                        10 PHOTOS POUR METTRE EN VALEUR VOTRE BIEN.
                    </p>
                    <div class="property-submit-upload-img property-img-upload-enabled"></div>  
                    <div class="property-submit-upload-img property-img-upload-enabled"></div>  
                    <div class="property-submit-upload-img property-img-upload-enabled"></div>              
                    <div class="property-submit-upload-img property-img-upload-enabled"></div>  
                    <div class="property-submit-upload-img property-img-upload-enabled"></div>  
                </div>
                <button id="aaiu-uploader"  class="hidden wpb_button  wpb_btn-success wpb_btn-large vc_button">
                    <?php _e('Select Media','wpestate');?>
                </button>
                <input type="hidden" name="attachid" id="attachid" value="<?php echo $attachid;?>">
                <input type="hidden" name="attachthumb" id="attachthumb" value="<?php echo $thumbid;?>">
            </div>  
        </div>
        <?php
        if ($action=='edit'){
        ?>
            <a href="<?php echo $floor_link;?>" class="wpb_button manage_floor wpb_btn-success wpb_btn-large vc_button" target="_blank"><?php _e('manage floorplans','wpestate');?></a>

        <?php
        }
        ?>
    </div>  
    <div class="col-md-12">
        <div class="pull-left property-submit-border-bottom"></div>
    </div>  
