<?php 
/**
 * Handles Post Setting metabox HTML
 *
 * @since 1.0.0
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;
//https://codeb.it/edittable/
// Add an nonce field so we can check for it later.
wp_nonce_field('kapee_size_chart', 'kapee_size_chart');

global $post;
$prefix = KAPEE_EXTENSIONS_META_PREFIX; // Metabox prefix
$chart_table 	= get_post_meta( $post->ID, $prefix.'size_chart_data', true );
if(empty($chart_table)){
	$chart_table = array(
		array('Size','Chest', 'Shoulder', 'Length','Sleeve Length'),
		array('M','20.3', '17', '27.5', '16.5'),
		array('L','22', '17.5', '28.3', '17'),
		array('XL','21.8', '18', '29', '17.5')
	);
	$chart_table = json_encode($chart_table);
}
?>
<div class="form-table kapee-size-chart-table">
	<div class="field-item">
		<textarea  id="kapee-chart-table" style="display:none;" name="<?php echo $prefix;?>size_chart_data"><?php echo $chart_table; ?></textarea>
	</div>	
</div><!-- end .kapee-size-chart-table -->