<?php

/*
* Title                   : Booking System Pro (WordPress Plugin)
* Version                 : 2.0
* File                    : includes/settings/class-backend-settings.php
* File Version            : 1.0.9
* Created / Last Modified : 10 February 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO back end settings PHP class.
*/

    if (!class_exists('DOPBSPBackEndSettings')){
        class DOPBSPBackEndSettings extends DOPBSPBackEnd{
            /*
             * Public variables.
             */
            public $default_calendar = array();
            public $default_notifications = array();
            public $default_payment = array();
            public $default_search = array();
                        
            /*
             * Constructor
             */
            function DOPBSPBackEndSettings(){
                add_filter('dopbsp_filter_default_settings_calendar', array(&$this, 'setCalendar'), 9);
                add_filter('dopbsp_filter_default_settings_notifications', array(&$this, 'setNotifications'), 9);
                add_filter('dopbsp_filter_default_settings_payment', array(&$this, 'setPayment'), 9);
                add_filter('dopbsp_filter_default_settings_search', array(&$this, 'setSearch'), 9);
                
                add_action('init', array(&$this, 'init'));
            }
        
            /*
             * Prints out the settings page.
             */
            function view(){
                global $DOPBSP;
                
                $DOPBSP->views->backend_settings->template();
            }
            
            /*
             * Initialize settings.
             */
            function init(){
                $this->default_calendar = apply_filters('dopbsp_filter_default_settings_calendar', $this->default_calendar);
                $this->default_notifications = apply_filters('dopbsp_filter_default_settings_notifications', $this->default_notifications);
                $this->default_payment = apply_filters('dopbsp_filter_default_settings_payment', $this->default_payment);
                $this->default_search = apply_filters('dopbsp_filter_default_settings_search', $this->default_search);
            }
            
            /*
             * Edit settings.
             * 
             * @post id (integer): calendar/search ID
             * @post settings_type (integer): settings type
             * @post key (string): option key
             * @post value (combined): the value with which the option will be modified
             */
            function set(){
                global $wpdb;
                global $DOPBSP;
                
                $id = $_POST['id'];
                $settings_type = $_POST['settings_type'];
                $key = $_POST['key'];
                $value = $key == 'hours_definitions' ? json_encode($_POST['value']):$_POST['value'];
                
                switch ($settings_type){
                    case 'notifications':
                        $table = $DOPBSP->tables->settings_notifications;
                        $id_type = 'calendar_id';
                        break;
                    case 'payment':
                        $table = $DOPBSP->tables->settings_payment;
                        $id_type = 'calendar_id';
                        break;
                    case 'search':
                        $table = $DOPBSP->tables->settings_search;
                        $id_type = 'search_id';
                        break;
                    default:
                        $table = $DOPBSP->tables->settings_calendar;
                        $id_type = 'calendar_id';
                }
                
                /*
                 * Update settings tables.
                 */
                $control_data = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$table.' WHERE '.$id_type.'=%d AND unique_key=%s',
                                                              $id, $key));
                
                if ($wpdb->num_rows == 0){
                    $wpdb->insert($table, array($id_type => $id,
                                                'unique_key' => $key,
                                                'value' => $value));
                }
                else{
                    $wpdb->update($table, array('value' => $value), 
                                          array($id_type => $id,
                                                'unique_key' => $key));
                }
                
                /*
                 * Update calendars/searches tables.
                 */
                if ($id != 0){
                    switch ($key){
                        case 'currency':
                            if ($settings_type == 'search'){
                                $wpdb->update($DOPBSP->tables->searches, array('currency' => $value), 
                                                                         array('id' => $id));
                            }
                            break;
                        case 'currency_position':
                            if ($settings_type == 'search'){
                                $wpdb->update($DOPBSP->tables->searches, array('currency_position' => $value), 
                                                                         array('id' => $id));
                            }
                            break;
                        case 'hours_enabled':
                            if ($settings_type == 'calendar'){
                                $wpdb->update($DOPBSP->tables->calendars, array('hours_enabled' => $value), 
                                                                          array('id' => $id));
                            }
                            elseif ($settings_type == 'search'){
                                $wpdb->update($DOPBSP->tables->searches, array('hours_enabled' => $value), 
                                                                          array('id' => $id));
                            }
                            break;
                        case 'hours_interval_enabled':
                            if ($settings_type == 'calendar'){
                                $wpdb->update($DOPBSP->tables->calendars, array('hours_interval_enabled' => $value), 
                                                                          array('id' => $id));
                            }
                            break;
                    }
                }
                
                die();
            }
            
            /*
             * Get options values from database.
             * 
             * @post id (integer): calendar/search ID
             * @post settings_type (integer): settings type
             * 
             * @return options values object
             */
            function values($id,
                            $settings_type){
                global $wpdb;
                global $DOPBSP;
                
                $values = new stdClass;
                
                switch ($settings_type){
                    case 'notifications':
                        $table = $DOPBSP->tables->settings_notifications;
                        $defaults = $this->default_notifications;
                        $id_type = 'calendar_id';
                        break;
                    case 'payment':
                        $table = $DOPBSP->tables->settings_payment;
                        $defaults = $this->default_payment;
                        $id_type = 'calendar_id';
                        break;
                    case 'search':
                        $table = $DOPBSP->tables->settings_search;
                        $defaults = $this->default_search;
                        $id_type = 'search_id';
                        break;
                    default:
                        $table = $DOPBSP->tables->settings_calendar;
                        $defaults = $this->default_calendar;
                        $id_type = 'calendar_id';
                }
                
                $settings = $wpdb->get_results($wpdb->prepare('SELECT unique_key, value FROM '.$table.' WHERE '.$id_type.'=%d', 
                                                              $id), OBJECT_K);
                $columns = $wpdb->get_results('DESCRIBE '.$table);
                
                foreach ($defaults as $key => $default){
                    $values->$key = isset($settings[$key]) ? $settings[$key]->value:(count($columns) > 5 ? $this->value($id, $settings_type, $key):$default);
                }
                $values->$id_type = $id;
                
                return $values;
            }
            
            /*
             * Get option value from database.
             * 
             * @post id (integer): calendar/search ID
             * @post settings_type (integer): settings type
             * @post key (string): option key
             * 
             * @return option value
             */
            function value($id,
                           $settings_type,
                           $key){
                global $wpdb;
                global $DOPBSP;
                
                switch ($settings_type){
                    case 'notifications':
                        $table = $DOPBSP->tables->settings_notifications;
                        $value_default = isset($this->default_notifications[$key]) ? $this->default_notifications[$key]:'Key is invalid!';
                        $id_type = 'calendar_id';
                        break;
                    case 'payment':
                        $table = $DOPBSP->tables->settings_payment;
                        $value_default = isset($this->default_payment[$key]) ? $this->default_payment[$key]:'Key is invalid!';
                        $id_type = 'calendar_id';
                        break;
                    case 'search':
                        $table = $DOPBSP->tables->settings_search;
                        $value_default = isset($this->default_search[$key]) ? $this->default_search[$key]:'Key is invalid!';
                        $id_type = 'search_id';
                        break;
                    default:
                        $table = $DOPBSP->tables->settings_calendar;
                        $value_default = isset($this->default_calendar[$key]) ? $this->default_calendar[$key]:'Key is invalid!';
                        $id_type = 'calendar_id';
                }
                
                if ($value_default != 'Key is invalid!'){
                    $value_data = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$table.' WHERE '.$id_type.'=%d AND unique_key="%s"',
                                                                $id, $key));
                    
                    if ($wpdb->num_rows == 0){
                        $value_data = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$table.' WHERE '.$id_type.'=%d AND unique_key=""',
                                                                    $id));
                        
                        if ($wpdb->num_rows == 0){
                            $value = $value_default;
                        }
                        else{
                            $value = isset($value_data->$key) ? $value_data->$key:$value_default;
                        }
                    }
                    else{
                        $value = $value_data->value;
                    }
                }
                else{
                    $value = $value_default;
                }
                
                return $value;
            }  
            
            /*
             * Set default calendar settings.
             * 
             * @param default_calendars (array): default calendar options values
             * 
             * @return default calendar settings array
             */
            function setCalendar($default_calendar){
                $default_calendar = array('date_type' => '1',
                                          'template' => 'default',
                                          'booking_stop' => '0',
                                          'months_no' => '1',
                                          'view_only' => 'false',
                                          'max_year' => date('Y'), // REMOVE AFTER UPDATE 4.0

                                          'currency' => 'USD',
                                          'currency_position' => 'before',

                                          'days_available' => 'true,true,true,true,true,true,true',
                                          'days_details_from_hours' => 'true',
                                          'days_first' => '1',
                                          'days_first_displayed' => '',
                                          'days_morning_check_out' => 'false',
                                          'days_multiple_select' => 'true',

                                          'hours_add_last_hour_to_total_price' => 'true',
                                          'hours_ampm' => 'false',
                                          'hours_definitions' => '[{"value": "00:00"}]',
                                          'hours_enabled' => 'false',
                                          'hours_info_enabled' => 'true',
                                          'hours_interval_enabled' => 'false',
                                          'hours_multiple_select' => 'true',

                                          'sidebar_no_items_enabled' => 'true',
                                          'sidebar_style' => '1',

                                          'rule' => '0',
                                          'extra' => '0',
                                          'cart_enabled' => 'false',
                                          'discount' => '0',
                                          'fees' => '',
                                          'coupon' => '0',

                                          'deposit' => '0',
                                          'deposit_type' => 'percent',

                                          'form' => '1',
                    
                                          'terms_and_conditions_enabled' => 'false',
                                          'terms_and_conditions_link' => '');
                
                return $default_calendar;
            } 
            
            /*
             * Set default notifications settings.
             * 
             * @param default_notifications (array): default notifications options values
             * 
             * @return default notifications settings array
             */
            function setNotifications($default_notifications){
                $default_notifications = array('templates' => '1',
                                               'method_admin' => 'mailer',
                                               'method_user' => 'mailer',
                                               'email' => '',
                                               'email_reply' => '',
                                               'email_name' => '',
                                               'email_cc' => '',
                                               'email_cc_name' => '',
                                               'email_bcc' => '',
                                               'email_bcc_name' => '',

                                               'smtp_host_name' => '',
                                               'smtp_host_port' => '25',
                                               'smtp_ssl' => 'false',
                                               'smtp_tls' => 'false',
                                               'smtp_user' => '',
                                               'smtp_password' => '',

                                               'smtp_host_name2' => '',
                                               'smtp_host_port2' => '25',
                                               'smtp_ssl2' => 'false',
                                               'smtp_tls2' => 'false',
                                               'smtp_user2' => '',
                                               'smtp_password2' => '',

                                               'send_book_admin' => 'true',
                                               'send_book_user' => 'true',
                                               'send_book_with_approval_admin' => 'true',
                                               'send_book_with_approval_user' => 'true',
                                               'send_approved' => 'true',
                                               'send_canceled' => 'true',
                                               'send_rejected' => 'true');
                
                return $default_notifications;
            }
            
            /*
             * Set default payment settings.
             * 
             * @param default_payment (array): default payment options values
             * 
             * @return default payment settings array
             */
            function setPayment($default_payment){
                $default_payment = array('arrival_enabled' => 'true',
                                         'arrival_with_approval_enabled' => 'false',
                                         'redirect' => '',

                                         'address_billing_enabled' => 'false',
                                         'address_billing_first_name_enabled' => 'true',
                                         'address_billing_first_name_required' => 'true',
                                         'address_billing_last_name_enabled' => 'true',
                                         'address_billing_last_name_required' => 'true',
                                         'address_billing_company_enabled' => 'true',
                                         'address_billing_company_required' => 'false',
                                         'address_billing_email_enabled' => 'true',
                                         'address_billing_email_required' => 'true',
                                         'address_billing_phone_enabled' => 'true',
                                         'address_billing_phone_required' => 'true',
                                         'address_billing_country_enabled' => 'true',
                                         'address_billing_country_required' => 'true',
                                         'address_billing_address_first_enabled' => 'true',
                                         'address_billing_address_first_required' => 'true',
                                         'address_billing_address_second_enabled' => 'true',
                                         'address_billing_address_second_required' => 'false',
                                         'address_billing_city_enabled' => 'true',
                                         'address_billing_city_required' => 'true',
                                         'address_billing_state_enabled' => 'true',
                                         'address_billing_state_required' => 'true',
                                         'address_billing_zip_code_enabled' => 'true',
                                         'address_billing_zip_code_required' => 'true',

                                         'address_shipping_enabled' => 'false',
                                         'address_shipping_first_name_enabled' => 'true',
                                         'address_shipping_first_name_required' => 'true',
                                         'address_shipping_last_name_enabled' => 'true',
                                         'address_shipping_last_name_required' => 'true',
                                         'address_shipping_company_enabled' => 'true',
                                         'address_shipping_company_required' => 'false',
                                         'address_shipping_email_enabled' => 'true',
                                         'address_shipping_email_required' => 'true',
                                         'address_shipping_phone_enabled' => 'true',
                                         'address_shipping_phone_required' => 'true',
                                         'address_shipping_country_enabled' => 'true',
                                         'address_shipping_country_required' => 'true',
                                         'address_shipping_address_first_enabled' => 'true',
                                         'address_shipping_address_first_required' => 'true',
                                         'address_shipping_address_second_enabled' => 'true',
                                         'address_shipping_address_second_required' => 'false',
                                         'address_shipping_city_enabled' => 'true',
                                         'address_shipping_city_required' => 'true',
                                         'address_shipping_state_enabled' => 'true',
                                         'address_shipping_state_required' => 'true',
                                         'address_shipping_zip_code_enabled' => 'true',
                                         'address_shipping_zip_code_required' => 'true',

                                         'paypal_enabled' => 'false',
                                         'paypal_username' => '',
                                         'paypal_password' => '',
                                         'paypal_signature' => '',
                                         'paypal_credit_card' => 'false',
                                         'paypal_sandbox_enabled' => 'false',
                                         'paypal_redirect' => '');
                
                return $default_payment;
            }
            
            /*
             * Set default search settings.
             * 
             * @param default_search (array): default search options values
             * 
             * @return default search settings array
             */
            function setSearch($default_search){
                $default_search = array('date_type' => '1',
                                        'template' => 'default',
                                        'search_enabled' => 'false',
                                        'price_enabled' => 'true',

                                        'view_default' => 'list',
                                        'view_list_enabled' => 'true',
                                        'view_grid_enabled' => 'false',
                                        'view_map_enabled' => 'false',
                                        'view_results_page' => '10',
                                        'view_sidebar_position' => 'left',

                                        'currency' => 'USD',
                                        'currency_position' => 'before',

                                        'days_first' => '1',
                                        'days_multiple_select' => 'true',

                                        'hours_ampm' => 'false',
                                        'hours_definitions' => '[{"value": "00:00"},{"value": "01:00"},{"value": "02:00"},{"value": "03:00"},{"value": "04:00"},{"value": "05:00"},{"value": "06:00"},{"value": "07:00"},{"value": "08:00"},{"value": "09:00"},{"value": "10:00"},{"value": "11:00"},{"value": "12:00"},{"value": "13:00"},{"value": "14:00"},{"value": "15:00"},{"value": "16:00"},{"value": "17:00"},{"value": "18:00"},{"value": "19:00"},{"value": "20:00"},{"value": "21:00"},{"value": "22:00"},{"value": "23:00"}]',
                                        'hours_enabled' => 'false',
                                        'hours_multiple_select' => 'true',

                                        'availability_enabled' => 'false',
                                        'availability_max' => '10',
                                        'availability_min' => '1');
                
                return $default_search;
            }
        }
    }