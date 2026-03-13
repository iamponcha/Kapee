<?php
/**
 * Element: Countdown
 */
class vcCountdown extends WPBakeryShortCode {

    function __construct() {
        $this->_mapping();
        add_shortcode( 'kapee_countdown', array( $this, '_html' ) );
	}
	public function _mapping() {
		if ( !defined( 'WPB_VC_VERSION' ) ) { return; }		
		vc_map( array(
			'name'			=> esc_html__( 'Countdown Timer', 'kapee-extensions' ),
			'base'			=> 'kapee_countdown',
			'category' 		=> esc_html__( 'Kapee', 'kapee-extensions' ),
			'description' 	=> esc_html__( 'Show countdown timer.', 'kapee-extensions' ),
        	'icon' 			=> KAPEE_URI.'/inc/admin/assets/images/vc-icon.png',
			'params' 		=> array(
				//General
				array(
					'type'        	=> 'dropdown',
					'param_name'  	=> 'align',
					'admin_label' 	=> true,
					'heading'     	=> esc_html__( 'Align', 'kapee-extensions' ),
					'value'       	=> array(
						esc_html__( 'Left', 'kapee-extensions' )       => 'left',
						esc_html__( 'Center', 'kapee-extensions' )  => 'center',
						esc_html__( 'Right', 'kapee-extensions' )  => 'right'
					),
					'std' 			=> 'center',
				),	
				array(
					'type' 			=> 'textfield',
					'heading' 		=> esc_html__( 'Date', 'kapee-extensions' ),
					'param_name' 	=> 'input_datetime',
					'description' 	=> esc_html__( 'Enter the date by format: YYYY-MM-DD', 'kapee-extensions' ),
					'admin_label'	=> true,
				),
				( function_exists( 'vc_map_add_css_animation' ) ) ? vc_map_add_css_animation( true ) : '',
				array(
					'type' 			=> 'textfield',
					'heading' 		=> esc_html__( 'Extra class name', 'kapee-extensions' ),
					'param_name' 	=> 'el_class',
					'description' 	=> esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'kapee-extensions' )
				),
				array(
					'type' 			=> 'kapee_title',
					'param_name' 	=> 'kapee_title',
					'class' 		=> '',
					'content' 		=> esc_html__( 'Coundown Box', 'kapee-extensions' ),
					'group' 		=> esc_html__( 'Typography', 'kapee-extensions' )
				),
				array(
					'type'            => 'dropdown',
					'heading'         => esc_html__( 'Border Style', 'kapee-extensions' ),
					'param_name'      => 'box_border_style',
					'value' 		=> array(
						esc_html__('None', 'kapee-extensions') 		=> 'none',
						esc_html__( 'Solid', 'kapee-extensions' ) 	=> 'solid',
						esc_html__( 'Dashed', 'kapee-extensions' ) 	=> 'dashed',						
						esc_html__( 'Dotted', 'kapee-extensions' ) 	=> 'dotted',
						esc_html__( 'Double', 'kapee-extensions' ) 	=> 'double',
						esc_html__( 'Inset', 'kapee-extensions' ) 	=> 'inset',
						esc_html__( 'Outset', 'kapee-extensions' ) 	=> 'outset',
					),
					'std'	=>	'none',
					'group' 		=> esc_html__( 'Typography', 'kapee-extensions' )
				),
				array(
					"type"       	=> "kapee_number",
					"param_name" 	=> "box_border_width",
					"heading"    	=> esc_html__("Border Width", 'kapee-extensions' ),
					'std' 			=> '2',
					'group' 		=> esc_html__( 'Typography', 'kapee-extensions' )
				),
				array(
					'type'            => 'colorpicker',
					'heading'         => esc_html__( 'Border Color', 'kapee-extensions' ),
					'param_name'      => 'box_border_color',
					'std' 			=> '#e9e9e9',
					'group' 		=> esc_html__( 'Typography', 'kapee-extensions' )
				),
				array(
					'type'            => 'colorpicker',
					'heading'         => esc_html__( 'Background Color', 'kapee-extensions' ),
					'param_name'      => 'box_background_color',
					'std' 			=> '#ffffff',
					'group' 		=> esc_html__( 'Typography', 'kapee-extensions' )
				),
				array(
					"type"       	=> "kapee_number",
					"param_name" 	=> "box_size",
					"heading"    	=> esc_html__("Box Size in Desktop", 'kapee-extensions' ),
					'description' 	=> esc_html__( 'Enter box size(px).', 'kapee-extensions' ),
					'std' 			=> '70',
					'group' 		=> esc_html__( 'Typography', 'kapee-extensions' ),
					"edit_field_class"	=> "vc_col-sm-4",
				),
				array(
					"type"       	=> "kapee_number",
					"param_name" 	=> "box_size_tablet",
					"heading"    	=> esc_html__("Box Size in Tablet", 'kapee-extensions' ),
					'description' 	=> esc_html__( 'Enter box size(px).', 'kapee-extensions' ),
					'std' 			=> '',
					'group' 		=> esc_html__( 'Typography', 'kapee-extensions' ),
					"edit_field_class"	=> "vc_col-sm-4",
				),
				array(
					"type"       	=> "kapee_number",
					"param_name" 	=> "box_size_mobile",
					"heading"    	=> esc_html__("Box Size in Mobile", 'kapee-extensions' ),
					'description' 	=> esc_html__( 'Enter box size(px).', 'kapee-extensions' ),
					'std' 			=> '',
					'group' 		=> esc_html__( 'Typography', 'kapee-extensions' ),
					"edit_field_class"	=> "vc_col-sm-4",
				),
				array(
					"type"       	=> "kapee_number",
					"param_name" 	=> "box_radius",
					"heading"    	=> esc_html__("Box Radius", 'kapee-extensions' ),
					'group' 		=> esc_html__( 'Typography', 'kapee-extensions' )
				),
				array(
					'type' 			=> 'kapee_title',
					'param_name' 	=> 'kapee_title',
					'class' 		=> '',
					'content' 		=> esc_html__( 'Coundown Numbers', 'kapee-extensions' ),
					'group' 		=> esc_html__( 'Typography', 'kapee-extensions' )
				),
				array(
					"type"       	=> "kapee_number",
					"param_name" 	=> "number_font_size",
					"heading"    	=> esc_html__("Font Size in Desktop", 'kapee-extensions' ),
					'description' 	=> esc_html__( 'Enter font size(px).', 'kapee-extensions' ),
					'std' 			=> '28',
					'group' 		=> esc_html__( 'Typography', 'kapee-extensions' ),
					"edit_field_class"	=> "vc_col-sm-4",
				),
				array(
					"type"       	=> "kapee_number",
					"param_name" 	=> "number_font_size_tablet",
					"heading"    	=> esc_html__("Font Size in Tablet", 'kapee-extensions' ),
					'description' 	=> esc_html__( 'Enter font size(px).', 'kapee-extensions' ),
					'std' 			=> '',
					'group' 		=> esc_html__( 'Typography', 'kapee-extensions' ),
					"edit_field_class"	=> "vc_col-sm-4",
				),
				array(
					"type"       	=> "kapee_number",
					"param_name" 	=> "number_font_size_mobile",
					"heading"    	=> esc_html__("Font Size in Mobile", 'kapee-extensions' ),
					'description' 	=> esc_html__( 'Enter font size(px).', 'kapee-extensions' ),
					'std' 			=> '',
					'group' 		=> esc_html__( 'Typography', 'kapee-extensions' ),
					"edit_field_class"	=> "vc_col-sm-4",
				),
				array(
					"type"       	=> "kapee_number",
					"param_name" 	=> "number_line_height",
					"heading"    	=> esc_html__("Line Height in Desktop", 'kapee-extensions' ),
					'description' 	=> esc_html__( 'Enter line height(px).', 'kapee-extensions' ),
					'std' 			=> '',
					'group' 		=> esc_html__( 'Typography', 'kapee-extensions' ),
					"edit_field_class"	=> "vc_col-sm-4",
				),
				array(
					"type"       	=> "kapee_number",
					"param_name" 	=> "number_line_height_tablet",
					"heading"    	=> esc_html__("Line Height in Tablet", 'kapee-extensions' ),
					'description' 	=> esc_html__( 'Enter line height(px).', 'kapee-extensions' ),
					'std' 			=> '',
					'group' 		=> esc_html__( 'Typography', 'kapee-extensions' ),
					"edit_field_class"	=> "vc_col-sm-4",
				),
				array(
					"type"       	=> "kapee_number",
					"param_name" 	=> "number_line_height_mobile",
					"heading"    	=> esc_html__("Line Height in Mobile", 'kapee-extensions' ),
					'description' 	=> esc_html__( 'Enter line height(px).', 'kapee-extensions' ),
					'std' 			=> '',
					'group' 		=> esc_html__( 'Typography', 'kapee-extensions' ),
					"edit_field_class"	=> "vc_col-sm-4",
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Font Weight', 'kapee-extensions' ),
					'param_name' 	=> 'number_font_weight',
					'value' 		=> array( 
						esc_html__( '100', 'kapee-extensions' ) 	=> '100',
						esc_html__( '200', 'kapee-extensions' ) 	=> '200',
						esc_html__( '300', 'kapee-extensions' ) 	=> '300',
						esc_html__( '400', 'kapee-extensions' ) 	=> '400',
						esc_html__( '500', 'kapee-extensions' ) 	=> '500',
						esc_html__( '600', 'kapee-extensions' ) 	=> '600',
						esc_html__( '700', 'kapee-extensions' ) 	=> '700',
						esc_html__( '800', 'kapee-extensions' ) 	=> '800',
						esc_html__( '900', 'kapee-extensions' ) 	=> '900',
					),
					'std' 			=> '600',
					'group' 		=> esc_html__( 'Typography', 'kapee-extensions' ),
				),
				array(
					'type'            => 'colorpicker',
					'heading'         => esc_html__( 'Color', 'kapee-extensions' ),
					'param_name'      => 'number_color',
					'std' 			=> '#333333',
					'group' 		=> esc_html__( 'Typography', 'kapee-extensions' )
				),
				array(
					'type' 			=> 'kapee_title',
					'param_name' 	=> 'kapee_title',
					'class' 		=> '',
					'content' 		=> esc_html__( 'Coundown Text', 'kapee-extensions' ),
					'group' 		=> esc_html__( 'Typography', 'kapee-extensions' )
				),
				array(
					"type"       	=> "kapee_number",
					"param_name" 	=> "text_font_size",
					"heading"    	=> esc_html__("Font Size in Desktop", 'kapee-extensions' ),
					'description' 	=> esc_html__( 'Enter font size(px).', 'kapee-extensions' ),
					'std' 			=> '12',
					'group' 		=> esc_html__( 'Typography', 'kapee-extensions' ),
					"edit_field_class"	=> "vc_col-sm-4",
				),
				array(
					"type"       	=> "kapee_number",
					"param_name" 	=> "text_font_size_tablet",
					"heading"    	=> esc_html__("Font Size in Tablet", 'kapee-extensions' ),
					'description' 	=> esc_html__( 'Enter font size(px).', 'kapee-extensions' ),
					'std' 			=> '',
					'group' 		=> esc_html__( 'Typography', 'kapee-extensions' ),
					"edit_field_class"	=> "vc_col-sm-4",
				),
				array(
					"type"       	=> "kapee_number",
					"param_name" 	=> "text_font_size_mobile",
					"heading"    	=> esc_html__("Font Size in Mobile", 'kapee-extensions' ),
					'description' 	=> esc_html__( 'Enter font size(px).', 'kapee-extensions' ),
					'std' 			=> '',
					'group' 		=> esc_html__( 'Typography', 'kapee-extensions' ),
					"edit_field_class"	=> "vc_col-sm-4",
				),
				array(
					"type"       	=> "kapee_number",
					"param_name" 	=> "text_line_height",
					"heading"    	=> esc_html__("Line Height in Desktop", 'kapee-extensions' ),
					'description' 	=> esc_html__( 'Enter line height(px).', 'kapee-extensions' ),
					'std' 			=> '',
					'group' 		=> esc_html__( 'Typography', 'kapee-extensions' ),
					"edit_field_class"	=> "vc_col-sm-4",
				),
				array(
					"type"       	=> "kapee_number",
					"param_name" 	=> "text_line_height_tablet",
					"heading"    	=> esc_html__("Line Height in Tablet", 'kapee-extensions' ),
					'description' 	=> esc_html__( 'Enter line height(px).', 'kapee-extensions' ),
					'std' 			=> '',
					'group' 		=> esc_html__( 'Typography', 'kapee-extensions' ),
					"edit_field_class"	=> "vc_col-sm-4",
				),
				array(
					"type"       	=> "kapee_number",
					"param_name" 	=> "text_line_height_mobile",
					"heading"    	=> esc_html__("Line Height in Mobile", 'kapee-extensions' ),
					'description' 	=> esc_html__( 'Enter line height(px).', 'kapee-extensions' ),
					'std' 			=> '',
					'group' 		=> esc_html__( 'Typography', 'kapee-extensions' ),
					"edit_field_class"	=> "vc_col-sm-4",
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Font Weight', 'kapee-extensions' ),
					'param_name' 	=> 'text_font_weight',
					'value' 		=> array( 
						esc_html__( '100', 'kapee-extensions' ) 	=> '100',
						esc_html__( '200', 'kapee-extensions' ) 	=> '200',
						esc_html__( '300', 'kapee-extensions' ) 	=> '300',
						esc_html__( '400', 'kapee-extensions' ) 	=> '400',
						esc_html__( '500', 'kapee-extensions' ) 	=> '500',
						esc_html__( '600', 'kapee-extensions' ) 	=> '600',
						esc_html__( '700', 'kapee-extensions' ) 	=> '700',
						esc_html__( '800', 'kapee-extensions' ) 	=> '800',
						esc_html__( '900', 'kapee-extensions' ) 	=> '900',
					),
					'std' 			=> '400',
					'group' 		=> esc_html__( 'Typography', 'kapee-extensions' ),
					'edit_field_class'	=> 'vc_col-sm-6',
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Text Transform', 'kapee-extensions' ),
					'param_name' 	=> 'text_transform',
					'value' 		=> array( 
						esc_html__( 'Inherit', 'kapee-extensions' ) 	=> 'inherit',
						esc_html__( 'Uppercase', 'kapee-extensions' ) 	=> 'uppercase',
						esc_html__( 'Capitalize', 'kapee-extensions' ) 	=> 'capitalize',
						esc_html__( 'Lowercase', 'kapee-extensions' ) 	=> 'lowercase',
					),
					'std' 			=> 'inherit',
					'group' 		=> esc_html__( 'Typography', 'kapee-extensions' ),
					'edit_field_class'	=> 'vc_col-sm-6',
				),
				array(
					'type'            => 'colorpicker',
					'heading'         => esc_html__( 'Color', 'kapee-extensions' ),
					'param_name'      => 'text_color',
					'std' 			=> '#555555',
					'group' 		=> esc_html__( 'Typography', 'kapee-extensions' )
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
			'align' 					=> 'center',
			'input_datetime' 			=> '',
			'box_border_style' 			=> 'none',
			'box_border_width' 			=> '2',
			'box_border_color' 			=> '#e9e9e9',
			'box_background_color' 		=> '#ffffff',
			'box_size' 					=> '70',
			'box_size_tablet' 			=> '',
			'box_size_mobile' 			=> '',
			'box_radius' 				=> '',
			'number_font_size' 			=> '28',
			'number_font_size_tablet' 	=> '',
			'number_font_size_mobile' 	=> '',
			'number_line_height' 		=> '',
			'number_line_height_tablet' => '',
			'number_line_height_mobile' => '',
			'number_font_weight' 		=> '600',
			'number_color' 				=> '#333333',
			'text_font_size' 			=> '12',
			'text_font_size_tablet' 	=> '',
			'text_font_size_mobile' 	=> '',
			'text_line_height' 			=> '',
			'text_line_height_tablet' 	=> '',
			'text_line_height_mobile' 	=> '',
			'text_font_weight' 			=> '400',
			'text_transform' 			=> 'inherit',
			'text_color' 				=> '#555555',
			'css_animation' 			=> 'none',	
			'el_class' 					=> '',
			'css' 						=> '',				
		), $atts ) );
		extract($args);
		$args['id'] 				= kapee_uniqid('kapee-countdown-');
		$class						= array('kapee-element', 'kapee-countdown' );
		$class[]					= 'countdown-simple';
		$class[]					= 'text-'.$align;
		$class[]					= $el_class;
		$class[]					= kapee_get_css_animation($css_animation);
		$css_class 					= vc_shortcode_custom_css_class( $css, ' ' );
		$class[]					= $css_class;
		
		$args['class'] 				= implode(' ', array_filter( $class ) ); 
		$args['countdown_style'] 	= 'countdown-box';
		$args['timezone'] 			= kapee_timezone_string();
		$args['date'] 				= strtotime($input_datetime) + ( 24 * 60 * 60 );/* Add one day*/
		
		$countdown_css 				= array();
		$style_css 					= '';
		if( 'none' != $box_border_style ) {
			$countdown_css['number'][] = !empty ( $box_border_style ) ? 'border-style : '.$box_border_style.';' : '';
			$countdown_css['number'][] = !empty ( $box_border_width ) ? 'border-width : '.$box_border_width.'px;' : '';
			$countdown_css['number'][] = !empty ( $box_border_color ) ? 'border-color : '.$box_border_color.';' : '';
		}
		$countdown_css['number'][] = !empty ( $box_size ) ? 'min-width : '.$box_size.'px;' : '';
		$countdown_css['number'][] = !empty ( $box_size ) ? 'min-height : '.$box_size.'px;' : '';
		$countdown_css['number'][] = !empty ( $box_radius ) ? 'border-radius : '.$box_radius.'px;' : '';
		$countdown_css['number'][] = !empty ( $box_background_color ) ? 'background-color : '.$box_background_color.';' : '';
		$countdown_css['number'][] = !empty ( $number_font_size ) ? 'font-size : '.$number_font_size.'px;' : '';
		$countdown_css['tablet']['number'][] = !empty ( $box_size_tablet ) ? 'min-width : '.$box_size_tablet.'px;' : '';
		$countdown_css['tablet']['number'][] = !empty ( $box_size_tablet ) ? 'min-height : '.$box_size_tablet.'px;' : '';
		$countdown_css['mobile']['number'][] = !empty ( $box_size_mobile ) ? 'min-width : '.$box_size_mobile.'px;' : '';
		$countdown_css['mobile']['number'][] = !empty ( $box_size_mobile ) ? 'min-height : '.$box_size_mobile.'px;' : '';
		$countdown_css['tablet']['number'][] = !empty ( $number_font_size_tablet ) ? 'font-size : '.$number_font_size_tablet.'px;' : '';
		$countdown_css['mobile']['number'][] = !empty ( $number_font_size_mobile ) ? 'font-size : '.$number_font_size_mobile.'px;' : '';
		$countdown_css['number'][] = !empty ( $number_line_height ) ? 'line-height : '.$number_line_height.'px;' : '';
		$countdown_css['tablet']['number'][] = !empty ( $number_line_height_tablet ) ? 'line-height : '.$number_line_height_tablet.'px;' : '';
		$countdown_css['mobile']['number'][] = !empty ( $number_line_height_mobile ) ? 'line-height : '.$number_line_height_mobile.'px;' : '';
		$countdown_css['number'][] = !empty ( $number_font_weight ) ? 'font-weight: '.$number_font_weight.';' : '' ;
		$countdown_css['number'][] = !empty ( $number_color ) ? 'color : '.$number_color.';' : '';
		
		$countdown_css['text'][] = !empty ( $text_font_size ) ? 'font-size : '.$text_font_size.'px;' : '';
		$countdown_css['tablet']['text'][] = !empty ( $text_font_size_tablet ) ? 'font-size : '.$text_font_size_tablet.'px;' : '';
		$countdown_css['mobile']['text'][] = !empty ( $text_font_size_mobile ) ? 'font-size : '.$text_font_size_mobile.'px;' : '';
		$countdown_css['text'][] = !empty ( $text_line_height ) ? 'line-height : '.$text_line_height.'px;' : '';
		$countdown_css['tablet']['text'][] = !empty ( $text_line_height_tablet ) ? 'line-height : '.$text_line_height_tablet.'px;' : '';
		$countdown_css['mobile']['text'][] = !empty ( $text_line_height_mobile ) ? 'line-height : '.$text_line_height_mobile.'px;' : '';
		$countdown_css['text'][] = !empty ( $text_font_weight ) ? 'font-weight: '.$text_font_weight.';' : '' ;
		$countdown_css['text'][] = !empty ( $text_transform ) ? 'text-transform:'.$text_transform.';' : '' ;
		$countdown_css['text'][] = !empty ( $text_color ) ? 'color : '.$text_color.';' : '';
		
		if( ! empty( array_filter(  $countdown_css['number'] ) ) ){
			$style_css .= '#'.$args['id'].'.kapee-countdown .product-countdown > span {';
			$style_css .= implode(' ',  array_filter( $countdown_css['number'] ) );
			$style_css .= '}';
		}
		if( ! empty( array_filter( $countdown_css['text'] ) ) ){
			$style_css .= '#'.$args['id'].'.kapee-countdown .product-countdown > span span {';
			$style_css .= implode(' ',  array_filter( $countdown_css['text'] ) );
			$style_css .= '}';			
		}
		if( ! empty( array_filter( $countdown_css['tablet'] ) ) ){
			$style_css .= '@media (max-width:991px){';
			if( !empty( array_filter($countdown_css['tablet']['number']) ) ){
				$style_css .= '#'.$args['id'].'.kapee-countdown .product-countdown > span {';
				$style_css .=  implode('; ', array_filter( $countdown_css['tablet']['number'] ) );
				$style_css .= '}';
			}	
			if( !empty( array_filter($countdown_css['tablet']['text']) ) ){
				$style_css .= '#'.$args['id'].'.kapee-countdown .product-countdown > span span {';
				$style_css .=  implode('; ', array_filter( $countdown_css['tablet']['text'] ) );
				$style_css .= '}';
			}			
			$style_css .= '}';
		}
		if( ! empty( array_filter( $countdown_css['mobile'] ) ) ){
			$style_css .= '@media (max-width:640px){';
			if( !empty( array_filter($countdown_css['mobile']['number']) ) ){
				$style_css .= '#'.$args['id'].'.kapee-countdown .product-countdown > span {';
				$style_css .=  implode('; ', array_filter( $countdown_css['mobile']['number'] ) );
				$style_css .= '}';
			}	
			if( !empty( array_filter($countdown_css['mobile']['text']) ) ){
				$style_css .= '#'.$args['id'].'.kapee-countdown .product-countdown > span span {';
				$style_css .=  implode('; ', array_filter( $countdown_css['mobile']['text'] ) );
				$style_css .= '}';
			}
			$style_css .= '}';
		}
		kapee_add_custom_css( $style_css );
		wp_enqueue_script( 'countdown' );
		ob_start();
			kapee_get_pl_templates('shortcodes/countdown',$args );	
		return ob_get_clean();
	}	
}
new vcCountdown();