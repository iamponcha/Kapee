<?php
/**
 * Element: WC Vendors
 */
class vcWCVendors extends WPBakeryShortCode {

    function __construct() {
        $this->_mapping();
        add_shortcode( 'kapee_wc_vendors', array( $this, '_html' ) );
	}
	public function _mapping() {
		if ( !defined( 'WPB_VC_VERSION' ) ) { return; }
		
		vc_map( array(
			'name' 			=> esc_html__( 'WC Vendors', 'kapee-extensions' ),
			'base' 			=> 'kapee_wc_vendors',
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
					'admin_label'   => true,
				),
				array(
					'type' 			=> 'dropdown',
					'param_name' 	=> 'style',
					'heading' 		=> esc_html__( 'Style', 'kapee-extensions' ),
					'description' 	=> esc_html__( 'Select style.', 'kapee-extensions' ),
					'value' 		=> array(
						esc_html__( 'Default', 'kapee-extensions' ) 						=> 'default',
						esc_html__( 'Boxed', 'kapee-extensions' ) 							=> 'boxed',						
						esc_html__( 'Boxed Center with Products', 'kapee-extensions' ) 		=> 'boxed-center-products',
						esc_html__( 'Boxed Horizontal with Products', 'kapee-extensions' ) 	=> 'boxed-horizontal-products',
						esc_html__( 'Boxed Simple', 'kapee-extensions' ) 					=> 'boxed-simple',
					),
					'std'			=> 'default',
					'admin_label'   => true,
				),
				array(
					'type' 			=> 'checkbox',
					'heading' 		=> esc_html__( 'Show Recent Products', 'kapee-extensions' ),
					'param_name' 	=> 'recent_products',
					'value' 			=> array( esc_html__( 'Yes', 'kapee-extensions' ) => 1 ),
					'std' 				=> 1,
					'dependency' 	=> array(
						'element' 	=> 'style',
						'value' 	=> array( 'boxed-center-products', 'boxed-horizontal-products' ),
					),
				),
				array(
					'type' 			=> 'kapee_number',
					'heading' 		=> esc_html__( 'Number Of Vendor', 'kapee-extensions' ),
					'param_name' 	=> 'number',
					'std'			=> 3,
					
				),
				array(
					"type" 			=> "textfield",
					"heading" 		=> esc_html__( "Specific Vendor", 'kapee-extensions' ),
					"param_name" 	=> "specific_vendor",
					"admin_label"   => true,
					"description"   => esc_html__( "Enter vendor id, multiple vendor id with comma-separated.", 'kapee-extensions' ),					
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Order By', 'kapee-extensions' ),
					'param_name' 	=> 'orderby',
					'std' 			=> 'display_name',
					'value'			=> array(
						esc_html__('Store Name','kapee-extensions') 	=> 'display_name',
						esc_html__('ID','kapee-extensions') 	=> 'ID',
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
					),
					'std'        	=> 3,
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
					),
					'std'           => 3,
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
					),
					'std'           => 3,
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
					),
					'std'           => 2,
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
					'std'           => 2,
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
					),
					'std'        	=> 3,
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
					),
					'std'        	=> 3,
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
					'std'        	=> 3,
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
					'std'        	=> 2,
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
			'style' 					=> 'default',
			'recent_products' 			=> 1,
			'number' 					=> 3,
			'specific_vendor' 			=> '',
			'orderby' 					=> 'display_name',
			'sortby' 					=> 'ASC',			
			'el_class' 					=> '',
			'grid_extra_large' 			=> 3,
			'grid_large'				=> 3,
			'grid_medium' 				=> 3,
			'grid_small' 				=> 2,
			'grid_extra_small' 			=> 2,
			'rows' 						=> 1,	
			'slider_autoplay' 			=> 0,
			'slider_loop' 				=> 0,
			'slider_center' 			=> 0,
			'slider_nav' 				=> 1,
			'slider_dots' 				=> 0,
			'rs_extra_large' 			=> 3,
			'rs_large'					=> 3,
			'rs_medium' 				=> 3,
			'rs_small' 					=> 2,
			'rs_extra_small' 			=> 2,
			"css"            			=> "",  
		), $atts ) );	 
		extract( $args );
		$args['id']				= kapee_uniqid('kapee-wc-vendors-');
		$class					= array( 'kapee-element', 'kapee-wc-vendors', 'kapee-vendors-'.$style,  $el_class );
		$css_class 				= vc_shortcode_custom_css_class( $css, ' ' );
		$class[]				= $css_class;
		$args['class'] 			= implode(' ',array_filter($class));
		$args['slider_class'] 	= 'row';
		$args['column_class'] 	= ''; 
		if($layout == 'grid'){
			$columns_class 		= array();
			$columns_class[] 	= 'col-'.( 12 / $grid_extra_small  );
			$columns_class[] 	= 'col-sm-'.( 12 / $grid_small  );
			$columns_class[] 	= 'col-md-'.( 12 / $grid_medium  );
			
			$grid_large_val 	= ( 12 / $grid_large  );			
			$grid_large 		= ( is_float($grid_large_val)) ?  $grid_large * 10 : $grid_large_val;
			$columns_class[] 	= 'col-lg-'.$grid_large;
			
			
			$grid_extra_large_val 	= ( 12 / $grid_extra_large  );			
			$grid_extra_large 		= ( is_float($grid_extra_large_val)) ?  $grid_extra_large * 10 : $grid_extra_large_val;			
			$columns_class[] 		= 'col-xl-'.$grid_extra_large;
			$args['column_class'] 	= join( ' ', $columns_class );
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
			$kapee_owlparam['owlCarouselArg'][$args['id']] 	= $slider_data;
			$args['slider_class'] 	= 'kapee-carousel owl-carousel'; 
			$args['slider_class'] 	.= ' grid-col-xl-'.$rs_extra_large;
			$args['slider_class'] 	.= ' grid-col-lg-'.$rs_large;
			$args['slider_class'] 	.= ' grid-col-md-'.$rs_medium;
			$args['slider_class'] 	.= ' grid-col-sm-'.$rs_small;
			$args['slider_class'] 	.= ' grid-col-'.$rs_extra_small; 
		}
		
		
		$user_args = array();
		$user_args['number'] 	= $number;
		$user_args['role'] 		= 'vendor';
		$user_args['orderby'] 	= $orderby;
		$user_args['order'] 	= $sortby;
		$user_args['fields'] 	= 'ID';
		if(!empty($specific_vendor)){
			$specific_ids = explode( ',', $atts[ 'specific_vendor' ] );
			$specific_ids = array_map( 'trim', $specific_ids );
			$user_args['include'] 	= $specific_ids;
			$user_args['number'] 	= count($specific_ids);
			unset($user_args['orderby']);
			unset($user_args['order']);
		}
		
		$vendors = get_users( $user_args );
		
		if(!$vendors){
			return;
		}
		
		$args['vendors'] = $vendors;
		$args['vendors_count'] = count($vendors);
		
		ob_start();
			kapee_get_pl_templates( 'shortcodes/wc-vendors/'.$style, $args );			
		return ob_get_clean();
	}	
}
new vcWCVendors();