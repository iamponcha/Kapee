<?php
/*
Element: Spacing
*/
class vcSpacing extends WPBakeryShortCode {

    function __construct() {
        $this->_mapping();
        add_shortcode( 'kapee_spacing', array( $this, '_html' ) );
	}
	public function _mapping() {
		if ( !defined( 'WPB_VC_VERSION' ) ) { return; }
		
		vc_map( array(
			'name'			=> esc_html__( 'Spacing', 'kapee-extensions' ),
			'base'			=> 'kapee_spacing',
			'category' 		=> esc_html__( 'Kapee', 'kapee-extensions' ),
			'description' 	=> esc_html__( 'Add blank spacing.', 'kapee-extensions' ),
        	'icon' 			=> KAPEE_URI.'/inc/admin/assets/images/vc-icon.png',
			'params' 		=> array(
				//General
				array(
					'type' 				=> 'kapee_number',
					'heading' 			=> esc_html__( 'Desktop', 'kapee-extensions' ),
					'param_name' 		=> 'spacing_desktop',
					'description' 		=> esc_html__( 'Add desktop spacing in px.', 'kapee-extensions' ),
					'std' 				=> '32',
				),
				array(
					'type' 				=> 'kapee_number',
					'heading' 			=> esc_html__( 'Tablet', 'kapee-extensions' ),
					'param_name' 		=> 'spacing_tablet',
					'description' 		=> esc_html__( 'Add tablet spacing in px.', 'kapee-extensions' ),
					'std' 				=> '',
				),
				array(
					'type' 				=> 'kapee_number',
					'heading' 			=> esc_html__( 'Mobile', 'kapee-extensions' ),
					'param_name' 		=> 'spacing_mobile',
					'description' 		=> esc_html__( 'Add mobile spacing in px.', 'kapee-extensions' ),
					'std' 				=> '',
				),
				array(
					'type' 			=> 'textfield',
					'heading' 		=> esc_html__( 'Extra class name', 'kapee-extensions' ),
					'param_name' 	=> 'el_class',
					'description' 	=> esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'kapee-extensions' )
				),
			),
		) );
	}
	
	public function _html( $atts, $content ) {
		$args = shortcode_atts( array(
			'spacing_desktop'		=> '32',
			'spacing_tablet'		=> '',
			'spacing_mobile'		=> '',
			'el_class'				=> '',
		), $atts );		
		extract( $args );
		$args['id'] 			= kapee_uniqid('kapee-spacing-');		
		$class 					= array();
		$class[]				= 'kapee-spacing-element';		
		$class[]				= $el_class;
		$args['class'] 			= implode(' ', array_filter( $class ) );
		
		/* Dynamic Css */
		$spacing_css 							= array();
		$style_css 							= '';		
		$spacing_css['desktop'][] 	= !empty($spacing_desktop) ? 'height:'.$spacing_desktop.'px' : '';
		$spacing_css['tablet'][] 	= !empty($spacing_tablet) ? 'height:'.$spacing_tablet.'px' : '';
		$spacing_css['mobile'][] 	= !empty($spacing_mobile) ? 'height:'.$spacing_mobile.'px' : '' ;
		
		if( ! empty( array_filter( $spacing_css['desktop'] ) ) ){
			
			if( !empty( array_filter($spacing_css['desktop']) ) ){
				$style_css .= '#'.$args['id'].' .kapee-spacing{';
				$style_css .=  implode('; ', array_filter( $spacing_css['desktop'] ) );
				$style_css .= '}';
			}
		}
		
		if( ! empty( array_filter( $spacing_css['tablet'] ) ) ){
			$style_css .= '@media (max-width:991px){';
			if( !empty( array_filter($spacing_css['tablet']) ) ){
				$style_css .= '#'.$args['id'].' .kapee-spacing{';
				$style_css .=  implode('; ', array_filter( $spacing_css['tablet'] ) );
				$style_css .= '}';
			}
			$style_css .= '}';
		}
		if( ! empty( array_filter( $spacing_css['mobile'] ) ) ){
			$style_css .= '@media (max-width:640px){';
			if( !empty( array_filter($spacing_css['mobile']) ) ){
				$style_css .= '#'.$args['id'].' .kapee-spacing{';
				$style_css .=  implode('; ', array_filter( $spacing_css['mobile'] ) );
				$style_css .= '}';
			}
			$style_css .= '}';
		}
		kapee_add_custom_css( $style_css );
		ob_start();
			kapee_get_pl_templates( 'shortcodes/spacing', $args );	
		return ob_get_clean();
	}	
}
new vcSpacing();
