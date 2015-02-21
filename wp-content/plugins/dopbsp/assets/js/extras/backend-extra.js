/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 2.0
* File                    : assets/js/extras/backend-extra.js
* File Version            : 1.0.4
* Created / Last Modified : 23 October 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO back end extra JavaScript class.
*/


var DOPBSPExtra = new function(){
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
    this.DOPBSPExtra = function(){
    };
    
    /*
     * Display extra.
     * 
     * @param id (Number): extra ID
     * @param language (String): extra current editing language
     * @param clearExtra (Boolean): clear current extra data diplay
     */
    this.display = function(id,
                            language,
                            clearExtra){
        var HTML = new Array();
        
        language = language === undefined ? ($('#DOPBSP-extra-language').val() === undefined ? '':$('#DOPBSP-extra-language').val()):language;
        clearExtra = clearExtra === undefined ? true:false;
        language = clearExtra ? '':language;
        
        if (clearExtra){
            DOPBSP.clearColumns(2);
        }
        DOPBSP.toggleMessages('active', DOPBSP.text('MESSAGES_LOADING'));
        
        $('#DOPBSP-column1 .dopbsp-column-content li').removeClass('dopbsp-selected');
        $('#DOPBSP-extra-ID-'+id).addClass('dopbsp-selected');
        $('#DOPBSP-extra-ID').val(id);
        
        $.post(ajaxurl, {action: 'dopbsp_extra_display', 
                         id: id,
                         language: language}, function(data){
            HTML.push('<a href="javascript:DOPBSP.confirmation(\'EXTRAS_DELETE_EXTRA_CONFIRMATION\', \'DOPBSPExtra.delete('+id+')\')" class="dopbsp-button dopbsp-delete"><span class="dopbsp-info">'+DOPBSP.text('EXTRAS_DELETE_EXTRA_SUBMIT')+'</span></a>');
            HTML.push('<a href="'+DOPBSP_CONFIG_HELP_DOCUMENTATION_URL+'" target="_blank" class="dopbsp-button dopbsp-help">');
            HTML.push(' <span class="dopbsp-info dopbsp-help">');
            HTML.push(DOPBSP.text('EXTRAS_EXTRA_ADD_GROUP_HELP')+'<br /><br />');
            HTML.push(DOPBSP.text('EXTRAS_EXTRA_EDIT_GROUP_HELP')+'<br /><br />');
            HTML.push(DOPBSP.text('EXTRAS_EXTRA_DELETE_GROUP_HELP')+'<br /><br />');
            HTML.push(DOPBSP.text('EXTRAS_EXTRA_SORT_GROUP_HELP')+'<br /><br />');
            HTML.push(DOPBSP.text('HELP_VIEW_DOCUMENTATION'));
            HTML.push(' </span>');
            HTML.push('</a>');
            
            $('#DOPBSP-column2 .dopbsp-column-header').html(HTML.join(''));
            $('#DOPBSP-column2 .dopbsp-column-content').html(data);
            
            DOPBSPExtraGroups.init();
            DOPBSPExtraGroupItems.init();
            DOPBSPExtraGroupItem.init();
            DOPBSP.toggleMessages('success', DOPBSP.text('EXTRAS_EXTRA_LOADED'));
        }).fail(function(data){
            DOPBSP.toggleMessages('error', data.status+': '+data.statusText);
        });
    };

    /*
     * Add extra.
     */
    this.add = function(){
        DOPBSP.clearColumns(2);
        DOPBSP.toggleMessages('active', DOPBSP.text('EXTRAS_ADD_EXTRA_ADDING'));

        $.post(ajaxurl, {action: 'dopbsp_extra_add'}, function(data){
            $('#DOPBSP-column1 .dopbsp-column-content').html(data);
            DOPBSP.toggleMessages('success', DOPBSP.text('EXTRAS_ADD_EXTRA_SUCCESS'));
        }).fail(function(data){
            DOPBSP.toggleMessages('error', data.status+': '+data.statusText);
        });
    };

    /*
     * Edit extra.
     * 
     * @param id (Number): extra ID
     * @param type (String): field type
     * @param field (String): group field
     * @param value (String): group value
     * @param onBlur (Boolean): true if function has been called on blur event
     */
    this.edit = function(id, 
                         type,
                         field,
                         value, 
                         onBlur){
        onBlur = onBlur === undefined ? false:true;
        
        this.ajaxRequestInProgress !== undefined && !onBlur ? this.ajaxRequestInProgress.abort():'';
        this.ajaxRequestTimeout !== undefined ? clearTimeout(this.ajaxRequestTimeout):'';
        
        switch (field){
            case 'name':
                $('#DOPBSP-extra-ID-'+id+' .dopbsp-name').html(value === '' ? '&nbsp;':value);
                break;
        }
        
        if (onBlur 
                || type === 'select' 
                || type === 'switch'){
            if (!onBlur){
                DOPBSP.toggleMessages('active-info', DOPBSP.text('MESSAGES_SAVING'));
            }
            
            $.post(ajaxurl, {action: 'dopbsp_extra_edit',
                             id: id,
                             field: field,
                             value: value}, function(data){
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

                this.ajaxRequestInProgress = $.post(ajaxurl, {action: 'dopbsp_extra_edit',
                                                              id: id,
                                                              field: field,
                                                              value: value}, function(data){
                    DOPBSP.toggleMessages('success', DOPBSP.text('MESSAGES_SAVING_SUCCESS'));
                }).fail(function(data){
                    DOPBSP.toggleMessages('error', data.status+': '+data.statusText);
                });
            }, 600);
        }
    };


    /*
     * Delete extra.
     * 
     * @param id (Number): extra ID
     */
    this.delete = function(id){
        DOPBSP.toggleMessages('active', DOPBSP.text('EXTRAS_DELETE_EXTRA_DELETING'));

        $.post(ajaxurl, {action: 'dopbsp_extra_delete', 
                         id: id}, function(data){
            DOPBSP.clearColumns(2);

            $('#DOPBSP-extra-ID-'+id).stop(true, true)
                                     .animate({'opacity':0}, 
                                     600, function(){
                $(this).remove();

                if (data === '0'){
                    $('#DOPBSP-column1 .dopbsp-column-content').html('<ul><li class="dopbsp-no-data">'+DOPBSP.text('EXTRAS_NO_EXTRAS')+'</li></ul>');
                }
                DOPBSP.toggleMessages('success', DOPBSP.text('EXTRAS_DELETE_EXTRA_SUCCESS'));
            });
        }).fail(function(data){
            DOPBSP.toggleMessages('error', data.status+': '+data.statusText);
        });
    };

    return this.DOPBSPExtra();
};