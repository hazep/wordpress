<?php

/*
* Title                   : Booking System Pro (WordPress Plugin)
* Version                 : 2.0
* File                    : includes/locations/class-backend-location.php
* File Version            : 1.0
* Created / Last Modified : 20 October 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO back end location PHP class.
*/

    if (!class_exists('DOPBSPBackEndLocation')){
        class DOPBSPBackEndLocation extends DOPBSPBackEndLocations{
            private $views;
            
            /*
             * Constructor
             */
            function DOPBSPBackEndLocation(){
            }
            
            /*
             * Add a location.
             */
            function add(){
                global $wpdb;
                global $DOPBSP;
                
                $wpdb->insert($DOPBSP->tables->locations, array('user_id' => wp_get_current_user()->ID,
                                                                'name' => $DOPBSP->text('LOCATIONS_ADD_LOCATION_NAME'))); 
                
                echo $DOPBSP->classes->backend_locations->display();

            	die();
            }
            
            /*
             * Prints out the location.
             * 
             * @post id (integer): location ID
             * @post language (string): location current editing language
             * 
             * @return location HTML
             */
            function display(){
                global $DOPBSP;
                
                $id = $_POST['id'];
                $language = $_POST['language'];
                
                $DOPBSP->views->backend_location->template(array('id' => $id,
                                                         'language' => $language));
                
                die();
            }
            
            /*
             * Edit location fields.
             * 
             * @post id (integer): location ID
             * @post field (string): location field
             * @post value (string): location new value
             * @post coordinates (string): location coordinates
             */
            function edit(){
                global $wpdb;  
                global $DOPBSP;
                
                $id = $_POST['id'];
                $field = $_POST['field'];
                $value = $_POST['value'];
                $coordinates = $_POST['coordinates'];
                
                $wpdb->update($DOPBSP->tables->locations, array($field => $value), 
                                                          array('id' =>$id));
                
                if ($field == 'address'){
                    $wpdb->update($DOPBSP->tables->locations, array('address_en' => $DOPBSP->classes->prototypes->getEnglishCharacters($value)), 
                                                              array('id' =>$id));
                    $wpdb->update($DOPBSP->tables->locations, array('coordinates' => $coordinates), 
                                                              array('id' =>$id));
                } 
                else if ($field == 'address_alt'){
                    $wpdb->update($DOPBSP->tables->locations, array('address_alt_en' => $DOPBSP->classes->prototypes->getEnglishCharacters($value)), 
                                                              array('id' =>$id));
                }
                
                if ($field == 'address' 
                        || $field == 'calendars'){
                    $this->setCoordinates($id);
                }
                
            	die();
            }
            
            /*
             * Set coordinates from location in selected calendars.
             * 
             * @param id (integer): location ID
             * @param clean (boolean): set to "true" clean coordinates from calendars
             */
            function setCoordinates($id,
                                    $clean = false){
                global $wpdb;
                global $DOPBSP;
                
                $location = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->locations.' WHERE id=%d', 
                                                           $id));
                
                if (isset($location->calendars)
                        && $location->calendars != ''){
                    $calendars = explode(',', $location->calendars);

                    foreach($calendars as $calendar){
                        $wpdb->update($DOPBSP->tables->calendars, array('address' => $clean ? '':$location->address,
                                                                        'address_en' => $clean ? '':$location->address_en,
                                                                        'address_alt' => $clean ? '':$location->address_alt,
                                                                        'address_alt_en' => $clean ? '':$location->address_alt_en,
                                                                        'coordinates' => $clean ? '':$location->coordinates), 
                                                                  array('id' => $calendar));
                    }
                }
            }
            
            /*
             * Delete location.
             * 
             * @post id (integer): location ID
             * 
             * @return number of locations left
             */
            function delete(){
                global $wpdb;
                global $DOPBSP;
                
                $id = $_POST['id'];

                /*
                 * Clean coordinates from calendars.
                 */
                $this->setCoordinates($id, true);
                
                /*
                 * Delete location.
                 */
                $wpdb->delete($DOPBSP->tables->locations, array('id' => $id));
                $locations = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->locations.' ORDER BY id DESC');
                
                echo $wpdb->num_rows;

            	die();
            }
        }
    }