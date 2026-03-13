<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

/* Add VC Param */

if( ! function_exists( 'kapee_vc_shortcodes_options' ) ) {

	add_action( 'vc_before_init', 'kapee_vc_shortcodes_options' );

	function kapee_vc_shortcodes_options() {
		/**
		 * Background position
		*/
		
		$bg_position = array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Background position', 'kapee-extensions' ),
			'param_name' => 'kapee_bg_position',
			'group' => esc_html__( 'Kapee Options', 'kapee-extensions' ),
			'value' => array(
				esc_html__( 'None', 'kapee-extensions' ) => '',
				esc_html__( 'Left top', 'kapee-extensions' ) => 'left-top',
				esc_html__( 'Left center', 'kapee-extensions' ) => 'left-center',
				esc_html__( 'Left bottom', 'kapee-extensions' ) => 'left-bottom',
				esc_html__( 'Right top', 'kapee-extensions' ) => 'right-top',
				esc_html__( 'Right center', 'kapee-extensions' ) => 'right-center',
				esc_html__( 'Right bottom', 'kapee-extensions' ) => 'right-bottom',
				esc_html__( 'Center top', 'kapee-extensions' ) => 'center-top',
				esc_html__( 'Center center', 'kapee-extensions' ) => 'center-center',
				esc_html__( 'Center bottom', 'kapee-extensions' ) => 'center-bottom',
			),
			'edit_field_class' => 'vc_col-sm-6 vc_column',
		);
		
		vc_add_param( 'vc_row', $bg_position );
		vc_add_param( 'vc_row_inner', $bg_position );
		vc_add_param( 'vc_section', $bg_position );
		vc_add_param( 'vc_column', $bg_position );
		vc_add_param( 'vc_column_inner', $bg_position );
		
		$kapee_bg_parallax = array(
			'type' 			=> 'checkbox',
			'class' 		=> '',
			'heading' 		=> esc_html__('Background Parallax', 'kapee-extensions'),
			'param_name' 	=> 'kapee_bg_parallax',
			'value' 		=> array( esc_html__( ' Yes', 'kapee-extensions' ) => 1 ),
			'group' => esc_html__( 'Kapee Options', 'kapee-extensions' ),
			'edit_field_class' => 'vc_col-sm-6 vc_column',
		);
		vc_add_param( 'vc_row', $kapee_bg_parallax );
		vc_add_param( 'vc_section', $kapee_bg_parallax );
		vc_add_param( 'vc_column', $kapee_bg_parallax );
		
		/**
		 * Hode bg on mobile
		*/
		
		$mobile_bg_img_hidden = array(
			'type' 			=> 'checkbox',
			'heading' 		=> esc_html__( 'Hide background on mobile', 'kapee-extensions' ),
			'param_name' 	=> 'hide_bg_mobile',
			'value' 			=> array( esc_html__( ' Yes', 'kapee-extensions' ) => 1 ),
			'std' 				=> 0,
			'group' => esc_html__( 'Kapee Options', 'kapee-extensions' ),
			'edit_field_class' => 'vc_col-sm-6 vc_column',			
		);

		vc_add_param( 'vc_row', $mobile_bg_img_hidden );
		vc_add_param( 'vc_section', $mobile_bg_img_hidden );
		vc_add_param( 'vc_column', $mobile_bg_img_hidden );
		
		/**
		 * Hode bg on tablet
		*/
		
		$tablet_bg_img_hidden = array(
			'type' 			=> 'checkbox',
			'heading' 		=> esc_html__( 'Hide background on tablet', 'kapee-extensions' ),
			'param_name' 	=> 'hide_bg_tablet',
			'value' 			=> array( esc_html__( ' Yes', 'kapee-extensions' ) => 1 ),
			'std' 				=> 0,
			'group' => esc_html__( 'Kapee Options', 'kapee-extensions' ),
			'edit_field_class' => 'vc_col-sm-6 vc_column',			
		);

		vc_add_param( 'vc_row', $tablet_bg_img_hidden );
		vc_add_param( 'vc_section', $tablet_bg_img_hidden );
		vc_add_param( 'vc_column', $tablet_bg_img_hidden );
		
		/**
		 * Text align
		*/
		
		$text_align = array(
			'type' 			=> 'dropdown',
			'heading' 		=> esc_html__( 'Text align', 'kapee-extensions' ),
			'param_name' 	=> 'kapee_text_align',
			'value' => array(
				esc_html__( 'Choose', 'kapee-extensions' ) => '',
				esc_html__( 'Left', 'kapee-extensions' ) => 'left',
				esc_html__( 'Center', 'kapee-extensions' ) => 'center',
				esc_html__( 'Right', 'kapee-extensions' ) => 'right',
			),
			'group' => esc_html__( 'Kapee Options', 'kapee-extensions' ),
			'edit_field_class' => 'vc_col-sm-6 vc_column',			
		);
		vc_add_param( 'vc_column', $text_align );
		vc_add_param( 'vc_column_inner', $text_align );
		
		
		
	}
}

if( ! function_exists( 'kapee_vc_extra_classes' ) ) {

	if( defined( 'VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG' ) ) {
		add_filter( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'kapee_vc_extra_classes', 30, 3 );
	}
	
	function kapee_vc_extra_classes( $class, $base, $atts ) {
		
		
		
		//Background option
		if ( ! empty( $atts['kapee_bg_position'] ) ) {
			$class .= ' kapee-bg-' . $atts['kapee_bg_position'];
		}
		
		if( isset( $atts['kapee_bg_parallax'] ) && $atts['kapee_bg_parallax']) {
			wp_enqueue_script('parallax');
			$class .= ' kapee-parallax-background';
		}
		
		//Text align option
		if ( ! empty( $atts['kapee_text_align'] ) ) {
			$class .= ' text-' . $atts['kapee_text_align'];
		}
		
		//Hide background img on mobile
		if ( isset( $atts['hide_bg_mobile'] ) && $atts['hide_bg_mobile'] ) {
			$class .= ' hide-bg-img-mobile';
		}

		//Hide background img on tablet
		if ( isset( $atts['hide_bg_tablet'] ) && $atts['hide_bg_tablet'] ) {
			$class .= ' hide-bg-img-tablet';
		}
		
		return $class;
	}
}
?>