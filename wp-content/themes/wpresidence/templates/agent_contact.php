<?php
global $agent_email;
global $propid;
 $contact_form_7_agent   =   stripslashes( ( get_option('wp_estate_contact_form_7_agent','') ) );
?>
  
<div class="agent_contanct_form">
    <?php    
     if ( basename(get_page_template())!='contact_page.php') { ?>
             <h4 id="show_contact"><?php _e('Contact Me', 'wpestate'); ?></h4>
     <?php 
           }else{
     ?>
             <h4 id="show_contact"><?php _e('Contact Us', 'wpestate'); ?></h4>
     <?php } ?>
                
    <?php if ($contact_form_7_agent ==''){ ?>


        <div class="alert-box error">
          <div class="alert-message" id="alert-agent-contact"></div>
        </div>
<div class="col-md-12">

<div class="col-md-2">
    
</div>

<div class="col-md-8">
    <div id="content_contact">
        <input name="contact_name" id="agent_contact_name" type="text"  placeholder="<?php _e('NOM', 'wpestate'); ?>" 
               aria-required="true" class="formulaire_design">
        <input type="text" name="email" class="formulaire_design" id="agent_user_email" aria-required="true" placeholder="<?php _e('E-MAIL', 'wpestate'); ?>" >
        <input type="text" name="phone"  class="formulaire_design" id="agent_phone" placeholder="<?php _e('SUJET', 'wpestate'); ?>" >

        <textarea id="agent_comment" name="comment" class="formulaire_design" cols="45" rows="8" aria-required="true" placeholder="<?php _e('MESSAGE', 'wpestate'); ?>" ></textarea>	

        <input type="submit" class="wpb_button  wpb_btn-info wpb_btn-large formulaire_design buttons"  id="agent_submit" value="<?php _e('Envoyer', 'wpestate'); ?>">

        <input name="prop_id" type="hidden"  id="agent_property_id" value="<?php echo $propid;?>">
        <input name="agent_email" type="hidden"  id="agent_email" value="<?php print $agent_email; ?>">
        <input type="hidden" name="contact_ajax_nonce" id="agent_property_ajax_nonce"  value="<?php echo wp_create_nonce( 'ajax-property-contact' );?>" />
    </div>
</div>
</div>

<div class="col-md-2">
    
</div>

</div>

    <?php 
    }else{
        if ( basename(get_page_template())=='contact_page.php') {
            $contact_form_7_contact = stripslashes( ( get_option('wp_estate_contact_form_7_contact','') ) );
            echo do_shortcode($contact_form_7_contact);
        }else{
            wp_reset_query();
            echo do_shortcode($contact_form_7_agent);
        }
      
      
    }
    ?>
</div>