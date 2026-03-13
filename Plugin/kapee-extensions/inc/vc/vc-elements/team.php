<?php 
/**
 * Element: Team
 */
 
class vcTeam extends WPBakeryShortCode {

    function __construct() {
        $this->_mapping();
        add_shortcode( 'kapee_team', array( $this, '_html' ) );
	}
	public function _mapping() {
		if ( !defined( 'WPB_VC_VERSION' ) ) { return; }	
		$image_sizes 			= kapee_get_all_image_sizes(true);
        array_shift($image_sizes);
		vc_map( array(
			'name' 						=> esc_html__( 'Team', 'kapee-extensions' ),
			'base' 						=> 'kapee_team',
			'as_parent' 				=> array( 'only' => 'kapee_team_member' ),
			'content_element' 			=> true,
			'show_settings_on_create' 	=> false,
			'category' 					=> esc_html__( 'Kapee', 'kapee-extensions' ),
			'description' 				=> esc_html__( 'Team', 'kapee-extensions' ),
        	'icon' 						=> KAPEE_URI.'/inc/admin/assets/images/vc-icon.png',
			'params' 					=> array(
				array(
					'type' 				=> 'dropdown',
					'heading' 			=> esc_html__( 'Style', 'kapee-extensions' ),
					'param_name' 		=> 'style',
					'value' 			=> array( 
						esc_html__( 'Image Top With Box', 'kapee-extensions' ) 			=> 'image-top-with-box',
						esc_html__( 'Image Top With Box 2', 'kapee-extensions' ) 		=> 'image-top-with-box-2',
						esc_html__( 'Image Middle With Swap Box', 'kapee-extensions' ) 	=> 'image-middle-swap-box',
						esc_html__( 'Image Top With Bottom Info', 'kapee-extensions' ) 	=> 'image-top-botton-info',
						esc_html__( 'Image With Bottom Overlay', 'kapee-extensions' ) 	=> 'image-bottom-overlay',
					),
					'description' 		=> esc_html__( 'Select style.', 'kapee-extensions' ),
					'admin_label'   	=> true,
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Member Avatar Image size', 'kapee-extensions' ),
					'param_name' 	=> 'img_size',
					'std' 			=> 'medium',
					'value'			=> array_flip($image_sizes),
					'description' 	=> esc_html__( 'Select image size.', 'kapee-extensions' )
				),				
				array(
					'type'            	=> 'colorpicker',
					'heading'         	=> esc_html__( 'Background Color', 'kapee-extensions' ),
					'param_name'      	=> 'bg_color',
					'std'				=>	'#f1f1f1',
				),
				array(
					'type'            	=> 'dropdown',
					'heading'         	=> esc_html__( 'Color', 'kapee-extensions' ),
					'param_name'      	=> 'color',
					'value' 			=> array(
						esc_html__('Inherit', 'kapee-extensions') 	=> 'inherit',
						esc_html__( 'Light', 'kapee-extensions' ) 	=> 'light',
						esc_html__( 'Dark', 'kapee-extensions' ) 	=> 'dark',
					),
					'std'				=>	'dark',
				),
				array(
					'type'            	=> 'colorpicker',
					'heading'         	=> esc_html__( 'Hover Background Color', 'kapee-extensions' ),
					'param_name'      	=> 'hover_bg_color',
					'std'				=>	'#2370F4',
					'dependency' 		=> array(
						'element' 	=> 'style', 
						'value' 	=> array('image-top-with-box-2')
					),
				),
				array(
					'type'            	=> 'dropdown',
					'heading'         	=> esc_html__( 'Hover Color', 'kapee-extensions' ),
					'param_name'      	=> 'hover_color',
					'value' 			=> array(
						esc_html__('Inherit', 'kapee-extensions') 	=> 'inherit',
						esc_html__( 'Light', 'kapee-extensions' ) 	=> 'light',
						esc_html__( 'Dark', 'kapee-extensions' ) 	=> 'dark',
					),
					'std'				=>	'light',
					'dependency' 		=> array(
						'element' 	=> 'style', 
						'value' 	=> array('image-top-with-box-2')
					),
				),
				array(
					'type' 				=> 'textfield',
					'heading' 			=> esc_html__( 'Extra class name', 'kapee-extensions' ),
					'param_name' 		=> 'el_class',
					'description' 		=> esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'kapee-extensions' )
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
			),
		    'js_view' 				=> 'VcColumnView'
		) );
	}
	
	public function _html( $atts, $content ) {
		$args = ( shortcode_atts( array(
			'style' 					=> 'image-top-with-box',
			'img_size' 					=> 'medium',
			'color' 					=> 'dark',
			'bg_color' 					=> '#f1f1f1',
			'hover_bg_color' 			=> '#2370F4',
			'hover_color' 				=> 'light',
			'el_class' 					=> '',
			'slider_autoplay' 			=> 0,
			'slider_loop' 				=> 0,
			'slider_center' 			=> 0,
			'slider_nav' 				=> 1,
			'slider_dots' 				=> 0,
			'slider_margin' 			=> 30,
			'rs_extra_large' 			=> 4,
			'rs_large'					=> 3,
			'rs_medium' 				=> 2,
			'rs_small' 					=> 1,
			'rs_extra_small' 			=> 1,				
		), $atts ) );
		extract( $args );
		$args['id'] 		= kapee_uniqid('kapee-team-');
		 
		$class = $member_class 	= array();
		$class[]				= 'kapee-element';
		$class[]				= 'kapee-team';
		$class[]				= $style;
		$class[]				= $el_class;
		$args['class'] 			= implode(' ', array_filter( $class ) );
		$args['content'] 		= $content;
		
		$member_info_css 				= array();		
		if( $style != 'image-top-botton-info' ){
			$member_info_css[] 	= !empty( $bg_color ) ? 'background-color:'.$bg_color : '' ;
		}
		$args['member_info_css']			= implode('; ', array_filter( $member_info_css ) ) ;
		$args['member_info_css'] 			= !empty($args['member_info_css']) ? 'style="'.$args['member_info_css'].'"' : '';
		
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
		$args['slider_data']	= json_encode( shortcode_atts(kapee_slider_options(),$owl_data));
		$args['slider_class'] 	= ' grid-col-xl-'.$rs_extra_large;
		$args['slider_class'] 	.= ' grid-col-lg-'.$rs_large;
		$args['slider_class'] 	.= ' grid-col-md-'.$rs_medium;
		$args['slider_class'] 	.= ' grid-col-sm-'.$rs_small;
		$args['slider_class'] 	.= ' grid-col-'.$rs_extra_small;
		global $kapee_owlparam, $team_args;
		$member_class[]					= 'color-scheme-'.$color;
		$member_class[]					= ( $style == 'image-top-with-box-2' ) ? 'hover-color-scheme-'.$hover_color : '';
		$team_args['member_class'] 		= implode(' ', array_filter( $member_class ) );
		$team_args['style']				= $style;
		$team_args['img_size']			= $img_size;
		$team_args['bg_color']			= $args['bg_color'];
		$team_args['hover_bg_color']	= $args['hover_bg_color'];
		$team_args['member_info_css']	= $args['member_info_css'];
		$kapee_owlparam['owlCarouselArg'][$args['id']] = $slider_data;
		extract( $args );
		
		ob_start();
			kapee_get_pl_templates('shortcodes/team',$args );
		return ob_get_clean();
	}	
}
new vcTeam();