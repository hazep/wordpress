<?php

/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 2.0
* File                    : views/tools/views-backend-tools-repair-search-settings.php
* File Version            : 1.0
* Created / Last Modified : 26 January 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO back end repair search settings views class.
*/

    if (!class_exists('DOPBSPViewsBackEndToolsRepairSearchSettings')){
        class DOPBSPViewsBackEndToolsRepairSearchSettings extends DOPBSPViewsBackEndTools{
            /*
             * Constructor
             */
            function DOPBSPViewsBackEndToolsRepairSearchSettings(){
            }
            
            /*
             * Returns search settings template.
             * 
             * @return search settings HTML
             */
            function template(){
                global $DOPBSP;
?>
                <table id="DOPBSP-tools-repair-search-settings" class="dopbsp-info-table">
                    <colgroup>
                        <col class="dopbsp-half" />
                        <col class="dopbsp-half" />
                    </colgroup>
                    <thead>
                        <tr>
                            <th><?php echo $DOPBSP->text('TOOLS_REPAIR_SEARCH_SETTINGS_SEARCHES'); ?></th>
                            <th><?php echo $DOPBSP->text('TOOLS_REPAIR_SEARCH_SETTINGS_SETTINGS_DATABASE'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
<?php
            }
        }
    }