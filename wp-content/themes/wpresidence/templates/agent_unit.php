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

<div class="row">

    <div class="col-md-12">
        <div class="row">

            <div class="col-md-6">
                <h4 class="agent_profil">MON PROFIL D'AGENT</h4>
                <ul>
                    <li>
                        <img src="<?= get_template_directory_uri() ?>/img/default.jpg">
                    </li>
                    <li>
                        <p class="agent_profil margin_top" >Social links :</p>
                    </li>
                    <li>
                        <p class="agent_info margin_top"><?php print $agent_skype; ?></p>
                        <p class="agent_info"><?php print $agent_twitter; ?></p>
                        <p class="agent_info"><?php print $agent_facebook; ?></p>
                        <p class="agent_info"><?php print $agent_pinterest; ?></p>
                        <p class="agent_info"><?php print $agent_linkedin; ?></p>
                    </li>
                </ul>
            </div>

            <div class="col-md-6">
                <p class="agent_info"><?php print $name; ?></p>
                <p class="agent_info">Adresse : <?php print $agent_posit; ?></p>
                <p class="agent_info">Téléphone agence : <?php print $agent_phone; ?></p>
                <p class="agent_info">Mobile : <?php print $agent_mobile; ?></p>
                <p class="agent_info">Mail : <?php print $agent_email; ?></p>
            </div>

            </div>
    </div>

    <div class="col-md-12">
        <div class="property-submit-border-bottom"></div>
    </div>

    <div class="col-md-12">
        <div class="row">
            <div class="col-md-6">
                <ul>
                    <li>
                        <p class="agent_profil margin_top">Mes messages :</p>
                    </li>
                    <li class="margin_top">
                        <p ><img src="<?= get_template_directory_uri() ?>/img/lettre.png" ></p>
                    </li>
                </ul>
            </div>

            <div class="col-md-6">
                <ul>
                    <li>
                        <p class="agent_profil margin_top">Mon forfait :</p>
                    </li>
                    <li>
                        <p class="forfait">Vous voulez vendre ou louer plus rapidement, consultez</br>
                        toutes les options disponibles pour vous aider à vendre</br>
                        ou louer votre bien.</br>
                        </p></br></br>
                    </li>
                    <li style="list-style-type:circle">
                    
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

