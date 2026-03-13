<?php 
/**
 * Newsletter Template
 */
?>
<div class="<?php echo esc_attr($class);?>">
	<?php if( function_exists( 'mc4wp_show_form' ) ) {
		mc4wp_show_form();
	} ?>
</div>