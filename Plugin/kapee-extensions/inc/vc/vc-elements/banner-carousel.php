<?php
/*
Element: Banner Carousel
*/
class vcBannerCarousel extends WPBakeryShortCode {

    function __construct() {
        $this->_mapping();
        add_shortcode( 'kapee_banner_carousel', array( $this, '_html' ) );
	}
	public function _mapping() {
		if ( !defined( 'WPB_VC_VERSION' ) ) { return; }
		$image_sizes 		= kapee_get_all_image_sizes(true);
		array_shift($image_sizes);
		vc_map( array(
			'name'			=> esc_html__( 'Banner Carousel', 'kapee-extensions' ),
			'base'			=> 'kapee_banner_carousel',
			'as_parent' => array( 'only' => 'kapee_banner' ),
			'content_element' => true,
			'show_settings_on_create' => true,
			'category' 		=> esc_html__( 'Kapee', 'kapee-extensions' ),
			'description' 	=> esc_html__( 'Display banners.', 'kapee-extensions' ),
        	'icon' 			=> KAPEE_URI.'/inc/admin/assets/images/vc-icon.png',
			'js_view' 		=> 'VcColumnView',
			'params' 		=> array(
				//General
				array(
					'type' 			=> 'checkbox',
					'heading' 		=> esc_html__( 'Autoplay', 'kapee-extensions' ),
					'param_name' 	=> 'slider_autoplay',
					'value' 			=> array( esc_html__( 'Yes', 'kapee-extensions' ) => 1 ),
					'std' 				=> 0,
				),				
				array(
					'type' 			=> 'checkbox',
					'heading' 		=> esc_html__( 'Loop', 'kapee-extensions' ),
					'param_name' 	=> 'slider_loop',
					'value' 		=> array( esc_html__( 'Yes', 'kapee-extensions' ) => 1 ),
					'std' 			=> 0,
					'description' 	=> esc_html__( 'True for infinate loop.', 'kapee-extensions' ),
				),
				array(
					'type' 			=> 'checkbox',
					'heading' 		=> esc_html__( 'Center Mode', 'kapee-extensions' ),
					'param_name' 	=> 'slider_center',
					'value' 		=> array( esc_html__( 'Yes', 'kapee-extensions' ) => 1 ),
					'std' 			=> 0,
					'description' 	=> esc_html__( 'Center item. Works well with an odd number of items.', 'kapee-extensions' ),
				),
				array(
					'type' 			=> 'checkbox',
					'heading' 		=> esc_html__( 'Nav', 'kapee-extensions' ),
					'param_name' 	=> 'slider_nav',
					'value' 			=> array( esc_html__( 'Yes', 'kapee-extensions' ) => 1 ),
					'std' 				=> 1,
					'description' 	=> esc_html__( 'True for display navigation icon.', 'kapee-extensions' ),
				),	
				array(
					'type' 			=> 'checkbox',
					'heading' 		=> esc_html__( 'Dots', 'kapee-extensions' ),
					'param_name' 	=> 'slider_dots',
					'value' 			=> array( esc_html__( 'Yes', 'kapee-extensions' ) => 1 ),
					'std' 				=> 0,
					'description' 	=> esc_html__( 'True for display dots.', 'kapee-extensions' ),
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
						"5" 	=> 5,
						"6" 	=> 6,
					),
					"std"        	=> 3,
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
						"5" 	=> 5,
					),
					"std"           => 3,
				),
				array(
					"type"          => "dropdown",
					"heading"       => esc_html__("Medium devices (tablets, 768px and up)", 'kapee-extensions' ),
					"param_name"    => "rs_medium",
					"value" 		=> array(
						"1"  	=> 1,
						"2" 	=> 2,
						"3" 	=> 3,
						"4" 	=> 4,
					),
					"std"           => 2,
				),
				array(
					"type"          => "dropdown",
					"heading"       => esc_html__("Small devices (landscape phones, 576px and up)", 'kapee-extensions' ),
					"param_name"    => "rs_small",
					"value" 		=> array(
						"1"  	=> 1,
						"2" 	=> 2,
						"3" 	=> 3,
					),
					"std"           => 1,
				),
				array(
					"type"          => "dropdown",
					"heading"       => esc_html__("Extra small devices (portrait phones, less than 576px)", 'kapee-extensions' ),
					"param_name"    => "rs_extra_small",
					"value" 		=> array(
						"1"  	=> 1,
						"2" 	=> 2,
					),
					"std"           => 1,
				),				
				array(
					'type' 			=> 'textfield',
					'heading' 		=> esc_html__( 'Extra class name', 'kapee-extensions' ),
					'param_name' 	=> 'el_class',
					'description' 	=> esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'kapee-extensions' )
				),
				array(
					'type'       => 'css_editor',
					'heading'    => esc_html__( 'CSS box', 'kapee-extensions' ),
					'param_name' => 'css',
					'group'      => esc_html__( 'Design Options', 'kapee-extensions' ),
				),
			),
		) );
	}
	
	public function _html( $atts, $content ) {
		$args = shortcode_atts( array(
			'slider_autoplay' 		=> 0,
			'slider_loop' 			=> 0,
			'slider_center' 		=> 0,
			'slider_nav' 			=> 1,
			'slider_dots' 			=> 0,
			'rs_extra_large' 		=> 3,
			'rs_large'				=> 3,
			'rs_medium' 			=> 2,
			'rs_small' 				=> 1,
			'rs_extra_small' 		=> 1,
			'el_class'				=> '',
			'css'					=> '',
		), $atts );		
		extract($args);
		$class				= array();
		$class[]			= 'kapee-element';
		$class[]			= 'kapee-banners-carousel';
		$class[]			= $el_class;
		$css_class 			= vc_shortcode_custom_css_class( $css, ' ' );
		$class[]			= $css_class;
		$args['class'] 		= implode( ' ', array_filter( $class ) );
		$args['content'] 	= $content;
		$args['id'] 		= kapee_uniqid( 'kapee-banner-carousel-' );
			
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
									
		$slider_data 		= shortcode_atts( kapee_slider_options(), $owl_data );
		global $kapee_owlparam;
		$kapee_owlparam['owlCarouselArg'][$args['id']] = $slider_data;
		$args['slider_class'] 	= 'kapee-carousel owl-carousel'; 
			$args['slider_class'] 	.= ' grid-col-xl-'.$rs_extra_large;
			$args['slider_class'] 	.= ' grid-col-lg-'.$rs_large;
			$args['slider_class'] 	.= ' grid-col-md-'.$rs_medium;
			$args['slider_class'] 	.= ' grid-col-sm-'.$rs_small;
			$args['slider_class'] 	.= ' grid-col-'.$rs_extra_small;		
		ob_start();
			kapee_get_pl_templates( 'shortcodes/banner-carousel', $args );	
		return ob_get_clean();
	}	
}
new vcBannerCarousel();
?>