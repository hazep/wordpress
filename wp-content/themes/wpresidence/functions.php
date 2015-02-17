<?php
require_once 'libs/css_js_include.php';
require_once 'libs/metaboxes.php'; 
require_once 'libs/plugins.php';
require_once 'libs/help_functions.php';
require_once 'libs/pin_management.php';
require_once 'libs/ajax_functions.php';
require_once 'libs/ajax_upload.php';
require_once 'libs/3rdparty.php';
require_once 'libs/theme-setup.php';
require_once 'libs/general-settings.php';
require_once 'libs/listing_functions.php'; 
require_once 'libs/theme-slider.php'; 
require_once 'libs/agents.php'; 
require_once ('libs/invoices.php');
require_once ('libs/searches.php');
require_once ('libs/membership.php');
require_once ('libs/property.php');
require_once ('libs/shortcodes_install.php');
require_once ('libs/shortcodes.php');
require_once ('libs/widgets.php');
require_once ('libs/events.php');


add_action('after_setup_theme', 'wp_estate_init');
if( !function_exists('wp_estate_init') ):
    function wp_estate_init() {
    
        global $content_width;
        if ( ! isset( $content_width ) ) {
            $content_width = 1200;
        }
        
        load_theme_textdomain('wpestate', get_template_directory() . '/languages');
        set_post_thumbnail_size(940, 198, true);
        add_editor_style();
        add_theme_support('post-thumbnails');
        add_theme_support('automatic-feed-links'); 
        add_theme_support('custom-background' );
        wp_estate_setup();
        add_action('widgets_init', 'register_wpestate_widgets' );
        add_action('init', 'wpestate_shortcodes');
        wp_oembed_add_provider('#https?://twitter.com/\#!/[a-z0-9_]{1,20}/status/\d+#i', 'https://api.twitter.com/1/statuses/oembed.json', true);
        wpestate_image_size();
        add_filter('excerpt_length', 'wp_estate_excerpt_length');
        add_filter('excerpt_more', 'wpestate_new_excerpt_more');
        add_action('tgmpa_register', 'wpestate_required_plugins');
        add_action('wp_enqueue_scripts', 'wpestate_scripts'); // function in css_js_include.php
        add_action('admin_enqueue_scripts', 'wpestate_admin');// function in css_js_include.php
    }
endif; // end   wp_estate_init  





///////////////////////////////////////////////////////////////////////////////////////////
/////// If admin create the menu
///////////////////////////////////////////////////////////////////////////////////////////
if (is_admin()) {
    add_action('admin_menu', 'wpestate_manage_admin_menu');
}

if( !function_exists('wpestate_manage_admin_menu') ):
    
    function wpestate_manage_admin_menu() {
        global $theme_name;
        add_theme_page('WpResidence Options', 'WpResidence Options', 'administrator', 'libs/theme-admin.php', 'wpestate_new_general_set' );
        require_once 'libs/property-admin.php';
        require_once 'libs/pin-admin.php';
        require_once 'libs/theme-admin.php'; 
    }
    
endif; // end   wpestate_manage_admin_menu 










//////////////////////////////////////////////////////////////////////////////////////////////
// page details : setting sidebar position etc...
//////////////////////////////////////////////////////////////////////////////////////////////

if( !function_exists('wpestate_page_details') ):


function wpestate_page_details($post_id){
    $return_array=array();
   
    if($post_id !='' && !is_home() && !is_tax() ){      
        $sidebar_name   =  esc_html( get_post_meta($post_id, 'sidebar_select', true) );
        $sidebar_status =  esc_html( get_post_meta($post_id, 'sidebar_option', true) );
    }else{
        $sidebar_name   = esc_html( get_option('wp_estate_blog_sidebar_name', '') );
        $sidebar_status = esc_html( get_option('wp_estate_blog_sidebar', '') );
    }
    
    if(''==$sidebar_name){
        $sidebar_name='primary-widget-area';
    }
    if(''==$sidebar_status){
        $sidebar_status='right';
    }
   
    
    if( 'left'==$sidebar_status ){
        $return_array['content_class']  =   'col-md-9 col-md-push-3 rightmargin';
        $return_array['sidebar_class']  =   'col-md-3 col-md-pull-9 ';      
    }else if( $sidebar_status=='right'){
        $return_array['content_class']  =   'col-md-9 rightmargin';
        $return_array['sidebar_class']  =   'col-md-3';
    }else{
        $return_array['content_class']  =   'col-md-12';
        $return_array['sidebar_class']  =   'none';
    }
    
    $return_array['sidebar_name']  =   $sidebar_name;
   
    return $return_array;

}

endif; // end   wpestate_page_details 



///////////////////////////////////////////////////////////////////////////////////////////
/////// generate custom css
///////////////////////////////////////////////////////////////////////////////////////////

add_action('wp_head', 'wpestate_generate_options_css');

if( !function_exists('wpestate_generate_options_css') ):

function wpestate_generate_options_css() {
    $general_font   = esc_html( get_option('wp_estate_general_font', '') );
    $custom_css     = stripslashes  ( get_option('wp_estate_custom_css')  );
    $color_scheme   = esc_html( get_option('wp_estate_color_scheme', '') );
    
    if ($general_font != '' || $color_scheme == 'yes' || $custom_css != ''){
        echo "<style type='text/css'>" ;
        if ($general_font != '') {
            require_once ('libs/custom_general_font.php');
        }
      

        if ($color_scheme == 'yes') {
           require_once ('libs/customcss.php');    
        }
        print $custom_css;
       echo "</style>";  
    }
 
}

endif; // end   generate_options_css 


///////////////////////////////////////////////////////////////////////////////////////////
///////  Display navigation to next/previous pages when applicable
///////////////////////////////////////////////////////////////////////////////////////////

if (!function_exists('wp_estate_content_nav')) :
 
    function wp_estate_content_nav($html_id) {
        global $wp_query;

        if ($wp_query->max_num_pages > 1) :
            ?>
            <nav id="<?php echo esc_attr($html_id); ?>">
                <h3 class="assistive-text"><?php _e('Post navigation', 'wpestate'); ?></h3>
                <div class="nav-previous"><?php next_posts_link(__('<span class="meta-nav">&larr;</span> Older posts', 'wpestate')); ?></div>
                <div class="nav-next"><?php previous_posts_link(__('Newer posts <span class="meta-nav">&rarr;</span>', 'wpestate')); ?></div>
            </nav><!-- #nav-above -->
        <?php
        endif;
    }

endif; // wpestate_content_nav





///////////////////////////////////////////////////////////////////////////////////////////
///////  Comments
///////////////////////////////////////////////////////////////////////////////////////////

if (!function_exists('wpestate_comment')) :
    function wpestate_comment($comment, $args, $depth) {
        $GLOBALS['comment'] = $comment;
        switch ($comment->comment_type) :
            case 'pingback' :
            case 'trackback' :
                ?>
                <li class="post pingback">
                    <p><?php _e('Pingback:', 'wpestate'); ?> <?php comment_author_link(); ?><?php edit_comment_link(__('Edit', 'wpestate'), '<span class="edit-link">', '</span>'); ?></p>
                <?php
                break;
                default :
                ?>

                    
                    
                    
                <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
                   
                <?php
                $avatar = wpestate_get_avatar_url(get_avatar($comment, 55));
                print '<div class="blog_author_image singlepage" style="background-image: url(' . $avatar . ');">';
                comment_reply_link(array_merge($args, array('reply_text' => __('Reply', 'wpestate'), 'depth' => $depth, 'max_depth' => $args['max_depth'])));
                print'</div>';   
                ?>
                
                <div id="comment-<?php comment_ID(); ?>" class="comment">     
                    <?php edit_comment_link(__('Edit', 'wpestate'), '<span class="edit-link">', '</span>'); ?>
                    <div class="comment-meta">
                        <div class="comment-author vcard">
                            <?php
                            print '<div class="comment_name">' . get_comment_author_link().'</div>';                                   
                            print '<span class="comment_date">'.__(' on ','wpestate').' '. get_comment_date() . '</span>';
                            ?>
                        </div><!-- .comment-author .vcard -->

                    <?php if ($comment->comment_approved == '0') : ?>
                            <em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.', 'wpestate'); ?></em>
                            <br />
                    <?php endif; ?>

                    </div>

                    <div class="comment-content"><?php comment_text(); ?></div>
                </div><!-- #comment-## -->
                <?php
                break;
        endswitch;
    }


endif; // ends check for  wpestate_comment 



////////////////////////////////////////////////////////////////////////////////
/// Add new profile fields
////////////////////////////////////////////////////////////////////////////////

add_filter('user_contactmethods', 'wpestate_modify_contact_methods');     
if( !function_exists('wpestate_modify_contact_methods') ):

function wpestate_modify_contact_methods($profile_fields) {

	// Add new fields
        $profile_fields['facebook']                     = 'Facebook';
        $profile_fields['twitter']                      = 'Twitter';
        $profile_fields['linkedin']                     = 'Linkedin';
        $profile_fields['pinterest']                    = 'Pinterest';
	$profile_fields['phone']                        = 'Phone';
        $profile_fields['mobile']                       = 'Mobile';
	$profile_fields['skype']                        = 'Skype';
	$profile_fields['title']                        = 'Title/Position';
        $profile_fields['custom_picture']               = 'Picture Url';
        $profile_fields['small_custom_picture']         = 'Small Picture Url';
        $profile_fields['package_id']                   = 'Package Id';
        $profile_fields['package_activation']           = 'Package Activation';
        $profile_fields['package_listings']             = 'Listings available';
        $profile_fields['package_featured_listings']    = 'Featured Listings available';
        $profile_fields['profile_id']                   = 'Paypal Recuring Profile';
        $profile_fields['user_agent_id']                = 'User Agent Id';
	return $profile_fields;
}

endif; // end   wpestate_modify_contact_methods 




if( !current_user_can('activate_plugins') ) {
    function wpestate_admin_bar_render() {
        global $wp_admin_bar;
        $wp_admin_bar->remove_menu('edit-profile', 'user-actions');
       }
    
    add_action( 'wp_before_admin_bar_render', 'wpestate_admin_bar_render' );

    add_action( 'admin_init', 'wpestate_stop_access_profile' );
    if( !function_exists('wpestate_stop_access_profile') ):
    function wpestate_stop_access_profile() {
        global $pagenow;

        if( defined('IS_PROFILE_PAGE') && IS_PROFILE_PAGE === true ) {
            wp_die( __('Please edit your profile page from site interface.','wpestate') );
        }
       
        if($pagenow=='user-edit.php'){
            wp_die( __('Please edit your profile page from site interface.','wpestate') );
        } 
    }
    endif; // end   wpestate_stop_access_profile 

}// end user can activate_plugins






///////////////////////////////////////////////////////////////////////////////////////////
// prevent changing the author id when admin hit publish
///////////////////////////////////////////////////////////////////////////////////////////

add_action( 'transition_post_status', 'wpestate_correct_post_data',10,3 );

if( !function_exists('wpestate_correct_post_data') ):
    
function wpestate_correct_post_data( $strNewStatus,$strOldStatus,$post) {
    /* Only pay attention to posts (i.e. ignore links, attachments, etc. ) */
    if( $post->post_type !== 'estate_property' )
        return;

    if( $strOldStatus === 'new' ) {
        update_post_meta( $post->ID, 'original_author', $post->post_author );
    }

       
    
    /* If this post is being published, try to restore the original author */
      if( $strNewStatus === 'publish' ) {
    
         // print_r($post);         
         //$originalAuthor = get_post_meta( $post->ID, 'original_author' );
          
            $originalAuthor_id =$post->post_author;
            $user = get_user_by('id',$originalAuthor_id); 
            $user_email=$user->user_email;
            
            if( $user->roles[0]=='subscriber'){
                $headers = 'From: No Reply <noreply@'.$_SERVER['HTTP_HOST'].'>' . "\r\n";
                $message  = __('Hi there,','wpestate') . "\r\n\r\n";
                $message .= sprintf( __("Your listing was approved on  %s! You should go check it out.","wpestate"), get_option('blogname')) . "\r\n\r\n";
                wp_mail($user_email,
		    sprintf(__('[%s] Your listing was approved','wpestate'), get_option('blogname')),
                    $message,
                    $headers);
               
            }
    }
}
endif; // end   wpestate_correct_post_data 







///////////////////////////////////////////////////////////////////////////////////////////
// set 'cron job' - wp_schedule_event seems like a unrecomend option since wp-cron.php is 
// blocked by a some of the hosting providers
///////////////////////////////////////////////////////////////////////////////////////////
/*
if ( get_option('wp_estate_paid_submission','')=='membership' ){
 
    $last_time=get_option('wp_estate_cron_run','');
    $now = time();
    $interval=86400;
    //$interval=60*5; // every 5 min
   
    $last_time=$last_time+$interval;   
    $remain=$now-$last_time;
   
      
    if( ($now > $last_time ) || $last_time==''){
       update_option('wp_estate_cron_run',time());
       wpestate_check_user_membership_status_function();
    }
} 
*/



///////////////////////////////////////////////////////////////////////////////////////////
// get attachment info
///////////////////////////////////////////////////////////////////////////////////////////

if( !function_exists('wp_get_attachment') ):
    function wp_get_attachment( $attachment_id ) {

            $attachment = get_post( $attachment_id );
            return array(
                    'alt' => get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
                    'caption' => $attachment->post_excerpt,
                    'description' => $attachment->post_content,
                    'href' => get_permalink( $attachment->ID ),
                    'src' => $attachment->guid,
                    'title' => $attachment->post_title
            );
    }
endif;


add_action('get_header', 'wpestate_my_filter_head');

if( !function_exists('wpestate_my_filter_head') ):
    function wpestate_my_filter_head() {
      remove_action('wp_head', '_admin_bar_bump_cb');
    }
endif;


///////////////////////////////////////////////////////////////////////////////////////////
// loosing session fix
///////////////////////////////////////////////////////////////////////////////////////////
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head');


///////////////////////////////////////////////////////////////////////////////////////////
// remove vc as theme 
///////////////////////////////////////////////////////////////////////////////////////////

 /*     
  if (function_exists('vc_set_as_theme')) {
      vc_set_as_theme($disable_updater = false);
  }
*/

///////////////////////////////////////////////////////////////////////////////////////////
// forgot pass action
///////////////////////////////////////////////////////////////////////////////////////////

add_action('wp_head','hook_javascript');
if( !function_exists('hook_javascript') ):
function hook_javascript(){
    global $wpdb;
    $allowed_html   =   array();
    if(isset($_GET['key']) && $_GET['action'] == "reset_pwd") {
        $reset_key  = wp_kses($_GET['key'],$allowed_html);
        $user_login = wp_kses($_GET['login'],$allowed_html);
        $user_data  = $wpdb->get_row($wpdb->prepare("SELECT ID, user_login, user_email FROM $wpdb->users 
                WHERE user_activation_key = %s AND user_login = %s", $reset_key, $user_login));

            
        if(!empty($user_data)){
                $user_login = $user_data->user_login;
                $user_email = $user_data->user_email;

                if(!empty($reset_key) && !empty($user_data)) {
                        $new_password = wp_generate_password(7, false); 
                        wp_set_password( $new_password, $user_data->ID );
                        //mailing the reset details to the user
                        $message = __('Your new password for the account at:','wpestate') . "\r\n\r\n";
                        $message .= get_bloginfo('name') . "\r\n\r\n";
                        $message .= sprintf(__('Username: %s','wpestate'), $user_login) . "\r\n\r\n";
                        $message .= sprintf(__('Password: %s','wpestate'), $new_password) . "\r\n\r\n";
                        $message .= __('You can now login with your new password at: ','wpestate') . get_option('siteurl')."/" . "\r\n\r\n";

                        $headers = 'From: noreply  <noreply@'.$_SERVER['HTTP_HOST'].'>' . "\r\n".
                        'Reply-To: noreply@'.$_SERVER['HTTP_HOST']. "\r\n" .
                        'X-Mailer: PHP/' . phpversion();

                        if ( $message && !wp_mail($user_email, __('Your Password was Reset','wpestate'), $message,$headers) ) {
                                $mess= "<div class='error'>".__('Email sending has failed for some unknown reason','wpestate')."</div>";
                                //exit();
                        }
                        else {
                              $mess= '<div class="login-alert">'.__('A new password was sent via email!','wpestate').'</div>';
                             //   $redirect_to = get_bloginfo('url')."/login?action=reset_success";
                              //  wp_safe_redirect($redirect_to);
                                //exit();
                        }
                }
                else {
                    exit('Not a Valid Key.');
                }
        }// end if empty
    print '<div class="login_alert_full">'.__('We have just sent you a new password. Please check your email!','wpestate').'</div>';    
    } 

}
endif;



add_action('wpcf7_before_send_mail', 'wpcf7_update_email_body');

function wpcf7_update_email_body($contact_form) {
    
    // don't copy my code little f.... - use your brain if you have one
    $submission = WPCF7_Submission::get_instance();
    $url        = $submission->get_meta( 'url' );
    $postid     = url_to_postid( $url );
    
    if ( $submission ){
        if( isset($postid) && get_post_type($postid) == 'estate_property' ){
            $mail = $contact_form->prop('mail');
            $mail['recipient']  = wpestate_return_agent_email_listing($postid);
            $mail['body'] .= __('Message sent from page: ','wpestate').get_permalink($postid);
            $contact_form->set_properties(array('mail' => $mail));
        }
    
        if(isset($postid) && get_post_type($postid) == 'estate_agent' ){
            $mail = $contact_form->prop('mail');
            $mail['recipient']  = esc_html( get_post_meta($postid, 'agent_email', true) );
            $mail['body'] .= __('Message sent from page: ','wpestate').get_permalink($postid);
            $contact_form->set_properties(array('mail' => $mail));
        }
    
    }
   
}


function wpestate_return_agent_email_listing($postid){

    $agent_id   = intval( get_post_meta($postid, 'property_agent', true) );

    if ($agent_id!=0){   
        $agent_email = esc_html( get_post_meta($agent_id, 'agent_email', true) );
    }else{
        $author_id           =  wpsestate_get_author($postid);
        $agent_email         =  get_the_author_meta( 'user_email',$author_id  );
    }
    return $agent_email;
}
add_filter( 'option_posts_per_page', 'tdd_tax_filter_posts_per_page' );

function tdd_tax_filter_posts_per_page( $value ) {
    
    $prop_no            =   intval( get_option('wp_estate_prop_no','') );
    
  // print 'vine '.$value.' avem '.$prop_no;
    return (is_tax('estate_property')) ? 1 : $prop_no;
}
    

?>