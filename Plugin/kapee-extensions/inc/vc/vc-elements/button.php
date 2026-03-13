<?php
/*
Element: Button
*/
class vcButton extends WPBakeryShortCode {

    function __construct() {
        $this->_mapping();
        add_shortcode( 'kapee_button', array( $this, '_html' ) );
	}
	public function _mapping() {
		if ( !defined( 'WPB_VC_VERSION' ) ) { return; }
		
		vc_map( array(
			'name' 			=> esc_html__( 'Button', 'kapee-extensions' ),
			'base' 			=> 'kapee_button',
			'category' 		=> esc_html__( 'Kapee', 'kapee-extensions' ),
			'description' 	=> esc_html__( 'Display button.', 'kapee-extensions' ),
        	'icon' 			=> KAPEE_URI.'/inc/admin/assets/images/vc-icon.png',
			'params' 		=> array(
				//General
				array(
					'type' 			=> 'textfield',
					'heading' 		=> esc_html__( 'Text', 'kapee-extensions' ),
					'admin_label' 	=> true,
					'param_name' 	=> 'text',
					'std' 			=> 'Button text here',
				),
				array(
					'type' 			=> 'vc_link',
					'param_name' 	=> 'button_link',
					'heading' 		=> esc_html__( 'Button Link', 'kapee-extensions'),
				),
				array(
					'type'        	=> 'dropdown',
					'param_name'  	=> 'style',
					'heading'     	=> esc_html__( 'Style', 'kapee-extensions' ),
					'admin_label' 	=> true,
					'value'       	=> array(
						esc_html__( 'Flat', 'kapee-extensions' )  		=> 'flat',
						esc_html__( 'Outline', 'kapee-extensions' )  	=> 'outline',
						esc_html__( 'Link', 'kapee-extensions' )  		=> 'link'
					),
					'std' 			=> 'flat',
				),
				array(
					'type'        	=> 'dropdown',
					'param_name'  	=> 'shape',
					'heading'     	=> esc_html__( 'Shape', 'kapee-extensions' ),
					'value'       	=> array(
						esc_html__( 'Square', 'kapee-extensions' )	=> 'square',
						esc_html__( 'Rounded', 'kapee-extensions' )	=> 'rounded',
						esc_html__( 'Round', 'kapee-extensions' )  	=> 'round'
					),
					'std' 			=> 'square',
				),
				array(
					'type'        	=> 'dropdown',
					'param_name'  	=> 'size',
					'heading'     	=> esc_html__( 'Size', 'kapee-extensions' ),
					'value'       	=> array(
						esc_html__( 'Small', 'kapee-extensions' )	=> 'small',
						esc_html__( 'Normal', 'kapee-extensions' )  => 'normal',
						esc_html__( 'Large', 'kapee-extensions' )  	=> 'large',
					),
					'std' 			=> 'normal',
				),
				array(
					'type'        	=> 'dropdown',
					'param_name'  	=> 'button_alignment',
					'heading'     	=> esc_html__( 'Alignment', 'kapee-extensions' ),
					'admin_label' 	=> true,
					'value'       	=> array(
						esc_html__( 'Inline', 'kapee-extensions' )	=> 'inline',
						esc_html__( 'Left', 'kapee-extensions' )	=> 'left',
						esc_html__( 'Right', 'kapee-extensions' )  	=> 'right',
						esc_html__( 'Center', 'kapee-extensions' )  => 'center',
					),
					'std' 			=> 'inline',
				),
				array(
					'type'        	=> 'dropdown',
					'param_name'  	=> 'button_color',
					'heading'     	=> esc_html__( 'Button Color', 'kapee-extensions' ),
					'admin_label' 	=> true,
					'value'       	=> array(
						esc_html__( 'Default', 'kapee-extensions' )		=> 'default',
						esc_html__( 'Primary', 'kapee-extensions' )		=> 'primary',
						esc_html__( 'Custom', 'kapee-extensions' )  	=> 'custom',
					),
					'std' 			=> 'default',
				),
				array(
					'type' 			=> 'checkbox',
					'heading' 		=> esc_html__( 'Add Icon', 'kapee-extensions' ),
					'param_name' 	=> 'button_icon',
					'value' 		=> array( esc_html__( 'Yes', 'kapee-extensions' ) => 1 ),
					'std' 			=> 0,
				),	
				array(
					'type'        	=> 'dropdown',
					'param_name'  	=> 'icon_alignment',
					'heading'     	=> esc_html__( 'Icon Alignment', 'kapee-extensions' ),
					'value'       	=> array(
						esc_html__( 'Left', 'kapee-extensions' )	=> 'left',
						esc_html__( 'Right', 'kapee-extensions' )  	=> 'right',
					),
					'std' 			=> 'left',
					'dependency'	=> array(
						'element' 	=> 'button_icon',
						'value'   	=> '1',
					),
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
					'dependency'	=> array(
						'element' 	=> 'button_icon',
						'value'   	=> '1',
					),
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
				),
				( function_exists( 'vc_map_add_css_animation' ) ) ? vc_map_add_css_animation( true ) : '',
				array(
					'type' 			=> 'textfield',
					'heading' 		=> esc_html__( 'Extra class name', 'kapee-extensions' ),
					'param_name' 	=> 'el_class',
					'description' 	=> esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'kapee-extensions' )
				),
				array(
					'type'          => 'colorpicker',
					'heading'       => esc_html__( 'Color', 'kapee-extensions' ),
					'param_name'    => 'button_custom_color',
					'std' 			=> '#2370F4',
					'dependency' 	=> array(
						'element' 	=> 'button_color',
						'value' 	=> 'custom',
					),
					'group' 		=> esc_html__( 'Button Color', 'kapee-extensions' ),
				),
				array(
					'type'        	=> 'dropdown',
					'param_name'  	=> 'button_custom_text_color',
					'heading'     	=> esc_html__( 'Text Color', 'kapee-extensions' ),
					'value'       	=> array(
						esc_html__( 'Light', 'kapee-extensions' )	=> 'light',
						esc_html__( 'Dark', 'kapee-extensions' )	=> 'dark',
					),
					'std' 			=> 'light',
					'dependency' 	=> array(
						'element' 	=> 'button_color',
						'value' 	=> 'custom',
					),
					'group' 		=> esc_html__( 'Button Color', 'kapee-extensions' ),
				),
				array(
					'type'          => 'colorpicker',
					'heading'       => esc_html__( 'Color on Hover', 'kapee-extensions' ),
					'param_name'    => 'button_custom_color_hover',
					'std' 			=> '#2370F4',
					'dependency' 	=> array(
						'element' 	=> 'button_color',
						'value' 	=> 'custom',
					),
					'group' 		=> esc_html__( 'Button Color', 'kapee-extensions' ),
				),
				array(
					'type'        	=> 'dropdown',
					'param_name'  	=> 'button_custom_text_color_hover',
					'heading'     	=> esc_html__( 'Text Color on Hover', 'kapee-extensions' ),
					'value'       	=> array(
						esc_html__( 'Light', 'kapee-extensions' )	=> 'light',
						esc_html__( 'Dark', 'kapee-extensions' )	=> 'dark',
					),
					'std' 			=> 'light',
					'dependency' 	=> array(
						'element' 	=> 'button_color',
						'value' 	=> 'custom',
					),
					'group' 		=> esc_html__( 'Button Color', 'kapee-extensions' ),
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
			'text' 						=> 'Button text here',			
			'button_link' 				=> '',			
			'style' 					=> 'flat',			
			'shape' 					=> 'square',			
			'size' 						=> 'normal',			
			'button_alignment' 			=> 'inline',			
			'button_icon' 				=> 0,			
			'icon_alignment' 			=> 'left',	
			'button_color' 				=> 'default',	
			'button_custom_color' 		=> '#2370F4',	
			'button_custom_text_color' 	=> 'light',	
			'button_custom_color_hover' => '#2370F4',	
			'button_custom_text_color_hover' => 'light',	
			'icon_type' 				=> 'fontawesome', 
			'icon_fontawesome' 			=> 'fa fa-adjust',  
            'icon_openiconic' 			=> 'vc-oi vc-oi-dial',     
            'icon_typicons' 			=> 'typcn typcn-adjust-brightness',     
            'icon_entypo' 				=> 'entypo-icon entypo-icon-note',    
            'icon_linecons' 			=> 'vc_li vc_li-heart',
			'icon_kapee' 				=> 'pls pls-heart',
			'css_animation' 			=> 'none',	
			'el_class' 					=> '',			
			'css' 						=> '',			
		), $atts );	
		extract( $args );
		
		$args['id'] 			= kapee_uniqid('kapee-button-');		
		$class					= array( 'kapee-element', 'kapee-button' );		
		$class[]				= 'text-'.$button_alignment;
		$class[]				= $el_class;
		$class[]				= kapee_get_css_animation($css_animation);
		$class[]				= kapee_get_css_animation($css_animation);
		$css_class 				= vc_shortcode_custom_css_class( $css, ' ' );
		$class[]				= $css_class;
		$args['class'] 			= implode(' ', array_filter( $class ) );		
		$button_class			= array( 'button' );
		$button_class[]			= 'btn-style-'.$style;
		$button_class[]			= 'btn-shape-'.$shape;
		$button_class[]			= 'btn-size-'.$size;
		$button_class[]			= 'btn-color-'.$button_color;
		$button_class[]			= ( $style != 'link' && $button_color == 'custom' ) ? 'color-scheme-'.$button_custom_text_color : '';
		$button_class[]			= ( $style != 'link' && $button_color == 'custom' ) ? 'hover-color-scheme-'.$button_custom_text_color_hover : '';
		$button_class[]			= !empty ( $button_icon ) ? 'btn-icon-'.$icon_alignment : '';
		$args['button_class'] 	= implode(' ', array_filter( $button_class ) );
		$icon_html 			= '';
		if( $button_icon ) {
			vc_icon_element_fonts_enqueue( $icon_type );
			$iconClass = $args["icon_". $icon_type];
			$icon_html = '<i class="' .  esc_attr($iconClass).' " aria-hidden="true"></i>';
		}
		
		$link_default = array( 'url'    => '', 'title'  => '', 'target' => '_self' );
		
		if ( function_exists( 'vc_build_link' ) && !empty($button_link) ):
			$link = wp_parse_args( vc_build_link( $button_link ), $link_default );
		else:
			$link = $link_default;
		endif;
		
		$link_url 						= '';
		// Fix empty target attribute
		if ( trim( $link['url'] ) != '' ) :
			$link_url = $link['url'];
		endif;
		
		$link_target  				= empty($link['target']) ? '_self':$link['target']; 
		$args['icon_html'] 			= $icon_html;
		$args['link_url'] 			= empty($link_url) ?  'javascript:voide();' : $link_url;
		$args['link_target'] 		= $link_target; 
		
		/* Dynamic Css */
		if( $button_color == 'custom' ){
			$button_css 		= array();
			$style_css 			= '';
			
			$button_css['btn_background'][]	=  !empty ( $button_custom_color ) ? 'background-color:'.$button_custom_color.';' : '';
			$button_css['btn_color'][]	=  !empty ( $button_custom_color ) ? 'color:'.$button_custom_color.';' : '';
			$button_css['btn_background_hover'][]	=  !empty ( $button_custom_color_hover ) ? 'background-color:'.$button_custom_color_hover.';' : '';
			$button_css['btn_txt_hover_color'][]	=  !empty ( $button_custom_color_hover ) ? 'color:'.$button_custom_color_hover.';' : '';
			$button_css['btn_border_color'][]	=  !empty ( $button_custom_color ) ? 'border-color:'.$button_custom_color.';' : '';
			$button_css['btn_border_hover_color'][]	=  !empty ( $button_custom_color_hover ) ? 'border-color:'.$button_custom_color_hover.';' : '';
			
			if( ! empty( $button_css['btn_background'] ) ){
				$style_css .= '#'.$args['id'].' .btn-style-flat{';
				$style_css .= implode(' ', $button_css['btn_background'] );
				$style_css .= '}';
			}
			if( ! empty( $button_css['btn_background_hover'] ) ){
				$style_css .= '#'.$args['id'].' .btn-style-flat:hover{';
				$style_css .= implode(' ', $button_css['btn_background_hover'] );
				$style_css .= '}';
			}
			if( ! empty( $button_css['btn_color'] ) ){
				$style_css .= '#'.$args['id'].' .btn-style-link{';
				$style_css .= implode(' ', $button_css['btn_color'] );
				$style_css .= '}';
			}
			if( ! empty( $button_css['btn_background_hover'] ) ){
				$style_css .= '#'.$args['id'].' .btn-style-outline:hover{';
				$style_css .= implode(' ', $button_css['btn_background_hover'] );
				$style_css .= '}';
			}
			if( ! empty( $button_css['btn_txt_hover_color'] ) ){
				$style_css .= '#'.$args['id'].' .btn-style-link:hover{';
				$style_css .= implode(' ', $button_css['btn_txt_hover_color'] );
				$style_css .= '}';
			}
			if( ! empty( $button_css['btn_border_color'] ) ){
				$style_css .= '#'.$args['id'].' .btn-style-outline, #'.$args['id'].' .btn-style-link{';
				$style_css .= implode(' ', $button_css['btn_border_color'] );
				$style_css .= '}';
			}			
			if( ! empty( $button_css['btn_border_hover_color'] ) ){
				$style_css .= '#'.$args['id'].' .btn-style-outline:hover, #'.$args['id'].' .btn-style-link.btn-color-custom:hover{';
				$style_css .= implode(' ', $button_css['btn_border_hover_color'] );
				$style_css .= '}';
			}			
			kapee_add_custom_css( $style_css );
		}
		
		ob_start();
			kapee_get_pl_templates('shortcodes/button',$args );	
		return ob_get_clean();
	}	
}
new vcButton();