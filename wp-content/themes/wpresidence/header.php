<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php
    // Print the <title> tag based on what is being viewed
    global $page, $paged;
    wp_title( '|', true, 'right' );

    // Add the blog name.
    bloginfo( 'name' );

    // Add the blog description for the home/front page.
    $site_description = get_bloginfo( 'description', 'display' );
    if ( $site_description && ( is_home() || is_front_page() ) )
        echo " | $site_description";

    // Add a page number if necessary:
    if ( $paged >= 2 || $page >= 2 )
        echo ' | ' . sprintf( __( 'Page %s', 'wpestate' ), max( $paged, $page ) );
    ?>
</title>



<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

<?php 
$favicon        =   esc_html( get_option('wp_estate_favicon_image','') );

if ( $favicon!='' ){
    echo '<link rel="shortcut icon" href="'.$favicon.'" type="image/x-icon" />';
} else {
    echo '<link rel="shortcut icon" href="'.get_template_directory_uri().'/img/favicon.gif" type="image/x-icon" />';
}

wp_head();
$wide_class      =   '';
$wide_status     =   esc_html(get_option('wp_estate_wide_status',''));
if($wide_status==1){
    $wide_class="wide";
}


if (get_post_type()== 'estate_property'){
    $image_id       =   get_post_thumbnail_id();
    $share_img= wp_get_attachment_image_src( $image_id, 'full'); 
    ?>
    <meta property="og:image" content="<?php echo $share_img[0]; ?>"/>
    <meta property="og:image:secure_url" content="<?php echo $share_img[0]; ?>" />
    <?php 
} 
?>
</head>


<body <?php body_class(); ?>>  
    <div class="website-wrapper">
        <div class="container main_wrapper <?php print $wide_class;?> ">


            <div class="master_header <?php print $wide_class;?>">

                <?php   
                if(esc_html ( get_option('wp_estate_show_top_bar_user_menu','') )=="yes"){
                    get_template_part( 'templates/top_bar' ); 
                } ?>

                <div class="header_wrapper">
                    <div class="header_wrapper_inside">

                        <div class="logo">
                            <a href="<?php echo home_url('','login');?>">
                                <?php
                                $logo=get_option('wp_estate_logo_image','');
                                if ( $logo!='' ){
                                 print '<img src="'.$logo.'" class="img-responsive" alt="logo"/>';
                             } else {
                                 print '<img class="img-responsive" src="'. get_template_directory_uri().'/img/logo.png" alt="logo"/>';
                             }
                             ?>
                         </a>
                     </div>

                     <?php if (is_user_logged_in()): ?>
                     <a href="#" class="buttons" id="btn-pro">
                        Accès professionnels
                    </a>
                    <a href="?page_id=7" class="buttons" id="btn-annonce">
                        Publiez votre annonce
                    </a>
                <?php else: ?>
                <div class="register-login">
                    <a id="register" href="#">Inscription</a>
                    <a id="login" href="#">Connexion</a>
                </div>
            <?php endif ?>



            <?php 
            if(esc_html ( get_option('wp_estate_show_top_bar_user_login','') )=="yes"){
             get_template_part('templates/top_user_menu');  
         }
         ?>    
<!--                 <nav id="access" role="navigation">
                    <?php  wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
                    <div class="register-login">
                        <a id="register" href="#">Inscription</a>
                        <a id="login" href="#">Connexion</a>
                    </div>
                </nav><!-- #access -->
            </div>
        </div>

    </div> 
    
    <?php get_template_part( 'header_media' ); ?>   
    <div class="container content_wrapper">