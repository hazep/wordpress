<?php
global $prop_action_category;
global $prop_action_category_selected;
global $prop_category_selected;

$args = array(
        'type'                     => 'post',
        'child_of'                 => 0,
        'parent'                   => '',
        'orderby'                  => 'description',
        'order'                    => 'ASC',
        'hide_empty'               => 0,
        'hierarchical'             => 1,
        'exclude'                  => '',
        'include'                  => '',
        'number'                   => '',
        'taxonomy'                 => 'property_category',
        'pad_counts'               => false 
); 


$categories = get_categories($args);?>
<div class="submit_container"> 
        <?php 
        $args['taxonomy'] = 'property_action_category';
        $prop_action = get_categories($args); ?>
     <div class="col-md-12">
        <p><label class="label-submit" for="prop_action_category"> <?php _e('Vous voulez : ','wpestate'); $prop_action_category;?></label>
        <ul class="property-submit-list">
        <?php foreach($prop_action as $value)  :      ?>
            <li><input type="radio" name="prop_action_propery" value="<?= $value->catID ?>" id="<?= $value->description ?>"><label for="<?= $value->description ?>"><?= $value->description ?></label></li>
        <?php endforeach; ?>
        </ul>
        </p> 
    </div>

    <div class="col-md-12 marg_t">
        <p><label class="label-submit" for="prop_category"><?php _e('Type de bien :','wpestate');?></label>
        <ul class="property-submit-list">
       <?php foreach($categories as $value)  :      ?>
            <li><input type="radio" name="prop_category" value="<?= $value->catID ?>" id="<?= $value->description ?>"><label for="<?= $value->description ?>"><?= $value->description ?></label></li>
        <?php endforeach; ?>
        </ul>
        </p>
    </div>
    <div class="row marg_t">
        <div class="col-md-6 ">
            <label for="title"><?php _e('Titre de votre annonce :','wpestate'); ?> </label>
            <input type="text" id="title" class="form-control input-mid-size" value="<?php print $submit_title; ?>" size="20" name="title" />
        </div>
        <div class="col-md-offset-3 col-md-3">
            <label for="property_price"> <?php _e('Prix :','wpestate'); ?></label>
            <div class="form-group input-group">
            <input type="text" id="property_price" class="form-control no-margin" size="40" name="property_price" value="<?php print $property_price;?>">
            <div class="input-group-addon"><i class="fa fa-eur"></i></div>
            </div>
        </div> 
    </div>
    <div class="col-md-12   ">
        <div class="property-submit-border-bottom"></div>
    </div>
</div>
