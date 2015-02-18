<?php
// Template Name: fiche agent
// Wp Estate Pack
get_header();

?>

<div class="row background_profil">
    <div class="col-md-2">
       <div class="sides">
        <?php generated_dynamic_sidebar( $options['sidebar_name']);  ?>
       </div>
    </div>  
    
    
    <div class="col-md-8 background_profil_content">
        
        <?php get_template_part('templates/ajax_container'); ?>
        
           <?php   get_template_part('templates/agent_unit'); ?>
    </div>
    <div class="col-md-2">
      <h3 class="gras calend">CALENDRIER</h3>
      <hr class="border_black">
      <?php the_widget( 'WP_Widget_Calendar'); ?>
    </div>
  
  
</div>    
<?php get_footer(); ?>