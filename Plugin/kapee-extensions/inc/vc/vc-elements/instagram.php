<?php
/*
Element: Instagram
*/
class vcInstagram extends WPBakeryShortCode {
	public $access_token,$new_refresh_token,$option_name = 'kapee_instagram_access_token';
    function __construct() {
        $this->_mapping();
        add_shortcode( 'kapee_instagram', array( $this, '_html' ) );
	}
	public function _mapping() {
		if ( !defined( 'WPB_VC_VERSION' ) ) { return; }
		
		vc_map( array(
			'name'			=> esc_html__( 'Instagram', 'kapee-extensions' ),
			'base'			=> 'kapee_instagram',
			'category' 		=> esc_html__( 'Kapee', 'kapee-extensions' ),
			'description' 	=> esc_html__( 'Instagram.', 'kapee-extensions' ),
        	'icon' 			=> KAPEE_URI.'/inc/admin/assets/images/vc-icon.png',
			'params' 		=> array(
				//General				
				array(
					'type' 			=> 'textfield',
					'heading' 		=> esc_html__( 'Title', 'kapee-extensions' ),
					'param_name' 	=> 'title',
					'description' 	=> esc_html__( 'Enter title.', 'kapee-extensions' ),
					'std' 			=> esc_html__( 'Instagram', 'kapee-extensions' ),
					'admin_label'   	=> true,
				),
				array(
					'type' 			=> 'textfield',
					'heading' 		=> esc_html__( 'Access Token', 'kapee-extensions' ),
					'param_name' 	=> 'access_token',
					'description' 	=> esc_html__( 'Enter title.', 'kapee-extensions' ),
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Layout', 'kapee-extensions' ),
					'param_name' 	=> 'layout',
					'std' 			=> 'slider',
					'value'			=> array( 
						esc_html__('Grid','kapee-extensions') 	=> 'grid',
						esc_html__('Slider','kapee-extensions') => 'slider'
					),
					'admin_label'   	=> true,
				),
				array(
					'type' 				=> 'kapee_number',
					'param_name' 		=> 'limit',
					'heading' 			=> esc_html__( 'Number Of Photos', 'kapee-extensions' ),
					'std' 				=> 8,
				),
				array(
					'type' 				=> 'dropdown',
					'heading' 			=> esc_html__( 'Open Link In', 'kapee-extensions' ),
					'value' 			=> array(
						esc_html__('New window', 'kapee-extensions') 		=> '_blank',
						esc_html__('Current window', 'kapee-extensions') 	=> '_self',
					),
					'std' 				=> '_blank',
					'param_name' 		=> 'target',
					"edit_field_class"	=> "vc_col-md-6",
				),
				array(
					'type' 				=> 'checkbox',
					'param_name' 		=> 'space_between_photos',
					'heading' 			=> esc_html__( 'Add Space Between Photos', 'kapee-extensions' ),
					'value' 			=> array( esc_html__( 'Yes, please', 'kapee-extensions' ) => 1 ),
					'std' 				=> 0,
					'dependency' 	=> array(
						'element' 	=> 'layout',
						'value' 	=> array( 'slider' ),
					),
				),
				array(
					'type' 				=> 'kapee_number',
					'param_name' 		=> 'space_photos',
					'heading' 			=> esc_html__( 'Sapce Between Photos', 'kapee-extensions' ),
					'description' 		=> esc_html__( 'Number of space between photos.', 'kapee-extensions' ),
					'std' 				=> 5,
					'dependency' 	=> array(
						'element' 	=> 'space_between_photos',
						'value' 	=> array( '1' ),
					),
				),
				//Grid Settings
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Number Of Columns', 'kapee-extensions' ),
					'param_name' 	=> 'columns',
					"value" 		=> array(
						"1"  	=> 1,
						"2" 	=> 2,
						"3" 	=> 3,
						"4" 	=> 4,
						"5" 	=> 5,
						"6" 	=> 6,
						"7" 	=> 7,
						"8" 	=> 8,
					),
					'std' 			=> 5,
					'dependency' 	=> array(
						'element' 	=> 'layout',
						'value' 	=> array( 'grid' ),
					),
					'group' 		=> esc_html__( 'Grid Settings', 'kapee-extensions' ),					
				),				
				array(
					'type' 				=> 'checkbox',
					'param_name' 		=> 'grid_space_between_photos',
					'heading' 			=> esc_html__( 'Remove Space Between Photos', 'kapee-extensions' ),
					'value' 			=> array( esc_html__( 'Yes, please', 'kapee-extensions' ) => 1 ),
					"edit_field_class"	=> "vc_col-md-6",
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
						"7" 	=> 7,
						"8" 	=> 8,
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
						"6" 	=> 6,
						"7" 	=> 7,
						"8" 	=> 8,
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
						"5" 	=> 5,
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
						"4" 	=> 4,
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
					"std"           => 1,
					'dependency' 	=> array(
						'element' 	=> 'layout',
						'value' 	=> array( 'slider' ),
					),
					'group'         => esc_html__( 'Carousel Settings', 'kapee-extensions' ),
				),
				( function_exists( 'vc_map_add_css_animation' ) ) ? vc_map_add_css_animation( true ) : '',
				array(
					'type' 			=> 'textfield',
					'heading' 		=> esc_html__( 'Extra class name', 'kapee-extensions' ),
					'param_name' 	=> 'el_class',
					'description' 	=> esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'kapee-extensions' )
				),
				//Style
				array(
					'type' 			=> 'css_editor',
					'heading' 		=> esc_html__( 'CSS box', 'kapee-extensions' ),
					'param_name' 	=> 'css',
					'group' 		=> esc_html__( 'Design Options', 'kapee-extensions' )
				)
			),
		) );
	}
	
	public function _html( $atts, $content ) {
		$args = shortcode_atts( array(
			'title' 					=> 'Instagram',
			'access_token' 				=> '',
			'limit' 					=> '8',
			'target' 					=> '_blank',
			'space_between_photos'		=> 0,
			'space_photos'				=> 5,
			'layout' 					=> 'slider',
			'columns' 					=> 4,
			'grid_space_between_photos' => 0,
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
			'rs_extra_small' 			=> 1,
			'css_animation' 		=> 'none',	
			'el_class'					=> '',
			"css"            			=> "", 	
		), $atts );		
		extract($args);
		if( empty( $access_token )){
			return;
		}
		$this->access_token 	= $access_token;
		$class					= array();
		$class[]				= 'kapee-element';
		$class[]				= 'kapee-instagram';
		$class[]				= $el_class;
		$class[]				= kapee_get_css_animation($css_animation);
		$css_class 				= vc_shortcode_custom_css_class( $css, ' ' );
		$class[]				= $css_class;
		$args['class'] 			= implode(' ',array_filter($class));
		$args['id'] 			= kapee_uniqid('kapee-instagram-');
		
		$args['column_class'] 	= '';	
		$args['slider_class'] 	= ( $layout =='grid' && $grid_space_between_photos ) ? 'row no-gutters' : 'row';
		if($args['layout'] == 'slider'){
			$owl_data	= array(
				'slider_loop'				=> $slider_loop ? true : false,
				'slider_autoplay' 			=> $slider_autoplay ? true : false,
				'slider_center' 			=> $slider_center ? true : false,
				'slider_nav'				=> $slider_nav ? true : false,
				'slider_dots'				=> $slider_dots ? true : false,
				'slider_margin'				=> $space_between_photos ? (int)$space_photos : 0,
				'rs_extra_large' 			=> $rs_extra_large,
				'rs_large' 					=> $rs_large,
				'rs_medium' 				=> $rs_medium,
				'rs_small' 					=> $rs_small,
				'rs_extra_small' 			=> $rs_extra_small,
			);
			$slider_data	= shortcode_atts(kapee_slider_options(),$owl_data);
			global $kapee_owlparam;
			$kapee_owlparam['owlCarouselArg'][$args['id']] = $slider_data;
			$args['slider_class'] 	= 'kapee-carousel owl-carousel';
			$args['slider_class'] 	.= ' grid-col-xl-'.$rs_extra_large;
			$args['slider_class'] 	.= ' grid-col-lg-'.$rs_large;
			$args['slider_class'] 	.= ' grid-col-md-'.$rs_medium;
			$args['slider_class'] 	.= ' grid-col-sm-'.$rs_small;
			$args['slider_class'] 	.= ' grid-col-'.$rs_extra_small;
		}else{
			$columns_val = ( 12 / $columns  );			
			$columns = ( is_float($columns_val)) ?  $columns * 10 : $columns_val;			
			$classes[] ='col-xl-'.$columns;			
			$args['column_class'] = 'col-6 col-sm-6 col-md-4 col-xl-'.$columns;
		}
		
		$num					= (int) $limit;
		$cols					= (int) $columns;
		$imagepadding			= $space_between_photos ? $space_photos : 0;		
		$args['num'] 			= $num ;
		$args['cols'] 			= $cols ;
		$args['imagepadding'] 	= $imagepadding ;
		
		$args 					= wp_parse_args($args,$atts);
		$instagram_data = '';
		
		$refresh_token = $this->refresh_access_token();
		if( is_wp_error($refresh_token) ){
			echo esc_html( $refresh_token->get_error_message() );
			$this->access_token = '';
			return;
		}
		
		if( !empty( $this->access_token ) ){
			$instagram_data = $this->instagram_media( $num );
			if( is_wp_error( $instagram_data ) ){
				echo esc_html( $instagram_data->get_error_message() );
			}
		}
		if( !is_wp_error( $instagram_data ) && !empty( $instagram_data ) ){
			$args['instagram_data'] 	= $instagram_data ;
		}
		if( empty( $args['instagram_data'] ) ){
			return;
		}
		ob_start();
			kapee_get_pl_templates('shortcodes/instagram',$args );	
		return ob_get_clean();
	}
	public function instagram_media( $limit = 10 ){
		
		$transient_key = 'kapee_'.sanitize_title_with_dashes($this->access_token).'_'.$limit;
		
		$stored_transient 	= get_transient( $transient_key ); // Getting cache value
		$stored_transient	= !empty($stored_transient) ? json_decode($stored_transient, true) : false;
		if ( false === $stored_transient ) {
			$args = [
				'fields'       => 'id,caption,media_type,media_url,permalink,thumbnail_url,username',
				'limit'		=> $limit,
				'access_token' => $this->access_token,
			];
			$result_data = array();
			$url = add_query_arg( $args, 'https://graph.instagram.com/me/media' );

			$response = wp_remote_get( $url );
			
			$response = wp_remote_retrieve_body( $response );		
			$response   = json_decode( $response, true );
			
			if( !is_array($response) ){
				return new WP_Error( 'invalid_response', esc_html__( 'Instagram has returned invalid data.', 'kapee-extensions' ) );
			}
			
			if( isset($response['error']['message']) ){
				return new WP_Error( 'error_response', $response['error']['message'] );
			}
			
			foreach ( $response['data'] as $media ) {
				$result_data[] = array(
					'username'    => $media['username'],
					'type'    => $media['media_type'],
					'caption' => isset( $media['caption'] ) ? $media['caption'] : $media['id'],
					'image_link'    => $media['permalink'],
					'image_url'  => strtolower( $media['media_type'] ) == 'video' ? $media['thumbnail_url'] : $media['media_url'],
				);
			}
			set_transient( $transient_key, json_encode($result_data), apply_filters( 'kapee_instagram_cache_time', HOUR_IN_SECONDS * 2 ) );
		}else{
			$result_data = $stored_transient;
		}
		if ( ! empty( $result_data ) ) {
			return array_slice( $result_data, 0, $limit );
		} else {
			return new WP_Error( 'no_images', esc_html__( 'Instagram did not return any images.', 'kapee-extensions' ) );
		}
	}
	public function refresh_access_token(){
		$token_data = array();
		$generate_new_taken = true;
		$access_token = get_option( $this->option_name, [] );
		
		if ( !empty( $access_token ) && isset($access_token[$this->access_token]) ) {
			if( isset( $access_token[$this->access_token]['timestamp'] ) && 
			 $access_token[$this->access_token]['timestamp'] > time() ){
				$generate_new_taken = false;
			}
			$this->access_token = $access_token[$this->access_token]['refreshed_token'];			
		}
		
		if($generate_new_taken){
			$args = [
				'grant_type' => 'ig_refresh_token',
				'access_token'  => $this->access_token
			];
			$url = add_query_arg( $args, 'https://graph.instagram.com/refresh_access_token' );
			$response 	= wp_remote_get( $url );
			$data 		= wp_remote_retrieve_body( $response );			
			$data = json_decode( $data, true );			
			if( isset($data['access_token']) ){
				$token_data[$this->access_token]['refreshed_token'] = $data['access_token'];
				$token_data[$this->access_token]['timestamp'] = time() + MONTH_IN_SECONDS;
				if(!empty($access_token)){
					$token_data = array_merge($access_token, $token_data);
				}
				update_option($this->option_name, $token_data);
				$this->access_token = $data['access_token'];
				return true;
			}else{
				return new WP_Error( 'access_token_refresh', esc_html__( "can't refresh token. Please check your access key.", 'kapee-extensions' ) );
			}
		}		
	}
}
new vcInstagram();