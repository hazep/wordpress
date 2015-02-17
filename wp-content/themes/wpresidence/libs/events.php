<?php
/////////////////////////////////////////////////////////////////////////////////////////////////
//// add weekly interval
/////////////////////////////////////////////////////////////////////////////////////////////////
add_filter( 'cron_schedules', 'wpestate_add_weekly_cron_schedule' );

if( !function_exists('wpestate_add_weekly_cron_schedule') ): 
    function wpestate_add_weekly_cron_schedule( $schedules ) {
        $schedules['weekly'] = array(
            'interval' => 604800, // 1 week in seconds
            'display'  => __( 'Once Weekly' ),
        );

        return $schedules;
    }
endif;

/////////////////////////////////////////////////////////////////////////////////////////////////
//// schedule user_checks
/////////////////////////////////////////////////////////////////////////////////////////////////

if( !function_exists('wp_estate_schedule_user_check') ): 
    function wp_estate_schedule_user_check(){
        $paid_submission_status    = esc_html ( get_option('wp_estate_paid_submission','') );
        if($paid_submission_status == 'membership' ){
            //  wpestate_check_user_membership_status_function();
            wp_clear_scheduled_hook('wpestate_check_for_users_event');
            wpestate_setup_daily_user_schedule();  
        }
    }
endif;

/////////////////////////////////////////////////////////////////////////////////////////////////
//// schedule daily USER check
/////////////////////////////////////////////////////////////////////////////////////////////////

if( !function_exists('wpestate_setup_daily_user_schedule') ): 
    function  wpestate_setup_daily_user_schedule(){
        if ( ! wp_next_scheduled( 'wpestate_check_for_users_event' ) ) {
            //daily
            wp_schedule_event( time(), 'daily', 'wpestate_check_for_users_event');
        }
    }
endif;
add_action( 'wpestate_check_for_users_event', 'wpestate_check_user_membership_status_function' );




/////////////////////////////////////////////////////////////////////////////////////////////////
//// schedule daily pin generation
/////////////////////////////////////////////////////////////////////////////////////////////////

//add_action( 'wp', 'setup_wpestate_cron_generate_pins_daily' );

if( !function_exists('setup_wpestate_cron_generate_pins_daily') ): 
    function setup_wpestate_cron_generate_pins_daily() {
            if ( ! wp_next_scheduled( 'prefix_wpestate_cron_generate_pins_daily' ) ) {
                    wp_schedule_event( time(), 'daily', 'prefix_wpestate_cron_generate_pins_daily');
            }
    }
endif;
setup_wpestate_cron_generate_pins_daily();
add_action( 'prefix_wpestate_cron_generate_pins_daily', 'wpestate_cron_generate_pins' );



if( !function_exists('wpestate_cron_generate_pins') ): 
    function wpestate_cron_generate_pins(){
        if ( get_option('wp_estate_readsys','') =='yes' ){

            $path=get_theme_root().'/wpresidence/pins.txt'; 
            if ( file_exists ($path) && is_writable ($path) ){
                  wpestate_listing_pins();
            }

        }
    }
endif;




/////////////////////////////////////////////////////////////////////////////////////////////////
//// schedule alerts
/////////////////////////////////////////////////////////////////////////////////////////////////

if( !function_exists('wp_estate_schedule_email_events') ): 
    function wp_estate_schedule_email_events(){
       $show_save_search            =   get_option('wp_estate_show_save_search','');
       $search_alert                =   intval( get_option('wp_estate_search_alert','') );

        if($show_save_search=='yes'){

            if ($search_alert==0){ // is daily
                wpestate_setup_daily_schedule();  
            }else {//is weekly
                wpestate_setup_weekly_schedule();
            }

        }else{
                wp_clear_scheduled_hook('wpestate_check_for_new_listings_event');
                update_option('wpestate_cron_saved_search','none');

        }

    }
endif;


/////////////////////////////////////////////////////////////////////////////////////////////////
//// schedule daily event
/////////////////////////////////////////////////////////////////////////////////////////////////
if( !function_exists('wpestate_setup_daily_schedule') ): 
    function  wpestate_setup_daily_schedule(){
        $schedule =   get_option('wpestate_cron_saved_search',true);
        if ( ! wp_next_scheduled( 'wpestate_check_for_new_listings' ) && $schedule!='daily'  ) {
            //daily
            wp_clear_scheduled_hook('wpestate_check_for_new_listings_event');
            wp_schedule_event( time(), 'daily', 'wpestate_check_for_new_listings_event');
            update_option('wpestate_cron_saved_search','daily');
        }
    }
endif;


/////////////////////////////////////////////////////////////////////////////////////////////////
////schedule weekly event
/////////////////////////////////////////////////////////////////////////////////////////////////
if( !function_exists('wpestate_setup_weekly_schedule') ): 
    function wpestate_setup_weekly_schedule(){
        $schedule =   get_option('wpestate_cron_saved_search',true);
        if ( ! wp_next_scheduled( 'wpestate_check_for_new_listings' ) && $schedule!='weekly' ) {
            //weekly hourly
            wp_clear_scheduled_hook('wpestate_check_for_new_listings_event');
            wp_schedule_event( time(), 'weekly', 'wpestate_check_for_new_listings_event');
            update_option('wpestate_cron_saved_search','weekly');
        }

    }
endif;
add_action( 'wpestate_check_for_new_listings_event', 'wpestate_check_for_new_listings' );

/////////////////////////////////////////////////////////////////////////////////////////////////
//// check for new listings
/////////////////////////////////////////////////////////////////////////////////////////////////

if( !function_exists('wpestate_check_for_new_listings') ): 
    function wpestate_check_for_new_listings(){
        $date_query_array=get_alert_period();
        $args = array(
            'post_type'       => 'estate_property',
            'post_status'     => 'publish',
            'posts_per_page'  => -1,
            'date_query'      => $date_query_array

        );
        $prop_selection =   new WP_Query($args);

        if ($prop_selection->have_posts()){    
            // we have new listings - we should compare searches

            wpestate_saved_search_checks();
        }else{

        }

    }
endif;


/////////////////////////////////////////////////////////////////////////////////
// 
/////////////////////////////////////////////////////////////////////////////////

if( !function_exists('wpestate_check_for_new_listings') ): 
    function wpestate_check_for_new_listings(){
           $args = array(
                    'post_type'        => 'wpestate_search',
                    'post_status'      =>  'any',
                    'posts_per_page'   => -1 ,
                );
            $prop_selection = new WP_Query($args);

            if($prop_selection->have_posts()){ 

                while ($prop_selection->have_posts()): $prop_selection->the_post(); 
                    $post_id=get_the_id();
                    $arguments      =   get_post_meta($post_id, 'search_arguments', true) ;
                    $user_email     =   get_post_meta($post_id, 'user_email', true) ;
                    $mail_content   =   wpestate_compose_send_email($arguments);
                    if($user_email!='' && $mail_content!=''){
                        $headers = 'From: noreply  <noreply@'.$_SERVER['HTTP_HOST'].'>' . "\r\n".
                        'Reply-To: noreply@'.$_SERVER['HTTP_HOST']."\r\n" .
                        'X-Mailer: PHP/' . phpversion();
                        @wp_mail(
                                $user_email,
                                __('Matching Submissions on ','wpestate').$_SERVER['HTTP_HOST'],
                                $mail_content,
                                $headers
                        );  
                    }

                endwhile;

            }

    }
endif;


/////////////////////////////////////////////////////////////////////////////////
// compose alert email
/////////////////////////////////////////////////////////////////////////////////

if( !function_exists('wpestate_compose_send_email') ): 
    function wpestate_compose_send_email($args){
        $mail_content=''; 
        $mail_content .= __('Hello,
    A new submission matching your chosen criteria has been published at ', 'wpestate').$_SERVER['HTTP_HOST'];
        $mail_content .=__('
    These are the new submissions:
        ','wpestate');
        $arguments = objectToArray( json_decode($args) );


        $arguments['date_query']=     $date_query_array=get_alert_period();


        $prop_selection = new WP_Query($arguments);

        if($prop_selection->have_posts()){ 

            while ($prop_selection->have_posts()): $prop_selection->the_post(); 
                $post_id=get_the_id();
                $mail_content .= get_the_permalink($post_id).'
         ';
            endwhile;
            $mail_content .= __('
    If you do not wish to be notified anymore please enter your account and delete the saved search.', 'wpestate');    
        }else{
            $mail_content='';   
        }
        wp_reset_postdata();
        wp_reset_query();


        return $mail_content;
    }

endif;


/////////////////////////////////////////////////////////////////////////////////
// convert object to array
/////////////////////////////////////////////////////////////////////////////////

if( !function_exists('objectToArray') ): 
    function objectToArray ($object) {
        if(!is_object($object) && !is_array($object))
            return $object;

        return array_map('objectToArray', (array) $object);
    }
endif;

/////////////////////////////////////////////////////////////////////////////////
// get email alert period
/////////////////////////////////////////////////////////////////////////////////

if( !function_exists('get_alert_period') ): 
    function get_alert_period(){
         $search_alert            =   get_option('wp_estate_search_alert','');


        if( $search_alert==0 ){ // is daly
            $today = getdate();
            $date_query_array=  array(
                                    array(
                                        'year'  => $today['year'],
                                        'month' => $today['mon'],
                                        'day'   => $today['mday'],
                                    )
                                );

        }else{ // is weekly
            $date_query_array=  array(
                                    array(
                                       'year' => date( 'Y' ),
                                       'week' => date( 'W' ),
                                    )
                                );
        }

        return $date_query_array;
    }
endif;
?>