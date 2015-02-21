<?php

/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 2.0
* File                    : views/coupons/views-backend-coupons.php
* File Version            : 1.0.4
* Created / Last Modified : 13 October 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO back end coupons views class.
*/

    if (!class_exists('DOPBSPViewsBackEndCoupons')){
        class DOPBSPViewsBackEndCoupons extends DOPBSPViewsBackEnd{
            /*
             * Constructor
             */
            function DOPBSPViewsBackEndCoupons(){
            }
            
            /*
             * Returns coupons template.
             * 
             * @param args (array): function arguments
             * 
             * @return coupons HTML page
             */
            function template($args = array()){
                global $DOPBSP;
                
                $this->getTranslation();
?>            
    <div class="wrap DOPBSP-admin">
        
<!--
    Header
-->
        <?php $this->displayHeader($DOPBSP->text('TITLE'), $DOPBSP->text('COUPONS_TITLE')); ?>
        <input type="hidden" name="DOPBSP-coupon-ID" id="DOPBSP-coupon-ID" value="" />
        
<!--
    Content
-->
        <div class="dopbsp-main dopbsp-hidden">
            <table class="dopbsp-content-wrapper">
                <colgroup>
                    <col id="DOPBSP-col-column1" class="dopbsp-column1" />
                    <col id="DOPBSP-col-column-separator1" class="dopbsp-separator" />
                    <col id="DOPBSP-col-column2" class="dopbsp-column2" />
                </colgroup>
                <tbody>
                    <tr>
                        <td id="DOPBSP-column1" class="dopbsp-column">
                            <div class="dopbsp-column-header">
<?php 
                if (isset($_GET['page']) 
                        && $DOPBSP->classes->backend_settings_users->permission(wp_get_current_user()->ID, 'use-booking-system')){ 
?>                  
                                <a href="javascript:DOPBSPCoupon.add()" class="dopbsp-button dopbsp-add"><span class="dopbsp-info"><?php echo $DOPBSP->text('COUPONS_ADD_COUPON_SUBMIT'); ?></span></a>
                                <a href="<?php echo DOPBSP_CONFIG_HELP_DOCUMENTATION_URL; ?>" target="_blank" class="dopbsp-button dopbsp-help"><span class="dopbsp-info dopbsp-help"><?php echo $DOPBSP->text('COUPONS_HELP').'<br /><br />'.$DOPBSP->text('COUPONS_ADD_COUPON_HELP').'<br /><br />'.$DOPBSP->text('HELP_VIEW_DOCUMENTATION'); ?></span></a>
<?php
                }
                else{
?>           
                             <a href="<?php echo DOPBSP_CONFIG_HELP_DOCUMENTATION_URL; ?>" target="_blank" class="dopbsp-button dopbsp-help"><span class="dopbsp-info dopbsp-help"><?php echo $DOPBSP->text('COUPONS_HELP').'<br /><br />'.$DOPBSP->text('HELP_VIEW_DOCUMENTATION'); ?></span></a>
<?php
                }
?>                           
                                <br class="dopbsp-clear" />
                            </div>
                            <div class="dopbsp-column-content">&nbsp;</div>
                        </td>
                        <td id="DOPBSP-column-separator1" class="dopbsp-separator"></td>
                        <td id="DOPBSP-column2" class="dopbsp-column">
                            <div class="dopbsp-column-header">&nbsp;</div>
                            <div class="dopbsp-column-content">&nbsp;</div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>       
<?php
            }
        }
    }