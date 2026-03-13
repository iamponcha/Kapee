<?php
/*
Element: Counter
*/
class vcCounter extends WPBakeryShortCode {

    function __construct() {
        $this->_mapping();
        add_shortcode( 'kapee_counter', array( $this, '_html' ) );
	}
	public function _mapping() {
		if ( !defined( 'WPB_VC_VERSION' ) ) { return; }
		
		vc_map( array(
			'name' 			=> esc_html__( 'Counter', 'kapee-extensions' ),
			'base' 			=> 'kapee_counter',
			'category' 		=> esc_html__( 'Kapee', 'kapee-extensions' ),
			'description' 	=> esc_html__( 'Animated counter.', 'kapee-extensions' ),
        	'icon' 			=> KAPEE_URI.'/inc/admin/assets/images/vc-icon.png',
			'params' 		=> array(
				//General
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Icon to display', 'kapee-extensions' ),
					'param_name' 	=> 'icon_display_type',
					'value' 		=> array( 
						esc_html__( 'Font Icon Manager', 'kapee-extensions' ) => 'font',
						esc_html__( 'Custom Image Icon', 'kapee-extensions' ) => 'image',
					),
					'std'			=> 'icon_font',
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
					'dependency' 	=> Array('element' => 'icon_display_type', 'value' => array('font')),
				),
				array(
					'type' 			=> 'iconpicker',
					'heading' 		=> esc_html__('Icon', 'kapee-extensions'),
					'param_name' 	=> 'icon_fontawesome',
					'value' 		=> 'fa fa-adjust', // default value to backend editor admin_label
					'settings' 		=> array(
						'emptyIcon' => true,
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
						'emptyIcon' 	=> true, // default true, display an "EMPTY" icon?
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
						'emptyIcon' 	=> true, // default true, display an "EMPTY" icon?
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
						'emptyIcon' 	=> true, // default true, display an "EMPTY" icon?
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
					'value'  		=> 'vc_li vc_li-heart ',
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
				array(
					'type' 			=> 'attach_image',
					'heading' 		=> esc_html__('Upload Image Icon:', 'kapee-extensions'),
					'param_name' 	=> 'icon_image',
					'value' 		=> '',
					'description' 	=> esc_html__('Upload the custom image icon.', 'kapee-extensions'),
					'dependency' 	=> array('element' => 'icon_display_type', 'value' => array('image')),
				),
				array(
					"type"       	=> "kapee_number",
					"param_name" 	=> "icon_image_size",
					"std" 			=> 48,
					"heading"    	=> esc_html__("Image Width(px)", 'kapee-extensions' ),
					'description'     => esc_html__( 'Provide image width.', 'kapee-extensions' ),
					'dependency' 	=> Array('element' => 'icon_display_type', 'value' => array('image')),
				),
				/* array(
					"type"       	=> "kapee_number",
					"param_name" 	=> "icon_font_size",
					"heading"    	=> esc_html__("Icon font size(px)", 'kapee-extensions' ),
					'std'			=> 38,
					'dependency' 	=> array('element' => 'icon_display_type', 'value' => array('font')),
				), */
				array(
					"type"       	=> "kapee_number",
					"param_name" 	=> "icon_size",
					"heading"    	=> esc_html__("Icon Size in Desktop", 'kapee-extensions' ),
					"description" 	=> esc_html__( 'Enter icon size(px).', 'kapee-extensions' ),
					"std"    		=> 38,
					'dependency' 	=> array('element' => 'icon_display_type', 'value' => array('font')),
					'edit_field_class'	=> 'vc_col-sm-4',
				),
				array(
					"type"       	=> "kapee_number",
					"param_name" 	=> "icon_size_tablet",
					"heading"    	=> esc_html__("Icon Size In Tablet", 'kapee-extensions' ),
					"description" 	=> esc_html__( 'Enter icon size(px).', 'kapee-extensions' ),
					"std"    		=> '',
					"dependency" 	=> array('element' => 'icon_display_type', 'value' => array('font')),
					"edit_field_class"	=> "vc_col-sm-4",
				),
				array(
					"type"       	=> "kapee_number",
					"param_name" 	=> "icon_size_mobile",
					"heading"    	=> esc_html__("Icon Size In Mobile", 'kapee-extensions' ),
					'description' 	=> esc_html__( 'Enter icon size(px).', 'kapee-extensions' ),
					"std"    		=> '',
					'dependency' 	=> array('element' => 'icon_display_type', 'value' => array('font')),
					'edit_field_class'	=> 'vc_col-sm-4',
				),
				array(
					'type'            => 'colorpicker',
					'heading'         => esc_html__( 'Icon Color', 'kapee-extensions' ),
					'param_name'      => 'icon_color',
					'std'      => '#2370F4',
					'description'     => esc_html__( 'Select icon color.', 'kapee-extensions' ),
					'dependency' 	=> array('element' => 'icon_display_type', 'value' => array('font')),
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__('Icon Style', 'kapee-extensions'),
					'value' 		=> array(
						esc_html__('Simple', 'kapee-extensions') 	=> 'icon-simple',
						esc_html__('Circle Background', 'kapee-extensions') 	=> 'icon-circle',
						esc_html__('Square Background', 'kapee-extensions') 		=> 'icon-square',
						esc_html__('Design Your Own', 'kapee-extensions') 		=> 'icon-custom',
					),
					'std'			=> 'icon-simple',
					'param_name' 	=> 'icon_style',
					'description' 	=> esc_html__('Select icon style.', 'kapee-extensions'),
					
				),
				array(
					'type'            => 'colorpicker',
					'heading'         => esc_html__( 'Background Color', 'kapee-extensions' ),
					'param_name'      => 'icon_bg_color',
					'description'     => esc_html__( 'Select background color for icon.', 'kapee-extensions' ),
					'dependency' 	=> array('element' => 'icon_style', 'value' => array('icon-circle','icon-square','icon-custom')),
				),
				
				array(
					'type'            => 'dropdown',
					'heading'         => esc_html__( 'Icon Border Style', 'kapee-extensions' ),
					'param_name'      => 'icon_border_style',
					'value' 		=> array(
						esc_html__('None', 'kapee-extensions') 	=> '',
						esc_html__( 'Solid', 'kapee-extensions' ) 	=> 'solid',
						esc_html__( 'Dashed', 'kapee-extensions' ) 	=> 'dashed',						
						esc_html__( 'Dotted', 'kapee-extensions' ) 	=> 'dotted',
						esc_html__( 'Double', 'kapee-extensions' ) 	=> 'double',
						esc_html__( 'Inset', 'kapee-extensions' ) 	=> 'inset',
						esc_html__( 'Outset', 'kapee-extensions' ) 	=> 'outset',
					),
					'std'	=>	'',
					'description'     => esc_html__( 'Select the border style for icon.', 'kapee-extensions' ),
					'dependency' 	=> array('element' => 'icon_style', 'value' => array('icon-custom')),
				),
				array(
					'type'            => 'colorpicker',
					'heading'         => esc_html__( 'Border Color', 'kapee-extensions' ),
					'param_name'      => 'icon_border_color',
					'std'      		=> '#000000',
					'dependency' 	=> array('element' => 'icon_border_style', 'value' => array('solid','dashed','dotted','double','inset','outset')),
				),
				array(
					'type'            => 'kapee_number',
					'heading'         => esc_html__( 'Border Width', 'kapee-extensions' ),
					'param_name'      => 'icon_border_width',
					'std'      		=> 1,
					'dependency' 	=> array('element' => 'icon_border_style', 'value' => array('solid','dashed','dotted','double','inset','outset')),
				),
				array(
					'type'            => 'kapee_number',
					'heading'         => esc_html__( 'Border Radius', 'kapee-extensions' ),
					'param_name'      => 'icon_border_radius',
					'std'      		=> 500,
					'dependency' 	=> array('element' => 'icon_border_style', 'value' => array('solid','dashed','dotted','double','inset','outset')),
				),
				array(
					"type"       	=> "kapee_number",
					"param_name" 	=> "icon_bg_size",
					"heading"    	=> esc_html__("Background Size(px)", 'kapee-extensions' ),
					"std" 			=> 50,
					'description'     => esc_html__( 'Spacing from center of the icon till the boundary of border / background.', 'kapee-extensions' ),
					'dependency' 	=> array('element' => 'icon_style', 'value' => array('icon-custom')),
				),
				array(
					'type'            => 'dropdown',
					'heading'         => esc_html__( 'Icon Position', 'kapee-extensions' ),
					'param_name'      => 'icon_position',
					'value' 		=> array(
						esc_html__('Top', 'kapee-extensions') 	=> 'top',
						esc_html__( 'Left', 'kapee-extensions' ) 	=> 'left',
						esc_html__( 'Right', 'kapee-extensions' ) 	=> 'right',
					),
					'std'				=> 'top',
					'description'     => esc_html__( 'Select Position of Icon.', 'kapee-extensions' ),
				),				
				array(
					'type' 			=> 'kapee_title',
					'param_name' 	=> 'kapee_title',
					'class' 		=> '',
					'content' 		=> esc_html__( 'Counter Title', 'kapee-extensions' ),
					'group' 		=> esc_html__( 'Title & Value', 'kapee-extensions' )
				),
				array(
					"type"       	=> "textfield",
					"param_name" 	=> "counter_title",
					"heading"    	=> esc_html__("Counter Title", 'kapee-extensions' ),
					'description'     => esc_html__( 'Enter title for stats counter block.', 'kapee-extensions' ),
					'admin_label'	=> true,
					'group' 		=> esc_html__( 'Title & Value', 'kapee-extensions' )
				),				
				/*array(
					'type' 			=> 'checkbox',
					'heading' 		=> esc_html__( 'Underline', 'kapee-extensions' ),
					'param_name' 	=> 'title_underline',
					'value' 			=> array( esc_html__( 'Yes', 'kapee-extensions' ) => 1 ),
					'std' 				=> 0,
					'group'      	=> esc_html__( 'Title & Value', 'kapee-extensions' ),
					"edit_field_class"	=> "vc_col-sm-4",
				),
				array(
					'type' 			=> 'checkbox',
					'heading' 		=> esc_html__( 'Italic', 'kapee-extensions' ),
					'param_name' 	=> 'title_italic',
					'value' 			=> array( esc_html__( 'Yes', 'kapee-extensions' ) => 1 ),
					'std' 				=> 0,
					'group'      	=> esc_html__( 'Title & Value', 'kapee-extensions' ),
					"edit_field_class"	=> "vc_col-sm-4",
				),
				array(
					'type' 			=> 'checkbox',
					'heading' 		=> esc_html__( 'Bold', 'kapee-extensions' ),
					'param_name' 	=> 'title_bold',
					'value' 			=> array( esc_html__( 'Yes', 'kapee-extensions' ) => 1 ),
					'std' 				=> 0,
					'group'      	=> esc_html__( 'Title & Value', 'kapee-extensions' ),
					"edit_field_class"	=> "vc_col-sm-4",
				),*/	
				array(
					"type"       	=> "kapee_number",
					"param_name" 	=> "title_font_size",
					"heading"    	=> esc_html__("Font Size In Desktop", 'kapee-extensions' ),
					'description' 	=> esc_html__( 'Enter font size(px).', 'kapee-extensions' ),
					'group' 		=> esc_html__( 'Title & Value', 'kapee-extensions' ),
					"edit_field_class"	=> "vc_col-sm-4",
				),
				array(
					"type"       	=> "kapee_number",
					"param_name" 	=> "title_font_size_tablet",
					"heading"    	=> esc_html__("Font Size In Tablet", 'kapee-extensions' ),
					'description' 	=> esc_html__( 'Enter font size(px).', 'kapee-extensions' ),
					'group' 		=> esc_html__( 'Title & Value', 'kapee-extensions' ),
					"edit_field_class"	=> "vc_col-sm-4",
				),
				array(
					"type"       	=> "kapee_number",
					"param_name" 	=> "title_font_size_mobile",
					"heading"    	=> esc_html__("Font Size In Mobile", 'kapee-extensions' ),
					'description' 	=> esc_html__( 'Enter font size(px).', 'kapee-extensions' ),
					'group' 		=> esc_html__( 'Title & Value', 'kapee-extensions' ),
					"edit_field_class"	=> "vc_col-sm-4",
				),
				array(
					"type"       	=> "kapee_number",
					"param_name" 	=> "title_line_height",
					"heading"    	=> esc_html__("Font Line Height", 'kapee-extensions' ),
					'description' 	=> esc_html__( 'Enter line height(px).', 'kapee-extensions' ),
					'group' 		=> esc_html__( 'Title & Value', 'kapee-extensions' ),
					"edit_field_class"	=> "vc_col-sm-4",
				),
				array(
					"type"       	=> "kapee_number",
					"param_name" 	=> "title_line_height_tablet",
					"heading"    	=> esc_html__("Line Height in Tablet", 'kapee-extensions' ),
					'description' 	=> esc_html__( 'Enter line height(px).', 'kapee-extensions' ),
					'group' 		=> esc_html__( 'Title & Value', 'kapee-extensions' ),
					"edit_field_class"	=> "vc_col-sm-4",
				),
				array(
					"type"       	=> "kapee_number",
					"param_name" 	=> "title_line_height_mobile",
					"heading"    	=> esc_html__("Line Height in Mobile", 'kapee-extensions' ),
					'description' 	=> esc_html__( 'Enter line height(px).', 'kapee-extensions' ),
					'group' 		=> esc_html__( 'Title & Value', 'kapee-extensions' ),
					"edit_field_class"	=> "vc_col-sm-4",
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
					'std' 			=> '400',
					'group' 		=> esc_html__( 'Title & Value', 'kapee-extensions' ),
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
					'std' 			=> 'inherit',
					'group' 		=> esc_html__( 'Title & Value', 'kapee-extensions' ),
					'edit_field_class'	=> 'vc_col-sm-6',
				),
				array(
					'type'            => 'colorpicker',
					'heading'         => esc_html__( 'Color', 'kapee-extensions' ),
					'param_name'      => 'title_font_color',
					'group' 		=> esc_html__( 'Title & Value', 'kapee-extensions' )
				),
				array(
					'type' 			=> 'kapee_title',
					'param_name' 	=> 'kapee_title',
					'class' 		=> '',
					'content' 		=> esc_html__( 'Counter Value', 'kapee-extensions' ),
					'group' 		=> esc_html__( 'Title & Value', 'kapee-extensions' )
				),
				array(
					"type"       	=> "textfield",
					"param_name" 	=> "counter_value",
					"heading"    	=> esc_html__("Counter Value", 'kapee-extensions' ),
					'description'     => esc_html__( 'Enter number for counter without any special character. You may enter a decimal number.', 'kapee-extensions' ),
					'group' 		=> esc_html__( 'Title & Value', 'kapee-extensions' )
				),
				array(
					"type"       	=> "textfield",
					"param_name" 	=> "counter_suffix",
					"heading"    	=> esc_html__("Counter Suffix", 'kapee-extensions' ),
					'group' 		=> esc_html__( 'Title & Value', 'kapee-extensions' )
				),
				array(
					"type"       	=> "textfield",
					"param_name" 	=> "counter_prefix",
					"heading"    	=> esc_html__("Counter Prefix", 'kapee-extensions' ),
					'group' 		=> esc_html__( 'Title & Value', 'kapee-extensions' )
				),
				/*array(
					'type' 			=> 'checkbox',
					'heading' 		=> esc_html__( 'Underline', 'kapee-extensions' ),
					'param_name' 	=> 'counter_value_underline',
					'value' 			=> array( esc_html__( 'Yes', 'kapee-extensions' ) => 1 ),
					'std' 				=> 0,
					'group'      	=> esc_html__( 'Title & Value', 'kapee-extensions' ),
					"edit_field_class"	=> "vc_col-sm-4",
				),
				array(
					'type' 			=> 'checkbox',
					'heading' 		=> esc_html__( 'Italic', 'kapee-extensions' ),
					'param_name' 	=> 'counter_value_italic',
					'value' 			=> array( esc_html__( 'Yes', 'kapee-extensions' ) => 1 ),
					'std' 				=> 0,
					'group'      	=> esc_html__( 'Title & Value', 'kapee-extensions' ),
					"edit_field_class"	=> "vc_col-sm-4",
				),
				array(
					'type' 			=> 'checkbox',
					'heading' 		=> esc_html__( 'Bold', 'kapee-extensions' ),
					'param_name' 	=> 'counter_value_bold',
					'value' 			=> array( esc_html__( 'Yes', 'kapee-extensions' ) => 1 ),
					'std' 				=> 0,
					'group'      	=> esc_html__( 'Title & Value', 'kapee-extensions' ),
					"edit_field_class"	=> "vc_col-sm-4",
				),*/	
				array(
					"type"       	=> "kapee_number",
					"param_name" 	=> "counter_value_font_size",
					"heading"    	=> esc_html__("Font Size In Desktop", 'kapee-extensions' ),
					'description' 	=> esc_html__( 'Enter font size(px).', 'kapee-extensions' ),
					'group' 		=> esc_html__( 'Title & Value', 'kapee-extensions' ),
					"edit_field_class"	=> "vc_col-sm-4",
				),
				array(
					"type"       	=> "kapee_number",
					"param_name" 	=> "counter_value_font_size_tablet",
					"heading"    	=> esc_html__("Font Size In Tablet", 'kapee-extensions' ),
					'description' 	=> esc_html__( 'Enter font size(px).', 'kapee-extensions' ),
					'group' 		=> esc_html__( 'Title & Value', 'kapee-extensions' ),
					"edit_field_class"	=> "vc_col-sm-4",
				),
				array(
					"type"       	=> "kapee_number",
					"param_name" 	=> "counter_value_font_size_mobile",
					"heading"    	=> esc_html__("Font Size In Mobile", 'kapee-extensions' ),
					'description' 	=> esc_html__( 'Enter font size(px).', 'kapee-extensions' ),
					'group' 		=> esc_html__( 'Title & Value', 'kapee-extensions' ),
					"edit_field_class"	=> "vc_col-sm-4",
				),
				array(
					"type"       	=> "kapee_number",
					"param_name" 	=> "counter_value_line_height",
					"heading"    	=> esc_html__("Font Line Height", 'kapee-extensions' ),
					'description' 	=> esc_html__( 'Enter line height(px).', 'kapee-extensions' ),
					'group' 		=> esc_html__( 'Title & Value', 'kapee-extensions' ),
					"edit_field_class"	=> "vc_col-sm-4",
				),
				array(
					"type"       	=> "kapee_number",
					"param_name" 	=> "counter_value_line_height_tablet",
					"heading"    	=> esc_html__("Line Height in Tablet", 'kapee-extensions' ),
					'description' 	=> esc_html__( 'Enter line height(px).', 'kapee-extensions' ),
					'group' 		=> esc_html__( 'Title & Value', 'kapee-extensions' ),
					"edit_field_class"	=> "vc_col-sm-4",
				),
				array(
					"type"       	=> "kapee_number",
					"param_name" 	=> "counter_value_line_height_mobile",
					"heading"    	=> esc_html__("Line Height in Mobile", 'kapee-extensions' ),
					'description' 	=> esc_html__( 'Enter line height(px).', 'kapee-extensions' ),
					'group' 		=> esc_html__( 'Title & Value', 'kapee-extensions' ),
					"edit_field_class"	=> "vc_col-sm-4",
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Font Weight', 'kapee-extensions' ),
					'param_name' 	=> 'counter_value_font_weight',
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
					'group' 		=> esc_html__( 'Title & Value', 'kapee-extensions' ),
					'edit_field_class'	=> 'vc_col-sm-6',
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Text Transform', 'kapee-extensions' ),
					'param_name' 	=> 'counter_value_text_transform',
					'value' 		=> array( 
						esc_html__( 'Inherit', 'kapee-extensions' ) 	=> 'inherit',
						esc_html__( 'Uppercase', 'kapee-extensions' ) 	=> 'uppercase',
						esc_html__( 'Capitalize', 'kapee-extensions' ) 	=> 'capitalize',
						esc_html__( 'Lowercase', 'kapee-extensions' ) 	=> 'lowercase',
					),
					'std' 			=> 'inherit',
					'group' 		=> esc_html__( 'Title & Value', 'kapee-extensions' ),
					'edit_field_class'	=> 'vc_col-sm-6',
				),
				array(
					'type'            => 'colorpicker',
					'heading'         => esc_html__( 'Color', 'kapee-extensions' ),
					'param_name'      => 'counter_value_font_color',
					'group' 		=> esc_html__( 'Title & Value', 'kapee-extensions' )
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
			'icon_display_type' 		=> 'font',
			'icon_type' 				=> 'fontawesome',     
            'icon_fontawesome' 			=> 'fa fa-adjust',  
            'icon_openiconic' 			=> 'vc-oi vc-oi-dial',     
            'icon_typicons' 			=> 'typcn typcn-adjust-brightness',     
            'icon_entypo' 				=> 'entypo-icon entypo-icon-note',    
            'icon_linecons' 			=> 'vc_li vc_li-heart ',
			'icon_kapee' 				=> 'pls pls-heart',
			'icon_image' 				=>	'',
			'icon_image_size' 			=>	48,
			'icon_size' 				=> 38,
			'icon_size_tablet' 			=> '',
			'icon_size_mobile' 			=> '',
			'icon_color' 				=> '#2370F4',
			'icon_style' 				=> 'icon-simple',
			'icon_bg_color' 			=> '',			
			'icon_border_style' 		=> '',			
			'icon_border_color' 		=> '#000000',			
			'icon_border_width' 		=> 1,			
			'icon_border_radius' 		=> 500,			
			'icon_bg_size' 				=> 50,			
			'icon_position' 			=> 'top',			
			'counter_title' 			=> '',			
			'counter_value' 			=> '',			
			'counter_suffix' 			=> '',			
			'counter_prefix' 			=> '',			
			/* 'title_underline' 			=> 0,			
			'title_italic' 				=> 0,			
			'title_bold' 				=> 0, */			
			'title_font_size' 			=> '',			
			'title_font_size_tablet' 	=> '',			
			'title_font_size_mobile' 	=> '',			
			'title_line_height' 		=> '',
			'title_line_height_tablet' 	=> '',
			'title_line_height_mobile' 	=> '',
			'title_font_weight'			=> '400',
			'title_text_transform'		=> 'inherit',
			'title_font_color' 			=> '',			
			/* 'counter_value_underline' 	=> 0,			
			'counter_value_italic' 		=> 0,			
			'counter_value_bold' 		=> 0, */			
			'counter_value_font_size' 	=> '',			
			'counter_value_font_size_tablet' 	=> '',			
			'counter_value_font_size_mobile' 	=> '',			
			'counter_value_line_height' => '',			
			'counter_value_line_height_tablet' => '',			
			'counter_value_line_height_mobile' => '',
			'counter_value_font_weight'	=> '400',
			'counter_value_text_transform'	=> 'inherit',			
			'counter_value_font_color' 	=> '',			
			'css_animation' 			=> 'none',
			'el_class' 					=> '',			
			'css' 						=> '',			
		), $atts );	
		extract( $args );
		
		$args['id'] 		= kapee_uniqid('kapee-counter-');		
		$class				= array();
		$class[]			= 'kapee-element';
		$class[]			= 'kapee-counter';
		$class[]			= $icon_style;
		$class[]			= 'icon-'.$icon_position;
		$class[]			= $el_class;
		$class[]			= kapee_get_css_animation($css_animation);
		$css_class 			= vc_shortcode_custom_css_class( $css, ' ' );
		$class[]			= $css_class;
		$args['class'] 		= implode(' ',array_filter($class));
		
		if( $icon_type !='' && $icon_display_type != 'image' ) {
		   vc_icon_element_fonts_enqueue( $icon_type );
			$iconClass = $args["icon_". $icon_type];
			
		}
				
		$icon_html 			= '';
		if($icon_display_type !== ''){
			if ( $icon_display_type == 'image' ) :
				$img = wp_get_attachment_image_src( $icon_image, 'full' );
				$icon_html = '<img src=" '. esc_url($img[0]) .' " alt="'.$counter_title.'"/>';
			else :                    
				$icon_html = '<i class="' .  esc_attr($iconClass).' " aria-hidden="true"></i>';
			endif; //$icon_type == 'image' 

		}
		$args['icon_html'] 	= $icon_html;
		
		/* Dynamic Css */		
		$count_css 				= array();
		$style_css 				= '';
		$count_css['icon'][] 			= !empty($icon_size) ? 'font-size:'.$icon_size.'px' : '' ;
		$count_css['tablet']['icon'][] = !empty($icon_size_tablet) ? 'font-size:'.$icon_size_tablet.'px' : '' ;
		$count_css['mobile']['icon'][] = !empty($icon_size_mobile) ? 'font-size:'.$icon_size_mobile.'px' : '' ;
		$count_css['icon'][] 			= !empty($icon_color) ? 'color:'.$icon_color : '' ;
		if($icon_style != 'icon-simple' && ! empty( $icon_bg_color ) ){
			$count_css['icon'][] = !empty($icon_bg_color) ? 'background-color:'.$icon_bg_color : '' ;
		}
		if($icon_style == 'icon-custom' && !empty($icon_border_style)){
			$count_css['icon'][] = 'border-style:'.$icon_border_style;
			$count_css['icon'][] = (!empty($icon_border_color)) ? 'border-color:'.$icon_border_color : '';			
			$count_css['icon'][] = (!empty($icon_border_width)) ? 'border-width:'.$icon_border_width.'px' : '';			
			$count_css['icon'][] = (!empty($icon_border_radius)) ? 'border-radius:'.$icon_border_radius.'px' : '';
		}
		if( $icon_style == 'icon-custom' && ! empty( $icon_bg_size ) ){
			$count_css['icon'][] 			= 'width:'.$icon_bg_size.'px';
			$count_css['icon'][] 			= 'height:'.$icon_bg_size.'px';
			$count_css['icon'][] 			= 'line-height:'.$icon_bg_size.'px';
		}
		$count_css['img'][] = '';
		if( $icon_display_type == 'image' && ! empty( $icon_image_size ) ){
			$count_css['img'][] 			= 'width:'.$icon_image_size.'px';
			$count_css['img'][] 			= 'height:'.$icon_image_size.'px';
		}
		
		$count_css['title'][] = !empty($title_font_size) ? 'font-size:'.$title_font_size.'px' : '' ;
		$count_css['tablet']['title'][] = !empty($title_font_size_tablet) ? 'font-size:'.$title_font_size_tablet.'px' : '' ;
		$count_css['mobile']['title'][] = !empty($title_font_size_mobile) ? 'font-size:'.$title_font_size_mobile.'px' : '' ;
		$count_css['title'][] = !empty($title_line_height) ? 'line-height:'.$title_line_height.'px' : '' ;
		$count_css['tablet']['title'][] = !empty($title_line_height_tablet) ? 'line-height:'.$title_line_height_tablet.'px' : '' ;
		$count_css['mobile']['title'][] = !empty($title_line_height_mobile) ? 'line-height:'.$title_line_height_mobile.'px' : '' ;
		$count_css['title'][] = ( $title_text_transform ) ? 'text-transform:'.$title_text_transform : '' ;
		$count_css['title'][] = ( $title_font_weight ) ? 'font-weight:'.$title_font_weight : '' ;
		$count_css['title'][] = !empty($title_font_color) ? 'color:'.$title_font_color : '' ;		
		/* $count_css['title'][] = ($title_underline) ? 'text-decoration: underline' : '';
		$count_css['title'][] = ($title_italic) ? 'font-style: italic' : '';
		$count_css['title'][] = ($title_bold) ? 'font-weight: bold' : ''; */
		
		$count_css['value'][] = !empty($counter_value_font_size) ? 'font-size:'.$counter_value_font_size.'px' : '' ;
		$count_css['tablet']['value'][] = !empty($counter_value_font_size_tablet) ? 'font-size:'.$counter_value_font_size_tablet.'px' : '' ;
		$count_css['mobile']['value'][] = !empty($counter_value_font_size_mobile) ? 'font-size:'.$counter_value_font_size_mobile.'px' : '' ;
		$count_css['value'][] = !empty($counter_value_line_height) ? 'line-height:'.$counter_value_line_height.'px' : '' ;
		$count_css['tablet']['value'][] = !empty($counter_value_line_height_tablet) ? 'line-height:'.$counter_value_line_height_tablet.'px' : '' ;
		$count_css['mobile']['value'][] = !empty($counter_value_line_height_mobile) ? 'line-height:'.$counter_value_line_height_mobile.'px' : '' ;
		$count_css['value'][] = ( $counter_value_text_transform ) ? 'text-transform:'.$counter_value_text_transform : '' ;
		$count_css['value'][] = ( $counter_value_font_weight ) ? 'font-weight:'.$counter_value_font_weight : '' ;
		$count_css['value'][] = !empty($counter_value_font_color) ? 'color:'.$counter_value_font_color : '' ;		
		/* $count_css['value'][] = ($counter_value_underline) ? 'text-decoration: underline' : '';
		$count_css['value'][] = ($counter_value_italic) ? 'font-style: italic' : '';
		$count_css['value'][] = ($counter_value_bold) ? 'font-weight: bold' : ''; */		
		
		if(!empty( array_filter( $count_css['icon'] ) ) ){
			$style_css .= '#'.$args['id'].' .counter-icon {';
			$style_css .=  implode('; ', array_filter($count_css['icon']) );
			$style_css .= '}';
		}
		if(!empty( array_filter( $count_css['img'] ) ) ){
			$style_css .= '#'.$args['id'].' .counter-icon-wrap img {';
			$style_css .=  implode('; ', array_filter($count_css['img']) );
			$style_css .= '}';
		}		
		if(!empty( array_filter( $count_css['value'] ) ) ){
			$style_css .= '#'.$args['id'].' .counter-number {';
			$style_css .=  implode('; ', array_filter($count_css['value']) );
			$style_css .= '}';
		}
		if(!empty( array_filter( $count_css['title'] ) ) ){
			$style_css .= '#'.$args['id'].' .counter-title {';
			$style_css .=  implode('; ', array_filter($count_css['title']) );
			$style_css .= '}';
		}
		if( ! empty( array_filter( $count_css['tablet'] ) ) ){
			$style_css .= '@media (max-width:991px){';
			if( !empty( array_filter($count_css['tablet']['icon']) ) ){
				$style_css .= '#'.$args['id'].' .counter-icon {';
				$style_css .=  implode('; ', array_filter( $count_css['tablet']['icon'] ) );
				$style_css .= '}';
			}
			if( !empty( array_filter( $count_css['tablet']['title'] ) ) ){
				$style_css .= '#'.$args['id'].' .counter-title {';
				$style_css .=  implode('; ', array_filter( $count_css['tablet']['title'] ) );
				$style_css .= '}';
			}
			if( !empty( array_filter( $count_css['tablet']['value']) ) ){
				$style_css .= '#'.$args['id'].' .counter-number {';
				$style_css .=  implode('; ', array_filter( $count_css['tablet']['value'] ) );
				$style_css .= '}';
			}
			$style_css .= '}';
		}
		if( ! empty( array_filter( $count_css['mobile'] ) ) ){
			$style_css .= '@media (max-width:640px){';
			if( !empty( array_filter($count_css['mobile']['icon']) ) ){
				$style_css .= '#'.$args['id'].' .counter-icon {';
				$style_css .=  implode('; ', array_filter( $count_css['mobile']['icon'] ) );
				$style_css .= '}';
			}
			if( !empty( array_filter( $count_css['mobile']['title']) ) ){
				$style_css .= '#'.$args['id'].' .counter-title {';
				$style_css .=  implode('; ', array_filter( $count_css['mobile']['title'] ) );
				$style_css .= '}';
			}
			if( !empty( array_filter( $count_css['mobile']['value']) ) ){
				$style_css .= '#'.$args['id'].' .counter-number {';
				$style_css .=  implode('; ', array_filter( $count_css['mobile']['value'] ) );
				$style_css .= '}';
			}
			$style_css .= '}';
		}
		kapee_add_custom_css( $style_css );
		wp_enqueue_script( 'waypoints' );
		wp_enqueue_script( 'counterup' );
		ob_start();
			kapee_get_pl_templates('shortcodes/counter',$args );	
		return ob_get_clean();
	}	
}
new vcCounter();