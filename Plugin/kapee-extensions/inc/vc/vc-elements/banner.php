<?php
/*
 * Element: Banner
 */
class vcBanner extends WPBakeryShortCode {

    function __construct() {
        $this->_mapping();
        add_shortcode( 'kapee_banner', array( $this, '_html' ) );
	}
	public function _mapping() {
		if ( !defined( 'WPB_VC_VERSION' ) ) { return; }
		$image_sizes 		= kapee_get_all_image_sizes(true);
		array_shift($image_sizes);
		vc_map( array(
			'name'			=> esc_html__( 'Banner', 'kapee-extensions' ),
			'base'			=> 'kapee_banner',
			'category' 		=> esc_html__( 'Kapee', 'kapee-extensions' ),
			'description' 	=> esc_html__( 'Display banners.', 'kapee-extensions' ),
        	'icon' 			=> KAPEE_URI.'/inc/admin/assets/images/vc-icon.png',
			'params' 		=> array(
				//General
				array(
					"type"            	=> "attach_image",
					"heading"         	=> esc_html__("Banner Image", 'kapee-extensions'),
					"param_name"      	=> "banner_image",
				),
				array(
					'type'			=> 'dropdown',
					'heading'		=> esc_html__( 'Banner Image Size', 'kapee-extensions' ),
					'param_name'	=> 'banner_image_size',
					'std'			=> 'full',
					'value'			=> array_flip($image_sizes),
				),
				array(
					'type' 				=> 'vc_link',
					'heading' 			=> esc_html__( 'Banner Link', 'kapee-extensions'),
					'param_name' 		=> 'banner_link',
					'edit_field_class'	=> 'vc_col-sm-6 vc_column',
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Hover Style', 'kapee-extensions' ),
					'param_name' 	=> 'banner_hover_effect',
					'value' 		=> array(
						esc_html__( 'None', 'kapee-extensions' ) => '',
						esc_html__( 'Zoom In', 'kapee-extensions' ) => 'zoom-in',
						esc_html__( 'Zoom Out', 'kapee-extensions' ) => 'zoom-out',
					),
					'std' 			=> 'zoom-out',
					'description' 	=> esc_html__( 'Select banner hover effect.', 'kapee-extensions' ),
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Banner Content Width', 'kapee-extensions' ),
					'param_name' 	=> 'banner_content_width',
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
						esc_html__( '100%', 'kapee-extensions' ) => '100',
					),
					'std' 			=> '70',
					'description' 	=> esc_html__( 'Select banner content width.', 'kapee-extensions' ),
				),				
				array(
					"type"       	=> "kapee_number",
					"param_name" 	=> "banner_content_padding_top_bottom",
					"heading"    	=> esc_html__("Padding Top Bottom", 'kapee-extensions' ),
					'description' 	=> esc_html__( 'Content padding top bottom(px).', 'kapee-extensions' ),
					'std' 			=> '',
					'edit_field_class'	=> 'vc_col-sm-6',
				),
				array(
					"type"       	=> "kapee_number",
					"param_name" 	=> "banner_content_padding_left_right",
					"heading"    	=> esc_html__("Padding Left Right", 'kapee-extensions' ),
					'description' 	=> esc_html__( 'Content padding left right(px).', 'kapee-extensions' ),
					'std' 			=> '',
					'edit_field_class'	=> 'vc_col-sm-6',
				),
				array(
					'type'          => 'colorpicker',
					'param_name'    => 'banner_content_bg_color',
					'heading'       => esc_html__( 'Background Color', 'kapee-extensions' ),
					'description' 	=> esc_html__( 'Content background color.', 'kapee-extensions' ),
					'std' 			=> '',
				),
				( function_exists( 'vc_map_add_css_animation' ) ) ? vc_map_add_css_animation( true ) : '',
				array(
					'type' 			=> 'textfield',
					'heading' 		=> esc_html__( 'Extra class name', 'kapee-extensions' ),
					'param_name' 	=> 'el_class',
					'description' 	=> esc_html__( 'If you wish to style particular content element differently, then use
					this field to add a class name and then refer to it in your css file.', 'kapee-extensions' )
				),
				array(
					'type' 			=> 'kapee_title',
					'param_name' 	=> 'section_title',
					'class' 		=> '',
					'content' 		=> esc_html__( 'Banner Title', 'kapee-extensions' ),
					'group' 		=> esc_html__( 'Title & Subtitle', 'kapee-extensions' )
				),
				array(
					"type" 			=> "textarea",
					"heading" 		=> esc_html__( "Title", 'kapee-extensions' ),
					"param_name" 	=> "title",
					"admin_label"   => true,
					"description"   => esc_html__( "Enter title", 'kapee-extensions' ),
					'std' 			=> '',
					'group' 		=> esc_html__( 'Title & Subtitle', 'kapee-extensions' ),
				),				
				array(
					"type"       	=> "kapee_number",
					"param_name" 	=> "title_font_size",
					"heading"    	=> esc_html__("Font Size in Desktop", 'kapee-extensions' ),
					'description' 	=> esc_html__( 'Enter font size(px).', 'kapee-extensions' ),
					'std' 			=> '26',
					'edit_field_class'	=> 'vc_col-sm-4',
					'group' 		=> esc_html__( 'Title & Subtitle', 'kapee-extensions' )
				),
				array(
					'type' 			=> 'kapee_number',
					'heading' 		=> esc_html__( 'Font Size in Tablet', 'kapee-extensions' ),
					'param_name' 	=> 'title_font_size_tablet',
					'description' 	=> esc_html__( 'Enter font size(px).', 'kapee-extensions' ),
					'group' 		=> esc_html__( 'Title & Subtitle', 'kapee-extensions' ),
					'edit_field_class'	=> 'vc_col-sm-4',
				),
				array(
					'type' 			=> 'kapee_number',
					'heading' 		=> esc_html__( 'Font Size in Mobile', 'kapee-extensions' ),
					'param_name' 	=> 'title_font_size_mobile',
					'description' 	=> esc_html__( 'Enter font size(px).', 'kapee-extensions' ),
					'group' 		=> esc_html__( 'Title & Subtitle', 'kapee-extensions' ),		
					'edit_field_class'	=> 'vc_col-sm-4',
				),
				array(
					"type"       	=> "kapee_number",
					"param_name" 	=> "title_line_height",
					"heading"    	=> esc_html__("Line Height in Desktop", 'kapee-extensions' ),
					'description' 	=> esc_html__( 'Enter line height(px).', 'kapee-extensions' ),
					'std' 			=> '',
					'group' 		=> esc_html__( 'Title & Subtitle', 'kapee-extensions' ),
					'edit_field_class'	=> 'vc_col-sm-4',
				),
				array(
					"type"       	=> "kapee_number",
					"param_name" 	=> "title_line_height_tablet",
					"heading"    	=> esc_html__("Line Height in Tablet", 'kapee-extensions' ),
					'description' 	=> esc_html__( 'Enter line height(px).', 'kapee-extensions' ),
					'std' 			=> '',
					'group' 		=> esc_html__( 'Title & Subtitle', 'kapee-extensions' ),
					'edit_field_class'	=> 'vc_col-sm-4',
				),
				array(
					"type"       	=> "kapee_number",
					"param_name" 	=> "title_line_height_mobile",
					"heading"    	=> esc_html__("Line Height in Mobile", 'kapee-extensions' ),
					'description' 	=> esc_html__( 'Enter line height(px).', 'kapee-extensions' ),
					'std' 			=> '',
					'group' 		=> esc_html__( 'Title & Subtitle', 'kapee-extensions' ),
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
					'std' 			=> '700',
					'group' 		=> esc_html__( 'Title & Subtitle', 'kapee-extensions' ),
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
					'group' 		=> esc_html__( 'Title & Subtitle', 'kapee-extensions' ),
					'edit_field_class'	=> 'vc_col-sm-6',
				),
				array(
					'type'          => 'colorpicker',
					'heading'       => esc_html__( 'Color', 'kapee-extensions' ),
					'param_name'    => 'title_color',
					'std' 			=> '#333333',
					'group' 		=> esc_html__( 'Title & Subtitle', 'kapee-extensions' )
				),
				array(
					'type' 			=> 'kapee_title',
					'param_name' 	=> 'section_subtitle',
					'class' 		=> '',
					'content' 		=> esc_html__( 'Banner Sub Title', 'kapee-extensions' ),
					'group' 		=> esc_html__( 'Title & Subtitle', 'kapee-extensions' )
				),
				array(
					"type" 			=> "textarea",
					"heading" 		=> esc_html__( "Subtitle", 'kapee-extensions' ),
					"param_name" 	=> "subtitle",
					"description"   => esc_html__( "Enter subtitle", 'kapee-extensions' ),
					'std' 			=> '',
					'group' 		=> esc_html__( 'Title & Subtitle', 'kapee-extensions' ),
				),
				array(
					"type"       	=> "kapee_number",
					"param_name" 	=> "subtitle_font_size",
					"heading"    	=> esc_html__("Font Size in Desktop", 'kapee-extensions' ),
					'description' 	=> esc_html__( 'Enter font size(px).', 'kapee-extensions' ),
					'std' 			=> '16',
					'group' 		=> esc_html__( 'Title & Subtitle', 'kapee-extensions' ),
					'edit_field_class'	=> 'vc_col-sm-4',
				),
				array(
					'type' 			=> 'kapee_number',
					'heading' 		=> esc_html__( 'Font Size in Tablet', 'kapee-extensions' ),
					'param_name' 	=> 'subtitle_font_size_tablet',
					'description' 	=> esc_html__( 'Enter font size(px).', 'kapee-extensions' ),
					'group' 		=> esc_html__( 'Title & Subtitle', 'kapee-extensions' ),
					'edit_field_class'	=> 'vc_col-sm-4',
				),
				array(
					'type' 			=> 'kapee_number',
					'heading' 		=> esc_html__( 'Font Size in Mobile', 'kapee-extensions' ),
					'param_name' 	=> 'subtitle_font_size_mobile',
					'description' 	=> esc_html__( 'Enter font size(px).', 'kapee-extensions' ),
					'group' 		=> esc_html__( 'Title & Subtitle', 'kapee-extensions' ),		
					'edit_field_class'	=> 'vc_col-sm-4',
				),
				array(
					"type"       	=> "kapee_number",
					"param_name" 	=> "subtitle_line_height",
					"heading"    	=> esc_html__("Line Height in Desktop", 'kapee-extensions' ),
					'description' 	=> esc_html__( 'Enter line height(px).', 'kapee-extensions' ),
					'std' 			=> '22',
					'group' 		=> esc_html__( 'Title & Subtitle', 'kapee-extensions' ),
					'edit_field_class'	=> 'vc_col-sm-4',
				),
				array(
					"type"       	=> "kapee_number",
					"param_name" 	=> "subtitle_line_height_tablet",
					"heading"    	=> esc_html__("Line Height in Tablet", 'kapee-extensions' ),
					'description' 	=> esc_html__( 'Enter line height(px).', 'kapee-extensions' ),
					'std' 			=> '',
					'group' 		=> esc_html__( 'Title & Subtitle', 'kapee-extensions' ),
					'edit_field_class'	=> 'vc_col-sm-4',
				),
				array(
					"type"       	=> "kapee_number",
					"param_name" 	=> "subtitle_line_height_mobile",
					"heading"    	=> esc_html__("Line Height in Mobile", 'kapee-extensions' ),
					'description' 	=> esc_html__( 'Enter line height(px).', 'kapee-extensions' ),
					'std' 			=> '',
					'group' 		=> esc_html__( 'Title & Subtitle', 'kapee-extensions' ),
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
					'group' 		=> esc_html__( 'Title & Subtitle', 'kapee-extensions' ),
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
					'group' 		=> esc_html__( 'Title & Subtitle', 'kapee-extensions' ),
					'edit_field_class'	=> 'vc_col-sm-6',
				),
				array(
					'type'          => 'colorpicker',
					'heading'       => esc_html__( 'Color', 'kapee-extensions' ),
					'param_name'    => 'subtitle_color',
					'std' 			=> '#2370F4',
					'group' 		=> esc_html__( 'Title & Subtitle', 'kapee-extensions' )
				),
				
				array(
					'type'          => 'textarea_html',
					'heading'       => esc_html__( 'Banner Content', 'kapee-extensions' ),
					'param_name'    => 'content',
					'std' 			=> '',
					'group' 		=> esc_html__( 'Content', 'kapee-extensions' )
				),
				array(
					"type"       	=> "kapee_number",
					"param_name" 	=> "content_text_font_size",
					"heading"    	=> esc_html__("Font Size in Desktop", 'kapee-extensions' ),
					'description' 	=> esc_html__( 'Enter font size(px).', 'kapee-extensions' ),
					'std' 			=> '14',
					'group' 		=> esc_html__( 'Content', 'kapee-extensions' ),
					'edit_field_class'	=> 'vc_col-sm-4',
				),
				array(
					'type' 			=> 'kapee_number',
					'param_name' 	=> 'content_text_font_size_tablet',
					'heading' 		=> esc_html__( 'Font Size in Tablet', 'kapee-extensions' ),
					'description' 	=> esc_html__( 'Enter font size(px).', 'kapee-extensions' ),
					'std' 			=> '',
					'group' 		=> esc_html__( 'Content', 'kapee-extensions' ),
					'edit_field_class'	=> 'vc_col-sm-4',
				),
				array(
					'type' 			=> 'kapee_number',
					'param_name' 	=> 'content_text_font_size_mobile',
					'heading' 		=> esc_html__( 'Font Size in Mobile', 'kapee-extensions' ),
					'description' 	=> esc_html__( 'Enter font size(px).', 'kapee-extensions' ),
					'std' 			=> '',
					'group' 		=> esc_html__( 'Content', 'kapee-extensions' ),
					'edit_field_class'	=> 'vc_col-sm-4',
				),
				array(
					"type"       	=> "kapee_number",
					"param_name" 	=> "content_text_line_height",
					"heading"    	=> esc_html__("Line Height in Desktop", 'kapee-extensions' ),
					'description' 	=> esc_html__( 'Enter line height(px).', 'kapee-extensions' ),
					'std' 			=> '18',
					'group' 		=> esc_html__( 'Content', 'kapee-extensions' ),
					'edit_field_class'	=> 'vc_col-sm-4',
				),
				array(
					"type"       	=> "kapee_number",
					"param_name" 	=> "content_text_line_height_tablet",
					"heading"    	=> esc_html__("Line Height in Tablet", 'kapee-extensions' ),
					'description' 	=> esc_html__( 'Enter line height(px).', 'kapee-extensions' ),
					'std' 			=> '',
					'group' 		=> esc_html__( 'Content', 'kapee-extensions' ),
					'edit_field_class'	=> 'vc_col-sm-4',
				),
				array(
					"type"       	=> "kapee_number",
					"param_name" 	=> "content_text_line_height_mobile",
					"heading"    	=> esc_html__("Line Height in Mobile", 'kapee-extensions' ),
					'description' 	=> esc_html__( 'Enter line height(px).', 'kapee-extensions' ),
					'std' 			=> '',
					'group' 		=> esc_html__( 'Content', 'kapee-extensions' ),
					'edit_field_class'	=> 'vc_col-sm-4',
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Font Weight', 'kapee-extensions' ),
					'param_name' 	=> 'content_font_weight',
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
					'group' 		=> esc_html__( 'Content', 'kapee-extensions' ),
					'edit_field_class'	=> 'vc_col-sm-6',
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Text Transform', 'kapee-extensions' ),
					'param_name' 	=> 'content_text_transform',
					'value' 		=> array( 
						esc_html__( 'Inherit', 'kapee-extensions' ) 	=> 'inherit',
						esc_html__( 'Uppercase', 'kapee-extensions' ) 	=> 'uppercase',
						esc_html__( 'Capitalize', 'kapee-extensions' ) 	=> 'capitalize',
						esc_html__( 'Lowercase', 'kapee-extensions' ) 	=> 'lowercase',
					),
					'std' 			=> 'inherit',
					'group' 		=> esc_html__( 'Content', 'kapee-extensions' ),
					'edit_field_class'	=> 'vc_col-sm-6',
				),
				array(
					'type'          => 'colorpicker',
					'heading'       => esc_html__( 'Color', 'kapee-extensions' ),
					'param_name'    => 'content_text_color',
					'std' 			=> '#555555',
					'group' 		=> esc_html__( 'Content', 'kapee-extensions' )
				),
				array(
					"type" 			=> "textfield",
					"heading" 		=> esc_html__( "Button Text", 'kapee-extensions' ),
					"param_name" 	=> "button_text",
					"description"   => esc_html__( "Enter butten text", 'kapee-extensions' ),
					'std' 			=> '',
					'group' 		=> esc_html__( 'Button', 'kapee-extensions' )
				),
				array(
					'type'        	=> 'dropdown',
					'param_name'  	=> 'button_style',
					'heading'     	=> esc_html__( 'Style', 'kapee-extensions' ),
					'value'       	=> array(
						esc_html__( 'Flat', 'kapee-extensions' )  		=> 'flat',
						esc_html__( 'Outline', 'kapee-extensions' )  	=> 'outline',
						esc_html__( 'Link', 'kapee-extensions' )  		=> 'link'
					),
					'std' 			=> 'flat',
					'group' 		=> esc_html__( 'Button', 'kapee-extensions' ),
					'edit_field_class'	=> 'vc_col-sm-4',
				),
				array(
					'type'        	=> 'dropdown',
					'param_name'  	=> 'button_shape',
					'heading'     	=> esc_html__( 'Shape', 'kapee-extensions' ),
					'value'       	=> array(
						esc_html__( 'Square', 'kapee-extensions' )	=> 'square',
						esc_html__( 'Rounded', 'kapee-extensions' )	=> 'rounded',
						esc_html__( 'Round', 'kapee-extensions' )  	=> 'round'
					),
					'std' 			=> 'square',
					'group' 		=> esc_html__( 'Button', 'kapee-extensions' ),
					'edit_field_class'	=> 'vc_col-sm-4',
				),
				array(
					'type'        	=> 'dropdown',
					'param_name'  	=> 'button_size',
					'heading'     	=> esc_html__( 'Size', 'kapee-extensions' ),
					'value'       	=> array(
						esc_html__( 'Small', 'kapee-extensions' )	=> 'small',
						esc_html__( 'Normal', 'kapee-extensions' )  => 'normal',
						esc_html__( 'Large', 'kapee-extensions' )  	=> 'large',
					),
					'std' 			=> 'normal',
					'group' 		=> esc_html__( 'Button', 'kapee-extensions' ),
					'edit_field_class'	=> 'vc_col-sm-4',
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Font Weight', 'kapee-extensions' ),
					'param_name' 	=> 'button_font_weight',
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
					'group' 		=> esc_html__( 'Button', 'kapee-extensions' ),
					'edit_field_class'	=> 'vc_col-sm-6',
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Text Transform', 'kapee-extensions' ),
					'param_name' 	=> 'button_text_transform',
					'value' 		=> array( 
						esc_html__( 'Inherit', 'kapee-extensions' ) 	=> 'inherit',
						esc_html__( 'Uppercase', 'kapee-extensions' ) 	=> 'uppercase',
						esc_html__( 'Capitalize', 'kapee-extensions' ) 	=> 'capitalize',
						esc_html__( 'Lowercase', 'kapee-extensions' ) 	=> 'lowercase',
					),
					'std' 			=> 'inherit',
					'group' 		=> esc_html__( 'Button', 'kapee-extensions' ),
					'edit_field_class'	=> 'vc_col-sm-6',
				),
				array(
					'type'          => 'dropdown',
					'heading'       => esc_html__( 'Color', 'kapee-extensions' ),
					'param_name'    => 'button_text_color',
					'value'       	=> array(
						esc_html__( 'Light', 'kapee-extensions' )	=> 'light',
						esc_html__( 'Dark', 'kapee-extensions' )	=> 'dark',
					),
					'std' 			=> 'light',
					'group' 		=> esc_html__( 'Button', 'kapee-extensions' ),
					'edit_field_class'	=> 'vc_col-sm-6',
				),
				array(
					'type'          => 'colorpicker',
					'heading'       => esc_html__( 'Background Color', 'kapee-extensions' ),
					'param_name'    => 'button_bg_color',
					'std' 			=> '#2370F4',
					'group' 		=> esc_html__( 'Button', 'kapee-extensions' ),
					'edit_field_class'	=> 'vc_col-sm-6',
				),
				array(
					'type'          => 'dropdown',
					'heading'       => esc_html__( 'Hover Color', 'kapee-extensions' ),
					'param_name'    => 'button_text_hover_color',
					'value'       	=> array(
						esc_html__( 'Light', 'kapee-extensions' )	=> 'light',
						esc_html__( 'Dark', 'kapee-extensions' )	=> 'dark',
					),
					'std' 			=> 'light',
					'group' 		=> esc_html__( 'Button', 'kapee-extensions' ),
					'edit_field_class'	=> 'vc_col-sm-6',
				),
				array(
					'type'          => 'colorpicker',
					'heading'       => esc_html__( 'Hover Background Color', 'kapee-extensions' ),
					'param_name'    => 'button_bg_hover_color',
					'std' 			=> '#2370F4',
					'group' 		=> esc_html__( 'Button', 'kapee-extensions' ),
					'edit_field_class'	=> 'vc_col-sm-6',
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Text Alignment', 'kapee-extensions' ),
					'param_name' 	=> 'content_text_align',
					'value' 		=> array( 
						esc_html__( 'Left', 'kapee-extensions' ) 	=> 'left',
						esc_html__( 'Center', 'kapee-extensions' ) 	=> 'center',
						esc_html__( 'Right', 'kapee-extensions' ) 	=> 'right',
					),
					'std' 			=> 'left',
					'group' 		=> esc_html__( 'Content Position', 'kapee-extensions' )
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Horizontal Alignment', 'kapee-extensions' ),
					'param_name' 	=> 'content_horizontal_align',
					'value' 		=> array( 
						esc_html__( 'Left', 'kapee-extensions' ) 	=> 'start',
						esc_html__( 'Center', 'kapee-extensions' ) 	=> 'center',
						esc_html__( 'Right', 'kapee-extensions' ) 	=> 'end',
					),
					'std' 			=> 'start',
					'group' 		=> esc_html__( 'Content Position', 'kapee-extensions' )
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Vertical Alignment', 'kapee-extensions' ),
					'param_name' 	=> 'content_vertical_align',
					'value' 		=> array( 
						esc_html__( 'Top', 'kapee-extensions' ) 	=> 'start',
						esc_html__( 'Middle', 'kapee-extensions' ) 	=> 'center',
						esc_html__( 'Bottom', 'kapee-extensions' ) 	=> 'end',
					),
					'std' 			=> 'start',
					'group' 		=> esc_html__( 'Content Position', 'kapee-extensions' )
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
	
	public function _html( $atts, $content = null ) {
		$args = shortcode_atts( array(			
			'banner_image' 					=> '',
			'banner_image_size' 			=> 'full',
			'banner_link' 					=> '#',
			'banner_hover_effect'			=> 'zoom-out',
			'banner_content_width'			=> '70',
			'banner_content_padding_top_bottom'	=> '',
			'banner_content_padding_left_right'	=> '',
			'banner_content_bg_color'		=> '',
			'css_animation' 				=> 'none',	
			'el_class'						=> '',
			'title'							=> '',
			'title_font_size'				=> '26',
			'title_font_size_tablet'		=> '',
			'title_font_size_mobile'		=> '',
			'title_line_height'				=> '',
			'title_line_height_tablet'		=> '',
			'title_line_height_mobile'		=> '',
			'title_font_weight'				=> '700',
			'title_text_transform'			=> 'uppercase',
			'title_color'					=> '#333333',
			'subtitle'						=> '',
			'subtitle_font_size'			=> '16',
			'subtitle_font_size_tablet'		=> '',
			'subtitle_font_size_mobile'		=> '',
			'subtitle_line_height'			=> '22',
			'subtitle_line_height_tablet'	=> '',
			'subtitle_line_height_mobile'	=> '',
			'subtitle_font_weight'			=> '400',
			'subtitle_text_transform'		=> 'uppercase',
			'subtitle_color'				=> '#2370F4',
			'content_text_font_size'		=> '14',
			'content_text_font_size_tablet'		=> '',
			'content_text_font_size_mobile'		=> '',
			'content_text_line_height'		=> '18',
			'content_text_line_height_tablet'		=> '',
			'content_text_line_height_mobile'		=> '',
			'content_font_weight'			=> '400',
			'content_text_transform'		=> 'inherit',
			'content_text_color'			=> '#555555',
			'button_text'					=> '',
			'button_style'					=> 'flat',
			'button_shape'					=> 'square',
			'button_size'					=> 'normal',
			'button_font_weight'			=> '400',
			'button_text_transform'			=> 'inherit',
			'button_text_color'				=> 'light',
			'button_bg_color'				=> '#2370F4',
			'button_text_hover_color'		=> 'light',
			'button_bg_hover_color'			=> '#2370F4',
			'content_text_align'			=> 'left',
			'content_horizontal_align'		=> 'start',
			'content_vertical_align'		=> 'start',
			'css'							=> '',
		), $atts );		
		extract( $args );
		$class 				= array('kapee-element', 'kapee-banner');		
		$content_class		= array();
		$id  				= kapee_uniqid('kapee-banner-');	
		$args['id'] 		= $id ;
		$class[]			= !empty( $banner_hover_effect ) ? 'banner-'.$banner_hover_effect : '';
		$class[]			= ( empty ( $button_text ) && ! empty( $link_url) ) ? 'wrap-link' : '';
		$class[]			= $el_class;
		$css_class 			= vc_shortcode_custom_css_class( $css, ' ' );
		$class[]			= $css_class;
		$content_class[]	= 'text-'.$content_text_align;
		$content_class[]	= 'align-items-'.$content_horizontal_align;
		$content_class[]	= 'justify-content-'.$content_vertical_align;
		
		
		$args['content_class'] 	= implode(' ', array_filter( $content_class ) );
		$args['image_src'] 	= '';
		if( $banner_image ){
			$bg_image_src 		= kapee_get_image_src( $banner_image, 'full' );
			$args['image_src'] 	= $bg_image_src;
		}
		
		$link_default = array( 'url'    => '', 'title'  => '', 'target' => '_self' );
		
		if ( function_exists( 'vc_build_link' ) ):
			$link = wp_parse_args( vc_build_link( $banner_link ), $link_default );
		else:
			$link = $link_default;
		endif;
		
		$link_url 						= '';
		$link_on_box_title 				= '';
		
		// Fix empty target attribute
		if ( trim( $link['url'] ) != '' ) :
			$link_url = $link['url'];
		endif;
		
		$link_target 					= empty($link['target']) ? '_self':$link['target'];
		$args['link_target'] 			= $link_target;
		$args['link_url'] 				= empty($link_url) ?  'javascript:voide();' : $link_url;
		$args['content'] = wpb_js_remove_wpautop($content, true);	
		
		if( empty ( $button_text ) && ! empty( $link_url) ){
			$link_on_box_title = ' onclick="window.open(\''.$link_url.'\',\''.$link_target.'\')"';
			$class[]			= 'wrap-link';
		}
		
		$args['link_on_box_title'] 		= $link_on_box_title;		
		$args['class'] 		= implode(' ',array_filter( $class ) );
		
		/* Dynamic Css */
		$banner_css 		= array();
		$style_css 			= '';
			
		$banner_css['content_css'][] = !empty ( $banner_content_width ) ?'max-width : '.$banner_content_width.'%;' : '';
		$banner_css['content_css'][] = !empty ( $banner_content_padding_top_bottom ) ?'padding-top : '.$banner_content_padding_top_bottom.'px;' : '';
		$banner_css['content_css'][] = !empty ( $banner_content_padding_top_bottom ) ?'padding-bottom : '.$banner_content_padding_top_bottom.'px;' : '';
		$banner_css['content_css'][] = !empty ( $banner_content_padding_left_right ) ?'padding-left : '.$banner_content_padding_left_right.'px;' : '';
		$banner_css['content_css'][] = !empty ( $banner_content_padding_left_right ) ?'padding-right : '.$banner_content_padding_left_right.'px;' : '';
		$banner_css['content_css'][] = !empty ( $banner_content_bg_color ) ?'background-color : '.$banner_content_bg_color : '';
		
		$banner_css['title'][] = !empty ( $title_color ) ? 'color : '.$title_color.';' : '';
		$banner_css['title'][] = !empty ( $title_font_size ) ? 'font-size : '.$title_font_size.'px;' : '';
		$banner_css['title'][] = !empty ( $title_font_weight ) ? 'font-weight : '.$title_font_weight.';' : '';
		$banner_css['title'][] = !empty ( $title_line_height ) ? 'line-height:'.$title_line_height.'px;' : '';
		$banner_css['title'][] = !empty ( $title_text_transform ) ? 'text-transform : '.$title_text_transform.';' : '';
		$banner_css['tablet']['title'][] = !empty($title_font_size_tablet) ? 'font-size:'.$title_font_size_tablet.'px' : '' ;
		$title_css['tablet']['title'][] = !empty($title_line_height_tabel) ? 'line-height:'.$title_line_height_tabel.'px' : '' ;
		$banner_css['mobile']['title'][] = !empty($title_font_size_mobile) ? 'font-size:'.$title_font_size_mobile.'px' : '' ;
		$banner_css['mobile']['title'][] = !empty($title_line_height_mobile) ? 'line-height:'.$title_line_height_mobile.'px' : '' ;
		
		$banner_css['subtitle'][] = !empty ( $subtitle_color ) ? 'color : '.$subtitle_color.';' : '';
		$banner_css['subtitle'][] = !empty ( $subtitle_font_size ) ? 'font-size:'.$subtitle_font_size.'px;' : '';
		$banner_css['subtitle'][] = !empty ( $subtitle_font_weight ) ? 'font-weight:'.$subtitle_font_weight.';' : '';
		$banner_css['subtitle'][] = !empty ( $subtitle_line_height ) ? 'line-height:'.$subtitle_line_height.'px;' : '';
		$banner_css['subtitle'][] = !empty ( $subtitle_text_transform ) ? 'text-transform:'.$subtitle_text_transform.';' : '';
		$banner_css['tablet']['subtitle'][] = !empty($subtitle_font_size_tablet) ? 'font-size:'.$subtitle_font_size_tablet.'px' : '' ;
		$banner_css['tablet']['subtitle'][] = !empty($subtitle_line_height_tablet) ? 'line-height:'.$subtitle_line_height_tablet.'px' : '' ;
		$banner_css['mobile']['subtitle'][] = !empty($subtitle_font_size_mobile) ? 'font-size:'.$subtitle_font_size_mobile.'px' : '' ;
		$banner_css['mobile']['subtitle'][] = !empty($subtitle_line_height_mobile) ? 'line-height:'.$subtitle_line_height_mobile.'px' : '' ;
		
		$banner_css['content_txt'][] = !empty ( $content_text_color ) ? 'color:'.$content_text_color.';' : '';
		$banner_css['content_txt'][] = !empty ( $content_text_font_size ) ? 'font-size:'.$content_text_font_size.'px;' : '';
		$banner_css['content_txt'][] = !empty ( $content_text_line_height ) ? 'line-height:'.$content_text_line_height.'px;': '';
		$banner_css['content_txt'][] = !empty ( $content_font_weight ) ? 'font-weight:'.$content_font_weight.';': '';
		$banner_css['content_txt'][] = !empty ( $content_text_transform ) ? 'text-transform:'.$content_text_transform.';': '';
		$banner_css['tablet']['content_txt'][] = !empty($content_text_font_size_tablet) ? 'font-size:'.$content_text_font_size_tablet.'px' : '' ;
		$banner_css['tablet']['content_txt'][] = !empty($content_text_line_height_tablet) ? 'line-height:'.$content_text_line_height_tablet.'px' : '' ;
		$banner_css['mobile']['content_txt'][] = !empty($content_text_font_size_mobile) ? 'font-size:'.$content_text_font_size_mobile.'px' : '' ;
		$banner_css['mobile']['content_txt'][] = !empty($content_text_line_height_mobile) ? 'line-height:'.$content_text_line_height_mobile.'px' : '' ;
		
		$button_class			= array( 'button' );
		$button_class[]			= 'btn-style-'.$button_style;
		$button_class[]			= 'btn-shape-'.$button_shape;
		$button_class[]			= 'btn-size-'.$button_size;
		$button_class[]			= ( $button_style != 'link' ) ? 'color-scheme-'.$button_text_color : '';
		$button_class[]			= ( $button_style != 'link' ) ? 'hover-color-scheme-'.$button_text_hover_color : '';
		$args['button_class'] 	= implode(' ', array_filter( $button_class ) );
		
		$banner_css['button']['btn_background'][]	=  !empty ( $button_bg_color ) ? 'background-color:'.$button_bg_color.';' : '';
		$banner_css['button']['btn_color'][]	=  !empty ( $button_bg_color ) ? 'color:'.$button_bg_color.';' : '';
		$banner_css['button']['btn_background_hover'][]	=  !empty ( $button_bg_hover_color ) ? 'background-color:'.$button_bg_hover_color.';' : '';
		$banner_css['button']['btn_txt_hover_color'][]	=  !empty ( $button_bg_hover_color ) ? 'color:'.$button_bg_hover_color.';' : '';
		$banner_css['button']['btn_border_color'][]	=  !empty ( $button_bg_color ) ? 'border-color:'.$button_bg_color.';' : '';
		$banner_css['button']['btn_border_hover_color'][]	=  !empty ( $button_bg_hover_color ) ? 'border-color:'.$button_bg_hover_color.';' : '';		
		$banner_css['button']['font_text'][] = !empty ( $button_font_weight ) ? 'font-weight:'.$button_font_weight.';' : '';	
		$banner_css['button']['font_text'][] = !empty ( $button_text_transform ) ? 'text-transform:'.$button_text_transform.';' : '';
				
		if( ! empty( array_filter( $banner_css['content_css'] ) ) ){
			$style_css .= '#'.$args['id'].' .banner-content {';
			$style_css .= implode(' ', array_filter( $banner_css['content_css'] ) );
			$style_css .= '}';
		}
		if( ! empty( array_filter( $banner_css['title'] ) ) ){
			$style_css .= '#'.$args['id'].' .banner-title {';
			$style_css .= implode(' ', array_filter( $banner_css['title'] ) );
			$style_css .= '}';
		}
		if( ! empty( array_filter( $banner_css['subtitle'] ) ) ){
			$style_css .= '#'.$args['id'].' .banner-subtitle {';
			$style_css .= implode(' ', array_filter( $banner_css['subtitle'] ) );
			$style_css .= '}';
		}
		if( ! empty( array_filter( $banner_css['content_txt'] ) ) ){
			$style_css .= '#'.$args['id'].' .banner-content-text p {';
			$style_css .= implode(' ', array_filter( $banner_css['content_txt'] ) );
			$style_css .= '}';
		}
		if( ! empty( array_filter( $banner_css['button']['font_text'] ) ) ){
			$style_css .= '#'.$args['id'].' .button {';
			$style_css .= implode(' ', array_filter( $banner_css['button']['font_text'] ) );
			$style_css .= '}';
		}
		if( ! empty( array_filter( $banner_css['button']['btn_background'] ) ) ){
			$style_css .= '#'.$args['id'].' .btn-style-flat{';
			$style_css .= implode(' ', array_filter( $banner_css['button']['btn_background'] ) );
			$style_css .= '}';
		}
		if( ! empty( array_filter( $banner_css['button']['btn_background_hover'] ) ) ){
			$style_css .= '#'.$args['id'].' .btn-style-flat:hover{';
			$style_css .= implode(' ', array_filter( $banner_css['button']['btn_background_hover'] ) );
			$style_css .= '}';
		}
		if( ! empty( array_filter( $banner_css['button']['btn_color'] ) ) ){
			$style_css .= '#'.$args['id'].' .btn-style-outline, #'.$args['id'].' .btn-style-link{';
			$style_css .= implode(' ', array_filter( $banner_css['button']['btn_color'] ) );
			$style_css .= '}';
		}
		if( ! empty( array_filter( $banner_css['button']['btn_background_hover'] ) ) ){
			$style_css .= '#'.$args['id'].' .btn-style-outline:hover{';
			$style_css .= implode(' ', array_filter( $banner_css['button']['btn_background_hover'] ) );
			$style_css .= '}';
		}
		if( ! empty( array_filter( $banner_css['button']['btn_txt_hover_color'] ) ) ){
			$style_css .= '#'.$args['id'].' .btn-style-link:hover{';
			$style_css .= implode(' ', array_filter( $banner_css['button']['btn_txt_hover_color'] ) );
			$style_css .= '}';
		}
		if( ! empty( array_filter( $banner_css['button']['btn_border_color'] ) ) ){
			$style_css .= '#'.$args['id'].' .btn-style-outline, #'.$args['id'].' .btn-style-link{';
			$style_css .= implode(' ', array_filter( $banner_css['button']['btn_border_color'] ) );
			$style_css .= '}';
		}			
		if( ! empty( array_filter( $banner_css['button']['btn_border_hover_color'] ) ) ){
			$style_css .= '#'.$args['id'].' .btn-style-outline:hover, #'.$args['id'].' .btn-style-link.btn-color-custom:hover{';
			$style_css .= implode(' ', array_filter( $banner_css['button']['btn_border_hover_color'] ) );
			$style_css .= '}';
		}
		if( ! empty( array_filter( $banner_css['tablet'] ) ) ){
			$style_css .= '@media (max-width:1199px){';
			if( !empty( array_filter($banner_css['tablet']['title']) ) ){
				$style_css .= '#'.$args['id'].' .banner-title {';
				$style_css .=  implode('; ', array_filter( $banner_css['tablet']['title'] ) );
				$style_css .= '}';
			}
			if( ! empty( array_filter($banner_css['tablet']['subtitle'] ) ) ){
				$style_css .= '#'.$args['id'].' .banner-subtitle {';
				$style_css .=  implode('; ', array_filter( $banner_css['tablet']['subtitle'] ) );
				$style_css .= '}';
			}
			if( ! empty( array_filter($banner_css['tablet']['content_txt'] ) ) ){
				$style_css .= '#'.$args['id'].' ..banner-content-text p {';
				$style_css .=  implode('; ', array_filter( $banner_css['tablet']['content_txt'] ) );
				$style_css .= '}';
			}
			$style_css .= '}';
		}
		if( ! empty( array_filter( $banner_css['mobile'] ) ) ){
			$style_css .= '@media (max-width:767px){';
			if( !empty( array_filter($banner_css['mobile']['title']) ) ){
				$style_css .= '#'.$args['id'].' .banner-title {';
				$style_css .=  implode('; ', array_filter( $banner_css['mobile']['title'] ) );
				$style_css .= '}';
			}
			if( ! empty( array_filter($banner_css['mobile']['subtitle'] ) ) ){
				$style_css .= '#'.$args['id'].' .banner-subtitle {';
				$style_css .=  implode('; ', array_filter( $banner_css['mobile']['subtitle'] ) );
				$style_css .= '}';
			}
			if( ! empty( array_filter($banner_css['mobile']['content_txt'] ) ) ){
				$style_css .= '#'.$args['id'].' .banner-content-text p {';
				$style_css .=  implode('; ', array_filter( $banner_css['mobile']['content_txt'] ) );
				$style_css .= '}';
			}
			$style_css .= '}';
		}
		kapee_add_custom_css( $style_css );	
		
		ob_start();
			kapee_get_pl_templates('shortcodes/banner', $args );	
		return ob_get_clean();
	}	
}
new vcBanner();