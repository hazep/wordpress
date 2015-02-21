<?php

/*
* Title                   : Booking System Pro (WordPress Plugin)
* Version                 : 2.0
* File                    : includes/calendars/class-backend-calendars.php
* File Version            : 1.0.7
* Created / Last Modified : 10 February 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO back end calendars PHP class.
*/

    if (!class_exists('DOPBSPBackEndCalendars')){
        class DOPBSPBackEndCalendars extends DOPBSPBackEnd{
            /*
             * Constructor
             */
            function DOPBSPBackEndCalendars(){
            }
        
            /*
             * Prints out the calendars page.
             * 
             * @return HTML page
             */
            function view(){
                global $DOPBSP;
                
                $DOPBSP->views->backend_calendars->template();
            }
                
            /*
             * Display calendars list.
             * 
             * @return calendars list HTML
             */
            function display(){
                global $wpdb;
                global $DOPBSP;
                                
                $calendars = array();
                $calendars_assigned = array();
                $calendars_assigned_raw = array();
                $html = array();
                
                /*
                 * If curent user is an administrator and can view all calendars get all calendars.
                 */
                if ($DOPBSP->classes->backend_settings_users->permission(wp_get_current_user()->ID, 'view-all-calendars')){
                    $calendars = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->calendars.' ORDER BY id DESC');
                }
                else{
                    /*
                     * If current user can use the booking system get the calendars he created.
                     */
                    if ($DOPBSP->classes->backend_settings_users->permission(wp_get_current_user()->ID, 'use-booking-system')){
                        $calendars = $wpdb->get_results($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->calendars.' WHERE user_id=%d ORDER BY id DESC',
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
                           $calendars_assigned_raw = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->calendars.' WHERE id IN ('.implode(', ', $calendars_found).') ORDER BY id DESC');   
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
                    arsort($calendars_assigned);
                }
                
                /* 
                 * Create calendars list HTML.
                 */
                array_push($html, '<ul>');
                
                if (count($calendars_assigned) > 0){
                    foreach ($calendars_assigned as $calendar) {
                        array_push($html, $this->listItem($calendar));
                    }
                }
                elseif (count($calendars) > 0){
                    foreach ($calendars as $calendar){
                        array_push($html, $this->listItem($calendar));  
                    }
                }
                else{
                    array_push($html, '<li class="dopbsp-no-data">'.$DOPBSP->text('CALENDARS_NO_CALENDARS').'</li>');
                }
                array_push($html, '</ul>');
                
                array_push($html, DOPBSP_DEVELOPMENT_MODE ? $this->pagination():'');
                
                echo implode('', $html);
                
            	die();                
            }
            
            /*
             * Returns calendars list item HTML.
             * 
             * @param calendar (object): calendar data
             * 
             * @return calendar list item HTML
             */
            function listItem($calendar){
                global $wpdb;
                global $DOPBSP;
                
                $html = array();
                $user = get_userdata($calendar->user_id); // Get data about the user who created the calendar.
                $reservations_no_pending = 0;
                $reservations_no_approved = 0;
                $reservations_no_rejected = 0;
                $reservations_no_canceled = 0;
                
                $DOPBSP->classes->backend_reservations->clean();
                $reservations = $wpdb->get_results($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->reservations.' WHERE calendar_id=%d  AND status <> "expired"',
                                                                  $calendar->id));
                
                /*
                 * Count the number of reservations.
                 */
                foreach ($reservations as $reservation){
                    switch ($reservation->status){
                        case 'pending':
                            $reservations_no_pending++;
                            break;
                        case 'approved':
                            $reservations_no_approved++;
                            break;
                        case 'rejected':
                            $reservations_no_rejected++;
                            break;
                        case 'canceled':
                            $reservations_no_canceled++;
                            break;
                    }
                }
                
                array_push($html, '<li class="dopbsp-item" id="DOPBSP-calendar-ID-'.$calendar->id.'" onclick="DOPBSPCalendar.init('.$calendar->id.', '.$calendar->user_id.')">');
                array_push($html, ' <div class="dopbsp-header">');
                
                /*
                 * Display calendar ID.
                 */
                array_push($html, '     <span class="dopbsp-id">ID: '.$calendar->id.'</span>');
                
                /*
                 * Display data about the user who created the calendar.
                 */
                array_push($html, '     <span class="dopbsp-header-item dopbsp-avatar">'.get_avatar($calendar->user_id, 17));
                array_push($html, '         <span class="dopbsp-info">'.$DOPBSP->text('CALENDARS_CREATED_BY').': '.$user->data->display_name.'</span>');
                array_push($html, '         <br class="dopbsp-clear" />');
                array_push($html, '     </span>');
                
                /*
                 * Display the number of pending reservations.
                 */
                array_push($html, '     <span class="dopbsp-header-item dopbsp-pending-background">');
                array_push($html, '         <span class="dopbsp-text">'.$reservations_no_pending.'</span>');
                array_push($html, '         <span class="dopbsp-info">'.$reservations_no_pending.' '.$DOPBSP->text('CALENDARS_NO_PENDING_RESERVATIONS').'</span>');
                array_push($html, '         <br class="dopbsp-clear" />');
                array_push($html, '     </span>');
                
                /*
                 * Display the number of approved reservations.
                 */
                array_push($html, '     <span class="dopbsp-header-item dopbsp-approved-background">');
                array_push($html, '         <span class="dopbsp-text">'.$reservations_no_approved.'</span>');
                array_push($html, '         <span class="dopbsp-info">'.$reservations_no_approved.' '.$DOPBSP->text('CALENDARS_NO_APPROVED_RESERVATIONS').'</span>');
                array_push($html, '         <br class="dopbsp-clear" />');
                array_push($html, '     </span>');
                
                /*
                 * Display the number of rejected reservations.
                 */
                array_push($html, '     <span class="dopbsp-header-item dopbsp-rejected-background">');
                array_push($html, '         <span class="dopbsp-text">'.$reservations_no_rejected.'</span>');
                array_push($html, '         <span class="dopbsp-info">'.$reservations_no_rejected.' '.$DOPBSP->text('CALENDARS_NO_REJECTED_RESERVATIONS').'</span>');
                array_push($html, '         <br class="dopbsp-clear" />');
                array_push($html, '     </span>');
                
                /*
                 * Display the number of canceled reservations.
                 */
                array_push($html, '     <span class="dopbsp-header-item dopbsp-canceled-background">');
                array_push($html, '         <span class="dopbsp-text">'.$reservations_no_canceled.'</span>');
                array_push($html, '         <span class="dopbsp-info">'.$reservations_no_canceled.' '.$DOPBSP->text('CALENDARS_NO_CANCELED_RESERVATIONS').'</span>');
                array_push($html, '         <br class="dopbsp-clear" />');
                array_push($html, '     </span>');
                array_push($html, '     <br class="dopbsp-clear" />');
                array_push($html, ' </div>');
                array_push($html, ' <div class="dopbsp-name">'.($calendar->name == '' ? '&nbsp;':$calendar->name).'</div>');
                array_push($html, '</li>');
                
                return implode('', $html);
            }
            
            function pagination($page = 1,
                                $no_pages = 1){
                $html = array();
                
                if ($no_pages == 1){
                    return '';
                }
                
                array_push($html, '<ul>');
                array_push($html, ' <li class="dopbsp-pagination-item dopbsp-prev"></li>');
                array_push($html, ' <li class="dopbsp-pagination-item">1</li>');
                array_push($html, ' <li class="dopbsp-pagination-item">2</li>');
                array_push($html, ' <li class="dopbsp-pagination-item">3</li>');
                array_push($html, ' <li class="dopbsp-pagination-item">4</li>');
                array_push($html, ' <li class="dopbsp-pagination-item">5</li>');
                array_push($html, ' <li class="dopbsp-pagination-item dopbsp-next"></li>');
                array_push($html, '</ul>');
                
                return implode('', $html);
            }
        }
    }