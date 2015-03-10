<?php
global $unit;
global $property_size;
global $property_lot_size;
global $property_rooms;
global $property_bedrooms;
global $property_bathrooms;
global $submit_description;
global $custom_fields_array;

global $prop_espace_selected;


$measure_sys            = esc_html ( get_option('wp_estate_measure_sys','') ); 

$custom_fields = get_option( 'wp_estate_custom_fields', true);    

 $i=0;
 if( !empty($custom_fields)){  
    while($i< count($custom_fields) ){
       $name  =   $custom_fields[$i][0];
       $label =   $custom_fields[$i][1];
       $type  =   $custom_fields[$i][2];
       $slug  =   str_replace(' ','_',$name);
       
       $slug         =   wpestate_limit45(sanitize_title( $name ));
       $slug         =   sanitize_key($slug);
        
       $i++;
       
       if (function_exists('icl_translate') ){
            $label     =   icl_translate('wpestate','wp_estate_property_custom_front_'.$label, $label ) ;
        }   

       /*if($i%2!=0){
            print '<p class="half_form half_form_last">';
       }else{
            print '<p class="half_form">';
       }
       print '<label for="'.$slug.'">'.$label.'</label>';

       if ($type=='long text'){
            print '<textarea type="text" class="form-control"  id="'.$slug.'"  size="0" name="'.$slug.'" rows="3" cols="42">'.$custom_fields_array[$slug].'</textarea>';
       }else{
            print '<input type="text" class="form-control"  id="'.$slug.'" size="40" name="'.$slug.'" value="'.$custom_fields_array[$slug].'">';
       }
       print '</p>';

       if ($type=='date'){
           print '<script type="text/javascript">
              //<![CDATA[
              jQuery(document).ready(function(){
                      jQuery("#'.$slug.'").datepicker({
                              dateFormat : "yy-mm-dd"
                      });
              });
              //]]>
              </script>';
       }*/

   }
}

?>


<div class="submit_details">

	<div class="row submit_row">
	
		<div class="col-md-6">
		
			<p class="full_form">
				<div class="title_section"><?php _e('DÉTAILS DU BIEN :','wpestate');?></div>
			</p>
			<p class="full_form">
			    <label class="title_label" for="property_rooms"><?php _e('Nombre de pièces :','wpestate');?></label>
			    <input type="text" id="property_rooms" size="40" class="form-control"  name="property_rooms" value="<?php print $property_rooms;?>">
			    <ul class="submit_radio" id="submit_rooms">
   			   		<li><label for="nb_pcs_1" class="nb_pcs_1">1</label><input type="radio" name="submit_rooms" value="1" id="nb_pcs_1"></li>
   			   		<li><label for="nb_pcs_2" class="nb_pcs_2">2</label><input type="radio" name="submit_rooms" value="2" id="nb_pcs_2"></li>
   			   		<li><label for="nb_pcs_3" class="nb_pcs_3">3</label><input type="radio" name="submit_rooms" value="3" id="nb_pcs_3"></li>
   			   		<li><label for="nb_pcs_4" class="nb_pcs_4">4</label><input type="radio" name="submit_rooms" value="4" id="nb_pcs_4"></li>
   			   		<li><label for="nb_pcs_5" class="nb_pcs_5">5</label><input type="radio" name="submit_rooms" value="5" id="nb_pcs_5"></li>
   			   		<li><label for="nb_pcs_6" class="nb_pcs_6">6+</label><input type="radio" name="submit_rooms" value="6" id="nb_pcs_6"></li>
   			   </ul>
			</p>
			<p class="full_form">
			    <label class="title_label" for="property_bedrooms "><?php _e('Nombre de chambres :','wpestate');?></label>
			    <input type="text" id="property_bedrooms" size="40" class="form-control"  name="property_bedrooms" value="<?php print $property_bedrooms;?>">
			    <ul class="submit_radio" id="submit_bedrooms">
			    	<li><label for="nb_bed_0" class="nb_bed_0">0</label><input type="radio" name="submit_bedrooms" value="0" id="nb_bed_0"></li>
   			   		<li><label for="nb_bed_1" class="nb_bed_1">1</label><input type="radio" name="submit_bedrooms" value="1" id="nb_bed_1"></li>
   			   		<li><label for="nb_bed_2" class="nb_bed_2">2</label><input type="radio" name="submit_bedrooms" value="2" id="nb_bed_2"></li>
   			   		<li><label for="nb_bed_3" class="nb_bed_3">3</label><input type="radio" name="submit_bedrooms" value="3" id="nb_bed_3"></li>
   			   		<li><label for="nb_bed_4" class="nb_bed_4">4</label><input type="radio" name="submit_bedrooms" value="4" id="nb_bed_4"></li>
   			   		<li><label for="nb_bed_5" class="nb_bed_5">5</label><input type="radio" name="submit_bedrooms" value="5" id="nb_bed_5"></li>
   			   		<li><label for="nb_bed_6" class="nb_bed_6">6+</label><input type="radio" name="submit_bedrooms" value="6" id="nb_bed_6"></li>
   			   </ul> 
			</p>
			<div class="full_form marg_bottom">
			    <label class="title_label" for="property_size"><?php _e('Superficie de :','wpestate');?></label>
			    <div class="input-group width_135">
			        <input type="text" id="property_size" size="40" class="form-control"  name="property_size" value="<?php print $property_size;?>">
			        <div class="input-group-addon"><?php print ' '.$measure_sys.'<sup>2</sup>';?></div>
			    </div>
			</div>
			<div class="full_form marg_bottom">
			    <label class="title_label" for="property_lot_size"> <?php  _e('Surface séjour :','wpestate');?></label>
			    <div class="input-group width_135">
				    <input type="text" id="property_lot_size" size="40" class="form-control"  name="property_lot_size" value="<?php print $property_lot_size;?>">
				    <div class="input-group-addon"><?php print ' '.$measure_sys.'<sup>2</sup>';?></div>
			    </div>
			</div>
			<div class="full_form">
				<p><label class="title_label" for="prop_espace"><?php _e('Espace extérieur :','wpestate');?></label>
			    <?php 
			        $args=array(
			        		'walker'=> new SH_Walker_TaxonomyDropdown(),
			                'class'       => 'select-submit2',
			                'hide_empty'  => false,
			                'selected'    => $prop_espace_selected,
			                'name'        => 'prop_espace',
			                'id'          => 'prop_espace_submit',
			                'orderby'     => 'NAME',
			                'order'       => 'ASC',
			                'show_option_none'   => __('None','wpestate'),
			                'taxonomy'    => 'property_espace_ext',
			                'hierarchical'=> true
			            );
			        wp_dropdown_categories( $args );
			        $prop_espace = get_categories($args); ?>
			        
			        <ul class="property-submit-list list-left" id="submit_espace">
			        	<li>
			        		<div class="input-group width_135">
			        			<input type="text" id="property-nb-space" size="40" class="form-control"  name="property-nb-space" value="<?php print $custom_fields_array['property-nb-space'];?>">
			        			<div class="input-group-addon"><?php print ' '.$measure_sys.'<sup>2</sup>';?></div>
			        		</div>
			        	</li>
					<?php foreach($prop_espace as $value)  : ?>
						<li><input type="radio" name="prop_espace" value="<?= $value->term_id ?>" id="<?= $value->slug ?>"><label for="<?= $value->slug ?>" class="<?= $value->slug ?>"><?= $value->name ?></label></li>
					<?php endforeach; ?>
					</ul>
			    </p>
			</div>
			<div class="full_form">
				<p><label class="title_label" for="prop_stationnement"><?php _e('Stationnement :','wpestate');?></label>
			    <?php 
			        $args=array(
			        		'walker'=> new SH_Walker_TaxonomyDropdown(),
			                'class'       => 'select-submit2',
			                'hide_empty'  => false,
			                //'selected'    => $prop_category_selected,
			                'name'        => 'prop_stationnement',
			                'id'          => 'prop_stationnement_submit',
			                'orderby'     => 'NAME',
			                'order'       => 'ASC',
			                'show_option_none'   => __('None','wpestate'),
			                'taxonomy'    => 'property_stationnement',
			                'hierarchical'=> true
			            );
			        wp_dropdown_categories( $args );
			        $prop_stationnement = get_categories($args); ?>
			        
			        <ul class="property-submit-list list-left" id="submit_stationnement">
			        	<li><input type="text" id="property-nb-stationnement" size="40" class="form-control width_100"  name="property-nb-stationnement" value="<?php print $custom_fields_array['property-nb-stationnement'];?>"></li>
					<?php foreach($prop_stationnement as $value)  : ?>
						<li><input type="radio" name="prop_stationnement" value="<?= $value->term_id ?>" id="<?= $value->slug ?>"><label for="<?= $value->slug ?>" class="<?= $value->slug ?>"><?= $value->name ?></label></li>
					<?php endforeach; ?>
					</ul>
			    </p>
			</div>
			<div class="full_form">
				<p><label class="title_label" for="prop_cave"><?php _e('Cave :','wpestate');?></label>
			    <?php 
			        $args=array(
			        		'walker'=> new SH_Walker_TaxonomyDropdown(),
			                'class'       => 'select-submit2',
			                'hide_empty'  => false,
			                //'selected'    => $prop_category_selected,
			                'name'        => 'prop_cave',
			                'id'          => 'prop_cave_submit',
			                'orderby'     => 'NAME',
			                'order'       => 'ASC',
			                'show_option_none'   => __('None','wpestate'),
			                'taxonomy'    => 'property_cave',
			                'hierarchical'=> true
			            );
			        wp_dropdown_categories( $args );
			        $prop_cave = get_categories($args); ?>
			        
			        <ul class="property-submit-list list-left" id="submit_cave">
					<?php foreach($prop_cave as $value)  : ?>
						<li><input type="radio" name="prop_cave" value="<?= $value->term_id ?>" id="<?= $value->slug ?>"><label for="<?= $value->slug ?>" class="<?= $value->slug ?>"><?= $value->name ?></label></li>
					<?php endforeach; ?>
					</ul>
			    </p>
			</div>
			<p class="full_form">
			   <label class="title_label" for="description"><?php _e('Description :','wpestate');?></label>
			   <textarea id="description"  class="form-control" tabindex="3" name="description" cols="50" rows="6"><?php print $submit_description; ?></textarea>
			</p>
			
		</div>
		
		<div class="col-md-6">
		
			<p class="full_form">
				<div class="title_section"><?php _e('AUTRES INFORMATIONS IMPORTANTES :','wpestate');?></div>
			</p>
			<p class="full_form">
			    <label class="title_label" for="property_bedrooms"><?php _e('Salle de bain :','wpestate');?></label>
			    <input type="text" id="property_bathrooms" size="40" class="form-control"  name="property_bathrooms" value="<?php print $property_bathrooms;?>">
			    <ul class="submit_radio" id="submit_bathrooms">
   			   		<li><label for="nb_bath_1" class="nb_bath_1">1</label><input type="radio" name="submit_bathrooms" value="1" id="nb_bath_1"></li>
   			   		<li><label for="nb_bath_2" class="nb_bath_2">2</label><input type="radio" name="submit_bathrooms" value="2" id="nb_bath_2"></li>
   			   		<li><label for="nb_bath_3" class="nb_bath_3">3</label><input type="radio" name="submit_bathrooms" value="3" id="nb_bath_3"></li>
   			   		<li><label for="nb_bath_4" class="nb_bath_4">4</label><input type="radio" name="submit_bathrooms" value="4" id="nb_bath_4"></li>
   			   		<li><label for="nb_bath_5" class="nb_bath_5">5</label><input type="radio" name="submit_bathrooms" value="5" id="nb_bath_5"></li>
   			   		<li><label for="nb_bath_6" class="nb_bath_6">6+</label><input type="radio" name="submit_bathrooms" value="6" id="nb_bath_6"></li>
   			   </ul>
			</p>
			<p class="full_form">
			    <label class="title_label" for="property-toilet"><?php _e('WC :','wpestate');?></label>
			    <input type="text" id="property-toilet" size="40" class="form-control"  name="property-toilet" value="<?php print $custom_fields_array['property-toilet'];?>">
			    <ul class="submit_radio" id="submit_wc">
   			   		<li><label for="nb_wc_1" class="nb_wc_1">1</label><input type="radio" name="submit_wc" value="1" id="nb_wc_1"></li>
   			   		<li><label for="nb_wc_2" class="nb_wc_2">2</label><input type="radio" name="submit_wc" value="2" id="nb_wc_2"></li>
   			   		<li><label for="nb_wc_3" class="nb_wc_3">3</label><input type="radio" name="submit_wc" value="3" id="nb_wc_3"></li>
   			   		<li><label for="nb_wc_4" class="nb_wc_4">4</label><input type="radio" name="submit_wc" value="4" id="nb_wc_4"></li>
   			   		<li><label for="nb_wc_5" class="nb_wc_5">5</label><input type="radio" name="submit_wc" value="5" id="nb_wc_5"></li>
   			   		<li><label for="nb_wc_6" class="nb_wc_6">6+</label><input type="radio" name="submit_wc" value="6" id="nb_wc_6"></li>
   			   </ul>
			</p>
			<div class="full_form">
				<p><label class="title_label" for="prop_chauffage"><?php _e('Chauffage :','wpestate');?></label>
			    <?php 
			        $args=array(
			        		'walker'=> new SH_Walker_TaxonomyDropdown(),
			                'class'       => 'select-submit2',
			                'hide_empty'  => false,
			                //'selected'    => $prop_category_selected,
			                'name'        => 'prop_chauffage',
			                'id'          => 'prop_chauffage_submit',
			                'orderby'     => 'NAME',
			                'order'       => 'ASC',
			                'show_option_none'   => __('None','wpestate'),
			                'taxonomy'    => 'property_chauffage',
			                'hierarchical'=> true
			            );
			        wp_dropdown_categories( $args );
			        $prop_chauffage = get_categories($args); ?>
			        
			        <ul class="property-submit-list" id="submit_chauffage">
					<?php foreach($prop_chauffage as $value)  : ?>
						<li><input type="radio" name="prop_chauffage" value="<?= $value->term_id ?>" id="<?= $value->slug ?>"><label for="<?= $value->slug ?>" class="<?= $value->slug ?>"><?= $value->name ?></label></li>
					<?php endforeach; ?>
					</ul>
			    </p>
			</div>
			<div class="full_form">
				<div class="submit_etage floleft">
				    <label class="title_label" for="property-etage"><?php _e('Étage :','wpestate');?></label>
				    <input type="text" id="property-etage" size="40" class="form-control width_100"  name="property-etage" value="<?php print $custom_fields_array['property-etage'];?>">
				</div>
				<div class="floleft floleftm"><label class="title_label" for="prop_ascenseur"><?php _e('Ascenseur :','wpestate');?></label>
			    <?php 
			        $args=array(
			        		'walker'=> new SH_Walker_TaxonomyDropdown(),
			                'class'       => 'select-submit2',
			                'hide_empty'  => false,
			                //'selected'    => $prop_category_selected,
			                'name'        => 'prop_ascenseur',
			                'id'          => 'prop_ascenseur_submit',
			                'orderby'     => 'NAME',
			                'order'       => 'ASC',
			                'show_option_none'   => __('None','wpestate'),
			                'taxonomy'    => 'property_ascenseur',
			                'hierarchical'=> true
			            );
			        wp_dropdown_categories( $args );
			        $prop_ascenseur = get_categories($args); ?>
			        
			        <ul class="property-submit-list list-left" id="submit_ascenseur">
					<?php foreach($prop_ascenseur as $value)  : ?>
						<li><input type="radio" name="prop_ascenseur" value="<?= $value->term_id ?>" id="<?= $value->slug ?>"><label for="<?= $value->slug ?>" class="<?= $value->slug ?>"><?= $value->name ?></label></li>
					<?php endforeach; ?>
					</ul>
			    </div>
			</div>

			<div class="full_form">
				<p><label class="title_label" for="prop_charges"><?php _e('Charges de copropriétés :','wpestate');?></label>
			    <?php 
			        $args=array(
			        		'walker'=> new SH_Walker_TaxonomyDropdown(),
			                'class'       => 'select-submit2',
			                'hide_empty'  => false,
			                //'selected'    => $prop_category_selected,
			                'name'        => 'prop_charges',
			                'id'          => 'prop_charges_submit',
			                'orderby'     => 'NAME',
			                'order'       => 'ASC',
			                'show_option_none'   => __('None','wpestate'),
			                'taxonomy'    => 'property_charges',
			                'hierarchical'=> true
			            );
			        wp_dropdown_categories( $args );
			        $prop_charges = get_categories($args); ?>
			        
			        <ul class="property-submit-list list-left" id="submit_charges">
			        	<li>
			        		<div class="input-group width_135">
			        			<input type="text" id="property-price-charges" size="40" class="form-control"  name="property-price-charges" value="<?php print $custom_fields_array['property-price-charges'];?>">
			        			<div class="input-group-addon">€</div>
			        		</div>
			        	</li>
					<?php foreach($prop_charges as $value)  : ?>
						<li><input type="radio" name="prop_charges" value="<?= $value->term_id ?>" id="<?= $value->slug ?>"><label for="<?= $value->slug ?>" class="<?= $value->slug ?>"><?= $value->name ?></label></li>
					<?php endforeach; ?>
					</ul>
			    </p>
			</div>
			<div class="full_form">
				<div class="floleft">
				    <label class="title_label" for="property-taxes"><?php _e('Taxes foncières :','wpestate');?></label>
				    <div class="input-group width_135">
					    <input type="text" id="property-taxes" size="40" class="form-control"  name="property-taxes" value="<?php print $custom_fields_array['property-taxes'];?>">
					    <div class="input-group-addon">€</div>
				    </div>
				</div>
				<div class="floleft floleftm">
					<label class="title_label" for="property-year"><?php _e('Année de construction :','wpestate');?></label>
					<input type="text" id="property-year" size="40" class="form-control width_100"  name="property-year" value="<?php print $custom_fields_array['property-year'];?>">
				</div>
			</div>
			<div class="full_form">
			    <div class="floleft">
			    	<label class="title_label" for="property-dpe"><?php _e('DPE :','wpestate');?></label>
					<input type="text" id="property-dpe" size="40" class="form-control width_100"  name="property-dpe" value="<?php print $custom_fields_array['property-dpe'];?>">
				</div>
			    <div class="floleft floleftm">
			    	<label class="title_label" for="property-ges"><?php _e('GES :','wpestate');?></label>
					<input type="text" id="property-ges" size="40" class="form-control width_100"  name="property-ges" value="<?php print $custom_fields_array['property-ges'];?>">
				</div>
			</div>
			<div class="full_form">
				<label class="title_label" for="property-transports"><?php _e('Transports :','wpestate');?></label>
			    <textarea id="property-transports"  class="form-control" name="property-transports" cols="50" rows="6"><?php print $custom_fields_array['property-transports']; ?></textarea>
			</div>
			
		</div>
		
	</div>

</div>  
<script>
jQuery(function(){

	var roomsValue 			= document.getElementById("property_rooms").value;
	var bedValue 			= document.getElementById("property_bedrooms").value;
	var bathValue 			= document.getElementById("property_bathrooms").value;
	var wcValue 			= document.getElementById("property-toilet").value;
	
	if (!jQuery('#prop_espace_submit option[selected]').attr("class") == '') {
		var espaceSelect		= jQuery('#prop_espace_submit option[selected]').attr("class").split(' ')[0];
	}
	if (jQuery('#prop_stationnement_submit option[selected]').attr("class") == '') {
		var stationnementSelect		= jQuery('#prop_stationnement_submit option[selected]').attr("class").split(' ')[0];
	}
	if (jQuery('#prop_cave_submit option[selected]').attr("class") == '') {
		var caveSelect		= jQuery('#prop_cave_submit option[selected]').attr("class").split(' ')[0];
	}
	if (jQuery('#prop_chauffage_submit option[selected]').attr("class") == '') {
		var chauffageSelect		= jQuery('#prop_chauffage_submit option[selected]').attr("class").split(' ')[0];
	}
	if (jQuery('#prop_ascenseur_submit option[selected]').attr("class") == '') {
		var ascenseurSelect		= jQuery('#prop_ascenseur_submit option[selected]').attr("class").split(' ')[0];
	}
	if (jQuery('#prop_charges_submit option[selected]').attr("class") == '') {
		var chargesSelect		= jQuery('#prop_charges_submit option[selected]').attr("class").split(' ')[0];
	}

	jQuery(document).ready(function(){
	
		if (!document.getElementById("property_rooms").value == '') {
        	jQuery("#nb_pcs_"+roomsValue).prop('checked', true);
        };
        
        if (!document.getElementById("property_bedrooms").value == '' || document.getElementById("property_bedrooms").value == '0') {
        	jQuery("#nb_bed_"+bedValue).prop('checked', true);
        } else {
        	jQuery("#nb_bed_0").prop('checked', true);
        }
        
        if (!document.getElementById("property_bathrooms").value == '') {
        	jQuery("#nb_bath_"+bathValue).prop('checked', true);
        };
        
        if (!document.getElementById("property-toilet").value == '') {
        	jQuery("#nb_wc_"+wcValue).prop('checked', true);
        };
        
        jQuery("#submit_espace li #"+espaceSelect).prop('checked', true);
		jQuery("#submit_stationnement li #"+stationnementSelect).prop('checked', true);
		jQuery("#submit_cave li #"+caveSelect).prop('checked', true);
		jQuery("#submit_chauffage li #"+chauffageSelect).prop('checked', true);
		jQuery("#submit_ascenseur li #"+ascenseurSelect).prop('checked', true);
		jQuery("#submit_charges li #"+chargesSelect).prop('checked', true);
        
	});
	
	jQuery("#submit_rooms li input").click(function(){
		var roomsValueRadio = jQuery(this).attr('value');
		document.getElementById("property_rooms").value = roomsValueRadio;	
	});
	
	jQuery("#submit_bedrooms li input").click(function(){
		var bedroomsValueRadio = jQuery(this).attr('value');
		if (!bedroomsValueRadio == '' || bedroomsValueRadio == '0') {
			document.getElementById("property_bedrooms").value = bedroomsValueRadio;
		} else {
			document.getElementById("property_bedrooms").value = '';
		}	
	});
	
	jQuery("#submit_bathrooms li input").click(function(){	
		var bathValueRadio = jQuery(this).attr('value');
		document.getElementById("property_bathrooms").value = bathValueRadio;	
	});
	
	jQuery("#submit_wc li input").click(function(){	
		var wcValueRadio = jQuery(this).attr('value');
		document.getElementById("property-toilet").value = wcValueRadio;	
	});
	
	jQuery("#submit_espace li label").click(function(){	
		var espaceDataClass = jQuery(this).attr("class");
		jQuery("#prop_espace_submit option").removeAttr('selected');
		jQuery("#prop_espace_submit option."+espaceDataClass).attr("selected", "selected");
	});
	jQuery("#submit_stationnement li label").click(function(){	
		var stationnementDataClass = jQuery(this).attr("class");
		jQuery("#prop_stationnement_submit option").removeAttr('selected');
		jQuery("#prop_stationnement_submit option."+stationnementDataClass).attr("selected", "selected");
	});
	jQuery("#submit_cave li label").click(function(){	
		var caveDataClass = jQuery(this).attr("class");
		jQuery("#prop_cave_submit option").removeAttr('selected');
		jQuery("#prop_cave_submit option."+caveDataClass).attr("selected", "selected");
	});
	jQuery("#submit_chauffage li label").click(function(){	
		var chauffageDataClass = jQuery(this).attr("class");
		jQuery("#prop_chauffage_submit option").removeAttr('selected');
		jQuery("#prop_chauffage_submit option."+chauffageDataClass).attr("selected", "selected");
	});
	jQuery("#submit_ascenseur li label").click(function(){	
		var ascenseurDataClass = jQuery(this).attr("class");
		jQuery("#prop_ascenseur_submit option").removeAttr('selected');
		jQuery("#prop_ascenseur_submit option."+ascenseurDataClass).attr("selected", "selected");
	});
	jQuery("#submit_charges li label").click(function(){	
		var chargesDataClass = jQuery(this).attr("class");
		jQuery("#prop_charges_submit option").removeAttr('selected');
		jQuery("#prop_charges_submit option."+chargesDataClass).attr("selected", "selected");
	});
	
});
</script>