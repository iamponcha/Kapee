<?php
/*
Element: Products And Categories Box
*/
class vcProductsAndCategoriesBox extends WPBakeryShortCode {

    function __construct() {
        $this->_mapping();
        add_shortcode( 'kapee_products_and_categories_box', array( $this, '_html' ) );
	}
	public function _mapping() {
		if ( !defined( 'WPB_VC_VERSION' ) ) { return; }
		
		vc_map( array(
			'name' 		=> esc_html__( 'Products And Categories Box', 'kapee-extensions' ),
			'base' 		=> 'kapee_products_and_categories_box',
			'category' 	=> esc_html__( 'Kapee', 'kapee-extensions' ),
        	'icon' 		=> KAPEE_URI.'/inc/admin/assets/images/vc-icon.png',
			'params' 	=> array(
				array(
					"type" 			=> "textfield",
					"heading" 		=> __( "Box Title", 'kapee-extensions' ),
					"param_name" 	=> "title",
					"description"   => __( "Enter title", 'kapee-extensions' ),
					"admin_label"   => true,
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Box Style', 'kapee-extensions' ),
					'param_name' 	=> 'layout',
					'value' 		=> array( 
						esc_html__( 'Banner With Products', 'kapee-extensions' ) 	=> 'banner-products',
						esc_html__( 'Banner With Categories', 'kapee-extensions' ) 	=> 'banner-categories',
						esc_html__( 'Only Products', 'kapee-extensions' ) 			=> 'only-products',
						esc_html__( 'Only Categories', 'kapee-extensions' ) 		=> 'only-categories',
					),
					'std'			=> 'banner-products',
					"admin_label"   => true,
					'description' 	=> esc_html__( 'Select box style.', 'kapee-extensions' ),
				),
				array(
					'type' 			=> 'checkbox',
					'heading' 		=> esc_html__( 'Hide Action Button', 'kapee-extensions' ),
					'param_name' 	=> 'hide_action_button',
					'value' 			=> array( esc_html__( 'Yes', 'kapee-extensions' ) => 1 ),
					'std' 				=> 1,
					'dependency' 	=> array(
						'element' 	=> 'layout',
						'value' 	=> array( 'banner-products','only-products' ),
					),
				),
				array(
					'type' 			=> 'dropdown',
					"heading"         => esc_html__("Category Box Style", 'kapee-extensions' ),
					"description"     => esc_html__("select category box style.", 'kapee-extensions' ),
					'param_name' 	=> 'category_box_style',
					'value' 		=> array( 
						esc_html__( 'Category Style-1', 'kapee-extensions' ) 	=> 'category-style-1',
						esc_html__( 'Category Style-2', 'kapee-extensions' ) 	=> 'category-style-2',
					),
					'std' 			=> 'category-style-1',
					'dependency' 	=> array(
						'element' 	=> 'layout',
						'value' 	=> array( 'banner-categories','only-categories' ),
					),
				),
				array(
					'type' 			=> 'checkbox',
					'heading' 		=> esc_html__( 'Show Count', 'kapee-extensions' ),
					'param_name' 	=> 'show_count',
					'value' 		=> array( esc_html__( 'Yes', 'kapee-extensions' ) => 1 ),
					'std' 			=> 1,
					'dependency' 	=> array(
						'element' 	=> 'layout',
						'value' 	=> array( 'banner-categories','only-categories' ),
					),
				),
				array(
					'type' 				=> 'autocomplete',
					'heading' 			=> esc_html__( 'Specific Categories', 'kapee-extensions' ),
					'param_name' 		=> 'categories',
					'settings' 		=> array(
						'multiple'	=> true,
					),
					"description" 		=> __( "Select specific categories.", 'kapee-extensions' ),
				),
				array(
					'type' 				=> 'autocomplete',
					'heading' 			=> esc_html__( 'Parent Category', 'kapee-extensions' ),
					'param_name' 		=> 'parent_category',
					"description" 		=> __( "Each tab will be a sub category of this category. This option is available when the specific Categories option is empty.", 'kapee-extensions' ),
				),
				array(
					'type' 			=> 'autocomplete',
					'heading' 		=> esc_html__( 'Exclude Category', 'kapee-extensions' ),
					'param_name' 	=> 'exclude_categories',
					'settings' 		=> array(
						'multiple'	=> true,
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
					),
					'description' 	=> esc_html__( 'Select data source', 'kapee-extensions' ),
				),
				array(
					"type" 			=> "textfield",
					"heading" 		=> __( "Number of Products", 'kapee-extensions' ),
					"param_name" 	=> "limit",
					"value" 		=> 8,
				),
				array(
					'type' 				=> 'autocomplete',
					'heading' 			=> esc_html__( 'Execlude Products', 'kapee-extensions' ),
					'param_name' 		=> 'exclude',
					'settings' 		=> array(
						'multiple'	=> true,
					),
					'dependency' 	=> array(
						'element' => 'layout',
						'value'   => array('banner-products','only-products'),
					),
					"description" 		=> __( "Select specific product to exclude.", 'kapee-extensions' ),
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
					"type" 			=> "dropdown",
					"heading" 		=> esc_html__( "Banner Style", 'kapee-extensions' ),
					"param_name" 	=> "banner_style",
					"std"			=> "banner_single_image",
					"value" 		=> array(
						esc_html__( "Banner Single Image", 'kapee-extensions' ) 				=> "banner_single_image",
						esc_html__( "Banner Mutliple Images With Slider", 'kapee-extensions' )	=> "banner_with_slider",
					),
					'dependency' 	=> array(
						'element' => 'layout',
						'value'   => array('banner-products','banner-categories'),
					),
					"description" 	=> esc_html__( "Select banner style. Only single image banner or multiple images banner with slider", 'kapee-extensions')
				),
				array(
					"type"        	=> "attach_image",
					"heading"     	=> esc_html__( "Banner Single Image", 'kapee-extensions' ),
					"param_name"  	=> "banner_image",
					'dependency' 	=> array(
						'element' => 'banner_style',
						'value'   => array('banner_single_image'),
					),
					"description" 	=> esc_html__( "Single image banner", 'kapee-extensions' )
				),
				array(
					"type"        	=> "attach_images",
					"heading"     	=> esc_html__( "Banner Mutliple Images", 'kapee-extensions' ),
					"param_name"  	=> "banner_images",
					'dependency' 	=> array(
						'element' => 'banner_style',
						'value'   => array('banner_with_slider'),
					),
					"description" 	=> esc_html__( "Multiple images banner with slider", 'kapee-extensions' )
				),
				array(
					"type"        	=> "colorpicker",
					"heading"     	=> esc_html__("Box Color", 'kapee-extensions'),
					"param_name"  	=> "box_color",
					"value"       	=> "#2370F4",
					"description" 	=> esc_html__( "Set unique color of this box", 'kapee-extensions' ),
				),
				array(
					'type' 			=> 'textfield',
					'heading' 		=> esc_html__( 'Extra class name', 'kapee-extensions' ),
					'param_name' 	=> 'el_class',
					'description' 	=> esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'kapee-extensions' )
				),
				//Carousel Settings
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
					"type"       	=> "dropdown",
					"heading"    	=> esc_html__("Extra large devices (large desktops, 1200px and up)", 'kapee-extensions' ),
					"param_name" 	=> "rs_extra_large",
					"value" 		=> array(
						"1"  	=> 1,
						"2" 	=> 2,
						"3" 	=> 3,
						"4" 	=> 4,
						"5" 	=> 5,
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
						"4" 	=> 4,
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
			'title' 					=> '',
			'layout' 					=> 'banner-products',
			'hide_action_button' 		=> 1,	
			'category_box_style' 		=> 'category-style-1',	
			'product_style' 			=> 'product-style-2',
			'show_count' 				=> 1,			
			'categories' 				=> '',					
			'parent_category' 			=> '',
			'exclude_categories' 		=> '',
			'data_source' 				=> 'recent_products',
			'limit' 					=> 8,		
			'exclude' 					=> '',		
			'orderby' 					=> 'date',		
			'sortby' 					=> 'desc',
			'banner_style' 				=> 'banner_single_image',
			'banner_image' 				=> '',
			'banner_images' 				=> '',
			'box_color' 				=> '#2370F4',
			'el_class' 					=> '',
			'slider_autoplay' 			=> 0,
			'slider_loop' 				=> 0,
			'slider_center' 			=> 0,
			'slider_nav' 				=> 1,
			'rs_extra_large' 			=> 3,
			'rs_large'					=> 4,
			'rs_medium' 				=> 3,
			'rs_small' 					=> 2,
			'rs_extra_small' 			=> 2,	
			"css"            			=> "", 		
		), $atts ) );	 
		extract( $args );
		global $kapee_owlparam;
		$args['id'] 			= kapee_uniqid('product-with-categories-box-');
		$class					= array();
		$class[]				= 'kapee-element';
		$class[]				= 'products-and-categories-box';
		$class[]				= 'woocommerce';
		$class[]				= $hide_action_button ? 'kp-hide-action-btn' : '' ;
		$class[]				= $layout;
		$class[]				= $el_class;
		$css_class 				= vc_shortcode_custom_css_class( $css, ' ' );
		$class[]				= $css_class;
		$args['cat_title_link']	= '';
		
		$cat_query_args = array(
			'taxonomy'		=> 'product_cat',
			'number'		=> $args['limit'],
			'orderby'		=> $orderby,
			'order'			=> $sortby,
			'hide_empty'	=> 1,
		);
		
		if( empty( $categories ) && empty( $parent_category ) ){
			$cat_query_args['parent'] = 0;
		}
		$ids = array();
		
		if ( ! empty( $args['categories'] ) ) {
			$ids 						= explode( ',', $atts[ 'categories' ] );
			$ids 						= array_map( 'trim', $ids );			
			$cat_query_args['include'] 	= $ids;
			$term 						= get_term_by( 'id',(int)$ids[0], 'product_cat' );
			
			if( ! empty( $term ) ):
				$args['cat_title_link'] = get_term_link($term);;
			endif;
		} 
		if ( ! empty( $args['exclude_categories'] ) ) {
			$ids = explode( ',', $atts[ 'exclude_categories' ] );
			$ids = array_map( 'trim', $ids );			
			$cat_query_args['exclude'] = $ids;			
		} 
		if ( ! empty( $parent_category ) && empty( $categories ) ) {
			$cat_query_args['parent'] 	= (int)$parent_category;	
			$args['categories']			= (int)$parent_category;
			$term 						= get_term_by( 'id',(int)$parent_category, 'product_cat' );
			
			if( ! empty( $term ) ):
				$args['cat_title_link'] = get_term_link($term);;
			endif;
		}
		$product_categories 	= get_terms( $cat_query_args );	
				
		$banner_unique_id 		= kapee_uniqid('section-banner-');
		if( $banner_style == "banner_with_slider" ){
			
			$owl_data			= array(
				'slider_loop'				=> true,
				'slider_autoplay' 			=> true,
				'slider_center' 			=> false,
				'slider_nav'				=> false,
				'slider_dots'				=> true,
				'slider_autoHeight'			=> false,
				'rs_extra_large' 			=> 1,
				'rs_large' 					=> 1,
				'rs_medium' 				=> 1,
				'rs_small' 					=> 1,
				'rs_extra_small' 			=> 1,
			);
			
			$slider_data 	= shortcode_atts( kapee_slider_options() ,$owl_data);			
			$kapee_owlparam['owlCarouselArg'][$banner_unique_id] = $slider_data;			
		}
		
		$query_args 			= kapee_get_products( $data_source, $args );		
		$the_query 				= new WP_Query( $query_args );		
		$args['query'] 			= $the_query;		
		
		kapee_set_loop_prop('product-style',$product_style);				
		kapee_set_loop_prop('name','kapee-carousel');
		kapee_set_loop_prop('products_view','grid-view');
		kapee_set_loop_prop('products-rating-histogram',0);
		kapee_set_loop_prop( 'products-countdown', 0 );
		kapee_set_loop_prop('sale-product-label-after-price','on-product-image');
		$owl_data				= array(
			'slider_loop'			=> $slider_loop ? true : false,
			'slider_autoplay' 		=> $slider_autoplay ? true : false,
			'slider_center' 		=> $slider_center ? true : false,
			'slider_nav'			=> $slider_nav ? true : false,
			'slider_dots'			=> false,
			'slider_autoHeight'		=> false,
			'rs_extra_large' 		=> $rs_extra_large,
			'rs_large' 				=> $rs_large,
			'rs_medium' 			=> $rs_medium,
			'rs_small' 				=> $rs_small,
			'rs_extra_small' 		=> $rs_extra_small,
		);
		$unique_id 			= kapee_uniqid('section');
		$slider_data 		= shortcode_atts( kapee_slider_options() ,$owl_data);			
		$kapee_owlparam['owlCarouselArg'][$unique_id] = $slider_data;
		
		kapee_set_loop_prop('unique_id',$unique_id);
		kapee_set_loop_prop('products-columns',$rs_extra_large);
		kapee_set_loop_prop('rs_extra_large',$rs_extra_large);
		kapee_set_loop_prop('rs_large',$rs_large);
		kapee_set_loop_prop('rs_medium',$rs_medium);
		kapee_set_loop_prop('rs_small',$rs_small);
		kapee_set_loop_prop('rs_extra_small',$rs_extra_small);
		$cat_section_unique_id 											= kapee_uniqid('section-cat-');
		$kapee_owlparam['owlCarouselArg'][$cat_section_unique_id] 		= $slider_data;		
		$args['class'] 													= implode(' ',array_filter($class));
		$args['product_categories'] 									= $product_categories;
		$args['banner_id'] 												= $banner_unique_id;
		$args['cat_section_id'] 										= $cat_section_unique_id;
		$args['rows'] 													= 2;
		$args['slider_class'] 	= 'kapee-carousel owl-carousel'; 
		$args['slider_class'] 	.= ' grid-col-xl-'.$rs_extra_large;
		$args['slider_class'] 	.= ' grid-col-lg-'.$rs_large;
		$args['slider_class'] 	.= ' grid-col-md-'.$rs_medium;
		$args['slider_class'] 	.= ' grid-col-sm-'.$rs_small;
		$args['slider_class'] 	.= ' grid-col-'.$rs_extra_small;
		$style_css 					= '';
		if( ! empty ( $box_color ) ) {
			$style_css = '
				#'.$args['id'].' .section-inner{
					border-top: 2px solid '.$box_color.';
				}
				#'.$args['id'].' .section-title h3,
				#'.$args['id'].' .sub-categories a:hover{
					color : '.$box_color.';
				}
			';
		}
		kapee_add_custom_css($style_css);
		
		ob_start();
			if( empty( $product_categories ) ){
				esc_html_e('No categories were found matching your selection','kapee-extensions');
			} else{
				kapee_get_pl_templates('shortcodes/products-and-categories-box/'.$layout,$args );
			}
		return ob_get_clean();
	}	
}
new vcProductsAndCategoriesBox();