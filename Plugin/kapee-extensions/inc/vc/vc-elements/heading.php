<?php
/*
Element: Heading
*/
class vcHeading extends WPBakeryShortCode {

    function __construct() {
        $this->_mapping();
        add_shortcode( 'kapee_heading', array( $this, '_html' ) );
	}
	public function _mapping() {
		if ( !defined( 'WPB_VC_VERSION' ) ) { return; }
		
		vc_map( array(
			'name'			=> esc_html__( 'Heading', 'kapee-extensions' ),
			'base'			=> 'kapee_heading',
			'category' 		=> esc_html__( 'Kapee', 'kapee-extensions' ),
			'description' 	=> esc_html__( 'Heading and separator.', 'kapee-extensions' ),
        	'icon' 			=> KAPEE_URI.'/inc/admin/assets/images/vc-icon.png',
			'params' 		=> array(
				//General
				array(
					'type' 			=> 'textarea',
					'heading' 		=> esc_html__( 'Title', 'kapee-extensions' ),
					'param_name' 	=> 'title',
					'description' 	=> esc_html__( 'Enter heading title.', 'kapee-extensions' ),
					'admin_label'	=> true,
				),
				array(
					'type' 			=> 'dropdown',
					'param_name' 	=> 'title_tag',
					'heading' 		=> esc_html__( 'Tag', 'kapee-extensions' ),
					'description' 	=> esc_html__( 'Default is H2', 'kapee-extensions' ),
					'value' 		=> array(
						esc_html__( 'H1', 'kapee-extensions' ) 		=> 'h1',
						esc_html__( 'H2', 'kapee-extensions' ) 		=> 'h2',
						esc_html__( 'H3', 'kapee-extensions' ) 		=> 'h3',
						esc_html__( 'H4', 'kapee-extensions' ) 		=> 'h4',
						esc_html__( 'H5', 'kapee-extensions' ) 		=> 'h5',
						esc_html__( 'H6', 'kapee-extensions' ) 		=> 'h6',
						esc_html__( 'Div', 'kapee-extensions' ) 	=> 'div',
						esc_html__( 'p', 'kapee-extensions' ) 		=> 'p',
						esc_html__( 'span', 'kapee-extensions' ) 	=> 'span',
					),
					'std'			=> 'h2',
					'admin_label'   => true,
				),
				array(
					'type' 			=> 'dropdown',					
					'param_name' 	=> 'title_align',
					'heading' 		=> esc_html__( 'Alignment', 'kapee-extensions' ),
					'value' 		=> array(
						esc_html__( 'Left', 'kapee-extensions' ) 	=> 'left',
						esc_html__( 'Center', 'kapee-extensions' ) 	=> 'center',						
						esc_html__( 'Right', 'kapee-extensions' ) 	=> 'right'
					),
					'std'			=> 'center',
					'admin_label'   => true,
					'edit_field_class'	=> 'vc_col-sm-6',
				),
				array(
					'type' 			=> 'dropdown',					
					'param_name' 	=> 'title_width',
					'heading' 		=> esc_html__( 'Title Width', 'kapee-extensions' ),
					'value' 		=> array(
						esc_html__( '10%', 'kapee-extensions' ) 	=> '10',
						esc_html__( '20%', 'kapee-extensions' ) 	=> '20',						
						esc_html__( '30%', 'kapee-extensions' ) 	=> '30',
						esc_html__( '40%', 'kapee-extensions' ) 	=> '40',
						esc_html__( '50%', 'kapee-extensions' ) 	=> '50',
						esc_html__( '60%', 'kapee-extensions' ) 	=> '60',
						esc_html__( '70%', 'kapee-extensions' ) 	=> '70',
						esc_html__( '80%', 'kapee-extensions' ) 	=> '80',
						esc_html__( '90%', 'kapee-extensions' ) 	=> '90',
						esc_html__( '100%', 'kapee-extensions' ) 	=> '100',
					),
					'std'			=> '100',
					'edit_field_class'	=> 'vc_col-sm-6',
				),
				array(
					'type' 				=> 'kapee_number',
					'heading' 			=> esc_html__( 'Font Size in Desktop', 'kapee-extensions' ),
					'param_name' 		=> 'title_font_size',
					'description' 		=> esc_html__( 'Enter font size(px).', 'kapee-extensions' ),
					'std' 				=> '',
					'edit_field_class'	=> 'vc_col-sm-4',
				),
				array(
					'type' 				=> 'kapee_number',
					'heading' 			=> esc_html__( 'Font Size in Tablet', 'kapee-extensions' ),
					'param_name' 		=> 'title_font_size_tablet',
					'description' 		=> esc_html__( 'Enter font size(px).', 'kapee-extensions' ),
					'std' 				=> '',
					'edit_field_class'	=> 'vc_col-sm-4',
				),
				array(
					'type' 				=> 'kapee_number',
					'heading' 			=> esc_html__( 'Font Size in Mobile', 'kapee-extensions' ),
					'param_name' 		=> 'title_font_size_mobile',
					'description' 		=> esc_html__( 'Enter font size(px).', 'kapee-extensions' ),
					'std' 				=> '',
					'edit_field_class'	=> 'vc_col-sm-4',
				),
				array(
					'type' 			=> 'kapee_number',
					'heading' 		=> esc_html__( 'Line Height in Desktop', 'kapee-extensions' ),
					'param_name' 	=> 'title_line_height',
					'description' 	=> esc_html__( 'Enter line height(px).', 'kapee-extensions' ),
					'edit_field_class'	=> 'vc_col-sm-4',
				),
				array(
					'type' 			=> 'kapee_number',
					'heading' 		=> esc_html__( 'Line Height in Tablet', 'kapee-extensions' ),
					'param_name' 	=> 'title_line_height_tabel',
					'description' 	=> esc_html__( 'Enter line height(px).', 'kapee-extensions' ),
					'edit_field_class'	=> 'vc_col-sm-4',
				),
				array(
					'type' 			=> 'kapee_number',
					'heading' 		=> esc_html__( 'Line Height in Mobile', 'kapee-extensions' ),
					'param_name' 	=> 'title_line_height_mobile',
					'description' 	=> esc_html__( 'Enter line height(px).', 'kapee-extensions' ),
					'edit_field_class'	=> 'vc_col-sm-4',
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Font Weight', 'kapee-extensions' ),
					'param_name' 	=> 'title_font_weight',
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
					'edit_field_class'	=> 'vc_col-sm-6',
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Text Transform', 'kapee-extensions' ),
					'param_name' 	=> 'title_text_transform',
					'value' 		=> array( 
						esc_html__( 'Inherit', 'kapee-extensions' ) 	=> 'inherit',
						esc_html__( 'Uppercase', 'kapee-extensions' ) 	=> 'uppercase',
						esc_html__( 'Capitalize', 'kapee-extensions' ) 	=> 'capitalize',
						esc_html__( 'Lowercase', 'kapee-extensions' ) 	=> 'lowercase',
					),
					'std' 			=> 'uppercase',
					'edit_field_class'	=> 'vc_col-sm-6',
				),
				array(
					'type' 			=> 'colorpicker',
					'param_name' 	=> 'title_color',
					'heading' 		=> esc_html__( 'Title Color', 'kapee-extensions' ),
					'description' 	=> esc_html__( 'Select heading color.', 'kapee-extensions' ),
				),
				array(
					'type' 			=> 'dropdown',					
					'param_name' 	=> 'title_separator',
					'heading' 		=> esc_html__( 'Separator', 'kapee-extensions' ),
					'description' 	=> esc_html__( 'Horizontal line or  image to divide sections', 'kapee-extensions' ),
					'value' 		=> array(
						esc_html__( 'None', 'kapee-extensions' ) 		=> 'none',
						esc_html__( 'Underline', 'kapee-extensions' ) 	=> 'underline',
						esc_html__( 'Line', 'kapee-extensions' ) 		=> 'line',						
						esc_html__( 'Image', 'kapee-extensions' ) 		=> 'image',
					),
					'std'			=> 'none',
					'admin_label'   => true,
				),
				array(
					'type'            	=> 'dropdown',
					'heading'         	=> esc_html__( 'Underline Color', 'kapee-extensions' ),
					'param_name'      	=> 'underline_color',
					'value' 			=> array(
						esc_html__( 'Default', 'kapee-extensions') 	=> 'default',
						esc_html__( 'Light', 'kapee-extensions' ) 	=> 'light',
						esc_html__( 'Dark', 'kapee-extensions' ) 	=> 'dark',
					),
					'std'				=>	'default',
					'dependency'	=> array(
						'element' => 'title_separator',
						'value'   => 'underline',
					),
				),
				array(
					'type' 			=> 'dropdown',					
					'param_name' 	=> 'title_separator_position',
					'heading' 		=> esc_html__( 'Separator Position', 'kapee-extensions' ),
					'value' 		=> array(
						esc_html__( 'Between Heading', 'kapee-extensions' ) => 'between-heading',
						esc_html__( 'Bottom Heading', 'kapee-extensions' ) 	=> 'bottom-heading',
					),
					'std'			=> 'between-heading',
					'dependency'	=> array(
						'element' => 'title_separator',
						'value'   => 'line',
					),
				),
				array(
					'type' 			=> 'dropdown',					
					'param_name' 	=> 'separator_line_style',
					'heading' 		=> esc_html__( 'Line Style', 'kapee-extensions' ),
					'value' 		=> array(
						esc_html__( 'Solid', 'kapee-extensions' ) 	=> 'solid',
						esc_html__( 'Dashed', 'kapee-extensions' ) 	=> 'dashed',						
						esc_html__( 'Dotted', 'kapee-extensions' ) 	=> 'dotted',
						esc_html__( 'Double', 'kapee-extensions' ) 	=> 'double',
						esc_html__( 'Inset', 'kapee-extensions' ) 	=> 'inset',
						esc_html__( 'Outset', 'kapee-extensions' ) 	=> 'outset',
					),
					'std'			=> 'solid',
					'dependency'	=> array(
						'element' => 'title_separator',
						'value'   => 'line',
					),
				),
				array(
					'type' 			=> 'kapee_number',
					'param_name' 	=> 'separator_line_width',
					'heading' 		=> esc_html__( 'Line Width', 'kapee-extensions' ),
					'description' 	=> esc_html__( 'Enter line width(px).', 'kapee-extensions' ),
					'std'			=> '1',
					'dependency'	=> array(
						'element' => 'title_separator',
						'value'   => 'line',
					),
				),
				/* array(
					'type' 			=> 'kapee_number',
					'param_name' 	=> 'separator_line_height',
					'heading' 		=> esc_html__( 'Line Height', 'kapee-extensions' ),
					'description' 	=> esc_html__( 'Enter line height(px).', 'kapee-extensions' ),
					'dependency'	=> array(
						'element' => 'title_separator',
						'value'   => 'line',
					),
				), */
				array(
					'type' 			=> 'colorpicker',
					'param_name' 	=> 'separator_line_color',
					'heading' 		=> esc_html__( 'Line Color', 'kapee-extensions' ),
					'std'			=> '#e9e9e9',
					'dependency'	=> array(
						'element' => 'title_separator',
						'value'   => 'line',
					),
				),
				array(
					'type'            => 'attach_image',
					'param_name'      => 'separator_image',
					'heading'         => esc_html__('Select Image', 'kapee-extensions' ),
					'dependency'	=> array(
						'element' => 'title_separator',
						'value'   => 'image',
					),
				),
				array(
					'type' 			=> 'kapee_number',
					'param_name' 	=> 'separator_image_width',
					'heading' 		=> esc_html__( 'Image Width', 'kapee-extensions' ),
					'description' 	=> esc_html__( 'Enter image width(px).', 'kapee-extensions' ),
					'std' 				=> 48,
					'dependency'	=> array(
						'element' => 'title_separator',
						'value'   => 'image',
					),
				),
				array(
					'type' 			=> 'textarea',
					'heading' 		=> esc_html__( 'Sub Title', 'kapee-extensions' ),
					'param_name' 	=> 'sub_title',
					'group' 		=> esc_html__( 'Sub Title', 'kapee-extensions' ),
				),
				array(
					'type' 			=> 'kapee_number',
					'heading' 		=> esc_html__( 'Font Size in Desktop', 'kapee-extensions' ),
					'param_name' 	=> 'subtitle_font_size',
					'description' 	=> esc_html__( 'Enter font size(px).', 'kapee-extensions' ),
					'group' 		=> esc_html__( 'Sub Title', 'kapee-extensions' ),
					'edit_field_class'	=> 'vc_col-sm-4',
				),
				array(
					'type' 			=> 'kapee_number',
					'heading' 		=> esc_html__( 'Font Size in Tablet', 'kapee-extensions' ),
					'param_name' 	=> 'subtitle_font_size_tablet',
					'description' 	=> esc_html__( 'Enter font size(px).', 'kapee-extensions' ),
					'group' 		=> esc_html__( 'Sub Title', 'kapee-extensions' ),
					'edit_field_class'	=> 'vc_col-sm-4',
				),
				array(
					'type' 			=> 'kapee_number',
					'heading' 		=> esc_html__( 'Font Size in Mobile', 'kapee-extensions' ),
					'param_name' 	=> 'subtitle_font_size_mobile',
					'description' 	=> esc_html__( 'Enter font size(px).', 'kapee-extensions' ),
					'group' 		=> esc_html__( 'Sub Title', 'kapee-extensions' ),
					'edit_field_class'	=> 'vc_col-sm-4',
				),
				array(
					'type' 			=> 'kapee_number',
					'heading' 		=> esc_html__( 'Line Height in Desktop', 'kapee-extensions' ),
					'param_name' 	=> 'subtitle_line_height',
					'description' 	=> esc_html__( 'Enter line height(px).', 'kapee-extensions' ),
					'group' 		=> esc_html__( 'Sub Title', 'kapee-extensions' ),
					'edit_field_class'	=> 'vc_col-sm-4',
				),
				array(
					'type' 			=> 'kapee_number',
					'heading' 		=> esc_html__( 'Line Height in Tablet', 'kapee-extensions' ),
					'param_name' 	=> 'subtitle_line_height_tablet',
					'description' 	=> esc_html__( 'Enter line height(px).', 'kapee-extensions' ),
					'group' 		=> esc_html__( 'Sub Title', 'kapee-extensions' ),
					'edit_field_class'	=> 'vc_col-sm-4',
				),
				array(
					'type' 			=> 'kapee_number',
					'heading' 		=> esc_html__( 'Line Height in Mobile', 'kapee-extensions' ),
					'param_name' 	=> 'subtitle_line_height_mobile',
					'description' 	=> esc_html__( 'Enter line height(px).', 'kapee-extensions' ),
					'group' 		=> esc_html__( 'Sub Title', 'kapee-extensions' ),
					'edit_field_class'	=> 'vc_col-sm-4',
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Font Weight', 'kapee-extensions' ),
					'param_name' 	=> 'subtitle_font_weight',
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
					'group' 		=> esc_html__( 'Sub Title', 'kapee-extensions' ),
					'edit_field_class'	=> 'vc_col-sm-6',
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Text Transform', 'kapee-extensions' ),
					'param_name' 	=> 'subtitle_text_transform',
					'value' 		=> array( 
						esc_html__( 'Inherit', 'kapee-extensions' ) 	=> 'inherit',
						esc_html__( 'Uppercase', 'kapee-extensions' ) 	=> 'uppercase',
						esc_html__( 'Capitalize', 'kapee-extensions' ) 	=> 'capitalize',
						esc_html__( 'Lowercase', 'kapee-extensions' ) 	=> 'lowercase',
					),
					'std' 			=> 'uppercase',
					'group' 		=> esc_html__( 'Sub Title', 'kapee-extensions' ),
					'edit_field_class'	=> 'vc_col-sm-6',
				),
				array(
					'type' 			=> 'colorpicker',
					'param_name' 	=> 'subtitle_color',
					'heading' 		=> esc_html__( 'Color', 'kapee-extensions' ),
					'group' 		=> esc_html__( 'Sub Title', 'kapee-extensions' ),
				),
				array(
					'type' 			=> 'textarea',
					'heading' 		=> esc_html__( 'Tag Line', 'kapee-extensions' ),
					'param_name' 	=> 'tagline',
					'group' 		=> esc_html__( 'Tag Line', 'kapee-extensions' ),
				),
				array(
					'type' 			=> 'kapee_number',
					'heading' 		=> esc_html__( 'Font Size in Desktop', 'kapee-extensions' ),
					'param_name' 	=> 'tagline_font_size',
					'description' 	=> esc_html__( 'Enter font size(px).', 'kapee-extensions' ),
					'group' 		=> esc_html__( 'Tag Line', 'kapee-extensions' ),
					'edit_field_class'	=> 'vc_col-sm-4',
				),
				array(
					'type' 			=> 'kapee_number',
					'heading' 		=> esc_html__( 'Font Size in Tablet', 'kapee-extensions' ),
					'param_name' 	=> 'tagline_font_size_tablet',
					'description' 	=> esc_html__( 'Enter font size(px).', 'kapee-extensions' ),
					'group' 		=> esc_html__( 'Tag Line', 'kapee-extensions' ),
					'edit_field_class'	=> 'vc_col-sm-4',
				),
				array(
					'type' 			=> 'kapee_number',
					'heading' 		=> esc_html__( 'Font Size in Mobile', 'kapee-extensions' ),
					'param_name' 	=> 'tagline_font_size_mobile',
					'description' 	=> esc_html__( 'Enter font size(px).', 'kapee-extensions' ),
					'group' 		=> esc_html__( 'Tag Line', 'kapee-extensions' ),
					'edit_field_class'	=> 'vc_col-sm-4',
				),
				array(
					'type' 			=> 'kapee_number',
					'heading' 		=> esc_html__( 'Line Height in Desktop', 'kapee-extensions' ),
					'param_name' 	=> 'tagline_line_height',
					'description' 	=> esc_html__( 'Enter line height(px).', 'kapee-extensions' ),
					'group' 		=> esc_html__( 'Tag Line', 'kapee-extensions' ),
					'edit_field_class'	=> 'vc_col-sm-4',
				),
				array(
					'type' 			=> 'kapee_number',
					'heading' 		=> esc_html__( 'Line Height in Tablet', 'kapee-extensions' ),
					'param_name' 	=> 'tagline_line_height_tablet',
					'description' 	=> esc_html__( 'Enter line height(px).', 'kapee-extensions' ),
					'group' 		=> esc_html__( 'Tag Line', 'kapee-extensions' ),
					'edit_field_class'	=> 'vc_col-sm-4',
				),
				array(
					'type' 			=> 'kapee_number',
					'heading' 		=> esc_html__( 'Line Height in Mobile', 'kapee-extensions' ),
					'param_name' 	=> 'tagline_line_height_mobile',
					'description' 	=> esc_html__( 'Enter line height(px).', 'kapee-extensions' ),
					'group' 		=> esc_html__( 'Tag Line', 'kapee-extensions' ),
					'edit_field_class'	=> 'vc_col-sm-4',
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Font Weight', 'kapee-extensions' ),
					'param_name' 	=> 'tagline_font_weight',
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
					'group' 		=> esc_html__( 'Tag Line', 'kapee-extensions' ),
					'edit_field_class'	=> 'vc_col-sm-6',
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Text Transform', 'kapee-extensions' ),
					'param_name' 	=> 'tagline_text_transform',
					'value' 		=> array( 
						esc_html__( 'Inherit', 'kapee-extensions' ) 	=> 'inherit',
						esc_html__( 'Uppercase', 'kapee-extensions' ) 	=> 'uppercase',
						esc_html__( 'Capitalize', 'kapee-extensions' ) 	=> 'capitalize',
						esc_html__( 'Lowercase', 'kapee-extensions' ) 	=> 'lowercase',
					),
					'std' 			=> 'inherit',
					'group' 		=> esc_html__( 'Tag Line', 'kapee-extensions' ),
					'edit_field_class'	=> 'vc_col-sm-6',
				),
				array(
					'type' 			=> 'colorpicker',
					'param_name' 	=> 'tagline_color',
					'heading' 		=> esc_html__( 'Color', 'kapee-extensions' ),
					'group' 		=> esc_html__( 'Tag Line', 'kapee-extensions' ),
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
			'title' 						=> '',
			'title_tag' 					=> 'h2',
			'title_align' 					=> 'center',
			'title_width' 					=> '100',
			'title_font_size'				=> '',
			'title_font_size_tablet'		=> '',
			'title_font_size_mobile'		=> '',
			'title_line_height' 			=> '',
			'title_line_height_tabel' 		=> '',
			'title_line_height_mobile' 		=> '',
			'title_font_weight' 			=> '600',
			'title_text_transform' 			=> 'uppercase',
			'title_color' 					=> '',
			'title_separator' 				=> 'none',
			'underline_color' 				=> 'default',
			'title_separator_position' 		=> 'between-heading',
			'separator_line_style' 			=> 'solid',
			'separator_line_width' 			=> '1',
			/* 'separator_line_height' 		=> '', */
			'separator_line_color' 			=> '#e9e9e9',
			'separator_image' 				=> '',
			'separator_image_width' 		=> 48,
			'sub_title' 					=> '',
			'subtitle_font_size' 			=> '',
			'subtitle_font_size_tablet' 	=> '',
			'subtitle_font_size_mobile' 	=> '',
			'subtitle_line_height' 			=> '',
			'subtitle_line_height_tablet' 	=> '',
			'subtitle_line_height_mobile' 	=> '',
			'subtitle_font_weight' 		    => '400',
			'subtitle_text_transform' 		=> 'uppercase',
			'subtitle_color' 				=> '',
			'tagline' 						=> '',
			'tagline_font_size' 			=> '',
			'tagline_font_size_tablet' 		=> '',
			'tagline_font_size_mobile' 		=> '',
			'tagline_line_height' 			=> '',
			'tagline_line_height_tablet' 	=> '',
			'tagline_line_height_mobile' 	=> '',
			'tagline_font_weight' 			=> '400',
			'tagline_text_transform' 		=> 'inherit',
			'tagline_color' 				=> '',
			'css_animation' 				=> 'none',
			'el_class' 						=> '',			
			'css' 							=> '',			
		), $atts );		
		extract( $args );
		$args['id'] 			= kapee_uniqid('kapee-header-');		
		$class 					= array();
		$class[]				= 'kapee-element';
		$class[]				= 'kapee-heading';
		$class[]				= $el_class;
		$class[]				= kapee_get_css_animation($css_animation);
		$css_class 				= vc_shortcode_custom_css_class( $css, ' ' );
		$class[]				= $css_class;
		$class[]				= 'text-'.$title_align;
		$class[]				= 'kapee-width-'.$title_width;
		$class[]				= 'separator-'.$title_separator;
		$class[]				= 'separator-'.$title_separator_position;		
		$args['class'] 			= implode(' ', array_filter( $class ) );
		
		if( ! empty( $args['title'] ) ){
			$args['title'] = '<'.$args['title_tag'].' class="heading-title">'.$args['title'].' </'.$args['title_tag'].'>';
		}
		/* Dynamic Css */
		$title_css 							= array();
		$style_css 							= '';		
		$title_css['title'][] 				= !empty($title_font_size) ? 'font-size:'.$title_font_size.'px' : '' ;
		$title_css['title'][] 				= !empty($title_line_height) ? 'line-height:'.$title_line_height.'px' : '' ;
		$title_css['title'][] 				= !empty($title_font_weight) ? 'font-weight:'.$title_font_weight : '' ;
		$title_css['title'][] 				= !empty($title_text_transform) ? 'text-transform:'.$title_text_transform : '' ;
		$title_css['title'][] 				= !empty($title_color) ? 'color:'.$title_color : '' ;
		$title_css['tablet']['title'][] 	= !empty($title_font_size_tablet) ? 'font-size:'.$title_font_size_tablet.'px' : '' ;
		$title_css['tablet']['title'][] 	= !empty($title_line_height_tabel) ? 'line-height:'.$title_line_height_tabel.'px' : '' ;
		$title_css['mobile']['title'][] 	= !empty($title_font_size_mobile) ? 'font-size:'.$title_font_size_mobile.'px' : '' ;
		$title_css['mobile']['title'][] 	= !empty($title_line_height_mobile) ? 'line-height:'.$title_line_height_mobile.'px' : '' ;
		
		$title_css['separator'][] 			= ( !empty($separator_line_style) && 'underline' != $title_separator )  ? 'border-bottom-style:'.$separator_line_style : '';
		$title_css['separator'][] 			= ( !empty($separator_line_style) && 'underline' != $title_separator ) ? 'border-bottom-width:'.$separator_line_width.'px' : '' ;
		$title_css['separator'][] 			= ( !empty($separator_line_style) && 'underline' != $title_separator ) ? 'border-bottom-color:'.$separator_line_color : '' ;
		//$title_css['separator'][] 			= ( !empty($separator_line_style) && 'underline' != $title_separator ) ? 'line-height:'.$separator_line_height.'px' : '' ;
		$args['separator_class'] 				= ( 'underline' == $title_separator && 'default' != $underline_color ) ? ' color-scheme-'.$underline_color : '';
		
		if( $separator_image ){
			$separator_image_src = kapee_get_image_src($separator_image,'full');
			$args['separator_image_src'] = $separator_image_src;
		}
		
		$title_css['subtitle'][] 			= !empty($subtitle_font_size) ? 'font-size:'.$subtitle_font_size.'px' : '' ;
		$title_css['subtitle'][] 			= !empty($subtitle_line_height) ? 'line-height:'.$subtitle_line_height.'px' : '' ;	
		$title_css['subtitle'][] 			= !empty($subtitle_font_weight) ? 'font-weight:'.$subtitle_font_weight : '' ;
		$title_css['subtitle'][] 			= !empty($subtitle_text_transform) ? 'text-transform:'.$subtitle_text_transform : '' ;
		$title_css['subtitle'][] 			= !empty($subtitle_color) ? 'color:'.$subtitle_color : '' ;
		$title_css['tablet']['subtitle'][] 	= !empty($subtitle_font_size_tablet) ? 'font-size:'.$subtitle_font_size_tablet.'px' : '' ;
		$title_css['tablet']['subtitle'][] 	= !empty($subtitle_line_height_tablet) ? 'line-height:'.$subtitle_line_height_tablet.'px' : '' ;
		$title_css['mobile']['subtitle'][] 	= !empty($subtitle_font_size_mobile) ? 'font-size:'.$subtitle_font_size_mobile.'px' : '' ;
		$title_css['mobile']['subtitle'][] 	= !empty($subtitle_line_height_mobile) ? 'line-height:'.$subtitle_line_height_mobile.'px' : '' ;
		
		$title_css['tagline'][] 			= !empty($tagline_font_size) ? 'font-size:'.$tagline_font_size.'px' : '' ;
		$title_css['tagline'][] 			= !empty($tagline_line_height) ? 'line-height:'.$tagline_line_height.'px' : '' ;
		$title_css['tagline'][] 			= !empty($tagline_font_weight) ? 'font-weight:'.$tagline_font_weight : '' ;
		$title_css['tagline'][] 			= !empty($tagline_text_transform) ? 'text-transform:'.$tagline_text_transform : '' ;
		$title_css['tagline'][] 			= !empty($tagline_color) ? 'color:'.$tagline_color : '' ;
		$title_css['tablet']['tagline'][] 	= !empty($tagline_font_size_tablet) ? 'font-size:'.$tagline_font_size_tablet.'px' : '' ;
		$title_css['tablet']['tagline'][] 	= !empty($tagline_line_height_tablet) ? 'line-height:'.$tagline_line_height_tablet.'px' : '' ;
		$title_css['mobile']['tagline'][] 	= !empty($tagline_font_size_mobile) ? 'font-size:'.$tagline_font_size_mobile.'px' : '' ;
		$title_css['mobile']['tagline'][] 	= !empty($tagline_line_height_mobile) ? 'line-height:'.$tagline_line_height_mobile.'px' : '' ;		
		
		if( ! empty( array_filter( $title_css['title'] ) ) ){
			$style_css .= '#'.$args['id'].' .heading-title {';
			$style_css .=  implode('; ', array_filter($title_css['title']));
			$style_css .= '}';
		}
		if( ! empty(array_filter( $title_css['subtitle'] ) ) ){
			$style_css .= '#'.$args['id'].' .heading-subtitle {';
			$style_css .=  implode('; ', array_filter($title_css['subtitle']) );
			$style_css .= '}';
		}
		if( ! empty( array_filter( $title_css['separator'] ) ) ){
			$style_css .= '#'.$args['id'].' .separator-left,#'.$args['id'].' .separator-right {';
			$style_css .=  implode('; ', array_filter($title_css['separator']) );
			$style_css .= '}';
		}
		if( ! empty( $separator_image_width ) ){
			$style_css .= '#'.$args['id'].' .image-separator img {';
			$style_css .=  'width:'.$separator_image_width.'px;';
			$style_css .= '}';
		}
		if(! empty( array_filter( $title_css['tagline'] ) ) ){
			$style_css .= '#'.$args['id'].' .heading-tagline {';
			$style_css .=  implode('; ', array_filter( $title_css['tagline'] ) );
			$style_css .= '}';
		}
		if( ! empty( array_filter( $title_css['tablet'] ) ) ){
			$style_css .= '@media (max-width:991px){';
			if( !empty( array_filter($title_css['tablet']['title']) ) ){
				$style_css .= '#'.$args['id'].' .heading-title {';
				$style_css .=  implode('; ', array_filter( $title_css['tablet']['title'] ) );
				$style_css .= '}';
			}
			if( ! empty( array_filter($title_css['tablet']['subtitle'] ) ) ){
				$style_css .= '#'.$args['id'].' .heading-subtitle {';
				$style_css .=  implode('; ', array_filter( $title_css['tablet']['subtitle'] ) );
				$style_css .= '}';
			}
			if( ! empty( array_filter($title_css['tablet']['tagline'] ) ) ){
				$style_css .= '#'.$args['id'].' .heading-tagline {';
				$style_css .=  implode('; ', array_filter( $title_css['tablet']['tagline'] ) );
				$style_css .= '}';
			}
			$style_css .= '}';
		}
		if( ! empty( array_filter( $title_css['mobile'] ) ) ){
			$style_css .= '@media (max-width:640px){';
			if( !empty( array_filter($title_css['mobile']['title']) ) ){
				$style_css .= '#'.$args['id'].' .heading-title {';
				$style_css .=  implode('; ', array_filter( $title_css['mobile']['title'] ) );
				$style_css .= '}';
			}
			if( ! empty( array_filter($title_css['mobile']['subtitle'] ) ) ){
				$style_css .= '#'.$args['id'].' .heading-subtitle {';
				$style_css .=  implode('; ', array_filter( $title_css['mobile']['subtitle'] ) );
				$style_css .= '}';
			}
			if( ! empty( array_filter($title_css['mobile']['tagline'] ) ) ){
				$style_css .= '#'.$args['id'].' .heading-tagline {';
				$style_css .=  implode('; ', array_filter( $title_css['mobile']['tagline'] ) );
				$style_css .= '}';
			}
			$style_css .= '}';
		}
		kapee_add_custom_css( $style_css );
		ob_start();
			kapee_get_pl_templates( 'shortcodes/heading', $args );	
		return ob_get_clean();
	}	
}
new vcHeading();
