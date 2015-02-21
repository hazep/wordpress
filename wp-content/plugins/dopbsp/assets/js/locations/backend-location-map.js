/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 2.0
* File                    : assets/js/locations/backend-location-map.js
* File Version            : 1.0
* Created / Last Modified : 25 September 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO back end location map JavaScript class.
*/

var DOPBSPLocationMap = new function(){
    'use strict';
    
    /*
     * Private variables.
     */
    var $ = jQuery.noConflict();
    
    /*
     * Constructor
     */
    this.DOPBSPLocationMap = function(){
    };
    
    /*
     * Initialize map.
     */
    this.init = function(){
        var $coordinates = $('#DOPBSP-location-coordinates').val(),
        coordinates = $coordinates === undefined || $coordinates === '' || $coordinates === ' ' ? [0, 0]:JSON.parse($coordinates),
        map,
        options,
        zoom = coordinates[0] === 0 && coordinates[1] === 0  ? 2:17;
        
        options = {center: new google.maps.LatLng(coordinates[0], coordinates[1]),
                   mapTypeId: google.maps.MapTypeId.ROADMAP,
                   zoom: zoom};
        /*
         * Create the map
         */          
        map = new google.maps.Map(document.getElementById('DOPBSP-location-address-map'), options);
            
        DOPBSPLocationMapMarker.set(map,
                                    coordinates);
    };
    
    /*
     * Set map.
     * 
     * @param address (String/Array): address or coordinates
     * @param geocode (String): geocode type "address"/"latLng"
     * @param changeAdress (Boolean): set to "true" to change address field
     * @param changeMap (Boolean): set to "true" to reinitialize map
     * 
     */
    this.set = function(address,
                        geocode,
                        changeAdress,
                        changeMap){
        var geocoder = new google.maps.Geocoder();
        
        geocode = geocode === undefined ? 'address':geocode;
        changeAdress = changeAdress === undefined ? true:changeAdress;
        changeMap = changeMap === undefined ? true:changeMap;
        
        DOPBSPLocationMapHints.clear();
        
        geocoder.geocode((geocode === 'address' ? {'address': address}:{'latLng': new google.maps.LatLng(address[0], address[1])}), function(data, status){
            if (status === google.maps.GeocoderStatus.OK) {
                var coordinates = data[0].geometry.location;
                
                changeAdress ? $('#DOPBSP-location-address').val(geocode === 'address' ? address:data[0].formatted_address):'';
                $('#DOPBSP-location-coordinates').val(JSON.stringify(geocode === 'address' ? [coordinates.lat(), coordinates.lng()]:[address[0], address[1]]));
                 
                changeMap ? DOPBSPLocationMap.init():'';
                
                changeAdress || changeMap ? DOPBSPLocation.edit($('#DOPBSP-location-ID').val(),
                                                                'map-hints', 
                                                                'address', 
                                                                $('#DOPBSP-location-address').val()):'';
            } 
            else{
                // console.log('Can not find address: '+status);
            }
        });
    };

    return this.DOPBSPLocationMap();
};