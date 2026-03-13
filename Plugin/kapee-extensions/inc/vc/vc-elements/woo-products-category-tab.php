<?php
/*
Element: Products Tabs
*/
class vcProductsCategoryTabs extends WPBakeryShortCode {

    function __construct() {
        $this->_mapping();
        add_shortcode( 'kapee_products_category_tab', array( $this, '_html' ) );
	}
	public function _mapping() {
		if ( !defined( 'WPB_VC_VERSION' ) ) { return; }
		
		vc_map( array(
			'name' 			=> esc_html__( 'Products Category Tab', 'kapee-extensions' ),
			'base' 			=> 'kapee_products_category_tab',
			'category' 		=> esc_html__( 'Kapee', 'kapee-extensions' ),
        	'icon' 			=> KAPEE_URI.'/inc/admin/assets/images/vc-icon.png',
			'params' 		=> array(
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
					'admin_label' 	=> true,
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
					'param_name'  	=> 'tab_style',
					'admin_label' 	=> true,
					'heading'     	=> esc_html__( 'Tabs Style', 'kapee-extensions' ),
					'value'       	=> array(
						esc_html__( 'Line', 'kapee-extensions' )  	=> 'tabs-line',
						esc_html__( 'Normal', 'kapee-extensions' )	=> 'tabs-normal',
					),
					'std' 			=> 'tabs-line',
					'description' 	=> esc_html__( 'Select product hover style.', 'kapee-extensions' ),
				),
				array(
					'type'        	=> 'dropdown',
					'param_name'  	=> 'tab_align',
					'admin_label' 	=> true,
					'heading'     	=> esc_html__( 'Tabs Align', 'kapee-extensions' ),
					'value'       	=> array(
						esc_html__( 'Left', 'kapee-extensions' )  	=> 'tabs-left',
						esc_html__( 'Center', 'kapee-extensions' )  => 'tabs-center',
						esc_html__( 'Right', 'kapee-extensions' )	=> 'tabs-right',
					),
					'std' 			=> 'tabs-center',
					'description' 	=> esc_html__( 'Select product hover style.', 'kapee-extensions' ),
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
					'heading' 		=> esc_html__( 'Number Of Product', 'kapee-extensions' ),
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
						esc_html__('Descending','kapee-extensions') => 'desc',
						esc_html__('Ascending','kapee-extensions') => 'asc',
					),
				),
				array(
					'type' 			=> 'textfield',
					'heading' 		=> esc_html__( 'Extra class name', 'kapee-extensions' ),
					'param_name' 	=> 'el_class',
					'description' 	=> esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'kapee-extensions' )
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
					'group'			=> esc_html__( 'Carousel Settings', 'kapee-extensions' ),
				),
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
						"5" 	=> 5,
						"6" 	=> 6,
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
						"5" 	=> 5,
					),
					"std"           => 4,
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
			'product_view_mode' 		=> 'vertical',
			'product_style' 			=> 'default',
			'action_buttons_style'		=> 'icon-with-text',
			'tab_style' 				=> 'tabs-line',
			'tab_align' 				=> 'tabs-center',
			'categories' 				=> '',
			'exclude' 					=> '',
			'limit' 					=> '10',
			'orderby' 					=> 'date',
			'sortby' 					=> 'desc',
			'el_class'					=> '',
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
			"css"            			=> "", 
		), $atts ) );	 
		extract( $args );
		
		$args['id'] 			= kapee_uniqid('kapee-products-tabs-');
		$class					= array('kapee-element', 'products-tabs', 'products-category-tabs', 'tabs-layout', $tab_style, $tab_align );
		$class[]				= ( 'horizontal' == $product_view_mode ) ? 'kapee-product-'.$product_view_mode : '';
		$class[]				= $el_class;
		$css_class 				= vc_shortcode_custom_css_class( $css, ' ' );
		$class[]				= $css_class;
		$args['class']			= implode( ' ', $class );
		
		//kapee_pre($args);
		
		if( $product_style != 'default' ){
			kapee_set_loop_prop( 'product-style', $product_style );
		}
		if( 'product-style-2' != $product_style && 'icon' == $action_buttons_style ){
			kapee_set_loop_prop('product-action-buttons-style', 'product-cart-icon' );
		}
		kapee_set_loop_prop('products-rating-histogram',0);
		$owl_data	= array(
			'slider_loop'			=> $slider_loop ? true : false,
			'slider_autoplay' 		=> $slider_autoplay ? true : false,
			'slider_center' 		=> $slider_center ? true : false,
			'slider_nav'			=> $slider_nav ? true : false,
			'slider_dots'			=> $slider_dots ? true : false,
			'slider_autoHeight'		=>  false,
			'rs_extra_large' 		=> $rs_extra_large,
			'rs_large' 				=> $rs_large,
			'rs_medium' 			=> $rs_medium,
			'rs_small' 				=> $rs_small,
			'rs_extra_small' 		=> $rs_extra_small,
		);	
		kapee_set_loop_prop('rs_extra_large',$rs_extra_large);
		kapee_set_loop_prop('rs_large',$rs_large);
		kapee_set_loop_prop('rs_medium',$rs_medium);
		kapee_set_loop_prop('rs_small',$rs_small);
		kapee_set_loop_prop('rs_extra_small',$rs_extra_small);
		$slider_data 	= shortcode_atts( kapee_slider_options(), $owl_data );		
		$args['slider_data'] = $slider_data;
		$data_args = array( 
						'post_type' 			=> 'product',
						'status'     			=> 'published',
						'ignore_sticky_posts' 	=> 1,
						'orderby'             	=> isset($args['orderby']) ? $args['orderby'] : 'date',
						'order'               	=> isset($args['sortby']) ? $args['sortby'] : 'desc',
						'posts_per_page'      	=> isset( $args['limit'] ) > 0 ? intval( $args['limit'] ) : 10,
						'paged'      			=> isset($args['paged']) > 0 ? intval( $args['paged'] ) : 1,
					);
		$data_args['meta_query'] 	= WC()->query->get_meta_query();
		$data_args['tax_query']   	= WC()->query->get_tax_query();
		$data_args['exclude']   	= $args['exclude'];
		$tabs = array();
		//$categories
		$categories = isset($categories) ? trim($categories) : '';
		if( !empty($categories) ){
			$categories_array = explode(',', $categories);
			$categories_array = array_map( 'trim', $categories_array );
			if( is_array($categories_array) && !empty($categories_array) ){
				foreach($categories_array as $catId){					
					$data_args['categories']   	= $catId;
					$query 		= kapee_get_products('category_element', $data_args );
					$the_query 	= new WP_Query( $query );			
					$tabs[]		= array( 
									'id'			=> 'kapee-product-tab-' . kapee_uniqid('tab-'),
									'title' 		=> kapee_get_product_category_name_by_id( $catId ), 
									'data_source' 	=> $catId, 
									'query' 		=> $the_query 
								);
				}
			}
		}
		$args['tabs'] 	= $tabs;
		ob_start();
			kapee_get_pl_templates( 'shortcodes/products-categories-tabs', $args );			
		return ob_get_clean();
	}	
}
new vcProductsCategoryTabs(); 
?>