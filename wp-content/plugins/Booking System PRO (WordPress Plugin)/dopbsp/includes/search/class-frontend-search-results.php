<?php

/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 2.0
* File                    : includes/search/class-frontend-search-results.php
* File Version            : 1.0.4
* Created / Last Modified : 26 January 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO front end search results PHP class.
*/

    if (!class_exists('DOPBSPFrontEndSearchResults')){
        class DOPBSPFrontEndSearchResults extends DOPBSPFrontEndSearch{
            /*
             * Constructor.
             */
            function DOPBSPFrontEndSearchResults(){
            }
            
            /*
             * Get search results.
             * 
             * @return results HTML
             */
            function get(){
                global $wpdb;
                global $DOPBSP;
                
                $id = $_POST['id'];
                $language = $_POST['language'];
                $check_in = $_POST['check_in'];
                $check_out = $_POST['check_out'];
                $start_hour = $_POST['start_hour'];
                $end_hour = $_POST['end_hour'];
                $no_items = $_POST['no_items'];
                $price_min = $_POST['price_min'];
                $price_max = $_POST['price_max'];
                $sort_by = $_POST['sort_by'];
                $sort_direction = $_POST['sort_direction'];
                $view = $_POST['view'];
                $results = $_POST['results'];
                $page = $_POST['page'];
                
                $query = array();
                
                $search = $wpdb->get_row($wpdb->prepare('SELECT calendars_excluded FROM '.$DOPBSP->tables->searches.' WHERE id=%d',
                                                        $id));
                $settings_search = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->settings_search.' WHERE search_id=%d',
                                                                 $id));
                
                /*
                 * Tables
                 */
                array_push($query, 'SELECT calendars.id, calendars.post_id, calendars.name, calendars.price_min, calendars.address, calendars.address_alt, calendars.coordinates, calendars.hours_interval_enabled, search.currency, search.currency_position');
                array_push($query, ' FROM '.$DOPBSP->tables->calendars.' calendars');
                array_push($query, ', '.$DOPBSP->tables->searches.' search');
                array_push($query, ' WHERE search.id='.$id);
                array_push($query, $view == 'map' ? ' AND calendars.coordinates<>""':'');
                
                /*
                 * Exclude calendars.
                 */
                array_push($query, ' AND calendars.post_id<>0');
                array_push($query, ' AND IF (search.hours_enabled="true", calendars.hours_enabled="true", calendars.hours_enabled="false")');
                array_push($query, $search->calendars_excluded == '' ? '':' AND calendars.id NOT IN ('.$search->calendars_excluded.')');
                
                /*
                 * Price
                 */
                if ($price_min != ''){
                    array_push($query, ' AND (calendars.price_min>='.$price_min.' AND calendars.price_min<='.$price_max.')');
                }
                
                /*
                 * Sort
                 */
                array_push($query, ' ORDER BY '.($sort_by == 'price' ? 'calendars.price_min':'calendars.name').' '.$sort_direction);
                
                /*
                 * Limit
                 */
                array_push($query, ' LIMIT 0, 2000');
                
                $calendars = $wpdb->get_results(implode('', $query));
                
                $DOPBSP->classes->translation->set($language,
                                                              false);
                
                $calendars = $this->available($calendars,
                                              $check_in,
                                              $check_out,
                                              $start_hour,
                                              $end_hour,
                                              $no_items,
                                              $settings_search);
                
                switch ($view){
                    case 'grid':
                        $DOPBSP->views->frontend_search_results_grid->template(array('calendars' => $calendars,
                                                                                     'page' => $page,
                                                                                     'results' => $results));
                        break;
                    case 'map':
                        $this->locations($calendars,
                                         $page,
                                         $results);
                        break;
                    default:
                        $DOPBSP->views->frontend_search_results_list->template(array('calendars' => $calendars,
                                                                                     'page' => $page,
                                                                                     'results' => $results));
                }
                
                die();
            }
            
            function available($calendars,
                               $check_in,
                               $check_out,
                               $start_hour,
                               $end_hour,
                               $no_items,
                               $settings_search){
                global $wpdb;
                global $DOPBSP;
                
                $availability = array();
                $available = $calendars;
                
                if ($check_in == ''
                        && $start_hour == ''){
                    return $available;
                }
                elseif ($check_in != ''
                            && $start_hour == ''){
                    if ($settings_search->hours_enabled == 'true'){
                        $availability = $wpdb->get_results($wpdb->prepare('SELECT data FROM '.$DOPBSP->tables->days_available.' WHERE day>="%s" AND day<="%s" AND hour<>"" ORDER BY unique_key',
                                                                          $check_in, $check_out));
                        
                        for ($i=0; $i<count($calendars); $i++){
                            $found = false;
                            
                            for ($j=0; $j<count($availability); $j++){
                                $data = explode('|', $availability[$j]->data);

                                if (strpos(','.$data[0].',', ','.$calendars[$i]->id.',') !== false){
                                    $found = true;
                                    break;
                                }
                            }

                            if (!$found){
                                unset($available[$i]);
                            }
                        }
                        
                        return array_values($available);
                    }
                    else{
                        $availability = $wpdb->get_results($wpdb->prepare('SELECT data FROM '.$DOPBSP->tables->days_available.' WHERE unique_key>="%s" AND unique_key<="%s" AND hour="" ORDER BY unique_key',
                                                                          $check_in.'_0', $check_out.'_0'));
                    }
                }
                elseif ($check_in == ''
                            && $start_hour != ''){
                    $availability = $wpdb->get_results($wpdb->prepare('SELECT data FROM '.$DOPBSP->tables->days_available.' WHERE hour>="%s" AND hour<="%s" AND hour<>"" ORDER BY unique_key',
                                                                      $start_hour, $end_hour));
                }
                else{
                    $availability = $wpdb->get_results($wpdb->prepare('SELECT data FROM '.$DOPBSP->tables->days_available.' WHERE day>="%s" AND day<="%s" AND hour>="%s" AND hour<="%s" AND hour<>"" ORDER BY unique_key',
                                                                      $check_in, $check_out, $start_hour, $end_hour));
                }
                
                if (count($availability) == 0){
                    $available = array();
                }
                else{
                    for ($i=0; $i<count($calendars); $i++){
                        $calendar_found = false;

                        for ($j=0; $j<count($availability)-($start_hour != '' && $calendars[$i]->hours_interval_enabled == 'true' ? 1:0); $j++){
                            $data = explode('|', $availability[$j]->data);
                            
                            if ($check_in == ''
                                    && $start_hour != ''){
                                if (strpos(','.$data[0].',', ','.$calendars[$i]->id.',') !== false){
                                    if ($no_items != ''){
                                        $ids = explode(',', $data[0]);
                                        $nos = explode(',', $data[1]);
                                        $calendars_no = array_combine($ids, $nos);

                                        if ((int)$calendars_no[$calendars[$i]->id] >= (int)$no_items){
                                            $calendar_found = true;
                                        }
                                    }
                                    else{
                                        $calendar_found = true;
                                    }
                                }
                                
                            }
                            else{
                                if (strpos(','.$data[0].',', ','.$calendars[$i]->id.',') === false){
                                    unset($available[$i]);
                                }
                                else{
                                    if ($no_items != ''){
                                        $ids = explode(',', $data[0]);
                                        $nos = explode(',', $data[1]);
                                        $calendars_no = array_combine($ids, $nos);

                                        if ((int)$calendars_no[$calendars[$i]->id] < (int)$no_items){
                                            unset($available[$i]);
                                        }
                                    }
                                }
                            }
                        }
                        
                        if ($check_in == ''
                                && $start_hour != ''
                                && !$calendar_found){
                            unset($available[$i]);
                        }
                    }
                }
                
                return array_values($available);
            }
            
            function locations($calendars,
                               $page,
                               $results){
                global $DOPBSP;
                
                $locations = array();

                for ($i=($page-1)*$results; $i<($page*$results > count($calendars) ? count($calendars):$page*$results); $i++){
                    $post = get_post($calendars[$i]->post_id);
                    $image = wp_get_attachment_image_src(get_post_thumbnail_id($calendars[$i]->post_id), 'medium');

                    $calendars[$i]->image = $image[0];
                    $calendars[$i]->link = get_permalink($calendars[$i]->post_id);
                    $calendars[$i]->price = str_replace('%s', 
                                                   '<span class="dopbsp-price">'.($DOPBSP->classes->price->set($calendars[$i]->price_min,
                                                                                  $DOPBSP->classes->currencies->get($calendars[$i]->currency),
                                                                                  $calendars[$i]->currency_position)).'<span>',
                                                   $DOPBSP->text('SEARCH_FRONT_END_RESULTS_PRICE'));
                    $calendars[$i]->text = $post->post_excerpt == '' ? wp_strip_all_tags(strip_shortcodes($post->post_content)):$post->post_excerpt;

                    /*
                     * Construct locations.
                     */
                    $calendar_found = false;

                    for ($j=0; $j<count($locations); $j++){
                        if ($locations[$j]['coordinates'] == $calendars[$i]->coordinates){
                            array_push($locations[$j]['calendars'], $calendars[$i]);
                            $calendar_found = true;
                        }
                    }

                    if (!$calendar_found){
                        array_push($locations, array('coordinates' => $calendars[$i]->coordinates,
                                                     'calendars' => array(0 => $calendars[$i])));
                    }
                }
                
                echo json_encode($locations).';;;;;';
                $DOPBSP->views->frontend_search_results->pagination(array('no' => count($calendars),
                                                                          'page' => $page,
                                                                          'results' => $results));
            }
        }
    }