<?php
/*
 * Element: list
 */
class vcList extends WPBakeryShortCode {

    function __construct() {
        $this->_mapping();
        add_shortcode( 'kapee_list', array( $this, '_html' ) );
	}
	public function _mapping() {
		if ( !defined( 'WPB_VC_VERSION' ) ) { return; }		
		vc_map( array(
			'name'			=> esc_html__( 'List', 'kapee-extensions' ),
			'base'			=> 'kapee_list',
			'category' 		=> esc_html__( 'Kapee', 'kapee-extensions' ),
			'description' 	=> esc_html__( 'Display list items.', 'kapee-extensions' ),
        	'icon' 			=> KAPEE_URI.'/inc/admin/assets/images/vc-icon.png',
			'params' 		=> array(
				//General
				array(
					'type'        	=> 'dropdown',
					'param_name'  	=> 'list_color',
					'heading'     	=> esc_html__( 'List Color', 'kapee-extensions' ),
					'value'       	=> array(
						esc_html__( 'Default', 'kapee-extensions' )	=> '',
						esc_html__( 'Light', 'kapee-extensions' )	=> 'light',
						esc_html__( 'Dark', 'kapee-extensions' )	=> 'dark',
					),
					'std' 			=> '',
				),
				array(
					'type' 			=> 'textfield',
					'heading' 		=> esc_html__( 'Extra class name', 'kapee-extensions' ),
					'param_name' 	=> 'el_class',
					'description' 	=> esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'kapee-extensions' )
				),
				//List
				array(
					'type'       	=> 'param_group',
					'param_name' 	=> 'list_items',
					'group'      	=> esc_html__( 'List Items', 'kapee-extensions' ),
					'params'     	=> array(
						array(
							'type'             => 'textfield',
							'heading'          => esc_html__( 'Item Content', 'kapee-extensions' ),
							'param_name'       => 'item_content',
							'tooltip'          => esc_html__( 'Add item content.', 'kapee-extensions' ),
							'admin_label'      => true,
						),
						array(
							'type' 				=> 'vc_link',
							'heading' 			=> esc_html__( 'Content Link', 'kapee-extensions'),
							'param_name' 		=> 'item_link'
						),
					),
				),
				
				// List Icon
				array(
					'type' 			=> 'dropdown',
					'param_name' 	=> 'list_type',
					'heading' 		=> esc_html__( 'List Type', 'kapee-extensions' ),
					'value' 		=> array(
						esc_html__( 'Default', 'kapee-extensions' ) 	=> 'none',
						esc_html__( 'Ordered', 'kapee-extensions' ) 	=> 'ordered',
						esc_html__( 'Unordered ', 'kapee-extensions' )  => 'unordered',
						esc_html__( 'With icon', 'kapee-extensions' ) 	=> 'icon',
						esc_html__( 'With image', 'kapee-extensions' ) 	=> 'image',
					),
					'std' 			=> '',
					'group' 		=> esc_html__( 'List Icon', 'kapee-extensions' ),
				),
				array(
					'type' 			=> 'dropdown',
					'param_name' 	=> 'list_style',
					'heading' 		=> esc_html__( 'List Style', 'kapee-extensions' ),
					'value' 		=> array(
						esc_html__( 'Default', 'kapee-extensions' ) 	=> 'default',
						esc_html__( 'Square', 'kapee-extensions' ) 		=> 'square',
						esc_html__( 'Round', 'kapee-extensions' ) 		=> 'round',
					),
					'std' 			=> 'default',
					'group' 		=> esc_html__( 'List Icon', 'kapee-extensions' ),
					'dependency'  	=> array(
						'element' 	=> 'list_type',
						'value'   	=> array( 'ordered','unordered','icon','image' ),
					),
				),
				array(
					'type' 			=> 'dropdown',
					'param_name' 	=> 'list_size',
					'heading' 		=> esc_html__( 'List Size', 'kapee-extensions' ),
					'value' 		=> array(
						esc_html__( 'Small', 'kapee-extensions' ) 	=> 'small',
						esc_html__( 'Medium', 'kapee-extensions' ) 	=> 'medium',
						esc_html__( 'Large', 'kapee-extensions' ) 	=> 'large',
					),
					'std' 			=> 'medium',
					'group' 		=> esc_html__( 'List Icon', 'kapee-extensions' ),
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__('Icon library', 'kapee-extensions'),
					'value' 		=> array(
						esc_html__('Font Awesome', 'kapee-extensions') 	=> 'fontawesome',
						esc_html__('Open Iconic', 'kapee-extensions') 	=> 'openiconic',
						esc_html__('Typicons', 'kapee-extensions') 		=> 'typicons',
						esc_html__('Entypo', 'kapee-extensions') 		=> 'entypo',
						esc_html__('Linecons', 'kapee-extensions')		=> 'linecons',
						esc_html__('Kapee Icons', 'kapee-extensions')	=> 'kapee',
					),
					'std'			=> 'fontawesome',
					'param_name' 	=> 'icon_type',
					'description' 	=> esc_html__('Select icon library.', 'kapee-extensions'),
					'dependency' 	=> array(
						'element' 	=> 'list_type',
						'value' 	=> 'icon'
					),
					'group' 		=> esc_html__( 'List Icon', 'kapee-extensions' ),
				),
				array(
					'type' 			=> 'iconpicker',
					'heading' 		=> esc_html__('Icon', 'kapee-extensions'),
					'param_name' 	=> 'icon_fontawesome',
					'value' 		=> 'fa fa-adjust', // default value to backend editor admin_label
					'settings' 		=> array(
						'emptyIcon' => false,
						// default true, display an "EMPTY" icon?
						'iconsPerPage' => 1000,
						// default 100, how many icons per/page to display, we use (big number) to display all icons in single page
					),
					'dependency' 	=> array('element' => 'icon_type', 'value' => 'fontawesome'),
					'description' 	=> esc_html__('Select icon from library.', 'kapee-extensions'),
					'group' 		=> esc_html__( 'List Icon', 'kapee-extensions' ),
				),
				array(
					'type' 			=> 'iconpicker',
					'heading' 		=> esc_html__('Icon', 'kapee-extensions'),
					'param_name' 	=> 'icon_openiconic',
					'value' 		=> 'vc-oi vc-oi-dial', // default value to backend editor admin_label
					'settings' 		=> array(
						'emptyIcon' 	=> false, // default true, display an "EMPTY" icon?
						'type' 			=> 'openiconic',
						'iconsPerPage' 	=> 1000, // default 100, how many icons per/page to display
					),
					'dependency' 	=> array(
						'element' 		=> 'icon_type',
						'value' 		=> 'openiconic',
					),
					'description' 	=> esc_html__('Select icon from library.', 'kapee-extensions'),
					'group' 		=> esc_html__( 'List Icon', 'kapee-extensions' ),
				),
				array(
					'type' 			=> 'iconpicker',
					'heading' 		=> esc_html__('Icon', 'kapee-extensions'),
					'param_name' 	=> 'icon_typicons',
					'value' 		=> 'typcn typcn-adjust-brightness', // default value to backend editor admin_label
					'settings' 		=> array(
						'emptyIcon' 	=> false, // default true, display an "EMPTY" icon?
						'type' 			=> 'typicons',
						'iconsPerPage' 	=> 1000, // default 100, how many icons per/page to display
					),
					'dependency' 	=> array(
						'element' 	=> 'icon_type',
						'value' 	=> 'typicons',
					),
					'description' 	=> esc_html__('Select icon from library.', 'kapee-extensions'),
					'group' 		=> esc_html__( 'List Icon', 'kapee-extensions' ),
				),
				array(
					'type' 			=> 'iconpicker',
					'heading' 		=> esc_html__('Icon', 'kapee-extensions'),
					'param_name' 	=> 'icon_entypo',
					'value' 		=> 'entypo-icon entypo-icon-note', // default value to backend editor admin_label
					'settings' 		=> array(
						'emptyIcon' 	=> false, // default true, display an "EMPTY" icon?
						'type' 			=> 'entypo',
						'iconsPerPage' 	=> 1000, // default 100, how many icons per/page to display
					),
					'dependency' 	=> array(
						'element' 	=> 'icon_type',
						'value' 	=> 'entypo',
					),
					'group' 		=> esc_html__( 'List Icon', 'kapee-extensions' ),
				),
				array(
					'type'        	=> 'iconpicker',
					'heading'     	=> esc_html__( 'Icon', 'kapee-extensions' ),
					'param_name'  	=> 'icon_linecons',
					'value'  		=> 'vc_li vc_li-heart',
					'settings'    	=> array(
						'emptyIcon'    => true,
						'type'         => 'linecons',
						'iconsPerPage' => 1000,
					),
					'dependency'  	=> array(
						'element' 	=> 'icon_type',
						'value'   	=> 'linecons',
					),
					'group' 		=> esc_html__( 'List Icon', 'kapee-extensions' ),
				),
				array(
					'type'        	=> 'iconpicker',
					'heading'     	=> esc_html__( 'Icon', 'kapee-extensions' ),
					'param_name'  	=> 'icon_kapee',
					'value'  		=> 'pls pls-heart',
					'settings'    	=> array(
						'emptyIcon'    => true,
						'type'         => 'kapee',
						'iconsPerPage' => 1000,
					),
					'dependency'  	=> array(
						'element' 	=> 'icon_type',
						'value'   	=> 'kapee',
					),
					'group' 		=> esc_html__( 'List Icon', 'kapee-extensions' ),
				),
				array(
					'type' 			=> 'attach_image',
					'heading' 		=> esc_html__( 'Image', 'kapee-extensions' ),
					'param_name' 	=> 'list_image',
					'value' 		=> '',
					'description' 	=> esc_html__( 'Select image from media library.', 'kapee-extensions' ),
					'dependency' 	=> array(
						'element' 	=> 'list_type',
						'value' 	=> array( 'image' ),
					),
					'group' 		=> esc_html__( 'List Icon', 'kapee-extensions' ),
				),
				array(
					'type'          => 'colorpicker',
					'heading'       => esc_html__( 'Icon Color', 'kapee-extensions' ),
					'param_name'    => 'icon_color',
					'std' 			=> '#555555',
					'group' 		=> esc_html__( 'List Icon', 'kapee-extensions' ),
				),
				array(
					'type'        	=> 'colorpicker',
					'param_name'  	=> 'icon_background',
					'heading'     	=> esc_html__( 'Icon Background', 'kapee-extensions' ),
					'std' 			=> '#2370F4',
					'group' 		=> esc_html__( 'List Icon', 'kapee-extensions' ),
					'dependency'  	=> array(
						'element' 	=> 'list_style',
						'value'   	=> array( 'square', 'round' ),
					),
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
		$args = ( shortcode_atts( array(
			'list_color' 				=> '',
			'el_class' 					=> '',
			'list_items' 				=> '',
			'item_link'					=> '',
			'list_type'					=> 'none',
			'list_style'				=> 'default',
			'list_size'					=> 'medium',
			'icon_type' 				=> 'fontawesome',     
            'icon_fontawesome' 			=> 'fa fa-adjust',  
            'icon_openiconic' 			=> 'vc-oi vc-oi-dial',     
            'icon_typicons' 			=> 'typcn typcn-adjust-brightness',     
            'icon_entypo' 				=> 'entypo-icon entypo-icon-note',    
            'icon_linecons' 			=> 'vc_li vc_li-heart',
			'icon_kapee' 				=> 'pls pls-heart',
			'list_image'				=> '',
			'icon_color'				=> '#555555',
			'icon_background'			=> '#2370F4',
			'css' 						=> '',				
		), $atts ) );
		extract( $args );
		
		if ( function_exists( 'vc_param_group_parse_atts' ) ) {
			$list_items = vc_param_group_parse_atts( $list_items );
		}
		
		// Return if no list items found
		if( !is_array( $list_items ) || empty( $list_items ) || ( (count($list_items) == 1) && empty( $list_items[0] ) ) ) {
			return;
		}
		$args['id']			= kapee_uniqid('kapee-list-');
		$class				= array( 'kapee-element', 'kapee-list' );		 
		$class[]			= ( $list_color != '' ) ? 'color-scheme-'.$list_color : '';	 
		$class[]			= 'list-type-'.$list_type;
		$icon_html 			= '';
		
		if( $list_type != 'none' ){
			$class[]		= 'list-style-'.$list_style;
			$class[]		= 'list-size-'.$list_size;
		
			if( $list_type =='icon' ) {
			   vc_icon_element_fonts_enqueue( $icon_type );
				$iconClass 	= $args["icon_". $icon_type];			
			}
			
			if ( $list_type == 'image' ) :
				$img = wp_get_attachment_image_src( $list_image, 'full' );
				$icon_html = '<img src=" '. esc_url($img[0]) .' "  alt="Icon image"/>';
			elseif( $list_type == 'icon' ) :                    
				$icon_html = '<i class="' .  esc_attr($iconClass).' " aria-hidden="true"></i>';
			endif; //$icon_type == 'image' 
		}
		$class[]				= $el_class;
		$class[]				= vc_shortcode_custom_css_class( $css, ' ' );
		$args['class'] 			= implode(' ', array_filter( $class ) );		
		$args['icon_html'] 		= $icon_html;
		$args['list_items'] 	= $list_items;
		
		$list_css 						= array();
		$style_css 						= '';		
		$list_css['icon_color'][]		=  !empty ( $icon_color ) ? 'color:'.$icon_color.';' : '';
		$list_css['icon_background'][]	=  !empty ( $icon_background ) ? 'background-color:'.$icon_background.';' : '';
		
		if( ! empty( $list_css['icon_color'] ) ){
			$style_css .= '#'.$args['id'].' .list-icon{';
			$style_css .= implode(' ', $list_css['icon_color'] );
			$style_css .= '}';
		}	
		if( ! empty( $list_css['icon_background'] ) ){
			$style_css .= '#'.$args['id'].'.list-style-square .list-icon, #'.$args['id'].'.list-style-round .list-icon{';
			$style_css .= implode(' ', $list_css['icon_background'] );
			$style_css .= '}';
		}	
		kapee_add_custom_css( $style_css );
			
		ob_start();
			kapee_get_pl_templates('shortcodes/list',$args );	
		return ob_get_clean();
	}	
}
new vcList();
