<?php 
/**
* Add image select
*/
if( ! function_exists( 'kapee_number_type' ) && function_exists( 'vc_add_shortcode_param' ) ) {
	function kapee_number_type( $settings, $value ) {		
        $uniqid = kapee_uniqid('kapee-');
		ob_start();
		?>
			<input type="number" id="input-<?php echo esc_attr( $uniqid ); ?>" class="kapee-number wpb_vc_param_value" name="<?php echo esc_attr( $settings['param_name'] ); ?>" value="<?php echo esc_attr( $value ); ?>" style="width:150px;">		
		<?php
		return ob_get_clean();
	}
	vc_add_shortcode_param( 'kapee_number', 'kapee_number_type' );
}