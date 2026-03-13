<?php 
/*
Element: Portfolio Carousel
*/
class vcPortfolioCarousel extends WPBakeryShortCode {

    function __construct() {
        $this->_mapping();
        add_shortcode( 'kapee_portfolio_carousel', array( $this, '_html' ) );
	}
	public function _mapping() {
		if ( !defined( 'WPB_VC_VERSION' ) ) { return; }	
		$image_sizes 			= kapee_get_all_image_sizes(true);
        array_shift($image_sizes);
		
		vc_map( array(
			'name' 			=> esc_html__( 'Portfolio Carousel', 'kapee-extensions' ),
			'base' 			=> 'kapee_portfolio_carousel',
			'category' 		=> esc_html__( 'Kapee', 'kapee-extensions' ),
			'description' 	=> esc_html__( 'Portfolio carousel.', 'kapee-extensions' ),
        	'icon' 			=> KAPEE_URI.'/inc/admin/assets/images/vc-icon.png',
			'params' 		=> array(
				array(
					"type" 			=> "textfield",
					"heading" 		=> esc_html__( "Portfolio Title", 'kapee-extensions' ),
					"param_name" 	=> "title",
					"admin_label"   => true,
					"description"   => esc_html__( "Enter title", 'kapee-extensions' ),					
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Style', 'kapee-extensions' ),
					"admin_label"   => true,
					'param_name' 	=> 'portfolio_style',
					'std' 			=> 'portfolio-style-1',
					'value' 		=> array( 
						esc_html__( 'Style 1', 'kapee-extensions' ) => 'portfolio-style-1',
						esc_html__( 'Style 2', 'kapee-extensions' ) => 'portfolio-style-2',
						esc_html__( 'Style 3', 'kapee-extensions' ) => 'portfolio-style-3',
						esc_html__( 'Style 4', 'kapee-extensions' ) => 'portfolio-style-4',
						esc_html__( 'Style 5', 'kapee-extensions' ) => 'portfolio-style-5',
						esc_html__( 'Style 6', 'kapee-extensions' ) => 'portfolio-style-6',
						esc_html__( 'Style 7', 'kapee-extensions' ) => 'portfolio-style-7',
					),
					'description' 	=> esc_html__( 'Select style.', 'kapee-extensions' ),
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Gapping Between Portfolio', 'kapee-extensions' ),
					'param_name' 	=> 'portfolio_grid_gap',
					'std' 			=> 30,
					'value'			=> array(
						esc_html__('0','kapee-extensions') 		=> 0,
						esc_html__('10','kapee-extensions') 	=> 10,
						esc_html__('20','kapee-extensions') 	=> 20,
						esc_html__('30','kapee-extensions') 	=> 30,
					),
					'dependency'	=> array(
						'element'				=> 'portfolio_style',
						'value_not_equal_to' 	=> array( 'portfolio-style-1','portfolio-style-2' ),
					)
				),
				array(
					'type' 			=> 'textfield',
					'heading' 		=> esc_html__( 'Number Of Portfolios', 'kapee-extensions' ),
					'param_name' 	=> 'portfolio_per_page',
					'std' 			=> '10',
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Order By', 'kapee-extensions' ),
					'param_name' 	=> 'orderby',
					'std' 			=> 'date',
					'value'			=> array( 
						esc_html__('Title','kapee-extensions') 	=> 'title',
						esc_html__('Date','kapee-extensions') 	=> 'date',
						esc_html__('Random','kapee-extensions') => 'random',
					),
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Sort By', 'kapee-extensions' ),
					'param_name' 	=> 'sortby',
					'std' 			=> 'desc',
					'value'			=> array( 
						esc_html__('Descending','kapee-extensions') => 'desc',
						esc_html__('Ascending','kapee-extensions') 	=> 'asc',
					),
				),
				( function_exists( 'vc_map_add_css_animation' ) ) ? vc_map_add_css_animation( true ) : '',
				array(
					'type' 			=> 'textfield',
					'heading' 		=> esc_html__( 'Extra class name', 'kapee-extensions' ),
					'param_name' 	=> 'el_class',
					'description' 	=> esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'kapee-extensions' )
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
					"std"        	=> 3,
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
				//Portfolio setting				
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Hover Button Icon', 'kapee-extensions' ),
					'param_name' 	=> 'portfolio_button_icon',
					'std' 			=> 1,
					'value'			=> array( 
						esc_html__('Show','kapee-extensions') => 1,
						esc_html__('Hide','kapee-extensions') => 0,
					),
					'group'			=> esc_html__( 'Portfolio Settings', 'kapee-extensions' ),
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Link Button Icon', 'kapee-extensions' ),
					'param_name' 	=> 'portfolio_link_icon',
					'std' 			=> 1,
					'value'			=> array( 
						esc_html__('Show','kapee-extensions') => 1,
						esc_html__('Hide','kapee-extensions') => 0,
					),
					'dependency' 	=> array(
						'element' 	=> 'portfolio_button_icon',
						'value'   	=> array('1'),
					),
					'group'			=> esc_html__( 'Portfolio Settings', 'kapee-extensions' ),
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Zoom Image Icon', 'kapee-extensions' ),
					'param_name' 	=> 'portfolio_zoom_icon',
					'std' 			=> 1,
					'value'			=> array( 
						esc_html__('Show','kapee-extensions') => 1,
						esc_html__('Hide','kapee-extensions') => 0,
					),
					'dependency' 	=> array(
						'element' 	=> 'portfolio_button_icon',
						'value'   	=> array('1'),
					),
					'group'			=> esc_html__( 'Portfolio Settings', 'kapee-extensions' ),
				),
				array(
					'type'			=> 'dropdown',
					'heading' 		=> esc_html__( 'Portfolio Content Part', 'kapee-extensions' ),
					'param_name' 	=> 'portfolio_content_part',
					'std' 			=> 1,
					'value'			=> array( 
						esc_html__('Show','kapee-extensions') => 1,
						esc_html__('Hide','kapee-extensions') => 0,
					),
					'group'			=> esc_html__( 'Portfolio Settings', 'kapee-extensions' ),
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Portfolio Category', 'kapee-extensions' ),
					'param_name' 	=> 'portfolio_category',
					'std' 			=> 1,
					'value'			=> array( 
						esc_html__('Show','kapee-extensions') => 1,
						esc_html__('Hide','kapee-extensions') => 0,
					),
					'dependency' 	=> array(
						'element' 	=> 'portfolio_content_part',
						'value'   	=> array('1'),
					),
					'group'			=> esc_html__( 'Portfolio Settings', 'kapee-extensions' ),
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Portfolio Title', 'kapee-extensions' ),
					'param_name' 	=> 'portfolio_title',
					'std' 			=> 1,
					'value'			=> array( 
						esc_html__('Show','kapee-extensions') => 1,
						esc_html__('Hide','kapee-extensions') => 0,
					),
					'dependency' 	=> array(
						'element' 	=> 'portfolio_content_part',
						'value'   	=> array('1'),
					),
					'group'			=> esc_html__( 'Portfolio Settings', 'kapee-extensions' ),
				),
				//Style
				array(
					'type' 			=> 'css_editor',
					'heading' 		=> esc_html__( 'CSS box', 'kapee-extensions' ),
					'param_name' 	=> 'css',
					'group' 		=> esc_html__( 'Design Options', 'kapee-extensions' )
				)
			)
		) );
	}
	
	public function _html( $atts) {
		$args = ( shortcode_atts( array(
			'title' 					=> '',
			'portfolio_style' 			=> 'portfolio-style-1',			
			'portfolio_grid_gap' 		=> 30,
			'portfolio_per_page' 		=> '10',				
			'orderby' 					=> 'date',				
			'sortby' 					=> 'desc',
			'css_animation' 			=> 'none',	
			'el_class' 					=> '',
			'slider_autoplay' 			=> 0,
			'slider_loop' 				=> 0,
			'slider_center' 			=> 0,
			'slider_nav' 				=> 1,
			'slider_dots' 				=> 0,
			'rs_extra_large' 			=> 3,
			'rs_large'					=> 3,
			'rs_medium' 				=> 2,
			'rs_small' 					=> 2,
			'rs_extra_small' 			=> 1,
			'portfolio_button_icon'		=> 1,
			'portfolio_link_icon' 		=> 1,
			'portfolio_zoom_icon' 		=> 1,				
			'portfolio_content_part' 	=> 1,				
			'portfolio_category' 		=> 1,				
			'portfolio_title' 			=> 1,			
			'css'            			=> '',  
		), $atts ) );	 
		extract( $args );
		$args['id'] 		= kapee_uniqid('kapee-portfolios-');
		$class				= array();
		$class[]			= 'kapee-element';
		$class[]			= 'kapee-portfolios-carousel';
		$class[]			= $portfolio_style;
		$class[]			= $slider_center ? 'kapee-carousel-center-mode' : '';
		$class[]			= $el_class;
		$class[]			= kapee_get_css_animation($css_animation);
		$css_class 			= vc_shortcode_custom_css_class( $css, ' ' );
		$class[]			= $css_class;
		$args['class'] 		= implode(' ',array_filter($class));
		
		$owl_data	= array(
			'slider_loop'				=> $slider_loop ? true : false,
			'slider_autoplay' 			=> $slider_autoplay ? true : false,
			'slider_center' 			=> $slider_center ? true : false,
			'slider_nav'				=> $slider_nav ? true : false,
			'slider_dots'				=> $slider_dots ? true : false,
			'slider_margin' 			=> ( $portfolio_style != 'portfolio-style-1' && $portfolio_style !='portfolio-style-1' ) ? (int)$portfolio_grid_gap : 30,
			'rs_extra_large' 			=> $rs_extra_large,
			'rs_large' 					=> $rs_large,
			'rs_medium' 				=> $rs_medium,
			'rs_small' 					=> $rs_small,
			'rs_extra_small' 			=> $rs_extra_small,
		);
		
		$slider_data 			= shortcode_atts(kapee_slider_options(), $owl_data);
		global $kapee_owlparam;
		$kapee_owlparam['owlCarouselArg'][$args['id']] = $slider_data;
		
		$query_args = array(
			'post_type'          => 'portfolio',
			'post_status'        => array('publish'),
			'posts_per_page'     => $portfolio_per_page,
			'ignore_sticky_posts'=> true,
		);
		
		$query_args['orderby'] = $args['orderby'];
		
		// Posts Order
		if( ! empty( $orderby ) ){

			// Random Posts
			if( $orderby == 'rand' ){
				$query_args['orderby'] = 'rand';
			}

			// Recent modified Posts
			elseif( $orderby == 'modified' ){
				$query_args['orderby'] = 'modified';
			}
		}
		
		$query_args['order'] = $args['sortby'];
		
		$the_query = new WP_Query( $query_args );
		$args['query'] 			= $the_query; 
		
		kapee_set_loop_prop( 'name', 'portfolios-slider-shortcode' );
		kapee_set_loop_prop( 'portfolio-style', $portfolio_style );
		kapee_set_loop_prop( 'portfolio-grid-layout', 'simple-grid' );
		kapee_set_loop_prop( 'portfolio-grid-columns', '');
		kapee_set_loop_prop('rs_extra_large',$rs_extra_large);
		kapee_set_loop_prop('rs_large',$rs_large);
		kapee_set_loop_prop('rs_medium',$rs_medium);
		kapee_set_loop_prop('rs_small',$rs_small);
		kapee_set_loop_prop('rs_extra_small',$rs_extra_small);
		kapee_set_loop_prop( 'portfolio-filter', 0 );
		kapee_set_loop_prop( 'portfolio-content-part', $portfolio_content_part );
		kapee_set_loop_prop( 'portfolio-button-icon', $portfolio_button_icon );
		kapee_set_loop_prop( 'portfolio-link-icon', $portfolio_link_icon );
		kapee_set_loop_prop( 'portfolio-zoom-icon', $portfolio_zoom_icon );
		kapee_set_loop_prop( 'portfolio-content-part', $portfolio_content_part );
		kapee_set_loop_prop( 'portfolio-category', $portfolio_category );
		kapee_set_loop_prop( 'portfolio-title', $portfolio_title );
		ob_start();
			kapee_get_pl_templates('shortcodes/portfolio-carousel', $args );			
		return ob_get_clean();
	}	
}
new vcPortfolioCarousel();