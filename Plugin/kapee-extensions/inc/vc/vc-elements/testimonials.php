<?php 
/**
 * Element: Testimonials
 */
 
class vcTestimonials extends WPBakeryShortCode {

    function __construct() {
        $this->_mapping();
        add_shortcode( 'kapee_testimonials', array( $this, '_html' ) );
	}
	public function _mapping() {
		if ( !defined( 'WPB_VC_VERSION' ) ) { return; }		
		vc_map( array(
			'name' 						=> esc_html__( 'Testimonials', 'kapee-extensions' ),
			'base' 						=> 'kapee_testimonials',
			'as_parent' 				=> array( 'only' => 'kapee_testimonials_item' ),
			'content_element' 			=> true,
			'show_settings_on_create' 	=> false,
			'category' 					=> esc_html__( 'Kapee', 'kapee-extensions' ),
			'description' 				=> esc_html__( 'User testimonials', 'kapee-extensions' ),
        	'icon' 						=> KAPEE_URI.'/inc/admin/assets/images/vc-icon.png',
			'params' 					=> array(
				array(
					'type' 				=> 'dropdown',
					'heading' 			=> esc_html__( 'Style', 'kapee-extensions' ),
					'param_name' 		=> 'style',
					'value' 			=> array( 
						esc_html__( 'Image Top Center', 'kapee-extensions' ) 		=> 'image-top-center',
						esc_html__( 'Image Middle Center', 'kapee-extensions' ) 	=> 'image-middle-center',
						esc_html__( 'Image Bottom Left', 'kapee-extensions' ) 		=> 'image-bottom-left',
					),
					'description' 		=> esc_html__( 'Select style.', 'kapee-extensions' ),
					'admin_label'   	=> true,
				),
				array(
					'type'            	=> 'dropdown',
					'heading'         	=> esc_html__( 'Color', 'kapee-extensions' ),
					'param_name'      	=> 'color',
					'value' 			=> array(
						esc_html__('Inherit', 'kapee-extensions') 	=> 'inherit',
						esc_html__( 'Light', 'kapee-extensions' ) 	=> 'light',
						esc_html__( 'Dark', 'kapee-extensions' ) 	=> 'dark',
					),
					'std'				=>	'inherit',
				),
				array(
					'type'            	=> 'colorpicker',
					'heading'         	=> esc_html__( 'Quote Background Color', 'kapee-extensions' ),
					'param_name'      	=> 'quote_bg_color',
					'std'				=>	'#2370F4',
					'dependency' 		=> array(
						'element' 	=> 'style', 
						'value' 	=> array('image-bottom-left')
					),
				),
				array(
					'type'            	=> 'dropdown',
					'heading'         	=> esc_html__( 'Quote Color', 'kapee-extensions' ),
					'param_name'      	=> 'quote_color',
					'value' 			=> array(
						esc_html__('Inherit', 'kapee-extensions') 	=> 'inherit',
						esc_html__( 'Light', 'kapee-extensions' ) 	=> 'light',
						esc_html__( 'Dark', 'kapee-extensions' ) 	=> 'dark',
					),
					'std'				=>	'light',
					'dependency' 		=> array(
						'element' 	=> 'style', 
						'value' 	=> array('image-bottom-left')
					),
				),
				array(
					'type' 				=> 'textfield',
					'heading' 			=> esc_html__( 'Extra class name', 'kapee-extensions' ),
					'param_name' 		=> 'el_class',
					'description' 		=> esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'kapee-extensions' )
				),
				//Carousel setting
				array(
					'type' 			=> 'checkbox',
					'heading' 		=> esc_html__( 'Autoplay', 'kapee-extensions' ),
					'param_name' 	=> 'slider_autoplay',
					'value' 			=> array( esc_html__( 'Yes', 'kapee-extensions' ) => 1 ),
					'std' 				=> 0,
					'group'      	=> esc_html__( 'Carousel Settings', 'kapee-extensions' ),
				),				
				array(
					'type' 			=> 'checkbox',
					'heading' 		=> esc_html__( 'Loop', 'kapee-extensions' ),
					'param_name' 	=> 'slider_loop',
					'value' 		=> array( esc_html__( 'Yes', 'kapee-extensions' ) => 1 ),
					'std' 			=> 0,
					'description' 	=> esc_html__( 'True for infinate loop.', 'kapee-extensions' ),
					'group'			=> esc_html__( 'Carousel Settings', 'kapee-extensions' ),
				),
				array(
					'type' 			=> 'checkbox',
					'heading' 		=> esc_html__( 'Center Mode', 'kapee-extensions' ),
					'param_name' 	=> 'slider_center',
					'value' 		=> array( esc_html__( 'Yes', 'kapee-extensions' ) => 1 ),
					'std' 			=> 0,
					'description' 	=> esc_html__( 'Center item. Works well with an odd number of items.', 'kapee-extensions' ),
					'group'			=> esc_html__( 'Carousel Settings', 'kapee-extensions' ),
				),
				array(
					'type' 			=> 'checkbox',
					'heading' 		=> esc_html__( 'Nav', 'kapee-extensions' ),
					'param_name' 	=> 'slider_nav',
					'value' 			=> array( esc_html__( 'Yes', 'kapee-extensions' ) => 1 ),
					'std' 				=> 1,
					'description' 	=> esc_html__( 'True for display navigation icon.', 'kapee-extensions' ),
					'group'			=> esc_html__( 'Carousel Settings', 'kapee-extensions' ),
				),	
				array(
					'type' 			=> 'checkbox',
					'heading' 		=> esc_html__( 'Dots', 'kapee-extensions' ),
					'param_name' 	=> 'slider_dots',
					'value' 			=> array( esc_html__( 'Yes', 'kapee-extensions' ) => 1 ),
					'std' 				=> 0,
					'description' 	=> esc_html__( 'True for display dots.', 'kapee-extensions' ),
					'group'			=> esc_html__( 'Carousel Settings', 'kapee-extensions' ),
				),
							
				array(
					"type"       	=> "dropdown",
					"heading"    	=> esc_html__("Extra large devices (large desktops, 1200px and up)", 'kapee-extensions' ),
					"param_name" 	=> "rs_extra_large",
					"value" 		=> array(
						"1"  	=> 1,
						"2" 	=> 2,
						"3" 	=> 3,
						"4" 	=> 4,
					),
					"std"        	=> 4,
					'group'      	=> esc_html__( 'Carousel Settings', 'kapee-extensions' ),
				),
				array(
					"type"          => "dropdown",
					"heading"       => esc_html__("Large devices (desktops, 992px and up)", 'kapee-extensions' ),
					"param_name"    => "rs_large",
					"value" 		=> array(
						"1"  	=> 1,
						"2" 	=> 2,
						"3" 	=> 3,
						"4" 	=> 4,
					),
					"std"           => 3,
					'group'         => esc_html__( 'Carousel Settings', 'kapee-extensions' ),
				),
				array(
					"type"          => "dropdown",
					"heading"       => esc_html__("Medium devices (tablets, 768px and up)", 'kapee-extensions' ),
					"param_name"    => "rs_medium",
					"value" 		=> array(
						"1"  	=> 1,
						"2" 	=> 2,
						"3" 	=> 3,
					),
					"std"           => 2,
					'group'         => esc_html__( 'Carousel Settings', 'kapee-extensions' ),
				),
				array(
					"type"          => "dropdown",
					"heading"       => esc_html__("Small devices (landscape phones, 576px and up)", 'kapee-extensions' ),
					"param_name"    => "rs_small",
					"value" 		=> array(
						"1"  	=> 1,
						"2" 	=> 2,
					),
					"std"           => 1,
					'group'         => esc_html__( 'Carousel Settings', 'kapee-extensions' ),
				),
				array(
					"type"          => "dropdown",
					"heading"       => esc_html__("Extra small devices (portrait phones, less than 576px)", 'kapee-extensions' ),
					"param_name"    => "rs_extra_small",
					"value" 		=> array(
						"1"  	=> 1,
					),
					"std"           => 1,
					'group'         => esc_html__( 'Carousel Settings', 'kapee-extensions' ),
				),
			),
		    'js_view' 				=> 'VcColumnView'
		) );
	}
	
	public function _html( $atts, $content ) {
		$args = ( shortcode_atts( array(
			'style' 					=> 'image-top-center',
			'color'						=> 'inherit',
			'quote_bg_color'			=> '#2370F4',
			'quote_color'				=> 'light',
			'el_class' 					=> '',
			'slider_autoplay' 			=> 0,
			'slider_loop' 				=> 0,
			'slider_center' 			=> 0,
			'slider_nav' 				=> 1,
			'slider_dots' 				=> 0,
			'slider_margin' 			=> 30,
			'rs_extra_large' 			=> 4,
			'rs_large'					=> 3,
			'rs_medium' 				=> 2,
			'rs_small' 					=> 1,
			'rs_extra_small' 			=> 1,				
		), $atts ) );
		extract( $args );
		
		$args['id'] 				= kapee_uniqid('kapee-testimonial-');
		$class						= array('kapee-element', 'kapee-testimonials');
		$class[]					= $style;
		$class[]					= 'color-scheme-'.$color;
		$class[]					= $el_class;
		$args['class'] 				= implode(' ',array_filter($class));
		$args['content'] 			= $content;
		$args['quote_color']		= 'color-scheme-'.$quote_color;
		
		$quote_css 					= array();		
		if($style == 'image-bottom-left'){
			$quote_css[] 	= !empty($quote_bg_color) ? 'background-color:'.$quote_bg_color : '' ;
		}
		$args['quote_css']			= implode('; ', array_filter( $quote_css ) ) ;
		$args['quote_css'] 			= !empty($args['quote_css']) ? 'style="'.$args['quote_css'].'"' : '';
		
		$owl_data	= array(
			'slider_loop'				=> $slider_loop ? true : false,
			'slider_autoplay' 			=> $slider_autoplay ? true : false,
			'slider_center' 			=> $slider_center ? true : false,
			'slider_nav'				=> $slider_nav ? true : false,
			'slider_dots'				=> $slider_dots ? true : false,
			'slider_margin'				=> 30,
			'rs_extra_large' 			=> $rs_extra_large,
			'rs_large' 					=> $rs_large,
			'rs_medium' 				=> $rs_medium,
			'rs_small' 					=> $rs_small,
			'rs_extra_small' 			=> $rs_extra_small,
		);
		$slider_data 		= shortcode_atts(kapee_slider_options(),$owl_data);
		$args['slider_data']= json_encode( shortcode_atts(kapee_slider_options(),$owl_data));
		$args['slider_class'] 	= ' grid-col-xl-'.$rs_extra_large;
		$args['slider_class'] 	.= ' grid-col-lg-'.$rs_large;
		$args['slider_class'] 	.= ' grid-col-md-'.$rs_medium;
		$args['slider_class'] 	.= ' grid-col-sm-'.$rs_small;
		$args['slider_class'] 	.= ' grid-col-'.$rs_extra_small;
		global $kapee_owlparam, $testimonial_args;
		$testimonial_args['style'] 			= $style;
		$testimonial_args['quote_color'] 	= $args['quote_color'];
		$testimonial_args['quote_css'] 		= $args['quote_css'] ;
		$kapee_owlparam['owlCarouselArg'][$args['id']] = $slider_data;
		//kapee_pre($kapee_owlparam);
		extract( $args );		
		ob_start();
			kapee_get_pl_templates('shortcodes/testimonials',$args );
		return ob_get_clean();
	}	
}
new vcTestimonials();
?>