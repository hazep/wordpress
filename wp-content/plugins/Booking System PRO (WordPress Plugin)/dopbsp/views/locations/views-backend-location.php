<?php

/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 2.0
* File                    : views/locations/views-backend-location.php
* File Version            : 1.0.3
* Created / Last Modified : 25 January 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO back end location views class.
*/

    if (!class_exists('DOPBSPViewsBackEndLocation')){
        class DOPBSPViewsBackEndLocation extends DOPBSPViewsBackEndLocations{
            /*
             * Constructor
             */
            function DOPBSPViewsBackEndLocation(){
            }
            
            /*
             * Returns location.
             * 
             * @param args (array): function arguments
             *                      * id (integer): location ID
             *                      * language (string): location language
             * 
             * @return location HTML
             */
            function template($args = array()){
                global $wpdb;
                global $DOPBSP;
                
                $id = $args['id'];
                
                $location = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->locations.' WHERE id=%d',
                                                          $id));
?>
                <div class="dopbsp-inputs-wrapper">
<?php                    
                /*
                 * Name
                 */
                $this->displayTextInput(array('id' => 'name',
                                              'label' => $DOPBSP->text('LOCATIONS_LOCATION_NAME'),
                                              'value' => $location->name,
                                              'location_id' => $location->id,
                                              'help' => $DOPBSP->text('LOCATIONS_LOCATION_NAME_HELP'),
                                              'container_class' => 'dopbsp-last'));
?>
                </div>
<?php           
                
                $this->templateMap($location);
                $this->templateCalendars($location);
            }
            
            /*
             * Returns location map template.
             * 
             * @param location (object): location data
             * 
             * @return map HTML
             */
            function templateMap($location){
                global $DOPBSP;
?>
                <div class="dopbsp-inputs-header dopbsp-hide">
                    <h3><?php echo $DOPBSP->text('LOCATIONS_LOCATION_MAP'); ?></h3>
                    <a href="javascript:DOPBSP.toggleInputs('location-map')" id="DOPBSP-inputs-button-location-map" class="dopbsp-button"></a>
                </div>
                <div id="DOPBSP-inputs-location-map" class="dopbsp-inputs-wrapper">
                    <!--
                        Location
                    -->
                    <div class="dopbsp-input-wrapper">
                        <label for="DOPBSP-location-address"><?php echo $DOPBSP->text('LOCATIONS_LOCATION_ADDRESS'); ?></label>
                        <input type="text" name="DOPBSP-location-address" id="DOPBSP-location-address" value="<?php echo $location->address; ?>" onkeyup="if ((event.keyCode||event.which) !== 9){DOPBSPLocation.edit('<?php echo $location->id; ?>', 'text', 'address', this.value); DOPBSPLocationMapHints.display();}" onpaste="DOPBSPLocation.edit('<?php echo $location->id; ?>', 'text', 'address', this.value); DOPBSPLocationMapHints.display();" onblur="DOPBSPLocation.edit('<?php echo $location->id; ?>', 'text', 'address', this.value, true); setTimeout(function(){DOPBSPLocationMapHints.clear();}, 300);" />
                        <a href="<?php echo DOPBSP_CONFIG_HELP_DOCUMENTATION_URL; ?>" target="_blank" class="dopbsp-button dopbsp-help"><span class="dopbsp-info dopbsp-help"><?php echo $DOPBSP->text('LOCATIONS_LOCATION_ADDRESS_HELP'); ?><br /><br /><?php echo $DOPBSP->text('HELP_VIEW_DOCUMENTATION'); ?></span></a>
                    </div>
                    
                    <!--
                        Hints
                    -->
                    <ul id="DOPBSP-location-address-hints">
                        <li></li>
                    </ul>
                    
                    <!--
                        Coordinates
                    -->
                    <input type="hidden" name="DOPBSP-location-coordinates" id="DOPBSP-location-coordinates" value="<?php echo $location->coordinates; ?>" />

                    <!--
                        Map
                    -->
                    <div id="DOPBSP-location-address-map"></div>
<?php
                    
                    /*
                     * Address Alt
                     */ 
                    $this->displayTextInput(array('id' => 'address_alt',
                                                  'label' => $DOPBSP->text('LOCATIONS_LOCATION_ALT_ADDRESS'),
                                                  'value' => $location->address_alt,
                                                  'location_id' => $location->id,
                                                  'help' => $DOPBSP->text('LOCATIONS_LOCATION_ALT_ADDRESS_HELP'),
                                                  'container_class' => 'dopbsp-last'));   
                
?>
                </div>
<?php                
            }
            
            /*
             * Returns location calendars template.
             * 
             * @param location (object): location data
             * 
             * @return calendars HTML
             */
            function templateCalendars($location){
                global $DOPBSP;
?>
                <div class="dopbsp-inputs-header dopbsp-last dopbsp-hide">
                    <h3><?php echo $DOPBSP->text('LOCATIONS_LOCATION_CALENDARS'); ?></h3>
                    <a href="javascript:DOPBSP.toggleInputs('location-calendars')" id="DOPBSP-inputs-button-location-calendars" class="dopbsp-button"></a>
                </div>
                <div id="DOPBSP-inputs-location-calendars" class="dopbsp-inputs-wrapper dopbsp-last">
                    <div class="dopbsp-input-wrapper dopbsp-last">
                        <ul id="DOPBSP-location-calendars" class="dopbsp-input-list">
<?php           
                /*
                 * Calendars list.
                 */
                echo $this->listCalendars($location);
?>
                        </ul>
                    </div>
                </div>
<?php       
            }

/*
 * Inputs.
 */         
            /*
             * Create a text input for locations.
             * 
             * @param args (array): function arguments
             *                      * id (integer): location field ID
             *                      * label (string): location label
             *                      * value (string): location current value
             *                      * location_id (integer): location ID
             *                      * help (string): location help
             *                      * container_class (string): container class
             *                      * input_class (string): input class
             * 
             * @return text input HTML
             */
            function displayTextInput($args = array()){
                global $DOPBSP;
                
                $id = $args['id'];
                $label = $args['label'];
                $value = $args['value'];
                $location_id = $args['location_id'];
                $help = $args['help'];
                $container_class = isset($args['container_class']) ? $args['container_class']:'';
                $input_class = isset($args['input_class']) ? $args['input_class']:'';
                    
                $html = array();

                array_push($html, ' <div class="dopbsp-input-wrapper '.$container_class.'">');
                array_push($html, '     <label for="DOPBSP-location-'.$id.'">'.$label.'</label>');
                array_push($html, '     <input type="text" name="DOPBSP-location-'.$id.'" id="DOPBSP-location-'.$id.'" class="'.$input_class.'" value="'.$value.'" onkeyup="if ((event.keyCode||event.which) !== 9){DOPBSPLocation.edit('.$location_id.', \'text\', \''.$id.'\', this.value);}" onpaste="DOPBSPLocation.edit('.$location_id.', \'text\', \''.$id.'\', this.value)" onblur="DOPBSPLocation.edit('.$location_id.', \'text\', \''.$id.'\', this.value, true)" />');
                array_push($html, '     <a href="'.DOPBSP_CONFIG_HELP_DOCUMENTATION_URL.'" target="_blank" class="dopbsp-button dopbsp-help"><span class="dopbsp-info dopbsp-help">'.$help.'<br /><br />'.$DOPBSP->text('HELP_VIEW_DOCUMENTATION').'</span></a>');                        
                array_push($html, ' </div>');

                echo implode('', $html);
            }
            
            /*
             * Get calendars list.
             * 
             * @param location (object): location data
             * 
             * @return HTML with the calendars
             */
            function listCalendars($location){
                global $wpdb;
                global $DOPBSP;
                 
                $calendars_data = ','.$location->calendars.',';
                
                if ($DOPBSP->classes->backend_settings_users->permission(wp_get_current_user()->ID, 'view-all-calendars')){
                    $calendars = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->calendars.' ORDER BY id ASC');
                }
                elseif ($DOPBSP->classes->backend_settings_users->permission(wp_get_current_user()->ID, 'use-booking-system')){
                    $calendars = $wpdb->get_results($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->calendars.' WHERE user_id=%d OR user_id=0 ORDER BY id ASC',
                                                                   wp_get_current_user()->ID));
                }
                
                if ($wpdb->num_rows != 0){
                    foreach ($calendars as $calendar){
?>                          
                            <li<?php echo strrpos($calendars_data, ','.$calendar->id.',') === false ? '':' class="dopbsp-selected"'; ?>>
                                <label for="DOPBSP-location-calendar<?php echo $calendar->id; ?>">
                                    <span class="dopbsp-id">ID: <?php echo $calendar->id; ?></span>
                                    <?php echo $calendar->name; ?>
                                </label>
                                <input type="checkbox" name="DOPBSP-location-calendar<?php echo $calendar->id; ?>" id="DOPBSP-location-calendar<?php echo $calendar->id; ?>"<?php echo strrpos($calendars_data, ','.$calendar->id.',') === false ? '':' checked="checked"'; ?> onclick="DOPBSPLocation.edit('<?php echo $location->id; ?>', 'checkbox', 'calendars')"  />
                            </li>
<?php
                    }
                }
                else{
?>
                            <li class="dopbsp-no-data">            
                                <?php printf($DOPBSP->text('LOCATIONS_LOCATION_NO_CALENDARS'), admin_url('admin.php?page=dopbsp-calendars')); ?>
                            </li>
<?php
                }
            }
        }
    }