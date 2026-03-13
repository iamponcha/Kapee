<?php 
/**
* Add image select
*/
if( ! function_exists( 'kapee_title_type' ) && function_exists( 'vc_add_shortcode_param' ) ) {
	function kapee_title_type( $settings, $value ) {		
        $uniqid = kapee_uniqid('kapee-');
		$c = empty( $settings['class'] ) ? '' : ' class="' . $settings['class'] . '"';
		$u = empty( $settings['url'] ) ? '' : '<a href="' . $settings['url'] . '" target="_blank">';
		$content = isset( $settings['content'] ) ? $settings['content'] : '' ;
		return $u . '<h4' . $c . '>' . $content . '</h4>' . ( $u ? '</a>' : '' ) . '<input type="hidden" name="' . $settings['param_name'] . '" class="wpb_vc_param_value ' . $settings['param_name'] . ' '.$settings['type'].'_field" value="'.$value.'" />';
	}
	vc_add_shortcode_param( 'kapee_title', 'kapee_title_type' );
}