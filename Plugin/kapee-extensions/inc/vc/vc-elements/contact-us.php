<?php
/*
Element: Contactus
*/
class vcContactus extends WPBakeryShortCode {

    function __construct() {
        $this->_mapping();
        add_shortcode( 'kapee_contactus', array( $this, '_html' ) );
	}
	public function _mapping() {
		if ( !defined( 'WPB_VC_VERSION' ) ) { return; }	
		$form_list = kapee_get_posts_dropdown('wpcf7_contact_form',__('Select Contact Form','kapee-extensions'));
		vc_map( array(
			'name'			=> esc_html__( 'Contactus', 'kapee-extensions' ),
			'base'			=> 'kapee_contactus',
			'category' 		=> esc_html__( 'Kapee', 'kapee-extensions' ),
			'description' 	=> esc_html__( 'Display contact form form.', 'kapee-extensions' ),
        	'icon' 			=> KAPEE_URI.'/inc/admin/assets/images/vc-icon.png',
			'params' 		=> array(
				//General
				array(
					'type' 			=> 'textfield',
					'heading' 		=> esc_html__( 'Title', 'kapee-extensions' ),
					'param_name' 	=> 'title',
					'description' 	=> esc_html__( 'Enter title.', 'kapee-extensions' ),
					'std' 			=> esc_html__( 'Contact Us', 'kapee-extensions' ),
				),
				array(
					'type' 			=> 'textfield',
					'heading' 		=> esc_html__( 'Description', 'kapee-extensions' ),
					'param_name' 	=> 'description',
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Select Form', 'kapee-extensions' ),
					'value' 		=> array_flip($form_list),
					'param_name' 	=> 'id'
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
			'title' 				=> esc_html__( 'Contact Us', 'kapee-extensions' ),
			'description' 			=> '',
			'id' 					=> '',
			'css_animation' 		=> 'none',	
			'el_class'				=> '',
			'css'					=> '',
		), $atts );		
		extract($args);
		$class				= array();
		$class[]			= 'kapee-element';
		$class[]			= 'kapee-contact-us';
		$class[]			= $el_class;
		$class[]			= kapee_get_css_animation($css_animation);
		$css_class 			= vc_shortcode_custom_css_class( $css, ' ' );
		$class[]			= $css_class;
		$args['class'] 		= implode(' ',array_filter($class));
		$args				= wp_parse_args($args,$atts);		
		ob_start();
			kapee_get_pl_templates('shortcodes/contact-us',$args );	
		return ob_get_clean();
	}	
}
new vcContactus();
?>