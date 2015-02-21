<?php

/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 2.0
* File                    : views/search/views-backend-search-sidebar.php
* File Version            : 1.0.1
* Created / Last Modified : 29 October 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO back end search sidebar views class.
*/

    if (!class_exists('DOPBSPViewsFrontEndSearchSidebar')){
        class DOPBSPViewsFrontEndSearchSidebar extends DOPBSPViewsFrontEndSearch{
            /*
             * Constructor
             */
            function DOPBSPViewsFrontEndSearchSidebar(){
            }
            
            /*
             * Returns search sidebar.
             * 
             * @param args (array): function arguments
             *                      * atts (object): shortcode attributes
             *                      * settings_search (object): search settings
             * 
             * @return search HTML
             */
            function template($args = array()){
                global $DOPBSP;
                
                $atts = $args['atts'];
                $settings_search = $args['settings_search'];
                
                $id = $atts['id'];
                $hours = json_decode($settings_search->hours_definitions);
                
                $html = array();
                
                array_push($html, ' <div class="dopbsp-module">');
                array_push($html, '     <h4>'.$DOPBSP->text('SEARCH_FRONT_END_TITLE').'</h4>');
                array_push($html, ' </div>');
                
                array_push($html, ' <hr />');
                
                array_push($html, ' <div class="dopbsp-search-sidebar-form">');
                
                if ($settings_search->search_enabled == 'true'
                        && DOPBSP_DEVELOPMENT_MODE){
                    array_push($html, ' <div class="dopbsp-module">');
                    array_push($html, '     <div class="dopbsp-input-wrapper">');
                    array_push($html, '         <input type="text" name="DOPBSPSearch-search'.$id.'" id="DOPBSPSearch-search'.$id.'" class="DOPBSPSearch-search" value="" />');
                    array_push($html, '     </div>');
                    array_push($html, ' </div>');
                }
                
                array_push($html, '     <div class="dopbsp-module">');
                array_push($html, '         <div class="dopbsp-input-wrapper">');
                array_push($html, '             <input type="text" name="DOPBSPSearch-check-in-view'.$id.'" id="DOPBSPSearch-check-in-view'.$id.'" class="DOPBSPSearch-check-in-view" value="'.$DOPBSP->text('SEARCH_FRONT_END_CHECK_IN').'" />');
                array_push($html, '             <input type="hidden" name="DOPBSPSearch-check-in'.$id.'" id="DOPBSPSearch-check-in'.$id.'" value="" />');
                array_push($html, '         </div>');
                
                if ($settings_search->days_multiple_select == 'true'){
                    array_push($html, '     <div class="dopbsp-input-wrapper">');
                    array_push($html, '         <input type="text" name="DOPBSPSearch-check-out-view'.$id.'" id="DOPBSPSearch-check-out-view'.$id.'" class="DOPBSPSearch-check-out-view" value="'.$DOPBSP->text('SEARCH_FRONT_END_CHECK_OUT').'" />');
                    array_push($html, '         <input type="hidden" name="DOPBSPSearch-check-out'.$id.'" id="DOPBSPSearch-check-out'.$id.'" value="" />');
                    array_push($html, '     </div>');
                }
                array_push($html, '     </div>');
                
                if ($settings_search->hours_enabled == 'true'){
                    array_push($html, ' <div class="dopbsp-module">');
                    array_push($html, '     <div class="dopbsp-input-wrapper DOPBSPSearch-left">');
                    array_push($html, '         <label for="DOPBSPSearch-start-hour'.$id.'">'.$DOPBSP->text('SEARCH_FRONT_END_START_HOUR').'</label>');
                    array_push($html, '         <select id="DOPBSPSearch-start-hour'.$id.'" class="dopbsp-small">');
                    array_push($html, '             <option value=""></option>');
                    
                    foreach ($hours as $hour){
                        array_push($html, '         <option value="'.$hour->value.'">'.$DOPBSP->classes->prototypes->getAMPM($hour->value).'</option>');
                    }
                    array_push($html, '         </select>');
                    array_push($html, '     </div>');
                
                    if ($settings_search->hours_multiple_select == 'true'){
                        array_push($html, ' <div class="dopbsp-input-wrapper DOPBSPSearch-left"">');
                        array_push($html, '     <label for="DOPBSPSearch-end-hour'.$id.'">'.$DOPBSP->text('SEARCH_FRONT_END_END_HOUR').'</label>');
                        array_push($html, '     <select id="DOPBSPSearch-end-hour'.$id.'" class="dopbsp-small">');
                        array_push($html, '         <option value=""></option>');

                        foreach ($hours as $hour){
                            array_push($html, '     <option value="'.$hour->value.'">'.$DOPBSP->classes->prototypes->getAMPM($hour->value).'</option>');
                        }
                        array_push($html, '     </select>');
                        array_push($html, ' </div>');
                    }
                    array_push($html, '     <br class="DOPBSPSearch-clear" />');
                    array_push($html, ' </div>');
                }
                
                if ($settings_search->availability_enabled == 'true'){
                    array_push($html, ' <div class="dopbsp-module">');
                    array_push($html, '     <div class="dopbsp-input-wrapper DOPBSPSearch-left">');
                    array_push($html, '         <label for="DOPBSPSearch-no-items'.$id.'">'.$DOPBSP->text('SEARCH_FRONT_END_NO_ITEMS').'</label>');
                    array_push($html, '         <select id="DOPBSPSearch-no-items'.$id.'" class="dopbsp-small">');
                    array_push($html, '             <option value=""></option>');
                    
                    for ($i=(int)$settings_search->availability_min; $i<=(int)$settings_search->availability_max; $i++){
                        array_push($html, '         <option value="'.$i.'">'.$i.'</option>');
                    }
                    array_push($html, '         </select>');
                    array_push($html, '     </div>');
                    array_push($html, '     <br class="DOPBSPSearch-clear" />');
                    array_push($html, ' </div>');
                }
                
                if ($settings_search->price_enabled == 'true'){
                    array_push($html, ' <div class="dopbsp-module dopbsp-price">');
                    array_push($html, '     <div class="dopbsp-input-wrapper">');
                    array_push($html, '         <label id="DOPBSPSearch-price-min'.$id.'">&nbsp;</label>');
                    array_push($html, '         <label id="DOPBSPSearch-price-max'.$id.'">&nbsp;</label>');
                    array_push($html, '         <input type="hidden" name="DOPBSPSearch-price-min-value'.$id.'" id="DOPBSPSearch-price-min-value'.$id.'" value="" />');
                    array_push($html, '         <input type="hidden" name="DOPBSPSearch-price-max-value'.$id.'" id="DOPBSPSearch-price-max-value'.$id.'" value="" />');
                    array_push($html, '         <div id="DOPBSPSearch-price'.$id.'"></div>');
                    array_push($html, '     </div>');
                    array_push($html, ' </div>');
                }
                array_push($html, ' </div>');
                
                return implode("\n", $html);
            }
        }
    }