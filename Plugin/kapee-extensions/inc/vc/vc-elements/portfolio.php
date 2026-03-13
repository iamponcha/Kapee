<?php
/*
Element: Portfolio
*/
class vcPortfolio extends WPBakeryShortCode {

    function __construct() {
        $this->_mapping();
        add_shortcode( 'kapee_portfolio', array( $this, '_html' ) );
	}
	public function _mapping() {
		if ( !defined( 'WPB_VC_VERSION' ) ) { return; }	
		$image_sizes 			= kapee_get_all_image_sizes(true);
        array_shift($image_sizes);		
		vc_map( array(
			'name' 			=> esc_html__( 'Portfolio', 'kapee-extensions' ),
			'base' 			=> 'kapee_portfolio',
			'category' 		=> esc_html__( 'Kapee', 'kapee-extensions' ),
			'description' 	=> esc_html__( 'Portfolio listing.', 'kapee-extensions' ),
        	'icon' 			=> KAPEE_URI.'/inc/admin/assets/images/vc-icon.png',
			'params' 		=> array(
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Style', 'kapee-extensions' ),
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
					"admin_label"   => true,
				),				
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Grid Gapping', 'kapee-extensions' ),
					'param_name' 	=> 'portfolio_grid_gap',
					'std' 			=> 15,
					'value'			=> array( 
						esc_html__('0','kapee-extensions') 	=> 0,
						esc_html__('5','kapee-extensions') 	=> 5,
						esc_html__('10','kapee-extensions') => 10,
						esc_html__('15','kapee-extensions') => 15,
					),
					'dependency'	=> array(
						'element'				=> 'portfolio_style',
						'value_not_equal_to' 	=> array( 'portfolio-style-1','portfolio-style-2' ),
					)
				),
				array(
					'type' 			=> 'textfield',
					'heading' 		=> esc_html__( 'Portfolio Per Page', 'kapee-extensions' ),
					'param_name' 	=> 'limit',
					'std' 			=> '10',
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Order By', 'kapee-extensions' ),
					'param_name' 	=> 'orderby',
					'std' 			=> 'date',
					'value'		=> array( 
						esc_html__('Title','kapee-extensions') 	=> 'title',
						esc_html__('Date','kapee-extensions') 	=> 'date',
						esc_html__('Random','kapee-extensions') => 'random',
					),
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Sort By', 'kapee-extensions' ),
					'param_name'	=> 'sortby',
					'std'			=> 'desc',
					'value'			=> array( 
						esc_html__('Descending','kapee-extensions') => 'desc',
						esc_html__('Ascending','kapee-extensions') 	=> 'asc',
					),
				),
				array(
					'type'        	=> 'dropdown',
					'param_name'  	=> 'pagination',
					'admin_label' 	=> true,
					'heading'     	=> esc_html__( 'Pagination', 'kapee-extensions' ),
					'value'       	=> array(
						esc_html__( 'None', 'kapee-extensions' )       => 'none',
						esc_html__( 'Default', 'kapee-extensions' )       => 'default',
						esc_html__( 'Infinity Scroll', 'kapee-extensions' )  => 'infinity-scroll',
						esc_html__( 'Load More', 'kapee-extensions' )  => 'load-more-button',
					),
					'std' 			=> 'none',
					'description' 	=> esc_html__( 'Select pagination style.', 'kapee-extensions' ),
					'dependency' 	=> array(
						'element' 	=> 'layout',
						'value' 	=> array( 'grid' ),
					),
				),
				( function_exists( 'vc_map_add_css_animation' ) ) ? vc_map_add_css_animation( true ) : '',
				array(
					'type' 			=> 'textfield',
					'heading' 		=> esc_html__( 'Extra class name', 'kapee-extensions' ),
					'param_name' 	=> 'el_class',
					'description' 	=> esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'kapee-extensions' )
				),
				//Grid setting
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Grid Layout', 'kapee-extensions' ),
					'param_name' 	=> 'portfolio_grid_layout',
					'std' 			=> 'masonry-grid',
					'value'			=> array( 
						esc_html__('Simple','kapee-extensions') 	=> 'simple-grid',
						esc_html__('Masonry','kapee-extensions') 	=> 'masonry-grid'
					),
					'group'			=> esc_html__( 'Grid Settings', 'kapee-extensions' ),
					"admin_label"   => true,
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Column', 'kapee-extensions' ),
					'param_name' 	=> 'portfolio_grid_columns',
					'std' 			=> 3,
					'value'			=> array( 
						esc_html__('2 Columns','kapee-extensions') => 2,
						esc_html__('3 Columns','kapee-extensions') => 3,
						esc_html__('4 Columns','kapee-extensions') => 4,
					),
					'group'			=> esc_html__( 'Grid Settings', 'kapee-extensions' ),
				),
				//Portfolio setting
				array(
					'type'			=> 'dropdown',
					'heading'		=> esc_html__( 'Portfolio Filter', 'kapee-extensions' ),
					'param_name' 	=> 'portfolio_filter',
					'std' 			=> 1,
					'value'			=> array( 
						esc_html__('Show','kapee-extensions') => 1,
						esc_html__('Hide','kapee-extensions') => 0,
					),
					'group'			=> esc_html__( 'Portfolio Settings', 'kapee-extensions' ),
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Hover Button Icon', 'kapee-extensions' ),
					'param_name' 	=> 'portfolio_button_icon',
					'std' 			=> 1,
					'value'			=> array( 
						esc_html__('Show','kapee-extensions') 	=> 1,
						esc_html__('Hide','kapee-extensions') 	=> 0,
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
						'element' => 'portfolio_button_icon',
						'value'   => array('1'),
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
						'element' => 'portfolio_button_icon',
						'value'   => array('1'),
					),
					'group'			=> esc_html__( 'Portfolio Settings', 'kapee-extensions' ),
				),
				array(
					'type' 			=> 'dropdown',
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
						'element' => 'portfolio_content_part',
						'value'   => array('1'),
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
			'portfolio_style' 				=> 'portfolio-style-1',
			'portfolio_grid_gap' 			=> 15,
			'limit' 						=> '10',				
			'orderby' 						=> 'date',				
			'sortby' 						=> 'desc',
			'pagination' 					=> 'none',
			'post_type' 					=> 'portfolio',
			'css_animation' 				=> 'none',	
			'el_class' 						=> '',
			'portfolio_grid_layout' 		=> 'masonry-grid',
			'portfolio_grid_columns' 		=> 3,
			'portfolio_filter' 				=> 1,
			'portfolio_button_icon'			=> 1,
			'portfolio_link_icon' 			=> 1,
			'portfolio_zoom_icon' 			=> 1,				
			'portfolio_content_part' 		=> 1,				
			'portfolio_category' 			=> 1,				
			'portfolio_title' 				=> 1,				
			'css' 							=> true,				
		), $atts ) );
		extract( $args );
		$default_atts 		= $args;
		$args['id'] 		= kapee_uniqid('kapee-portfolio-');
		$class				= array();
		$class[]			= 'kapee-element';
		$class[]			= 'kapee-portfolio';
		$class[]			= $portfolio_style;
		$class[]			= $el_class;
		$class[]			= kapee_get_css_animation($css_animation);
		$css_class 			= vc_shortcode_custom_css_class( $css, ' ' );
		$class[]			= $css_class;
		$args['class'] 		= implode(' ', array_filter( $class ) );
		// Pagination parameter
		if(is_home() || is_front_page()) {
			$paged = get_query_var('page');
		} else {
			$paged = get_query_var('paged');
		}
		$args['paged'] = $paged;
			
		$query_args  	= kapee_get_posts($args);
		$the_query 		= new WP_Query( $query_args );
		$args['query'] 	= $the_query; 
		
		$total   = $the_query->max_num_pages;
		$current = $paged;
		$base    = esc_url_raw( str_replace( 999999999, '%#%', get_pagenum_link( 999999999, false ) ) );
		$format  = '?page=%#%';
		$show_pagination  = true;
		if ( $total <= 1 || $pagination == 'none') {
			$show_pagination  = false;
		}
		
		$args['show_pagination'] 	= $show_pagination;
		$args['total'] 				= $total;
		$args['base'] 				= $base;
		$args['current'] 			= $current;
		$args['format'] 			= $format;
		$args['atts'] 				= wp_json_encode( $default_atts );	
		
		
		kapee_set_loop_prop( 'name','portfolio-post-shortcode' );
		kapee_set_loop_prop( 'portfolio-style', $portfolio_style );
		kapee_set_loop_prop( 'portfolio-grid-layout', $portfolio_grid_layout );
		kapee_set_loop_prop( 'portfolio-grid-columns', $portfolio_grid_columns );
		kapee_set_loop_prop( 'portfolio-content-part', $portfolio_content_part );
		kapee_set_loop_prop( 'portfolio-grid-gap', $portfolio_grid_gap );
		kapee_set_loop_prop( 'portfolio-filter', $portfolio_filter );
		kapee_set_loop_prop( 'portfolio-button-icon', $portfolio_button_icon );
		kapee_set_loop_prop( 'portfolio-link-icon', $portfolio_link_icon );
		kapee_set_loop_prop( 'portfolio-zoom-icon', $portfolio_zoom_icon );
		kapee_set_loop_prop( 'portfolio-content-part', $portfolio_content_part );
		kapee_set_loop_prop( 'portfolio-category', $portfolio_category );
		kapee_set_loop_prop( 'portfolio-title', $portfolio_title );
		
		ob_start();
			kapee_get_pl_templates('shortcodes/portfolio', $args );
		return ob_get_clean();
	}	
}
new vcPortfolio();