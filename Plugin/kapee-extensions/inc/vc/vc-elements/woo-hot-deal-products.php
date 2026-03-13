<?php
/*
Element: Hot Deal Products
*/
class vcHotDealProducts extends WPBakeryShortCode {

    function __construct() {
        $this->_mapping();
        add_shortcode( 'kapee_hot_deal_products', array( $this, '_html' ) );
	}
	public function _mapping() {
		if ( !defined( 'WPB_VC_VERSION' ) ) { return; }
		
		vc_map( array(
			'name' 			=> esc_html__( 'Hot Deal Products', 'kapee-extensions' ),
			'base' 			=> 'kapee_hot_deal_products',
			'category' 		=> esc_html__( 'Kapee', 'kapee-extensions' ),
        	'icon' 			=> KAPEE_URI.'/inc/admin/assets/images/vc-icon.png',
			'params' 		=> array(				
				//Data Settings
				array(
					'type' 			=> 'textfield',
					'heading' 		=> esc_html__( 'Title', 'kapee-extensions' ),
					'param_name' 	=> 'title',
					'std' 			=> esc_html__( 'Hot Deals', 'kapee-extensions' ),
				),
				array(
					'type' 			=> 'dropdown',
					'param_name' 	=> 'layout',
					'heading' 		=> esc_html__( 'Layout', 'kapee-extensions' ),
					'value'			=> array( 
						esc_html__('Slider','kapee-extensions') => 'slider',
						esc_html__('Grid','kapee-extensions') 	=> 'grid'
					),
					'std' 			=> 'slider',
					"admin_label"   => true,
				),
				array(
					'type'        	=> 'dropdown',
					'param_name'  	=> 'product_deal_style',
					'heading'     	=> esc_html__( 'Products Deal Style', 'kapee-extensions' ),
					'description' 	=> esc_html__( 'Select product deal style.', 'kapee-extensions' ),
					'value'       	=> array(
						esc_html__( 'Simple Deal', 'kapee-extensions' )  	=> 'simple',
						esc_html__( 'Deal With Timer', 'kapee-extensions' )	=> 'deal-with-timer',
					),
					'std' 			=> 'simple',
					'admin_label' 	=> true,
				),
				array(
					'type' 			=> 'textfield',
					'param_name' 	=> 'deal_title',
					'heading' 		=> esc_html__( 'Deal title', 'kapee-extensions' ),
					'description' 	=> esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'kapee-extensions' ),
					'std'			=> 'Deal Ends In:',
					'dependency' 	=> array(
						'element' 	=> 'product_deal_style',
						'value' 	=> array( 'deal-with-timer'),
					),
				),
				array(
					'type' 			=> 'textfield',
					'param_name' 	=> 'deal_end_date',
					'heading' 		=> esc_html__( 'Deal End Date', 'kapee-extensions' ),
					'description' 	=> esc_html__( 'Enter deal end date like YYYY-MM-DD', 'kapee-extensions' ),
					'dependency' 	=> array(
						'element' 	=> 'product_deal_style',
						'value' 	=> array( 'deal-with-timer'),
					),
				),
				array(
					'type' 			=> 'checkbox',
					'param_name' 	=> 'hide_element',
					'heading' 		=> esc_html__( 'Hide Elements After Deal Ends.', 'kapee-extensions' ),
					'value' 			=> array( esc_html__( 'Yes', 'kapee-extensions' ) => 1 ),
					'std' 				=> 0,
					'dependency' 	=> array(
						'element' 	=> 'product_deal_style',
						'value' 	=> array( 'deal-with-timer'),
					),
				),
				array(
					'type' 			=> 'dropdown',
					'param_name' 	=> 'product_view_mode',
					'heading' 		=> esc_html__( 'Product View Mode', 'kapee-extensions' ),
					'value'			=> array( 
						esc_html__('Vertical','kapee-extensions') 	=> 'vertical',
						esc_html__('Horizontal','kapee-extensions') 	=> 'horizontal'
					),
					'std' 			=> 'vertical',
					"admin_label"   => true,
				),
				array(
					'type'        	=> 'dropdown',
					'param_name'  	=> 'product_style',
					'heading'     	=> esc_html__( 'Products Hover Style', 'kapee-extensions' ),
					'value'       	=> array(
						esc_html__( 'Default', 'kapee-extensions' )      			=> 'default',
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
					'type' 			=> 'checkbox',
					'param_name' 	=> 'show_stock_progressbar',
					'heading' 		=> esc_html__( 'Show Progressbar', 'kapee-extensions' ),
					'value' 			=> array( esc_html__( 'Yes', 'kapee-extensions' ) => 1 ),
					'std' 				=> 0,
				),
				array(
					'type' 			=> 'checkbox',
					'param_name' 	=> 'show_countdown',
					'heading' 		=> esc_html__( 'Show Countdown', 'kapee-extensions' ),
					'value' 			=> array( esc_html__( 'Yes', 'kapee-extensions' ) => 1 ),
					'std' 				=> 1,
				),
				array(
					'type' 			=> 'checkbox',
					'param_name' 	=> 'highlighted_border',
					'heading' 		=> esc_html__( 'Highlighted with Border', 'kapee-extensions' ),
					'value' 			=> array( esc_html__( 'Yes', 'kapee-extensions' ) => 1 ),
					'std' 				=> 0,
				),
				array(
					'type'        	=> 'dropdown',
					'param_name'  	=> 'countdown_position',
					'heading'     	=> esc_html__( 'Countdown Position', 'kapee-extensions' ),
					'description' 	=> esc_html__( 'Select product countdown display position.', 'kapee-extensions' ),
					'value'       	=> array(
						esc_html__( 'On Product Image', 'kapee-extensions' )  	=> 'on-product-image',
						esc_html__( 'After Product Price', 'kapee-extensions' )  => 'after-product-price',
					),
					'std' 			=> 'on-product-image',
					'dependency' 	=> array(
						'element' 	=> 'show_countdown',
						'value' 	=> array( '1' ),
					),
				),
				array(
					'type' 			=> 'autocomplete',
					'heading' 		=> esc_html__( 'Specific Categories', 'kapee-extensions' ),
					'param_name' 	=> 'categories',
					'settings' 		=> array(
						'multiple'	=> true,
					),
					'description' 	=> esc_html__( 'If you want to display hot deal products of specific categories then select categories otherwise skip it.', 'kapee-extensions' ),
				),
				array(
					'type' 			=> 'autocomplete',
					'heading' 		=> esc_html__( 'Specific Products', 'kapee-extensions' ),
					'param_name' 	=> 'product_ids',
					'settings' 		=> array(
						'multiple'	=> true,
					),
					'description' 	=> esc_html__( 'Select products.', 'kapee-extensions' ),
					'admin_label'   => true,
				),
				array(
					'type' 			=> 'textfield',
					'heading' 		=> esc_html__( 'Number Of Products', 'kapee-extensions' ),
					'param_name' 	=> 'limit',
					'std' 			=> '10',
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
						esc_html__('Descending','kapee-extensions') 	=> 'desc',
						esc_html__('Ascending','kapee-extensions') 		=> 'asc',
					),
				),
				array(
					'type' 			=> 'textfield',
					'heading' 		=> esc_html__( 'Extra class name', 'kapee-extensions' ),
					'param_name' 	=> 'el_class',
					'description' 	=> esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'kapee-extensions' )
				),
				
				//Grid Settings
				array(
					'type' 			=> 'dropdown',
					'param_name' 	=> 'columns',
					'heading' 		=> esc_html__( 'Number Of Columns', 'kapee-extensions' ),
					"value" 		=> array(
						"1"  	=> 1,
						"2" 	=> 2,
						"3" 	=> 3,
						"4" 	=> 4,
						"5" 	=> 5,
						"6" 	=> 6,
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
				/* array(
					'type' 			=> 'dropdown',
					'param_name' 	=> 'slider_nav_position',
					'heading' 		=> esc_html__( 'Navigation Position', 'kapee-extensions' ),
					'description' 	=> esc_html__( 'Select next/prev navigation position.', 'kapee-extensions' ),
					'value' 		=> array(
						'Middle' 	=> 'middle',
						'Top'		=> 'top',
					),
					'std' 			=> 'middle',
					'dependency' 	=> array( 
						'element' 	=> 'slider_nav',
						'value' 	=> array( '1' ),
					),
					'group'       	=> esc_html__( 'Carousel Settings', 'kapee-extensions' ),
				), */
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
					"std"        	=> 4,
					'dependency' 	=> array(
						'element' 	=> 'layout',
						'value' 	=> array( 'slider' ),
					),
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
						"5" 	=> 5,
					),
					"std"           => 4,
					'dependency' 	=> array(
						'element' 	=> 'layout',
						'value' 	=> array( 'slider' ),
					),
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
						"4" 	=> 4,
					),
					"std"           => 3,
					'dependency' 	=> array(
						'element' 	=> 'layout',
						'value' 	=> array( 'slider' ),
					),
					'group'         => esc_html__( 'Carousel Settings', 'kapee-extensions' ),
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
					"std"           => 2,
					'dependency' 	=> array(
						'element' 	=> 'layout',
						'value' 	=> array( 'slider' ),
					),
					'group'         => esc_html__( 'Carousel Settings', 'kapee-extensions' ),
				),
				array(
					"type"          => "dropdown",
					"heading"       => esc_html__("Extra small devices (portrait phones, less than 576px)", 'kapee-extensions' ),
					"param_name"    => "rs_extra_small",
					"value" 		=> array(
						"1"  	=> 1,
						"2" 	=> 2,
					),
					"std"           => 2,
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
			'title' 					=> esc_html__( 'Hot Deals', 'kapee-extensions' ),
			'layout' 				=> 'slider',
			'product_deal_style' 	=> 'simple',
			'deal_title' 			=> 'Deal Ends In:',			
			'deal_end_date' 		=> '',			
			'hide_element' 			=> 0,
			'product_view_mode' 	=> 'vertical',
			'product_style' 			=> 'default',
			'action_buttons_style'		=> 'icon-with-text',
			'show_stock_progressbar' => 0,
			'show_countdown' 		=> 1,
			'highlighted_border' 	=> 0,
			'countdown_position'	=> 'on-product-image',
			'categories' 				=> '',
			'product_ids' 				=> '',
			'limit' 					=> '10',
			'orderby' 					=> 'date',
			'sortby' 					=> 'desc',
			'el_class' 					=> '',
			'columns' 					=> 4,	
			'rows' 						=> 1,	
			'slider_autoplay' 			=> 0,
			'slider_loop' 				=> 0,
			'slider_center' 			=> 0,
			'slider_nav' 				=> 1,
            'slider_nav_position' 		=> 'middle',
			'slider_dots' 				=> 0,
			'rs_extra_large' 			=> 4,
			'rs_large'					=> 4,
			'rs_medium' 				=> 3,
			'rs_small' 					=> 2,
			'rs_extra_small' 			=> 2,
			"css"            			=> '',
		), $atts ) );	 
		extract( $args );
		
		//Get Products
        global $woocommerce_loop, $wpdb;
		
		// Get products on sale
		$product_ids_raw = $wpdb->get_results(
		"SELECT posts.ID, posts.post_parent
		FROM `$wpdb->posts` posts
		INNER JOIN `$wpdb->postmeta` ON (posts.ID = `$wpdb->postmeta`.post_id)
		INNER JOIN `$wpdb->postmeta` AS mt1 ON (posts.ID = mt1.post_id)
		WHERE
			posts.post_status = 'publish'
			AND  (mt1.meta_key = '_sale_price_dates_to' AND mt1.meta_value >= ".time().") 
			GROUP BY posts.ID 
			ORDER BY posts.post_title");

		$product_ids_on_sale = array();

		foreach ( $product_ids_raw as $product_raw ) 
		{
			if(!empty($product_raw->post_parent))
			{
				$product_ids_on_sale[] = $product_raw->post_parent;
			}
			else
			{
				$product_ids_on_sale[] = $product_raw->ID;  
			}
		}
		$product_ids_on_sale = array_unique( $product_ids_on_sale );
		
		//Hot Deal products
		$query_args = array(
				'post_type'				=> 'product',
				'post_status'			=> 'publish',
				'ignore_sticky_posts'	=> 1,
				'posts_per_page' 		=> $limit,
				'orderby' 			    => $orderby,
				'order' 				=> $sortby,
				'post__in'			    => array_merge( array( 0 ), $product_ids_on_sale ),
			);
		$meta_query			= WC()->query->get_meta_query();
		$tax_query   		= WC()->query->get_tax_query();	
		//Get Categories
		if( ! empty( $product_ids ) ):
			$product_ids_array = explode(',', $product_ids);
			$product_ids_array = array_map( 'trim', $product_ids_array );
			$query_args['post__in'] = $product_ids_array;
		endif;
		
		if( ! empty( $categories ) ):
			$categories_array = explode(',', $categories);
			$categories_array = array_map( 'trim', $categories_array );
			if( is_array( $categories_array ) && !empty( $categories_array ) ){
				$tax_query[] = array(
					array(
						'taxonomy' => 'product_cat',
						'field'    => 'term_id',
						'terms'    => $categories_array
					)
				);
			}
		endif;
		
		$query_args['meta_query']	= $meta_query;
		$query_args['tax_query']	= $tax_query;
		//kapee_pre($query_args);
		$the_query = new WP_Query( $query_args );		
		$args['query'] 			= $the_query;
		
		$args['id']			= kapee_uniqid('kapee-hot-deal-');
		$class				= array( 'kapee-element', 'kapee-hot-deal-products', 'woocommerce', $el_class );	
		$class[]			= ( 'horizontal' == $product_view_mode ) ? 'kapee-product-'.$product_view_mode : '';
		$class[]	 		= ( $highlighted_border ) ? 'highlighted-border' : '';
		$class[]	 		= ( $slider_nav ) ? 'navigation-'.$slider_nav_position : '';	
		$css_class 			= vc_shortcode_custom_css_class( $css, ' ' );
		$class[]			= $css_class;
		if( $product_style != 'default' ){
			kapee_set_loop_prop( 'product-style', $product_style );
		}
		if( 'product-style-2' != $product_style && 'icon' == $action_buttons_style ){
			kapee_set_loop_prop('product-action-buttons-style', 'product-cart-icon' );
		}
		kapee_set_loop_prop('products_view', 'grid-view' );
		kapee_set_loop_prop('products-rating-histogram',0);
		
		if( 'grid' == $layout ){
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
			$unique_id 		= kapee_uniqid( 'section-' );
			$slider_data 	= shortcode_atts( kapee_slider_options(), $owl_data );
			global $kapee_owlparam;
			$kapee_owlparam['owlCarouselArg'][$unique_id] = $slider_data;
			kapee_set_loop_prop('name', 'kapee-carousel');	
			kapee_set_loop_prop( 'products-columns', $rs_extra_large );
			kapee_set_loop_prop('rs_extra_large',$rs_extra_large);
			kapee_set_loop_prop('rs_large',$rs_large);
			kapee_set_loop_prop('rs_medium',$rs_medium);
			kapee_set_loop_prop('rs_small',$rs_small);
			kapee_set_loop_prop('rs_extra_small',$rs_extra_small);
			kapee_set_loop_prop( 'unique_id', $unique_id );
			kapee_set_loop_prop( 'slider_data', $slider_data );
		}
		
		if( $show_countdown ){
			kapee_set_loop_prop( 'products-countdown', 1 );
			$class[]			= ( $countdown_position == 'after-product-price' ) ? 'after-product-price' : '';
		}
		
		if( $show_stock_progressbar ){
			kapee_set_loop_prop( 'products-stock-progressbar', 1 );
		}
		
		$args['class'] 				= implode( ' ', array_filter( $class ) );	
		$args['countdown_style'] 	= 'countdown-text';
		$args['timezone'] 			= kapee_timezone_string();
		$args['date'] 				= '';
		
		if( $hide_element && !empty( $deal_end_date ) && strtotime( $deal_end_date ) < time() ){
			return;
		}
		
		if( ! empty($deal_end_date ) && strtotime( $deal_end_date ) > time() ){
			$args['date'] 				= strtotime($deal_end_date);
		}
		
		$args['class'] = implode( ' ', array_filter( $class ) );	
		wp_enqueue_script( 'countdown' );
		ob_start();
			kapee_get_pl_templates('shortcodes/products-hot-deal/'.$product_deal_style, $args );
		return ob_get_clean();
	}	
}
new vcHotDealProducts(); 
?>