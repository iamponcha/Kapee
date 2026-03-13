<?php 
/**
 * Element: Testimonials Item
 */
 
class vcTestimonialsItem extends WPBakeryShortCode {

    function __construct() {
        $this->_mapping();
        add_shortcode( 'kapee_testimonials_item', array( $this, '_html' ) );
	}
	public function _mapping() {
		if ( !defined( 'WPB_VC_VERSION' ) ) { return; }		
		vc_map( array(
			'name' 				=> esc_html__( 'Testimonials Item', 'kapee-extensions' ),
			'base' 				=> 'kapee_testimonials_item',
			'class' 			=> '',
			'as_child' 			=> array( 'only' => 'kapee_testimonials' ),
			'content_element' 	=> true,
			'category' 			=> esc_html__( 'Theme elements', 'kapee-extensions' ),
			'description' 		=> esc_html__( 'User testimonial', 'kapee-extensions' ),
        	'icon' 				=> KAPEE_URI.'/inc/admin/assets/images/vc-icon.png',
			'params' 			=> array(
				array(
					'type' 			=> 'textfield',
					'heading' 		=> esc_html__( 'Name', 'kapee-extensions' ),
					'param_name' 	=> 'name',
					'value' 		=> '',
					'description' 	=> esc_html__( 'Client name', 'kapee-extensions' )
				),
				array(
					'type' 			=> 'attach_image',
					'heading' 		=> esc_html__( 'Client Avatar', 'kapee-extensions' ),
					'param_name' 	=> 'image',
					'value' 		=> '',
					'description' 	=> esc_html__( 'Select image from media library.', 'kapee-extensions' )
				),
				array(
					'type' 			=> 'textarea',
					'holder' 		=> 'div',
					'heading' 		=> esc_html__( 'Description', 'kapee-extensions' ),
					'param_name' 	=> 'description'
				),
				array(
					'type' 			=> 'textfield',
					'heading' 		=> esc_html__( 'Designation(Job Title)', 'kapee-extensions' ),
					'param_name' 	=> 'designation',
					'description' 	=> esc_html__( 'Enter client designation.', 'kapee-extensions' )
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Rating', 'kapee-extensions' ),
					'param_name' 	=> 'rating',
					'value'			=> array(1,2,3,4,5),
					'description' 	=> esc_html__( 'Select rating.', 'kapee-extensions' )
				),
				array(
					'type' 			=> 'textfield',
					'heading' 		=> esc_html__( 'Extra class name', 'kapee-extensions' ),
					'param_name' 	=> 'el_class',
					'description' 	=> esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'kapee-extensions' )
				)
			)
		) );
	}
	
	public function _html( $atts, $content ) {
		global $testimonial_args;
		$args = ( shortcode_atts( array(
			'name' 			=> '',
			'image' 		=> '',
			'description' 	=> '',
			'designation' 	=> '',
			'rating' 		=> '',				
			'el_class' 		=> '',				
		), $atts ) );		
		
		$args = array_merge($args, $testimonial_args);
		extract( $args );
		
		$args['class'] 		= $el_class; 
		$image_output 		= wp_get_attachment_image( $image,  'thumbnail', false );
		$args['image'] 		= $image_output;
		$args['rating']		= 100 * $args['rating'] / 5;
		
		ob_start();
			kapee_get_pl_templates('shortcodes/testimonials/'.$style, $args );
		return ob_get_clean();
	}	
}
new vcTestimonialsItem();
?>