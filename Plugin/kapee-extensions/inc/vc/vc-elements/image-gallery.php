<?php
/**
 * Element: Image Gallery
 */
class vcImageGallery extends WPBakeryShortCode {

    function __construct() {
        $this->_mapping();
        add_shortcode( 'kapee_image_gallery', array( $this, '_html' ) );
	}
	public function _mapping() {
		if ( !defined( 'WPB_VC_VERSION' ) ) { return; }
		$image_sizes 		= kapee_get_all_image_sizes(true);
		array_shift($image_sizes);
		vc_map( array(
			'name' 		=> esc_html__( 'Image Gallery', 'kapee-extensions' ),
			'base' 		=> 'kapee_image_gallery',
			'category' 	=> esc_html__( 'Kapee', 'kapee-extensions' ),
        	'icon' 			=> KAPEE_URI.'/inc/admin/assets/images/vc-icon.png',
			'params' 	=> array(
				array(
					"type"        	=> "attach_images",
					"param_name"  	=> "gallery_images",
					"heading"     	=> esc_html__( "Gallery Images", 'kapee-extensions' ),
					"description" 	=> esc_html__( "Select gallery images.", 'kapee-extensions' ),
				),
				array(
					'type'			=> 'dropdown',
					'heading'		=> esc_html__( 'Image Size', 'kapee-extensions' ),
					'param_name'	=> 'image_size',
					'std'			=> 'medium',
					'value'			=> array_flip($image_sizes),
				),
				array(
					'type' 			=> 'dropdown',
					'param_name' 	=> 'gallery_view',
					'heading' 		=> esc_html__( 'Gallery View', 'kapee-extensions' ),
					'value'			=> array( 
						esc_html__('Normal Grid','kapee-extensions') 	=> 'normal-grid',
						esc_html__('Masonry Grid','kapee-extensions') 	=> 'masonry-grid',
						esc_html__('Carousel','kapee-extensions') 		=> 'carousel',
					),
					'std' 			=> 'normal-grid',
					'admin_label'   => true,
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Gallery Gapping/Spacing ', 'kapee-extensions' ),
					'param_name' 	=> 'image_gallery_gap',
					'std' 			=> 15,
					'value'			=> array( 
						esc_html__('0','kapee-extensions') 	=> 0,
						esc_html__('5','kapee-extensions') 	=> 5,
						esc_html__('10','kapee-extensions') => 10,
						esc_html__('15','kapee-extensions') => 15,
					),
				),
				( function_exists( 'vc_map_add_css_animation' ) ) ? vc_map_add_css_animation( true ) : '',
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
						'element' 	=> 'gallery_view',
						'value' 	=> array( 'normal-grid', 'masonry-grid' ),
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
						'element' 	=> 'gallery_view',
						'value' 	=> array( 'carousel' ),
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
						'element' 	=> 'gallery_view',
						'value' 	=> array( 'carousel' ),
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
						'element' 	=> 'gallery_view',
						'value' 	=> array( 'carousel' ),
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
						'element' 	=> 'gallery_view',
						'value' 	=> array( 'carousel' ),
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
						'element' 	=> 'gallery_view',
						'value' 	=> array( 'carousel' ),
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
						'element' 	=> 'gallery_view',
						'value' 	=> array( 'carousel' ),
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
						'element' 	=> 'gallery_view',
						'value' 	=> array( 'carousel' ),
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
						'6' 	=> 6,
					),
					'std'           => 4,
					'dependency' 	=> array(
						'element' 	=> 'gallery_view',
						'value' 	=> array( 'carousel' ),
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
						'5' 	=> 5,
						'6' 	=> 6,
					),
					'std'           => 2,
					'dependency' 	=> array(
						'element' 	=> 'gallery_view',
						'value' 	=> array( 'carousel' ),
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
					'std'           => 2,
					'dependency' 	=> array(
						'element' 	=> 'gallery_view',
						'value' 	=> array( 'carousel' ),
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
					'std'           => 2,
					'dependency' 	=> array(
						'element' 	=> 'gallery_view',
						'value' 	=> array( 'carousel' ),
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
			'gallery_images' 			=> '',
			'image_size' 				=> 'medium',
			'gallery_view' 				=> 'normal-grid',
			'image_gallery_gap' 		=> 15,
			'css_animation' 			=> 'none',	
			'el_class'            		=> '', 	
			'columns' 					=> 4,	
			'rows' 						=> 1,	
			'slider_autoplay' 			=> 0,
			'slider_loop' 				=> 0,
			'slider_center' 			=> 0,
			'slider_nav' 				=> 1,
			'slider_dots' 				=> 0,
			'rs_extra_large' 			=> 4,
			'rs_large'					=> 4,
			'rs_medium' 				=> 2,
			'rs_small' 					=> 2,
			'rs_extra_small' 			=> 2,			
			'css'            			=> '', 
		), $atts ) );
		extract( $args );
		
		$args['slider_class'] 	= '';
		$args['gallery_images'] = !empty($gallery_images) ? explode(',', $gallery_images ) : array();
		if(empty($args['gallery_images'])){ return;}
		$args['id'] 			= kapee_uniqid( 'kapee-image-gallery-' );
		$class					= array( 'kapee-element', 'kapee-image-gallery', 'image-gallery-'.$gallery_view, $el_class );
		$class[]				= kapee_get_css_animation($css_animation);
		$css_class 				= vc_shortcode_custom_css_class( $css, ' ' );
		$class[]				= $css_class;		
		$args['class'] 			= implode(' ', array_filter( $class ) );
		$args['column_class'] 	= ''; 
		if( $gallery_view == 'masonry-grid'){
				wp_enqueue_script( 'isotope' );
				wp_enqueue_script('masonry');
			}	
		if( $gallery_view == 'normal-grid' || $gallery_view == 'masonry-grid' ){
			$args['slider_class'] 	= 'row gutters-space-'.$image_gallery_gap;
			$columns_val = ( 12 / $columns  );			
			$columns = ( is_float( $columns_val ) ) ?  $columns * 10 : $columns_val;			
			$classes[] ='col-xl-'.$columns;			
			$args['column_class'] = 'col-6 col-sm-6 col-md-4 col-xl-'.$columns;
		}else{			
			$args['slider_class'] 	= 'kapee-carousel owl-carousel slider-gutters-space-'.$image_gallery_gap;
			$args['slider_class'] 	.= ' grid-col-xl-'.$rs_extra_large;
			$args['slider_class'] 	.= ' grid-col-lg-'.$rs_large;
			$args['slider_class'] 	.= ' grid-col-md-'.$rs_medium;
			$args['slider_class'] 	.= ' grid-col-sm-'.$rs_small;
			$args['slider_class'] 	.= ' grid-col-'.$rs_extra_small;
			$owl_data	= array(
				'slider_loop'				=> $slider_loop ? true : false,
				'slider_autoplay' 			=> $slider_autoplay ? true : false,
				'slider_center' 			=> $slider_center ? true : false,
				'slider_nav'				=> $slider_nav ? true : false,
				'slider_dots'				=> $slider_dots ? true : false,
				'slider_margin'				=> ( (int)$image_gallery_gap ) * 2,
				'rs_extra_large' 			=> $rs_extra_large,
				'rs_large' 					=> $rs_large,
				'rs_medium' 				=> $rs_medium,
				'rs_small' 					=> $rs_small,
				'rs_extra_small' 			=> $rs_extra_small,
			);
			$slider_data 			= shortcode_atts(kapee_slider_options(),$owl_data);
			global $kapee_owlparam;
			$kapee_owlparam['owlCarouselArg'][$args['id']] = $slider_data;
		}
		
		ob_start();
			kapee_get_pl_templates( 'shortcodes/image-gallery', $args );			
		return ob_get_clean();
	}	
}
new vcImageGallery();