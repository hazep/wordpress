<?php

/*
* Title                   : Booking System Pro (WordPress Plugin)
* Version                 : 2.0
* File                    : includes/woocommerce/class-woocommerce-tab.php
* File Version            : 1.0.6
* Created / Last Modified : 10 February 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO WooCommerce back end tab PHP class.
*/

    if (!class_exists('DOPBSPWooCommerceTab')){
        class DOPBSPWooCommerceTab extends DOPBSPWooCommerce{
            /*
             * Constructor.
             */
            function DOPBSPWooCommerceTab(){
                /*
                 * Add tab.
                 */
                add_action('woocommerce_product_write_panel_tabs', array(&$this, 'add'));
                
                /*
                 * Add content to tab.
                 */
                add_action('woocommerce_product_write_panels', array(&$this, 'display'));
                
                /*
                 * Save tab data.
                 */
                add_action('woocommerce_process_product_meta', array(&$this, 'set'));
            }
            
            /*
             * Add booking system in product tabs list.
             * 
             * @return HTML tab button
             */
            function add(){
                global $DOPBSP;
      
                echo '<li class="dopbsp_tab"><a href="#dopbsp_tab_data">'.$DOPBSP->text('WOOCOMMERCE_TAB').'</a></li>';
            }
            
            /*
             * Display tab content.
             * 
             * @return HTML form
             */
            function display(){
                global $post;
                global $DOPBSP;
	
                $dopbsp_woocommerce_options = array('calendar' => get_post_meta($post->ID, 'dopbsp_woocommerce_calendar', true),
                                                    'language' => get_post_meta($post->ID, 'dopbsp_woocommerce_language', true) == '' ? DOPBSP_CONFIG_TRANSLATION_DEFAULT_LANGUAGE:get_post_meta($post->ID, 'dopbsp_woocommerce_language', true),
                                                    'position' => get_post_meta($post->ID, 'dopbsp_woocommerce_position', true) == '' ? 'summary':get_post_meta($post->ID, 'dopbsp_woocommerce_position', true),
                                                    'add_to_cart' => get_post_meta($post->ID, 'dopbsp_woocommerce_add_to_cart', true) == '' ? 'false':get_post_meta($post->ID, 'dopbsp_woocommerce_add_to_cart', true));	
?>
    <div id="dopbsp_tab_data" class="panel woocommerce_options_panel">
        <div class="options_group">
            <p class="form-field">
<?php 
                woocommerce_wp_select(array('id' => 'dopbsp_woocommerce_calendar',
                                            'options' => $this->getCalendars(),
                                            'label' => $DOPBSP->text('WOOCOMMERCE_TAB_CALENDAR'),
                                            'description' => $DOPBSP->text('WOOCOMMERCE_TAB_CALENDAR_HELP')));
                woocommerce_wp_select(array('id' => 'dopbsp_woocommerce_language',
                                            'options' => $this->getLanguages(),
                                            'label' => $DOPBSP->text('WOOCOMMERCE_TAB_LANGUAGE'),
                                            'description' => $DOPBSP->text('WOOCOMMERCE_TAB_LANGUAGE_HELP'),
                                            'value' => $dopbsp_woocommerce_options['language']));
                woocommerce_wp_select(array('id' => 'dopbsp_woocommerce_position',
                                            'options' => array('summary' => $DOPBSP->text('WOOCOMMERCE_TAB_POSITION_SUMMARY'),
                                                               'tabs' => $DOPBSP->text('WOOCOMMERCE_TAB_POSITION_TABS'),
                                                               'summary-tabs' => $DOPBSP->text('WOOCOMMERCE_TAB_POSITION_SUMMARY_AND_TABS')),
                                            'label' => $DOPBSP->text('WOOCOMMERCE_TAB_POSITION'),
                                            'description' => $DOPBSP->text('WOOCOMMERCE_TAB_POSITION_HELP'),
                                            'value' => $dopbsp_woocommerce_options['position']));
                woocommerce_wp_select(array('id' => 'dopbsp_woocommerce_add_to_cart',
                                            'options' => array('false' => 'WooCommerce',
                                                               'true' => $DOPBSP->text('TITLE')),
                                            'label' => $DOPBSP->text('WOOCOMMERCE_TAB_ADD_TO_CART'),
                                            'description' => $DOPBSP->text('WOOCOMMERCE_TAB_ADD_TO_CART_HELP'),
                                            'value' => $dopbsp_woocommerce_options['add_to_cart']));
?>
            </p>
        </div>	
    </div>
<?php
            }
            
            /*
             * Set booking system options for selected product.
             * 
             * @param post_id (integer): product ID
             * 
             * @post dopbsp_woocommerce_calendar (integer): calendar ID
             * @post dopbsp_woocommerce_language (string): calendar language
             * @post dopbsp_woocommerce_position (integer): calendar position
             */
            function set($post_id){
                update_post_meta($post_id, 'dopbsp_woocommerce_calendar', $_POST['dopbsp_woocommerce_calendar']);
                update_post_meta($post_id, 'dopbsp_woocommerce_language', $_POST['dopbsp_woocommerce_language']);
                update_post_meta($post_id, 'dopbsp_woocommerce_position', $_POST['dopbsp_woocommerce_position']);
                update_post_meta($post_id, 'dopbsp_woocommerce_add_to_cart', $_POST['dopbsp_woocommerce_add_to_cart']);
            }
            
            /*
             * Get calendars list.
             * 
             * @return calendars list
             */
            function getCalendars(){
                global $wpdb;
                global $DOPBSP;
                          
                $calendars = array();
                $calendars_assigned = array();
                $calendars_assigned_raw = array();        
                $calendars_list = array();
                
                /*
                 * If curent user is an administrator and can view all calendars get all calendars.
                 */
                if ($DOPBSP->classes->backend_settings_users->permission(wp_get_current_user()->ID, 'view-all-calendars')){
                    $calendars = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->calendars.' ORDER BY id ASC');
                }
                else{
                    /*
                     * If current user can use the booking system get the calendars he created.
                     */
                    if ($DOPBSP->classes->backend_settings_users->permission(wp_get_current_user()->ID, 'use-booking-system')){
                        $calendars = $wpdb->get_results($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->calendars.' WHERE user_id=%d ORDER BY id ASC',
                                                                       wp_get_current_user()->ID));
                    }

                    /*
                     * If current user has been allowed to use only some calendars.
                     */
                    if ($DOPBSP->classes->backend_settings_users->permission(wp_get_current_user()->ID, 'use-calendars')){
                        $calendars_ids = explode(',', get_user_meta(wp_get_current_user()->ID, 'DOPBSP_permissions_calendars', true));
                        $calendars_found = array();

                        foreach($calendars_ids as $calendar_id){
                            if ($calendar_id != ''){
                                array_push($calendars_found, $calendar_id);
                            }
                        }

                        if (count($calendars_found) > 0){
                           $calendars_assigned_raw = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->calendars.' WHERE id IN ('.implode(', ', $calendars_found).') ORDER BY id ASC');   
                        }
                    }
                    
                    $calendars_assigned_raw = array_merge($calendars_assigned_raw, $calendars);
                    $calendars_assigned_unique = ',';
                    
                    for ($i=0; $i<count($calendars_assigned_raw); $i++){
                        if (strpos($calendars_assigned_unique, ','.$calendars_assigned_raw[$i]->id.',') === false){
                            $calendars_assigned_unique .= $calendars_assigned_raw[$i]->id.',';
                            $calendars_assigned[$calendars_assigned_raw[$i]->id] = $calendars_assigned_raw[$i];
                        }
                    }
                    asort($calendars_assigned);
                }
                
                /* 
                 * Create calendars list.
                 */ 
                if (count($calendars_assigned) > 0){
                    $calendars_list[0] = $DOPBSP->text('WOOCOMMERCE_TAB_CALENDAR_SELECT');
                    
                    foreach ($calendars_assigned as $calendar) {
                        $calendars_list[$calendar->id] = 'ID '.$calendar->id.': '.$calendar->name;
                    }
                }
                elseif (count($calendars) > 0){
                    $calendars_list[0] = $DOPBSP->text('WOOCOMMERCE_TAB_CALENDAR_SELECT');
                    
                    foreach ($calendars as $calendar){
                        $calendars_list[$calendar->id] = 'ID '.$calendar->id.': '.$calendar->name;
                    }
                }
                else{
                    $calendars_list[0] = $DOPBSP->text('WOOCOMMERCE_TAB_CALENDAR_NO_CALENDARS');
                }
                
                return $calendars_list;
            }
            
            /*
             * Get languages list.
             * 
             * @return enabled languages 
             */
            function getLanguages(){
                global $wpdb;
                global $DOPBSP;
                
                $languages_list = array();
                
                $languages = $DOPBSP->classes->languages->languages;
                $languages_enabled = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->languages.' WHERE enabled="true"');
                
                foreach ($languages_enabled as $language_enabled){
                    for ($i=0; $i<count($languages); $i++){
                        if ($language_enabled->code == $languages[$i]['code']){
                            $languages_list[$languages[$i]['code']] = $languages[$i]['name'];
                        }
                    }
                }
                
                return $languages_list;
            }
        }
    }