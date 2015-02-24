/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 2.0
* File                    : assets/js/settings/backend-tools-repair-search-settings.js
* File Version            : 1.0
* Created / Last Modified : 26 January 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO back end repair search settings JavaScript class.
*/

var DOPBSPToolsRepairSearchSettings = new function(){
    'use strict';
    
    /*
     * Private variables
     */
    var $ = jQuery.noConflict(),
    searches = new Array();
    

    /*
     * Constructor
     */
    this.DOPBSPToolsRepairSearchSettings = function(){
    };
    
    /*
     * Initialize search settings repair.
     */
    this.init = function(){
        DOPBSP.toggleMessages('active', DOPBSP.text('TOOLS_REPAIR_SEARCH_SETTINGS_REPAIRING'));
        
        $.post(ajaxurl, {action: 'dopbsp_tools_repair_search_settings_display'}, function(data){
            $('#DOPBSP-column2 .dopbsp-column-content').html($.trim(data));
            
            $.post(ajaxurl, {action: 'dopbsp_tools_repair_search_settings_get'}, function(data){
                searches = $.trim(data).split(',');
            
                DOPBSPToolsRepairSearchSettings.set(0);
            }).fail(function(data){
                DOPBSP.toggleMessages('error', data.status+': '+data.statusText);
            });
        }).fail(function(data){
            DOPBSP.toggleMessages('error', data.status+': '+data.statusText);
        });
    };
    
    /*
     * Set repair to calendar settings.
     * 
     * @param no (Number): calendars array index
     */
    this.set = function(no){
        $.post(ajaxurl, {action: 'dopbsp_tools_repair_search_settings_set',
                         id: searches[no],
                         no: no}, function(data){
            $('#DOPBSP-tools-repair-search-settings tbody').append(data);
            
            if (no < searches.length-1){
                DOPBSPToolsRepairSearchSettings.set(no+1);
            }
            else{
                DOPBSPToolsRepairSearchSettings.clean();
            }
        }).fail(function(data){
            DOPBSP.toggleMessages('error', data.status+': '+data.statusText);
        });
    };
    
    /*
     * Clean calendars settings tables.
     */
    this.clean = function(){
        $.post(ajaxurl, {action: 'dopbsp_tools_repair_search_settings_clean'}, function(data){
            DOPBSP.toggleMessages('success', DOPBSP.text('TOOLS_REPAIR_SEARCH_SETTINGS_SUCCESS'));
        }).fail(function(data){
            DOPBSP.toggleMessages('error', data.status+': '+data.statusText);
        });
    };
    
    return this.DOPBSPToolsRepairSearchSettings();
};