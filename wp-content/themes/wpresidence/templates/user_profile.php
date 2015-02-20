<?php
global $current_user;
get_currentuserinfo();
$userID                 =   $current_user->ID;
$user_login             =   $current_user->user_login;
$first_name             =   get_the_author_meta( 'first_name' , $userID );
$last_name              =   get_the_author_meta( 'last_name' , $userID );
$user_email             =   get_the_author_meta( 'user_email' , $userID );
$user_mobile            =   get_the_author_meta( 'mobile' , $userID );
$user_phone             =   get_the_author_meta( 'phone' , $userID );
$description            =   get_the_author_meta( 'description' , $userID );
$facebook               =   get_the_author_meta( 'facebook' , $userID );
$twitter                =   get_the_author_meta( 'twitter' , $userID );
$linkedin               =   get_the_author_meta( 'linkedin' , $userID );
$pinterest              =   get_the_author_meta( 'pinterest' , $userID );
$user_skype             =   get_the_author_meta( 'skype' , $userID );

$user_title             =   get_the_author_meta( 'title' , $userID );
$user_custom_picture    =   get_the_author_meta( 'custom_picture' , $userID );
$user_small_picture     =   get_the_author_meta( 'small_custom_picture' , $userID );
$image_id               =   get_the_author_meta( 'small_custom_picture',$userID); 
$about_me               =   get_the_author_meta( 'description' , $userID );
if($user_custom_picture==''){
    $user_custom_picture=get_template_directory_uri().'/img/default.jpg';
}
$user_option                    =   'favorites'.$userID;
$curent_fav                     =   get_option($user_option);

$author_query = array('posts_per_page' => '1','author' => $userID);
$author_posts = new WP_Query($author_query);

?>

<div class="user_profile_div">    
            <h4 class="mon_profil">MON PROFIL</h4>
        <div class="add-estate profile-page row overwrite_marg_row">  
            <div class="profile_div col-md-3 col-sm-3 col-xs-3" id="profile-div">
                <?php print '<img class="avatar-200" src="'.$user_custom_picture.'" alt="user image" data-profileurl="'.$user_custom_picture.'" data-smallprofileurl="'.$image_id.'" >'; ?>
            </div>
            <div class="col-md-8 col-sm-8 col-xs-8 noms_profil">
                <ul class="list-stylez">
                    <li class="size_info_profil"><span class="gras"><?php echo $user_login . " "?></span>( Public )</li>
                    <li class="size_info_profil"><span class="gras"><?php echo $first_name . " "?></span><span class="gras"><?php echo $last_name . " "?></span>( Confidentiel )</li>
                    <li class="size_info_profil"><span class="gras">Mail : </span><span><?php echo $user_email . " "?></span>( Confidentiel )</li>
                    <li class="size_info_profil"><span class="gras">Téléphone : </span><span><?php echo $user_phone . " "?></span></li>
                </ul>
            </div>
           

        </div>
        <br>
        <hr>
        <div class="row overwrite_marg_row">
            <div class="col-md-6 col-sm-6 col-xs-6 padd0">
                <h4 class="blackos">Mon annonce en ligne :</h4>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6 padd0">
                <h4 class="blackos marg">Les statistiques de mon annonce :</h4>
            </div>
        </div>
         <div class="row overwrite_marg_row">
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
                        print '<h4>'.__('You don\'t have any properties yet!','wpestate').'</h4>';
                     $autofill='';
                       
                    while ($prop_selection->have_posts()): $prop_selection->the_post();          
                           get_template_part('templates/dashboard_listing_unit'); 
                            $autofill.= '"'.get_the_title().'",';
                    endwhile;      
                    ?>
             <div class="col-md-6 col-sm-6 col-xs-6 responsivBlocs">
                <h1 class="stats">STATS</h1>
             </div>
         </div>
         <br>
        <hr>
        <div class="row overwrite_marg_row">
            <div class="col-md-6 col-sm-6 col-xs-6 padd0">
                <h4 class="blackos">Mes messages :</h4>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6 padd0">
                <h4 class="blackos">Mon forfait :</h4>
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
        <hr>
        <div class="row overwrite_marg_row">
            <div class="col-md-12 col-sm-12 col-xs-12 padd0">
                <h4 class="blackos">Mes favoris :</h4>
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