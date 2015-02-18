</div><!-- end content_wrapper started in header -->
<?php 
if (!is_page_template('property_list_half.php') ){
?>    
    <footer id="colophon" role="contentinfo"> 
    
    <div id="customfooter">
      <ul id="links">
        <li>
          <p class='blueTitle'>Plan du site</p>
        </li>
        <li>
          <p class='blueTitle'>Particuliers</p>
          <a href="#">Inscription</a>
          <a href="#">Connexion</a>
        </li>
        <li>
          <p class='blueTitle'>Professionnels</p>
          <a href="#">Inscription</a>
          <a href="#">Connexion</a>
        </li>
        <li>
          <p class='blueTitle'>Societe</p>
          <a href="#">Nous Contacter</a>
          <a href="#">Mentions Légales</a>
          <a href="#">C.G.U.</a>
          <a href="#">Recrutement</a>
        </li>
      </ul>
      <p class="blueTitle">Suivez-nous sur</p>
      <ul id="social_ico">
        <li><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/img/fb.png"></a></li>
        <li><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/img/twitter.png"></a></li>
        <li><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/img/google.png"></a></li>
        <li><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/img/insta.png"></a></li>
        <li><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/img/youtube.png"></a></li>
      </ul>
      <div class="copyrightz">Copyright © 2014 Instantimmo - Websiting - Création site internet</div>
    </div>

        <div id="footer-widget-area" class="row">
           <?php get_sidebar('footer');?>
        </div><!-- #footer-widget-area -->

        <!-- <div class="sub_footer">  
            <div class="sub_footer_content">
                <span class="copyright">
                    <?php      
                    if (function_exists('icl_translate') ){
                        print $property_copy_text      =   icl_translate('wpestate','wp_estate_property_copyright_text', esc_html( get_option('wp_estate_copyright_message') ) );
                    }else{
                        print esc_html (get_option('wp_estate_copyright_message', ''));
                    }
                    ?>
                </span>

                <div class="subfooter_menu">
                    <?php      
                        wp_nav_menu( array(
                            'menu'              => 'footer_menu',
                            'theme_location'    => 'footer_menu',
                            'depth'             => 1                           
                        ));  
                    ?>
                </div>  
            </div>  
        </div> -->
    </footer><!-- #colophon -->
<?php } ?>

<?php get_template_part('templates/footer_buttons');?>
<?php get_template_part('templates/navigational');?>

<?php wp_get_schedules(); ?>

<?php wp_footer(); ?>

<?php
$ga = esc_html(get_option('wp_estate_google_analytics_code', ''));
if ($ga != '') { ?>

<script>
    //<![CDATA[
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', '<?php echo $ga; ?>', '<?php     echo $_SERVER['SERVER_NAME']; ?>');
  ga('send', 'pageview');
//]]>
</script>

<?php
}
?>

</div> <!-- end class container -->
</div> <!-- end website wrapper -->
</body>
</html>