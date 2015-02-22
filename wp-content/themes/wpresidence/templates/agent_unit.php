<?php
global $options;

$post->ID           = 11; // A REMPLACER AVEC LE CURRENT ID AGENT
$thumb_id           = get_post_thumbnail_id($post->ID);
$preview            = wp_get_attachment_image_src(get_post_thumbnail_id(), 'property_listings');
$agent_skype        = esc_html( get_post_meta($post->ID, 'agent_skype', true) );
$agent_phone        = esc_html( get_post_meta($post->ID, 'agent_phone', true) );
$agent_mobile       = esc_html( get_post_meta($post->ID, 'agent_mobile', true) );
$agent_email        = esc_html( get_post_meta($post->ID, 'agent_email', true) );

if (function_exists('icl_translate') ){
    $agent_posit      =   icl_translate('wpestate','agent_position', esc_html( get_post_meta($post->ID, 'agent_position', true) ) );
}else{
    $agent_posit        = esc_html( get_post_meta($post->ID, 'agent_position', true) );
}

$agent_facebook     = esc_html( get_post_meta($post->ID, 'agent_facebook', true) );
$agent_twitter      = esc_html( get_post_meta($post->ID, 'agent_twitter', true) );
$agent_linkedin     = esc_html( get_post_meta($post->ID, 'agent_linkedin', true) );
$agent_pinterest    = esc_html( get_post_meta($post->ID, 'agent_pinterest', true) );
$name               = get_the_title(11);
$link               = get_permalink();
$extra= array(
    'data-original'=>$preview[0],
    'class' => 'lazyload img-responsive',    
    );
$thumb_prop    = get_the_post_thumbnail($post->ID, 'property_listings',$extra);

if($thumb_prop==''){
    $thumb_prop = '<img src="'.get_template_directory_uri().'/img/default_user.png" alt="agent-images">';
}

$col_class=4;
if($options['content_class']=='col-md-12'){
    $col_class=3;
}

?>

<div class="user_profile_div">    
            <h4 class="mon_profil marg_l">Prolfil Agent</h4>
        <div class="add-estate profile-page row overwrite_marg_row col-md-12 regl-marg marg_l">  
            <div class="profile_div col-md-3" id="profile-div">
                <img class="avatar-200" src="<?= get_template_directory_uri() ?>/img/default.jpg">
            </div>
            <div class="col-md-8 noms_profil">
                <ul class="list-stylez">
                    <li class="size_info_profil"><span class="gras"><?php print $name;?></span> ( Public )</li>
                    <li class="size_info_profil"><span class="gras"><?php print $agent_posit;?></span> ( Public )</li>
                    <li class="size_info_profil"><span class="gras">Mail : </span><span><?php print $agent_email;?></span> ( Public )</li>
                    <li class="size_info_profil"><span class="gras">Téléphone : </span><span><?php print $agent_mobile;?></span></li>
                </ul>
            </div>
           

        </div>
        <br>
        <hr>
        <div class="row overwrite_marg_row marg_l">
            <div class="col-md-6 col-sm-6 col-xs-6 padd0">
                <h4 class="blackos">Mon annonce en ligne :</h4>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6 padd0">
                <h4 class="blackos marg">Les statistiques de mon annonce :</h4>
            </div>
        </div>
         <div class="row overwrite_marg_row marg_l">
            <?php
                    $paged        = (get_query_var('paged')) ? get_query_var('paged') : 1;
                    $args = array(
                            'post_type'        =>  'estate_property',
                            'author'           =>  $current_user->ID,
                            'order' => 'desc',
                            'posts_per_page'    => 1,
                            );


                    $prop_selection = new WP_Query($args);
                    if( !$prop_selection->have_posts() )
                        print '<h4>'.__('Vous avez 0 propriétées','wpestate').'</h4>';
                     $autofill='';
                       
                    while ($prop_selection->have_posts()): $prop_selection->the_post();          
                           get_template_part('templates/dashboard_listing_unit_1'); 
                            $autofill.= '"'.get_the_title().'",';
                    endwhile;      
                    ?>
             <div class="col-md-6 col-sm-6 col-xs-6 responsivBlocs regl-marg-title">
                <h1 class="stats">STATS</h1>
             </div>
         </div>
         <br>
        <div class="row overwrite_marg_row">
        <hr>
            <div class="col-md-6 col-sm-6 col-xs-6 padd0">
                <h4 class="blackos fav_marg">Mes messages :</h4>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6 padd0">
                <h4 class="blackos fav_marg">Mon forfait :</h4>
            </div>
        </div>
        <div class="row overwrite_marg_row">
            <div class="col-md-6 col-sm-6 col-xs-6" style="padding:0px!important; margin-top:15px;">
                <div class="img_lettre">
                </div>
                <div class="pCnt2">
                <p style="margin-left:10px; margin-top:33px;">Consultez votre boite de réception.</p>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="padding:0px!important; margin-top:15px;">
                <p >Vous voulez vendre ou louer plus rapidement, consultez</p>
                <p style="line-height:2;">toutes les options disponibles pour vous aider à vendre</p>
                <p style="">votre bien.</p>
                <ul class="list_info" style="margin-top:15px;">
                    <li>Jusqu'à 10 photos - panorama + vidéo</li>
                    <li style="line-height:2;">Statistiques détaillées</li>
                    <li>Remonter votre annonce en tête de liste</li>
                    <li style="line-height:2;">Mettre votre annonce en avant</li>
                    <li>Bannière "URGENT"</li>
                </ul>
            </div>
        </div>
        <br>
        <div class="row overwrite_marg_row">
        <hr>
            <div class="col-md-12 col-sm-12 col-xs-12 padd0">
                <h4 class="blackos fav_marg">Mes favoris :</h4>
            </div>
        </div>
        <div class="row overwrite_marg_row">
            
                <?php
        if( !empty($curent_fav)){
             $args = array(
                 'post_type'        => 'estate_property',
                 'post_status'      => 'publish',
                 'post__in'         => $curent_fav,
                 'order' => 'desc',
                 'posts_per_page'    => 4,
             );

             $prop_selection = new WP_Query($args);
             $counter = 0;
             $options['related_no']=4;
             while ($prop_selection->have_posts()): $prop_selection->the_post(); 
                    get_template_part('templates/dashboard_listing_unit');
         
             endwhile;
        }else{
            print '<h4>'.__('Vous avez 0 favoris.','wpestate').'</h4>';
        }
        ?>   
            
        </div>

 </div>

