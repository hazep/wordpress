<?php

/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 2.0
* File                    : views/search/views-backend-search.php
* File Version            : 1.0.3
* Created / Last Modified : 23 January 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO back end search views class.
*/

    if (!class_exists('DOPBSPViewsFrontEndSearch')){
        class DOPBSPViewsFrontEndSearch extends DOPBSPViewsFrontEnd{
            /*
             * Constructor
             */
            function DOPBSPViewsFrontEndSearch(){
            }
            
            /*
             * Returns search.
             * 
             * @param args (array): function arguments
             *                      * atts (object): shortcode attributes
             *                      * search (object): search data
             * 
             * @return search HTML
             */
            function template($args = array()){
                global $DOPBSP;
        
                $atts = $args['atts'];
                $search = $args['search'];
                
                $DOPBSP->classes->translation->set($atts['lang'],
                                                   false);
                $id = $atts['id'];
                $settings_search = $DOPBSP->classes->backend_settings->values($id,  
                                                                              'search');
                
                $html = array();
                

// HOOK (dopbsp_action_frontend_search_content_before) ****************************** Add content before calendar.
                ob_start();
                    do_action('dopbsp_action_frontend_search_content_before');
                    $content = ob_get_contents();
                ob_end_clean();
                array_push($html, $content);
                
                /*
                 * Search HTML.
                 */
                array_push($html, '<link rel="stylesheet" type="text/css" href="'.$DOPBSP->paths->url.'templates/'.$settings_search->template.'/css/jquery.dop.frontend.BSPSearch.css" />');
                
                array_push($html, '<script type="text/JavaScript">');
                array_push($html, '    jQuery(document).ready(function(){');
                array_push($html, '        jQuery("#DOPBSPSearch'.$id.'").DOPBSPSearch('.$DOPBSP->classes->frontend_search->getJSON($atts,
                                                                                                                                    $search,
                                                                                                                                    $settings_search).');');
                array_push($html, '    });');
                array_push($html, '</script>');
                
                array_push($html, '<div id="DOPBSPSearch-loader'.$id.'" class="DOPBSPSearch-loader"></div>');

                array_push($html, '<table id="DOPBSPSearch'.$id.'" class="DOPBSPSearch-wrapper DOPBSPSearch-hidden notranslate">');
                array_push($html, ' <colgroup>');
                
                switch ($settings_search->view_sidebar_position){
                    case 'right':
                        array_push($html, '     <col class="dopbsp-results-style" />');
                        array_push($html, '     <col class="dopbsp-column-separator-style" />');
                        array_push($html, '     <col class="dopbsp-sidebar-style" />');
                        break;
                    case 'top':
                        array_push($html, '     <col />');
                        break;
                    default:
                        array_push($html, '     <col class="dopbsp-sidebar-style" />');
                        array_push($html, '     <col class="dopbsp-column-separator-style" />');
                        array_push($html, '     <col class="dopbsp-results-style" />');
                    
                }
                array_push($html, ' </colgroup>');
                array_push($html, ' <tbody>');
                
                switch ($settings_search->view_sidebar_position){
                    case 'right':
                        array_push($html, ' <tr>');
                        array_push($html, '     <td class="DOPBSPSearch-content">');
                        array_push($html, $DOPBSP->views->frontend_search_sort->template(array('atts' => $atts)));
                        array_push($html, $DOPBSP->views->frontend_search_view->template(array('atts' => $atts, 'settings_search' => $settings_search)));
                        array_push($html, '     <br class="DOPBSPSearch-clear" />');
                        array_push($html, '     <hr />');
                        array_push($html, $DOPBSP->views->frontend_search_results->template(array('atts' => $atts, 'settings_search' => $settings_search)));
                        array_push($html, '     </td>');
                        array_push($html, '     <td class="dopbsp-column-separator"></td>');
                        array_push($html, '     <td class="DOPBSPSearch-sidebar">'.$DOPBSP->views->frontend_search_sidebar->template(array('atts' => $atts, 'settings_search' => $settings_search)).'</td>');
                        array_push($html, ' </tr>');
                        break;
                    case 'top':
                        array_push($html, ' <tr>');
                        array_push($html, '     <td class="DOPBSPSearch-sidebar">'.$DOPBSP->views->frontend_search_sidebar->template(array('atts' => $atts, 'settings_search' => $settings_search)).'</td>');
                        array_push($html, ' </tr>');
                        array_push($html, ' <tr>');
                        array_push($html, '     <td class="DOPBSPSearch-content">');
                        array_push($html, $DOPBSP->views->frontend_search_sort->template(array('atts' => $atts)));
                        array_push($html, $DOPBSP->views->frontend_search_view->template(array('atts' => $atts, 'settings_search' => $settings_search)));
                        array_push($html, '     <br class="DOPBSPSearch-clear" />');
                        array_push($html, '     <hr />');
                        array_push($html, $DOPBSP->views->frontend_search_results->template(array('atts' => $atts, 'settings_search' => $settings_search)));
                        array_push($html, '     </td>');
                        array_push($html, ' </tr>');
                        break;
                    default:
                        array_push($html, ' <tr>');
                        array_push($html, '     <td class="DOPBSPSearch-sidebar">'.$DOPBSP->views->frontend_search_sidebar->template(array('atts' => $atts, 'settings_search' => $settings_search)).'</td>');
                        array_push($html, '     <td class="dopbsp-column-separator"></td>');
                        array_push($html, '     <td class="DOPBSPSearch-content">');
                        array_push($html, $DOPBSP->views->frontend_search_sort->template(array('atts' => $atts)));
                        array_push($html, $DOPBSP->views->frontend_search_view->template(array('atts' => $atts, 'settings_search' => $settings_search)));
                        array_push($html, '     <br class="DOPBSPSearch-clear" />');
                        array_push($html, '     <hr />');
                        array_push($html, $DOPBSP->views->frontend_search_results->template(array('atts' => $atts, 'settings_search' => $settings_search)));
                        array_push($html, '     </td>');
                        array_push($html, ' </tr>');
                    
                }
                array_push($html, ' </tbody>');
                array_push($html, '</table>');
                
// HOOK (dopbsp_frontend_content_after_calendar) ******************************* Add content after calendar.
                ob_start();
                    do_action('dopbsp_action_frontend_search_content_after');
                    $content = ob_get_contents();
                ob_end_clean();
                array_push($html, $content);
                
                return implode("\n", $html);
            }
        }
    }