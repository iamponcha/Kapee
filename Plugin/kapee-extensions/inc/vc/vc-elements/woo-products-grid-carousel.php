<?php
/*
Element: Products Grid Or Carousel
*/
class vcProductsGridCarousel extends WPBakeryShortCode {

    function __construct() {
        $this->_mapping();
        add_shortcode( 'kapee_products_grid_carousel', array( $this, '_html' ) );
	}
	public function _mapping() {
		if ( !defined( 'WPB_VC_VERSION' ) ) { return; }
		
		vc_map( array(
			'name' 			=> esc_html__( 'Products Grid Or Carousel', 'kapee-extensions' ),
			'base' 			=> 'kapee_products_grid_carousel',
			'category' 		=> esc_html__( 'Kapee', 'kapee-extensions' ),
        	'icon' 			=> KAPEE_URI.'/inc/admin/assets/images/vc-icon.png',
			'params' 		=> array(
				array(
					"type" 			=> "textfield",
					"heading" 		=> esc_html__( "Title", 'kapee-extensions' ),
					"param_name" 	=> "title",
					"admin_label"   => true,
					"description"   => esc_html__( "Enter title", 'kapee-extensions' ),					
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Layout', 'kapee-extensions' ),
					'param_name' 	=> 'layout',
					'std' 			=> 'slider',
					'value'			=> array( 
						esc_html__('Slider','kapee-extensions') => 'slider',
						esc_html__('Grid','kapee-extensions') 	=> 'grid',
					),
					"admin_label"   => true,
				),				
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Product View Mode', 'kapee-extensions' ),
					'param_name' 	=> 'product_view_mode',
					'std' 			=> 'vertical',
					'value'			=> array( 
						esc_html__('Vertical','kapee-extensions') 	=> 'vertical',
						esc_html__('Horizontal','kapee-extensions') => 'horizontal',
					),
					"admin_label"   => true,
				),
				array(
					'type'        	=> 'dropdown',
					'param_name'  	=> 'product_style',
					'heading'     	=> esc_html__( 'Products Hover Style', 'kapee-extensions' ),
					'value'       	=> array(
						esc_html__( 'Default', 'kapee-extensions' )       => 'default',
						esc_html__( 'Products Hover Style 1', 'kapee-extensions' )  => 'product-style-1',
						esc_html__( 'Products Hover Style 2', 'kapee-extensions' )  => 'product-style-2',
						esc_html__( 'Products Hover Style 3', 'kapee-extensions' ) 	=> 'product-style-3',
						esc_html__( 'Products Hover Style 4', 'kapee-extensions' )  => 'product-style-4',
						esc_html__( 'Products Hover Style 5', 'kapee-extensions' )  => 'product-style-5',
					),
					'std' 			=> 'default',
					'description' 	=> esc_html__( 'Select product hover style.', 'kapee-extensions' ),
				),
				array(
					'type'        	=> 'dropdown',
					'param_name'  	=> 'action_buttons_style',
					'heading'     	=> esc_html__( 'Action Buttons Style', 'kapee-extensions' ),
					'value'       	=> array(
						esc_html__( 'Icons With Cart Text', 'kapee-extensions' )  	=> 'icon-with-text',
						esc_html__( 'Only Icons', 'kapee-extensions' )      		=> 'icon',
					),
					'std' 			=> 'icon-with-text',
					'description' 	=> esc_html__( 'Select product action button style', 'kapee-extensions' ),
					'dependency' 	=> array(
						'element' 	=> 'product_style',
						'value' 	=> array( 'default', 'product-style-1', 'product-style-3', 'product-style-4', 'product-style-5' ),
					),
				),
				array(
					'type'        	=> 'dropdown',
					'param_name'  	=> 'data_source',
					'admin_label' 	=> true,
					'heading'     	=> esc_html__( 'Data source', 'kapee-extensions' ),
					'value'       	=> array(
						esc_html__( 'Recent Products', 'kapee-extensions' )       => 'recent_products',
						esc_html__( 'Featured Products', 'kapee-extensions' )     => 'featured_products',
						esc_html__( 'On Sale Products', 'kapee-extensions' )      => 'sale_products',
						esc_html__( 'Best-Selling Products', 'kapee-extensions' ) => 'best_selling_products',
						esc_html__( 'Top Rated Products', 'kapee-extensions' )    => 'top_rated_products',
						esc_html__( 'List of Products', 'kapee-extensions' )      => 'products',
					),
					'description' 	=> esc_html__( 'Select data source for your product grid', 'kapee-extensions' ),
				),
				array(
					'type' 			=> 'autocomplete',
					'heading'		=> esc_html__( 'Include Product Ids', 'kapee-extensions' ),
					'param_name'	=> 'product_ids',
					'settings' 		=> array(
						'multiple' 	=> true,
					),
					'dependency'	=> array(
						'element' => 'data_source',
						'value'   => 'products',
					),
					'description'	=> esc_html__( 'Add products by title.', 'kapee-extensions' ),					
				),				
				array(
					'type' 				=> 'autocomplete',
					'heading' 			=> esc_html__( 'Category', 'kapee-extensions' ),
					'param_name' 		=> 'categories',
					'settings' 		=> array(
						'multiple'	=> true,
					),
					"description" 		=> __( "Select specific categories.", 'kapee-extensions' ),
				),
				array(
					'type' 			=> 'autocomplete',
					'heading'		=> esc_html__( 'Exclude Products', 'kapee-extensions' ),
					'param_name'	=> 'exclude',
					'settings' 		=> array(
						'multiple' 	=> true,
					),
					'description'	=> esc_html__('Exclude some products which you do not want to display. Add product by title.','kapee-extensions'),
					
				),
				array(
					'type' 			=> 'textfield',
					'heading' 		=> esc_html__( 'Number Of Products', 'kapee-extensions' ),
					'param_name' 	=> 'limit',
					'std'			=> 10,
					
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Order By', 'kapee-extensions' ),
					'param_name' 	=> 'orderby',
					"value" 		=> array(
						esc_html__( "Date", 'kapee-extensions' )   		=> "date",
						esc_html__( "Title", 'kapee-extensions' )   	=> "title",
						esc_html__( "Name(Slug)", 'kapee-extensions' ) 	=> "name",
						esc_html__( "Menu Order", 'kapee-extensions' ) 	=> "menu_order",
						esc_html__( "Random", 'kapee-extensions' )   	=> "rand",
						esc_html__( "ID", 'kapee-extensions' )   		=> "id",
					),
					'std' 			=> 'date',
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Sort By', 'kapee-extensions' ),
					'param_name' 	=> 'sortby',
					'std' 			=> 'desc',
					'value'			=> array( 
						esc_html__('Descending','kapee-extensions') => 'desc',
						esc_html__('Ascending','kapee-extensions') => 'asc',
					),
				),
				array(
					'type'        	=> 'dropdown',
					'param_name'  	=> 'pagination',
					'heading'     	=> esc_html__( 'Products Pagination', 'kapee-extensions' ),
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
				array(
					'type' 			=> 'checkbox',
					'param_name' 	=> 'show_view_more_button',
					'heading' 		=> esc_html__( 'Show View All Button', 'kapee-extensions' ),
					'value' 			=> array( esc_html__( 'Yes', 'kapee-extensions' ) => 1 ),
					'std' 				=> 1,
				),
				array(
					'type' 			=> 'textfield',
					'heading' 		=> esc_html__( 'View All Button Text', 'kapee-extensions' ),
					'param_name' 	=> 'view_more_button_text',
					'std' 			=> 'View All',
					'description' 	=> esc_html__( 'Enter view all button text.', 'kapee-extensions' ),
					'dependency' 	=> array(
						'element' 	=> 'show_view_more_button',
						'value' 	=> '1',
					),
				),
				array(
					'type' 			=> 'vc_link',
					'param_name' 	=> 'view_more_button_link',
					'heading' 		=> esc_html__( 'View More Button Link', 'kapee-extensions'),
					'dependency' 	=> array(
						'element' 	=> 'show_view_more_button',
						'value' 	=> '1',
					),
				),				
				array(
					'type' 			=> 'textfield',
					'param_name' 	=> 'el_class',
					'heading' 		=> esc_html__( 'Extra class name', 'kapee-extensions' ),
					'description' 	=> esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'kapee-extensions' )
				),
				//Grid Settings
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Number Of Columns', 'kapee-extensions' ),
					'param_name' 	=> 'columns',
					'value' 		=> array(
						'1'  	=> 1,
						'2' 	=> 2,
						'3' 	=> 3,
						'4' 	=> 4,
						'5' 	=> 5,
						'6' 	=> 6,
					),
					'std' 			=> 4,
					'dependency' 	=> array(
						'element' 	=> 'layout',
						'value' 	=> array( 'grid' ),
					),
					'group' 		=> esc_html__( 'Grid Settings', 'kapee-extensions' ),					
				),
				//Carousel setting
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Number Of Row', 'kapee-extensions' ),
					'param_name' 	=> 'rows',
					'std' 			=> 1,
					'value'			=> array( 
						esc_html__('1 Row','kapee-extensions') 		=> 1,
						esc_html__('2 Rows','kapee-extensions') 	=> 2,
						esc_html__('3 Rows','kapee-extensions') 	=> 3,
					),
					'dependency' 	=> array(
						'element' 	=> 'layout',
						'value' 	=> array( 'slider' ),
					),
					'group'			=> esc_html__( 'Carousel Settings', 'kapee-extensions' ),
				),
				array(
					'type' 			=> 'checkbox',
					'heading' 		=> esc_html__( 'Autoplay', 'kapee-extensions' ),
					'param_name' 	=> 'slider_autoplay',
					'value' 			=> array( esc_html__( 'Yes', 'kapee-extensions' ) => 1 ),
					'std' 				=> 0,
					'dependency' 	=> array(
						'element' 	=> 'layout',
						'value' 	=> array( 'slider' ),
					),
					'group'      	=> esc_html__( 'Carousel Settings', 'kapee-extensions' ),
				),				
				array(
					'type' 			=> 'checkbox',
					'heading' 		=> esc_html__( 'Loop', 'kapee-extensions' ),
					'param_name' 	=> 'slider_loop',
					'value' 		=> array( esc_html__( 'Yes', 'kapee-extensions' ) => 1 ),
					'std' 			=> 0,
					'description' 	=> esc_html__( 'True for infinate loop.', 'kapee-extensions' ),
					'dependency' 	=> array(
						'element' 	=> 'layout',
						'value' 	=> array( 'slider' ),
					),
					'group'			=> esc_html__( 'Carousel Settings', 'kapee-extensions' ),
				),
				array(
					'type' 			=> 'checkbox',
					'heading' 		=> esc_html__( 'Center Mode', 'kapee-extensions' ),
					'param_name' 	=> 'slider_center',
					'value' 		=> array( esc_html__( 'Yes', 'kapee-extensions' ) => 1 ),
					'std' 			=> 0,
					'description' 	=> esc_html__( 'Center item. Works well with an odd number of items.', 'kapee-extensions' ),
					'dependency' 	=> array(
						'element' 	=> 'layout',
						'value' 	=> array( 'slider' ),
					),
					'group'			=> esc_html__( 'Carousel Settings', 'kapee-extensions' ),
				),
				array(
					'type' 			=> 'checkbox',
					'heading' 		=> esc_html__( 'Nav', 'kapee-extensions' ),
					'param_name' 	=> 'slider_nav',
					'value' 			=> array( esc_html__( 'Yes', 'kapee-extensions' ) => 1 ),
					'std' 				=> 1,
					'description' 	=> esc_html__( 'True for display navigation icon.', 'kapee-extensions' ),
					'dependency' 	=> array(
						'element' 	=> 'layout',
						'value' 	=> array( 'slider' ),
					),
					'group'			=> esc_html__( 'Carousel Settings', 'kapee-extensions' ),
				),	
				array(
					'type' 			=> 'checkbox',
					'heading' 		=> esc_html__( 'Dots', 'kapee-extensions' ),
					'param_name' 	=> 'slider_dots',
					'value' 			=> array( esc_html__( 'Yes', 'kapee-extensions' ) => 1 ),
					'std' 				=> 0,
					'description' 	=> esc_html__( 'True for display dots.', 'kapee-extensions' ),
					'dependency' 	=> array(
						'element' 	=> 'layout',
						'value' 	=> array( 'slider' ),
					),
					'group'			=> esc_html__( 'Carousel Settings', 'kapee-extensions' ),
				),
							
				array(
					'type'       	=> 'dropdown',
					'heading'    	=> esc_html__('Extra large devices (large desktops, 1200px and up)', 'kapee-extensions' ),
					'param_name' 	=> 'rs_extra_large',
					'value' 		=> array(
						'1'  	=> 1,
						'2' 	=> 2,
						'3' 	=> 3,
						'4' 	=> 4,
						'5' 	=> 5,
						'6' 	=> 6,
					),
					'std'        	=> 4,
					'dependency' 	=> array(
						'element' 	=> 'layout',
						'value' 	=> array( 'slider' ),
					),
					'group'      	=> esc_html__( 'Carousel Settings', 'kapee-extensions' ),
				),
				array(
					'type'          => 'dropdown',
					'heading'       => esc_html__('Large devices (desktops, 992px and up)', 'kapee-extensions' ),
					'param_name'    => 'rs_large',
					'value' 		=> array(
						'1'  	=> 1,
						'2' 	=> 2,
						'3' 	=> 3,
						'4' 	=> 4,
						'5' 	=> 5,
					),
					'std'           => 4,
					'dependency' 	=> array(
						'element' 	=> 'layout',
						'value' 	=> array( 'slider' ),
					),
					'group'         => esc_html__( 'Carousel Settings', 'kapee-extensions' ),
				),
				array(
					'type'          => 'dropdown',
					'heading'       => esc_html__('Medium devices (tablets, 768px and up)', 'kapee-extensions' ),
					'param_name'    => 'rs_medium',
					'value' 		=> array(
						'1'  	=> 1,
						'2' 	=> 2,
						'3' 	=> 3,
						'4' 	=> 4,
					),
					'std'           => 3,
					'dependency' 	=> array(
						'element' 	=> 'layout',
						'value' 	=> array( 'slider' ),
					),
					'group'         => esc_html__( 'Carousel Settings', 'kapee-extensions' ),
				),
				array(
					'type'          => 'dropdown',
					'heading'       => esc_html__('Small devices (landscape phones, 576px and up)', 'kapee-extensions' ),
					'param_name'    => 'rs_small',
					'value' 		=> array(
						'1'  	=> 1,
						'2' 	=> 2,
						'3' 	=> 3,
					),
					'std'           => 2,
					'dependency' 	=> array(
						'element' 	=> 'layout',
						'value' 	=> array( 'slider' ),
					),
					'group'         => esc_html__( 'Carousel Settings', 'kapee-extensions' ),
				),
				array(
					'type'          => 'dropdown',
					'heading'       => esc_html__('Extra small devices (portrait phones, less than 576px)', 'kapee-extensions' ),
					'param_name'    => 'rs_extra_small',
					'value' 		=> array(
						'1'  	=> 1,
						'2' 	=> 2,
					),
					'std'           => 2,
					'dependency' 	=> array(
						'element' 	=> 'layout',
						'value' 	=> array( 'slider' ),
					),
					'group'         => esc_html__( 'Carousel Settings', 'kapee-extensions' ),
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
	
	public function _html( $atts, $content ) {
		$args = ( shortcode_atts( array(
			'title' 					=> '',
			'layout' 					=> 'slider',
			'product_view_mode' 		=> 'vertical',
			'product_style' 			=> 'default',
			'action_buttons_style'		=> 'icon-with-text',
			'data_source' 				=> 'recent_products',
			'product_ids' 				=> '',
			'categories' 				=> '',
			'exclude' 					=> '',
			'limit' 					=> '10',
			'orderby' 					=> 'date',
			'sortby' 					=> 'desc',
			'pagination' 				=> 'none',
			'show_view_more_button' 	=> 1,
			'view_more_button_text'		=> 'View All',
			'view_more_button_link'		=> '',
			'el_class' 					=> '',	
			'columns' 					=> 4,	
			'rows' 						=> 1,	
			'slider_autoplay' 			=> 0,
			'slider_loop' 				=> 0,
			'slider_center' 			=> 0,
			'slider_nav' 				=> 1,
			'slider_dots' 				=> 0,
			'rs_extra_large' 			=> 4,
			'rs_large'					=> 4,
			'rs_medium' 				=> 3,
			'rs_small' 					=> 2,
			'rs_extra_small' 			=> 2,
			'css'            			=> '',  
		), $atts ) );	 
		extract( $args );
		$default_atts 		= $args;
		$args['id']			= kapee_uniqid('kapee-grid-slider');
		$class				= array( 'kapee-element', 'woocommerce' );
		$class[]			= ( 'horizontal' == $product_view_mode ) ? 'kapee-product-'.$product_view_mode : '';
		$class[]			= $el_class;
		$css_class 			= vc_shortcode_custom_css_class( $css, ' ' );
		$class[]			= $css_class;
		
		$args['show_view_more_button'] 	= $show_view_more_button ? true : false;
		$args['view_all_link'] 			= wc_get_page_permalink( 'shop' );
		
		// Pagination parameter
		if( is_home() || is_front_page() ) {
			$paged = get_query_var('page');
		} else {
			$paged = get_query_var('paged');
		}
		$args['paged'] = $paged;
		
		$query = kapee_get_products( $data_source, $args );
		
		$the_query = new WP_Query( $query );		
		$args['query'] 			= $the_query;
		$total   = $the_query->max_num_pages;
		$current = $paged;
		$base    = esc_url_raw( str_replace( 999999999, '%#%', get_pagenum_link( 999999999, false ) ) );
		$format  = '?page=%#%';
		$show_pagination  = true;
		if ( $total <= 1 || $pagination == 'none' || $layout == 'slider') {
			$show_pagination  = false;
		}
		
		$args['show_pagination'] 	= $show_pagination;
		$args['total'] 				= $total;
		$args['base'] 				= $base;
		$args['current'] 			= $current;
		$args['format'] 			= $format;
		$args['atts'] 				= wp_json_encode($default_atts);
				
		$link_default = array( 'url'    => '', 'title'  => '', 'target' => '_self' );
		
		if ( function_exists( 'vc_build_link' ) && !empty($view_more_button_link) ):
			$link = wp_parse_args( vc_build_link( $view_more_button_link ), $link_default );
		else:
			$link = $link_default;
		endif;
		
		$link_url 						= '';
		// Fix empty target attribute
		if ( trim( $link['url'] ) != '' ) :
			$link_url = $link['url'];
		endif;
		
		if(!empty($link_url)){
			$args['view_all_link'] 	= $link_url;
		}else if(!empty($categories)){
			$cat_id = explode( ',', $categories );
			$args['view_all_link'] 	= get_term_link( (int)trim($cat_id[0]), 'product_cat' );
		}
		
		if( $product_style != 'default' ){
			kapee_set_loop_prop( 'product-style', $product_style );
		}		
		if( 'product-style-2' != $product_style && 'icon' == $action_buttons_style ){
			kapee_set_loop_prop( 'product-action-buttons-style', 'product-cart-icon' );
		}
		kapee_set_loop_prop( 'products_view', 'grid-view' );
		kapee_set_loop_prop('products-rating-histogram',0);
		if( $layout == 'grid' ){
			kapee_set_loop_prop( 'products-columns', $columns );
			wc_set_loop_prop( 'columns', $columns );
		}else{			
			$owl_data	= array(
				'slider_loop'				=> $slider_loop ? true : false,
				'slider_autoplay' 			=> $slider_autoplay ? true : false,
				'slider_center' 			=> $slider_center ? true : false,
				'slider_nav'				=> $slider_nav ? true : false,
				'slider_dots'				=> $slider_dots ? true : false,
				'slider_autoHeight'			=>  false,
				'rs_extra_large' 			=> $rs_extra_large,
				'rs_large' 					=> $rs_large,
				'rs_medium' 				=> $rs_medium,
				'rs_small' 					=> $rs_small,
				'rs_extra_small' 			=> $rs_extra_small,
			);
			$unique_id 		= kapee_uniqid('section-');
			$slider_data 	= shortcode_atts( kapee_slider_options() ,$owl_data);
			global $kapee_owlparam;
			$kapee_owlparam['owlCarouselArg'][$unique_id] = $slider_data;
			$class[]			= 'products-carousel';						
			kapee_set_loop_prop('name','kapee-carousel');
			kapee_set_loop_prop('products-rating-histogram',0);
			kapee_set_loop_prop('products-columns',$rs_extra_large);
			kapee_set_loop_prop('rs_extra_large',$rs_extra_large);
			kapee_set_loop_prop('rs_large',$rs_large);
			kapee_set_loop_prop('rs_medium',$rs_medium);
			kapee_set_loop_prop('rs_small',$rs_small);
			kapee_set_loop_prop('rs_extra_small',$rs_extra_small);
			kapee_set_loop_prop('unique_id',$unique_id);
			kapee_set_loop_prop('slider_data',$slider_data);
			
		}
		$args['class'] = implode(' ',array_filter($class));
		$args['args'] = wp_json_encode( $args );
		wp_enqueue_script( 'countdown' );
		ob_start();
			kapee_get_pl_templates('shortcodes/products-grid-carousel',$args );			
		return ob_get_clean();
	}	
}
new vcProductsGridCarousel();
?>