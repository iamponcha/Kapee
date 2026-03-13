<?php
/*
Element: Product Brands
*/
class vcProductBrands extends WPBakeryShortCode {

    function __construct() {
        $this->_mapping();
        add_shortcode( 'kapee_product_brands', array( $this, '_html' ) );
	}
	public function _mapping() {
		if ( !defined( 'WPB_VC_VERSION' ) ) { return; }
		
		vc_map( array(
			'name' 		=> esc_html__( 'Product Brands', 'kapee-extensions' ),
			'base' 		=> 'kapee_product_brands',
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
						esc_html__( 'Square', 'kapee-extensions' ) 	=> 'brand-square',
						esc_html__( 'Circle', 'kapee-extensions' ) 	=> 'brand-circle',						
					),
					'std'			=> 'brand-square',
					'admin_label'   => true,
				),				
				array(
					'type' 			=> 'autocomplete',
					'heading' 		=> esc_html__( 'Specific Brands', 'kapee-extensions' ),
					'param_name' 	=> 'brands',
					'settings' 		=> array(
						'multiple'	=> true,
					),
					'description' 	=> esc_html__( 'Select specific brands.', 'kapee-extensions' ),
					'admin_label'   => true,
				),
				array(
					'type' 			=> 'textfield',
					'heading' 		=> esc_html__( 'Number of Brands', 'kapee-extensions' ),
					'param_name' 	=> 'number',
					'value' 		=> 12,
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Order By', 'kapee-extensions' ),
					'param_name' 	=> 'orderby',
					'std' 			=> 'name',
					'value'			=> array(
						esc_html__('Name','kapee-extensions') 	=> 'name',
						esc_html__('Slug','kapee-extensions') 	=> 'slug',
						esc_html__('ID','kapee-extensions') 	=> 'id',
					),
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
					'type' 			=> 'checkbox',
					'heading' 		=> esc_html__( 'Show Title', 'kapee-extensions' ),
					'param_name' 	=> 'show_title',
					'value' 			=> array( esc_html__( 'Yes', 'kapee-extensions' ) => 1 ),
					'std' 				=> 0,
				),
				array(
					'type' 			=> 'checkbox',
					'heading' 		=> esc_html__( 'Enable Hover Effect', 'kapee-extensions' ),
					'param_name' 	=> 'hover_effect',
					'value' 			=> array( esc_html__( 'Yes', 'kapee-extensions' ) => 1 ),
					'std' 				=> false,
				),
				array(
					'type' 			=> 'textfield',
					'heading' 		=> esc_html__( 'Extra class name', 'kapee-extensions' ),
					'param_name' 	=> 'el_class',
					'description' 	=> esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'kapee-extensions' )
				),
				//Grid Settings
				array(
					'type'       	=> 'dropdown',
					'heading'    	=> esc_html__('Extra large devices (large desktops, 1200px and up)', 'kapee-extensions' ),
					'param_name' 	=> 'grid_extra_large',
					'value' 		=> array(
						'1'  	=> 1,
						'2' 	=> 2,
						'3' 	=> 3,
						'4' 	=> 4,
						'5' 	=> 5,
						'6' 	=> 6,
						'7' 	=> 7,
						'8' 	=> 8,
						'9' 	=> 9,
						'10' 	=> 10,
					),
					'std'        	=> 10,
					'dependency' 	=> array(
						'element' 	=> 'layout',
						'value' 	=> array( 'grid' ),
					),
					'group' 		=> esc_html__( 'Grid Settings', 'kapee-extensions' ),
				),
				array(
					'type'          => 'dropdown',
					'heading'       => esc_html__('Large devices (desktops, 992px and up)', 'kapee-extensions' ),
					'param_name'    => 'grid_large',
					'value' 		=> array(
						'1'  	=> 1,
						'2' 	=> 2,
						'3' 	=> 3,
						'4' 	=> 4,
						'5' 	=> 5,
						'6' 	=> 6,
						'7' 	=> 7,
						'8' 	=> 8,
					),
					'std'           => 8,
					'dependency' 	=> array(
						'element' 	=> 'layout',
						'value' 	=> array( 'grid' ),
					),
					'group' 		=> esc_html__( 'Grid Settings', 'kapee-extensions' ),
				),
				array(
					'type'          => 'dropdown',
					'heading'       => esc_html__('Medium devices (tablets, 768px and up)', 'kapee-extensions' ),
					'param_name'    => 'grid_medium',
					'value' 		=> array(
						'1'  	=> 1,
						'2' 	=> 2,
						'3' 	=> 3,
						'4' 	=> 4,
						'6' 	=> 6,
					),
					'std'           => 6,
					'dependency' 	=> array(
						'element' 	=> 'layout',
						'value' 	=> array( 'grid' ),
					),
					'group' 		=> esc_html__( 'Grid Settings', 'kapee-extensions' ),
				),
				array(
					'type'          => 'dropdown',
					'heading'       => esc_html__('Small devices (landscape phones, 576px and up)', 'kapee-extensions' ),
					'param_name'    => 'grid_small',
					'value' 		=> array(
						'1'  	=> 1,
						'2' 	=> 2,
						'3' 	=> 3,
						'4' 	=> 4,
						'6' 	=> 6,
					),
					'std'           => 4,
					'dependency' 	=> array(
						'element' 	=> 'layout',
						'value' 	=> array( 'grid' ),
					),
					'group' 		=> esc_html__( 'Grid Settings', 'kapee-extensions' ),
				),
				array(
					'type'          => 'dropdown',
					'heading'       => esc_html__('Extra small devices (portrait phones, less than 576px)', 'kapee-extensions' ),
					'param_name'    => 'grid_extra_small',
					'value' 		=> array(
						'1'  	=> 1,
						'2' 	=> 2,
						'3' 	=> 3,
						'4' 	=> 4,
					),
					'std'           => 3,
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
						'4' 	=> 4,
						'5' 	=> 5,
						'6' 	=> 6,
						'7' 	=> 7,
						'8' 	=> 8,
						'9' 	=> 9,
						'10' 	=> 10,
					),
					'std'        	=> 10,
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
						'3' 	=> 3,
						'4' 	=> 4,
						'5' 	=> 5,
						'6' 	=> 6,
						'7' 	=> 7,
						'8' 	=> 8,
					),
					'std'           => 8,
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
						'6' 	=> 6,
					),
					'std'           => 6,
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
						'4' 	=> 4,
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
					'heading'       => esc_html__('Extra small devices (portrait phones, less than 576px)', 'kapee-extensions' ),
					'param_name'    => 'rs_extra_small',
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
			'style' 					=> 'brand-square',
			'brands' 					=> '',			
			'number' 					=> 12,		
			'orderby' 					=> 'name',		
			'sortby' 					=> 'asc',
			'show_child_of' 			=> 0,
			'show_title'				=> 0,
			'hover_effect'				=> 0,
			'el_class'            		=> '', 
			'grid_extra_large' 			=> 10,
			'grid_large'				=> 8,
			'grid_medium' 				=> 6,
			'grid_small' 				=> 4,
			'grid_extra_small' 			=> 3,
			'rows' 						=> 1,	
			'slider_autoplay' 			=> 0,
			'slider_loop' 				=> 0,
			'slider_center' 			=> 0,
			'slider_nav' 				=> 1,
			'slider_dots' 				=> 0,
			'rs_extra_large' 			=> 10,
			'rs_large'					=> 8,
			'rs_medium' 				=> 6,
			'rs_small' 					=> 4,
			'rs_extra_small' 			=> 3,			
			'css'            			=> '', 
		), $atts ) );
		extract( $args );
		
		$args['slider_class'] 	= 'row';
		$args['id'] 			= kapee_uniqid('kapee-brands-cat-');
		$class					= array('kapee-element', 'kapee-product-brands', $style, $el_class);
		$class[]				= $hover_effect ? 'brand-hover-effect' : '';
		$css_class 				= vc_shortcode_custom_css_class( $css, ' ' );
		$class[]				= $css_class;		
				
		$args['class'] 			= implode(' ',array_filter( $class ) );
		$args['column_class'] 	= ''; 
		
		$query_args = array(
			'taxonomy'  	=> 'product_brand',
			'number'    	=> $args['number'],
			'orderby'    	=> $args['orderby'],
			'order'      	=> $args['sortby'],
			'hide_empty' 	=> false,
		);
		$args['args']		= $query_args; // Query
		
		
		$ids = array();
		if ( !empty( $args['brands'] ) ) {
			$ids = explode( ',', $atts[ 'brands' ] );
			$ids = array_map( 'trim', $ids );			
			$query_args['include'] = $ids;			
		} 
		
		$product_brands = get_terms( $query_args );	
		
		$args['product_brands'] 			= $product_brands;	
		if($layout == 'grid'){
			$columns_class = array();
			$columns_class[] = 'col-'.( 12 / $grid_extra_small  );
			$columns_class[] = 'col-sm-'.( 12 / $grid_small  );
			$columns_class[] = 'col-md-'.( 12 / $grid_medium  );
			
			$grid_large_val = ( 12 / $grid_large  );			
			$grid_large = ( is_float($grid_large_val)) ?  $grid_large * 10 : $grid_large_val;
			$columns_class[] = 'col-lg-'.$grid_large;
			
			
			$grid_extra_large_val = ( 12 / $grid_extra_large  );			
			$grid_extra_large = ( is_float($grid_extra_large_val)) ?  $grid_extra_large * 10 : $grid_extra_large_val;			
			$columns_class[] = 'col-xl-'.$grid_extra_large;
			
			$args['column_class'] = join( ' ', $columns_class );
			wc_set_loop_prop('columns',$grid_extra_small);
		}else{
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
			$slider_data 			= shortcode_atts(kapee_slider_options(),$owl_data);
			global $kapee_owlparam;
			$kapee_owlparam['owlCarouselArg'][$args['id']] = $slider_data;
			$args['slider_class'] 	= 'kapee-carousel owl-carousel'; 
			$args['slider_class'] 	.= ' grid-col-xl-'.$rs_extra_large;
			$args['slider_class'] 	.= ' grid-col-lg-'.$rs_large;
			$args['slider_class'] 	.= ' grid-col-md-'.$rs_medium;
			$args['slider_class'] 	.= ' grid-col-sm-'.$rs_small;
			$args['slider_class'] 	.= ' grid-col-'.$rs_extra_small; 
		}
		ob_start();
			kapee_get_pl_templates( 'shortcodes/product-brands', $args );			
		return ob_get_clean();
	}	
}
new vcProductBrands(); 
?>