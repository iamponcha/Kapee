<?php
/**
 * Element: Product Categories
 */
class vcProductcategories extends WPBakeryShortCode {

    function __construct() {
        $this->_mapping();
        add_shortcode( 'kapee_product_categories', array( $this, '_html' ) );
	}
	public function _mapping() {
		if ( !defined( 'WPB_VC_VERSION' ) ) { return; }
		$image_sizes 		= kapee_get_all_image_sizes(true);
		array_shift($image_sizes);
		vc_map( array(
			'name' 		=> esc_html__( 'Product Categories', 'kapee-extensions' ),
			'base' 		=> 'kapee_product_categories',
			'category' 	=> esc_html__( 'Kapee', 'kapee-extensions' ),
        	'icon' 		=> KAPEE_URI.'/inc/admin/assets/images/vc-icon.png',
			'params' 	=> array(
				array(
					'type' 			=> 'textfield',
					'heading' 		=> __( 'Title', 'kapee-extensions' ),
					'param_name' 	=> 'title',
					'description'   => __( 'Enter title', 'kapee-extensions' ),
					'admin_label'   => true,
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
					'admin_label'   => true,
				),
				array(
					'type' 			=> 'dropdown',
					'param_name' 	=> 'style',
					'heading' 		=> esc_html__( 'Style', 'kapee-extensions' ),
					'description' 	=> esc_html__( 'Select style.', 'kapee-extensions' ),
					'value' 		=> array( 
						esc_html__( 'Default', 'kapee-extensions' ) 						=> 'categories-default',
						esc_html__( 'Categories with Banner Left', 'kapee-extensions' ) 	=> 'categories-banner-left',
						esc_html__( 'Categories with Banner Right', 'kapee-extensions' ) 	=> 'categories-banner-right',
						esc_html__( 'Categories and Sub Categories Box', 'kapee-extensions' ) 	=> 'categories-sub-categories-box',
						esc_html__( 'Categories and Sub Categories Vertical', 'kapee-extensions' ) 	=> 'categories-sub-categories-vertical',
					),
					'std' 			=> 'categories-default',
					'admin_label'   => true,
				),
				array(
					'type' 			=> 'dropdown',
					"heading"         => esc_html__("Category Box Style", 'kapee-extensions' ),
					"description"     => esc_html__("select category box style.", 'kapee-extensions' ),
					'param_name' 	=> 'category_box_style',
					'value' 		=> array( 
						esc_html__( 'Category Style-1', 'kapee-extensions' ) 						=> 'category-style-1',
						esc_html__( 'Category Style-2', 'kapee-extensions' ) 						=> 'category-style-2',
					),
					'std' 			=> 'category-style-1',
					'dependency' 	=> array(
						'element' 	=> 'style',
						'value' 	=> array( 'categories-default','categories-banner-left','categories-banner-right' ),
					),
				),
				array(
					'type'			=> 'dropdown',
					'heading'		=> esc_html__( 'Image Size', 'kapee-extensions' ),
					'param_name'	=> 'image_size',
					'std'			=> 'shop_catalog',
					'value'			=> array_flip($image_sizes),
				),
				array(
					'type' 			=> 'autocomplete',
					'heading' 		=> esc_html__( 'Specific Category', 'kapee-extensions' ),
					'param_name' 	=> 'categories',
					'settings' 		=> array(
						'multiple'	=> true,
					),
					'description' 	=> esc_html__( 'Select specific categories.', 'kapee-extensions' ),
					'admin_label'   => true,
				),
				array(
					'type' 			=> 'autocomplete',
					'heading' 		=> esc_html__( 'Parent Category', 'kapee-extensions' ),
					'param_name' 	=> 'parent_category',
					'description' 	=> esc_html__( 'Each category item will be a sub category of this category. This option is available when the specific Categories option is empty.', 'kapee-extensions' ),
					'admin_label'   => true,
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
					'type' 			=> 'textfield',
					'heading' 		=> esc_html__( 'Number of Categories', 'kapee-extensions' ),
					'param_name' 	=> 'number',
					'value' 		=> 12,
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Order By', 'kapee-extensions' ),
					'param_name' 	=> 'orderby',
					'std' 			=> 'name',
					'value'			=> array(
						esc_html__('Name','kapee-extensions') 		=> 'name',
						esc_html__('Slug','kapee-extensions') 		=> 'slug',
						esc_html__('ID','kapee-extensions') 		=> 'id',
						esc_html__('Sort Order','kapee-extensions')	=> 'menu_order',
					),
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Sort By', 'kapee-extensions' ),
					'param_name' 	=> 'sortby',
					'std' 			=> 'ASC',
					'value'			=> array( 
						esc_html__('Descending','kapee-extensions') 	=> 'DESC',
						esc_html__('Ascending','kapee-extensions') 		=> 'ASC',
					),
				),
				array(
					'type' 			=> 'attach_image',
					"heading"         => esc_html__("Banner Image", 'kapee-extensions' ),
					"description"     => esc_html__("Upload banner image.", 'kapee-extensions' ),
					'param_name' 	=> 'banner_image',
					'dependency' 	=> array(
						'element' 	=> 'style',
						'value' 	=> array( 'categories-banner-left','categories-banner-right' ),
					),
				),
				array(
					'type' 			=> 'checkbox',
					'heading' 		=> esc_html__( 'Child Of', 'kapee-extensions' ),
					'param_name' 	=> 'show_child_of',
					'value' 			=> array( esc_html__( 'Yes', 'kapee-extensions' ) => 1 ),
					'std' 				=> 0,
					'dependency' 	=> array(
						'element' 	=> 'style',
						'value_not_equal_to' 	=> array( 'categories-sub-categories-box','categories-sub-categories-vertical' ),
					),
				),
				array(
					'type' 			=> 'checkbox',
					'heading' 		=> esc_html__( 'Hide Empty Categories', 'kapee-extensions' ),
					'param_name' 	=> 'hide_empty_categories',
					'value' 		=> array( esc_html__( 'Yes', 'kapee-extensions' ) => 1 ),
					'std' 			=> 1,
				),
				array(
					'type' 			=> 'checkbox',
					'heading' 		=> esc_html__( 'Show Count', 'kapee-extensions' ),
					'param_name' 	=> 'show_count',
					'value' 		=> array( esc_html__( 'Yes', 'kapee-extensions' ) => 1 ),
					'std' 			=> 1,
					'dependency' 	=> array(
						'element' 	=> 'style',
						'value' 	=> array( 'categories-default','categories-banner-left','categories-banner-right' ),
					),
				),
				array(
					'type' 			=> 'checkbox',
					'heading' 		=> esc_html__( 'Show View All Button', 'kapee-extensions' ),
					'param_name' 	=> 'show_view_more_button',
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
					'heading' 		=> esc_html__( 'Extra class name', 'kapee-extensions' ),
					'param_name' 	=> 'el_class',
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
					'value' 		=> array( esc_html__( 'Yes', 'kapee-extensions' ) => 1 ),
					'std' 			=> 0,
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
					'value' 		=> array( esc_html__( 'Yes', 'kapee-extensions' ) => 1 ),
					'std' 			=> 1,
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
					'value' 		=> array( esc_html__( 'Yes', 'kapee-extensions' ) => 1 ),
					'std' 			=> 0,
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
					'std'           => 3,
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
			'style' 					=> 'categories-default',
			'category_box_style' 		=> 'category-style-1',			
			'image_size' 				=> 'shop_catalog',			
			'categories' 				=> '',			
			'parent_category' 			=> '',
			'exclude_categories' 		=> '',
			'number' 					=> 12,		
			'orderby' 					=> 'name',		
			'sortby' 					=> 'ASC',
			'banner_image'				=> '',
			'show_child_of' 			=> 0,			
			'hide_empty_categories' 	=> 1,			
			'show_count' 				=> '1',			
			'show_view_more_button' 	=> 1,
			'view_more_button_text'		=> 'View All',
			'view_more_button_link'		=> '',
			'el_class'            		=> '', 	
			'columns' 					=> 4,	
			'rows' 						=> 1,	
			'slider_autoplay' 			=> 0,
			'slider_loop' 				=> 0,
			'slider_center' 			=> 0,
			'slider_nav' 				=> 1,
			'slider_dots' 				=> 0,
			'rs_extra_large' 			=> 4,
			'rs_large'					=> 3,
			'rs_medium' 				=> 3,
			'rs_small' 					=> 2,
			'rs_extra_small' 			=> 2,			
			'css'            			=> '', 
		), $atts ) );
		extract( $args );
		$args['show_count'] 			= $show_count ? true : false;
		$args['show_view_more_button'] 	= $show_view_more_button ? true : false;
		$args['view_all_link'] 			= wc_get_page_permalink( 'shop' );
		$args['slider_class'] 			= 'row';
		$args['section_class'] 			= '';
		$args['id'] 			= kapee_uniqid( 'kapee-product-cat-' );
		$class = $column_class	= array();
		$class[]				= 'kapee-element';
		$class[]				= 'kapee-product-categories';
		$class[]				= $style;
		$class[]				= 'layout-'.$layout;
		$class[]				= $el_class;
		$css_class 				= vc_shortcode_custom_css_class( $css, ' ' );
		$class[]				= $css_class;		
		$args['class'] 			= implode(' ',array_filter( $class ) );
		$args['banner_layout'] 	= ''; 
		
		
		$template = $style;
		if($style == 'categories-banner-left' || $style == 'categories-banner-right'){
			$template = 'categories-with-banner';
			if($style == 'categories-banner-right'){
				$args['banner_layout'] 	= 'flex-row-reverse';
			}
			
		}
		$query_args = array(
			'taxonomy'  	=> 'product_cat',
			'number'    	=> $args['number'],
			'orderby'    	=> $args['orderby'],
			'order'      	=> $args['sortby'],
			'hide_empty' 	=> true,
		);
		$args['args']		= $query_args; // Query for inner sub categories
		if(!empty( $hide_empty_categories ) ){
			$query_args['hide_empty'] = true;
		}else{
			$query_args['hide_empty'] = false;
		}
		if( empty( $categories ) && empty( $parent_category ) ){
			$query_args['parent'] = 0;
		}
		$ids = array();
		if ( ! empty( $parent_category ) && empty( $categories ) ) {
			if( $style == 'categories-sub-categories-box' || $style == 'categories-sub-categories-vertical' ){				
				$query_args['parent'] = (int)$parent_category;
			} else {
				
				if($show_child_of){
					$query_args['child_of'] = (int)$parent_category;
				}else{
					$query_args['parent'] = (int)$parent_category;
				}				
			}
						
			$term = get_term_by( 'id',(int)$parent_category, 'product_cat' );
			if( ! empty( $term ) ):
				$args['view_all_link'] = get_term_link($term);;
			endif;
		}
		if ( ! empty( $args['categories'] ) ) {
			$ids = explode( ',', $atts[ 'categories' ] );
			$ids = array_map( 'trim', $ids );
			
			$query_args['include'] = $ids;
			$term = get_term_by( 'id',(int)$ids[0], 'product_cat' );
			if(!empty($term)):
				$args['view_all_link'] = get_term_link($term);
			endif;
		} 
		
		if ( ! empty( $args['exclude_categories'] ) ) {
			$ids = explode( ',', $atts[ 'exclude_categories' ] );
			$ids = array_map( 'trim', $ids );			
			$query_args['exclude'] = $ids;			
		} 
		
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
		}
		
		$product_categories 			= get_terms( $query_args );			
		$args['product_categories'] 	= $product_categories;	
		if( 'grid' == $layout ){
			$columns_val 			= 12/$columns;
			$columns 				= ( is_float( $columns_val ) ) ?  $columns * 10  : $columns_val;
			if( 'categories-sub-categories-box' == $style ){
				$column_class[] 	= 'col-4 col-sm-4 col-xl-'.$columns;
			}else{
				$column_class[] 	= 'col-6 col-sm-4 col-xl-'.$columns;
			}
			wc_set_loop_prop( 'columns', $columns );
		}else{
			$owl_data	= array(
				'slider_loop'				=> $slider_loop ? true : false,
				'slider_autoplay' 			=> $slider_autoplay ? true : false,
				'slider_center' 			=> $slider_center ? true : false,
				'slider_nav'				=> $slider_nav ? true : false,
				'slider_dots'				=> $slider_dots ? true : false,
				'slider_autoHeight'			=> false,
				'slider_margin'				=> ( 'categories-sub-categories-box' == $style || 'categories-sub-categories-vertical' == $style ) ? 30 : 0,
				'rs_extra_large' 			=> $rs_extra_large,
				'rs_large' 					=> $rs_large,
				'rs_medium' 				=> $rs_medium,
				'rs_small' 					=> $rs_small,
				'rs_extra_small' 			=> $rs_extra_small,
			);
			$slider_data 			= shortcode_atts(kapee_slider_options(),$owl_data);
			global $kapee_owlparam;
			$kapee_owlparam['owlCarouselArg'][$args['id']] = $slider_data;
			$args['slider_class'] 	= 'kapee-carousel owl-carousel'; 
			$args['slider_class'] 	.= ' grid-col-xl-'.$rs_extra_large;
			$args['slider_class'] 	.= ' grid-col-lg-'.$rs_large;
			$args['slider_class'] 	.= ' grid-col-md-'.$rs_medium;
			$args['slider_class'] 	.= ' grid-col-sm-'.$rs_small;
			$args['slider_class'] 	.= ' grid-col-'.$rs_extra_small;
			$args['section_class'] 		= ( 'categories-sub-categories-box' != $style && 'categories-sub-categories-vertical' != $style ) ? 'row' : '';
		}
		$args['column_class']	= implode( ' ', array_filter( $column_class ) );
		
		ob_start();
			kapee_get_pl_templates( 'shortcodes/product-categories/'.$template, $args );			
		return ob_get_clean();
	}	
}
new vcProductcategories();