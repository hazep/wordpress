<?php

/*
* Title                   : Booking System Pro (WordPress Plugin)
* Version                 : 2.0
* File                    : includes/settings/class-backend-settings-search.php
* File Version            : 1.0.1
* Created / Last Modified : 13 October 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO back end search settings PHP class.
*/

    if (!class_exists('DOPBSPBackEndSettingsSearch')){
        class DOPBSPBackEndSettingsSearch extends DOPBSPBackEndSettings{
            /*
             * Constructor
             */
            function DOPBSPBackEndSettingsSearch(){
            }
            
            /*
             * Display search settings.
             * 
             * @post id (integer): search ID
             * 
             * @return search settings HTML
             */
            function display(){
                global $DOPBSP;
                
                $DOPBSP->views->backend_settings_search->template(array('id' => $_POST['id']));
                
                die();
            }
        }
    }