<?php 
global $current_user;
global $wpdb;

get_currentuserinfo();

if(isset($_POST['delete_note']))
	delete_post_meta($post->ID, 'property_note', $_POST['note_value']);

$notes = get_post_meta($post->ID, 'property_note');
$note = $wpdb->get_results('SELECT * FROM wp_postmeta WHERE meta_key = "property_note" AND post_id ='.$post->ID);
$count_note = $wpdb->get_results('SELECT COUNT(*) as "count" FROM wp_postmeta WHERE meta_key = "property_note" AND post_id ='.$post->ID);
var_dump($note);
?>
<h2 style="font-size:14px; font-weight:none; margin-top:30px;">Mes notes (5 max) :</h2>
<hr style="margin:0px!important;">
<?php foreach ($note as $key) { 
	?>
	<div class="notes">
		<p class="note">
			<?php print $key->meta_value;?>
		</p>
		<form method="POST" action="<?= $_SERVER['REQUEST_URI'] ?>">
			<input type="hidden" name="note_value" value="<?= $key->meta_value ?>"/>
			<input type="submit" class="delete_note" name="delete_note" value="x"/>
		</form>
	</div>
	<?php } ?>
