/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 2.0
* File                    : assets/js/locations/backend-location.js
* File Version            : 1.0.1
* Created / Last Modified : 23 October 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO back end location JavaScript class.
*/

var DOPBSPLocation = new function(){
    'use strict';
    
    /*
     * Private variables.
     */
    var $ = jQuery.noConflict();

    /*
     * Public variables
     */
    this.ajaxRequestInProgress;
    this.ajaxRequestTimeout;
    
    /*
     * Constructor
     */
    this.DOPBSPLocation = function(){
    };
    
    /*
     * Display location.
     * 
     * @param id (Number): location ID
     * @param language (String): location current editing language
     * @param clearLocation (Boolean): clear location extra data diplay
     */
    this.display = function(id,
                            language,
                            clearLocation){
        var HTML = new Array();
        
        language = language === undefined ? ($('#DOPBSP-location-language').val() === undefined ? '':$('#DOPBSP-location-language').val()):language;
        clearLocation = clearLocation === undefined ? true:false;
        language = clearLocation ? '':language;
        
        if (clearLocation){
            DOPBSP.clearColumns(2);
        }
        DOPBSP.toggleMessages('active', DOPBSP.text('MESSAGES_LOADING'));
        
        $('#DOPBSP-column1 .dopbsp-column-content li').removeClass('dopbsp-selected');
        $('#DOPBSP-location-ID-'+id).addClass('dopbsp-selected');
        $('#DOPBSP-location-ID').val(id);
        
        $.post(ajaxurl, {action: 'dopbsp_location_display', 
                         id: id,
                         language: language}, function(data){
            HTML.push('<a href="javascript:DOPBSP.confirmation(\'LOCATIONS_DELETE_LOCATION_CONFIRMATION\', \'DOPBSPLocation.delete('+id+')\')" class="dopbsp-button dopbsp-delete"><span class="dopbsp-info">'+DOPBSP.text('LOCATIONS_DELETE_LOCATION_SUBMIT')+'</span></a>');
            HTML.push('<a href="'+DOPBSP_CONFIG_HELP_DOCUMENTATION_URL+'" target="_blank" class="dopbsp-button dopbsp-help">');
            HTML.push(' <span class="dopbsp-info dopbsp-help">');
            HTML.push(DOPBSP.text('LOCATIONS_LOCATION_HELP')+'<br /><br />');
            HTML.push(DOPBSP.text('HELP_VIEW_DOCUMENTATION'));
            HTML.push(' </span>');
            HTML.push('</a>');
            
            $('#DOPBSP-column2 .dopbsp-column-header').html(HTML.join(''));
            $('#DOPBSP-column2 .dopbsp-column-content').html(data);
            
            DOPBSPLocation.init();
        }).fail(function(data){
            DOPBSP.toggleMessages('error', data.status+': '+data.statusText);
        });
    };
    
    /*
     * Initialize location.
     */
    this.init = function(){
        /*
         * Map Init
         */

        if (typeof google === 'object' 
                && typeof google.maps === 'object'){
            DOPBSP.toggleMessages('success', DOPBSP.text('LOCATIONS_LOCATION_LOADED'));
            google.maps.event.addDomListener(window, 'load', DOPBSPLocationMap.init());
        }
        else{
            DOPBSP.toggleMessages('error', DOPBSP.text('LOCATIONS_LOCATION_NO_GOOGLE_MAPS'));
        }
    };

    /*
     * Add location.
     */
    this.add = function(){
        DOPBSP.clearColumns(2);
        DOPBSP.toggleMessages('active', DOPBSP.text('LOCATIONS_ADD_LOCATION_ADDING'));

        $.post(ajaxurl, {action: 'dopbsp_location_add'}, function(data){
            $('#DOPBSP-column1 .dopbsp-column-content').html(data);
            DOPBSP.toggleMessages('success', DOPBSP.text('LOCATIONS_ADD_LOCATION_SUCCESS'));
        }).fail(function(data){
            DOPBSP.toggleMessages('error', data.status+': '+data.statusText);
        });
    };

    /*
     * Edit location.
     * 
     * @param id (Number): location ID
     * @param type (String): field type
     * @param field (String): location field
     * @param value (String): location value
     * @param onBlur (Boolean): true if function has been called on blur event
     */
    this.edit = function(id, 
                         type, 
                         field,
                         value, 
                         onBlur){
        var calendars = new Array();
        
        onBlur = onBlur === undefined ? false:true;
        
        this.ajaxRequestInProgress !== undefined && !onBlur ? this.ajaxRequestInProgress.abort():'';
        this.ajaxRequestTimeout !== undefined ? clearTimeout(this.ajaxRequestTimeout):'';
        
        switch (field){
            case 'name':
                $('#DOPBSP-location-ID-'+id+' .dopbsp-name').html(value === '' ? '&nbsp;':value);
                break;
            case 'calendars':
                $('#DOPBSP-location-calendars input[type=checkbox]').each(function(){
                    if ($(this).is(':checked')){
                        calendars.push($(this).attr('id').split('DOPBSP-location-calendar')[1]);
                        $(this).parent().addClass('dopbsp-selected');
                    }
                    else{
                        $(this).parent().removeClass('dopbsp-selected');
                    }
                });
                value = calendars.join(',');
                break;
        }
        
        if (onBlur  
                || type === 'checkbox'
                || type === 'select' 
                || type === 'switch'){
            if (!onBlur){
                DOPBSP.toggleMessages('active-info', DOPBSP.text('MESSAGES_SAVING'));
            }
            
            $.post(ajaxurl, {action: 'dopbsp_location_edit',
                             id: id,
                             field: field,
                             value: value,
                             coordinates: $('#DOPBSP-location-coordinates').val()}, function(data){
                if (!onBlur){
                    DOPBSP.toggleMessages('success', DOPBSP.text('MESSAGES_SAVING_SUCCESS'));
                }
            }).fail(function(data){
                DOPBSP.toggleMessages('error', data.status+': '+data.statusText);
            });
        }
        else{
            DOPBSP.toggleMessages('active-info', DOPBSP.text('MESSAGES_SAVING'));
            
            this.ajaxRequestTimeout = setTimeout(function(){
                clearTimeout(this.ajaxRequestTimeout);
                
                this.ajaxRequestInProgress = $.post(ajaxurl, {action: 'dopbsp_location_edit',
                                                              id: id,
                                                              field: field,
                                                              value: value,
                                                              coordinates: $('#DOPBSP-location-coordinates').val()}, function(data){
                    DOPBSP.toggleMessages('success', DOPBSP.text('MESSAGES_SAVING_SUCCESS'));
                }).fail(function(data){
                    DOPBSP.toggleMessages('error', data.status+': '+data.statusText);
                });
            }, 600);
        }
    };

    /*
     * Delete location.
     * 
     * @param id (Number): location ID
     */
    this.delete = function(id){
        DOPBSP.toggleMessages('active', DOPBSP.text('LOCATIONS_DELETE_LOCATION_DELETING'));

        $.post(ajaxurl, {action: 'dopbsp_location_delete', 
                         id: id}, function(data){
            DOPBSP.clearColumns(2);

            $('#DOPBSP-location-ID-'+id).stop(true, true)
                                   .animate({'opacity':0}, 
                                   600, function(){
                $(this).remove();

                if (data === '0'){
                    $('#DOPBSP-column1 .dopbsp-column-content').html('<ul><li class="dopbsp-no-data">'+DOPBSP.text('LOCATIONS_NO_LOCATIONS')+'</li></ul>');
                }
                DOPBSP.toggleMessages('success', DOPBSP.text('LOCATIONS_DELETE_LOCATION_SUCCESS'));
            });
        }).fail(function(data){
            DOPBSP.toggleMessages('error', data.status+': '+data.statusText);
        });
    };

    return this.DOPBSPLocation();
};