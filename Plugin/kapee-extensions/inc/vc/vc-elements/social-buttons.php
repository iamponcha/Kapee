<?php
/*
Element: Social Buttons
*/
class vcSocialButton extends WPBakeryShortCode {

    function __construct() {
        $this->_mapping();
        add_shortcode( 'kapee_social_buttons', array( $this, '_html' ) );
	}
	public function _mapping() {
		if ( !defined( 'WPB_VC_VERSION' ) ) { return; }
		
		vc_map( array(
			'name'			=> esc_html__( 'Social Buttons', 'kapee-extensions' ),
			'base'			=> 'kapee_social_buttons',
			'category' 		=> esc_html__( 'Kapee', 'kapee-extensions' ),
			'description' 	=> esc_html__( 'Social Buttons.', 'kapee-extensions' ),
        	'icon' 			=> KAPEE_URI.'/inc/admin/assets/images/vc-icon.png',
			'params' 		=> array(
				//General
				array(
					'type' 			=> 'textfield',
					'heading' 		=> esc_html__( 'Title', 'kapee-extensions' ),
					'param_name' 	=> 'title',
					'description' 	=> esc_html__( 'Enter social button type title.', 'kapee-extensions' ),
					'admin_label'	=> true,
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Social Type', 'kapee-extensions' ),
					'value' 		=> array(
						esc_html__( 'Share', 'kapee-extensions' ) 	=> 'share',
						esc_html__( 'Profile', 'kapee-extensions' )	=> 'profile',
					),
					'param_name' 	=> 'social_type',
					'std' 			=> 'share',
					'admin_label'	=> true,
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Icons Style', 'kapee-extensions' ),
					'value' 		=> array(
						esc_html__('Default','kapee-extensions') 			=> 'icons-default',
						esc_html__( 'Colour', 'kapee-extensions' ) 			=> 'icons-colour',
						esc_html__( 'Bordered', 'kapee-extensions' ) 		=> 'icons-bordered',
						esc_html__( 'Fill Colour', 'kapee-extensions' )		=> 'icons-fill-colour',
						esc_html__( 'Theme Colour', 'kapee-extensions' )	=> 'icons-theme-colour',
					),
					'param_name' 	=> 'social_style',
					'std' 			=> 'icons-default',
					'admin_label'	=> true,
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Icons Shape', 'kapee-extensions' ),
					'value' 		=> array(
						esc_html__('Circle','kapee-extensions') 	=> 'icons-shape-circle',
						esc_html__( 'Square', 'kapee-extensions' ) 	=> 'icons-shape-square',
					),
					'param_name' 	=> 'social_shape',
					'std' 			=> 'icons-shape-circle',
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Icons Size', 'kapee-extensions' ),
					'value' 		=> array(
						esc_html__('Default','kapee-extensions') 	=> 'icons-size-default',
						esc_html__( 'Small', 'kapee-extensions' ) 	=> 'icons-size-small',
						esc_html__( 'Large', 'kapee-extensions' ) 	=> 'icons-size-large',
					),
					'param_name' 	=> 'social_icon_size',
					'std' 			=> 'icons-size-default',
				),
				array(
					'type' 			=> 'dropdown',					
					'param_name' 	=> 'social_alignment',
					'heading' 		=> esc_html__( 'Alignment', 'kapee-extensions' ),
					'value' 		=> array(
						esc_html__( 'Left', 'kapee-extensions' ) 	=> 'left',
						esc_html__( 'Center', 'kapee-extensions' ) 	=> 'center',						
						esc_html__( 'Right', 'kapee-extensions' ) 	=> 'right'
					),
					'std'			=> 'left',
				),
				( function_exists( 'vc_map_add_css_animation' ) ) ? vc_map_add_css_animation( true ) : '',
				array(
					'type' 			=> 'textfield',
					'heading' 		=> esc_html__( 'Extra class name', 'kapee-extensions' ),
					'param_name' 	=> 'el_class',
					'description' 	=> esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'kapee-extensions' )
				),
				//Style
				array(
					'type' 			=> 'css_editor',
					'heading' 		=> esc_html__( 'CSS box', 'kapee-extensions' ),
					'param_name' 	=> 'css',
					'group' 		=> esc_html__( 'Design Options', 'kapee-extensions' )
				)
			),
		) );
	}
	
	public function _html( $atts, $content ) {
		$args = shortcode_atts( array(
			'title' 			=> '',
			'social_type' 		=> 'share',
			'social_style' 		=> 'icons-default',
			'social_shape' 		=> 'icons-shape-circle',
			'social_icon_size' 	=> 'icons-size-default',
			'social_alignment'	=> 'left',
			'css_animation' 	=> 'none',
			'el_class' 			=> '',
			'css' 				=> '',
		), $atts );		
		extract( $args );
		$args['id']			= kapee_uniqid('kapee-social-button-');
		$class				= array('kapee-element', 'kapee-social-button-wrap', 'kapee-social-buttons');		
		$class[]			= 'text-'.$social_alignment;
		$class[]			= $el_class;
		$css_class 			= vc_shortcode_custom_css_class( $css, ' ' );
		$class[] 		    = $css_class; 
		$args['class'] 		= implode(' ',array_filter($class));
		ob_start();
			kapee_get_pl_templates('shortcodes/social-buttons',$args );	
		return ob_get_clean();
	}	
}
new vcSocialButton();