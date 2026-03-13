<?php
/*
Element: Info Box
*/
class vcInfoBox extends WPBakeryShortCode {

    function __construct() {
        $this->_mapping();
        add_shortcode( 'kapee_info_box', array( $this, '_html' ) );
	}
	public function _mapping() {
		if ( !defined( 'WPB_VC_VERSION' ) ) { return; }
		
		vc_map( array(
			'name' 			=> esc_html__( 'Info Box', 'kapee-extensions' ),
			'base' 			=> 'kapee_info_box',
			'category' 		=> esc_html__( 'Kapee', 'kapee-extensions' ),
			'description' 	=> esc_html__( 'Adds icon box with cutom font icon.', 'kapee-extensions' ),
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
					'dependency' 	=> array('element' => 'icon_display_type', 'value' => array('font')),
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
					"heading"    	=> esc_html__("Icon Image Width(px)", 'kapee-extensions' ),
					"std"    		=> 48,
					'description'     => esc_html__( 'Provide image width.', 'kapee-extensions' ),
					'dependency' 	=> array('element' => 'icon_display_type', 'value' => array('image')),
				),
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
					'description'     => esc_html__( 'Select icon color.', 'kapee-extensions' ),
					'std'     		=> '#2370F4',
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
					'std'      		=> '#2370F4',
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
					"std"    		=> 50,
					'description'     => esc_html__( 'Spacing from center of the icon till the boundary of border / background.', 'kapee-extensions' ),
					'dependency' 	=> array('element' => 'icon_style', 'value' => array('icon-custom')),
				),
				array(
					'type'            => 'dropdown',
					'heading'         => esc_html__( 'Icon Hover Effect', 'kapee-extensions' ),
					'param_name'      => 'icon_hover_effet',
					'value' 		=> array(
						esc_html__( 'No Effect', 'kapee-extensions') 		=> 'icon-effect-none',
						esc_html__( 'Icon Zoom', 'kapee-extensions' ) 		=> 'icon-effect-zoom',
						esc_html__( 'Icon Bounce Up', 'kapee-extensions' ) 	=> 'icon-effect-bounceup',
					),
					'std'				=> 'icon-effect-none',
				),				
				array(
					'type'            => 'dropdown',
					'heading'         => esc_html__( 'Apply link to', 'kapee-extensions' ),
					'param_name'      => 'apply_to_link',
					'value' 		=> array(
						esc_html__( 'No Link', 'kapee-extensions') 		=> 'default',
						esc_html__( 'Complete Box', 'kapee-extensions' ) 		=> 'complete_box',
						esc_html__( 'Box Title', 'kapee-extensions' ) 		=> 'box_title',
						esc_html__( 'Display Read More', 'kapee-extensions' ) 		=> 'display_read_more',
					),
					'std'				=> 'default',
				),
				array(
					'type' 				=> 'vc_link',
					'heading' 			=> esc_html__( 'Add Link', 'kapee-extensions'),
					'param_name' 		=> 'link',
					"description"	=> esc_html__('Add a custom link or select existing page. You can remove existing link as well.','kapee-extensions'),
					'dependency' 	=> array('element' => 'apply_to_link', 'value' => array('complete_box','box_title','display_read_more')),
				),
				array(
					"type"       	=> "textfield",
					"param_name" 	=> "read_more_text",
					"heading"    	=> esc_html__("Read More Text", 'kapee-extensions' ),
					"std"    		=> esc_html__("Read More", 'kapee-extensions' ),
					"description"	=> esc_html__('Customize the read more text.','kapee-extensions'),
					'dependency' 	=> array('element' => 'apply_to_link', 'value' => array('display_read_more')),
				),
				array(
					'type'            => 'dropdown',
					'heading'         => esc_html__( 'Box Style', 'kapee-extensions' ),
					'param_name'      => 'box_style',
					'value' 		=> array(
						esc_html__( 'Icon Top', 'kapee-extensions' ) 		=> 'icon-top',
						esc_html__( 'Icon Left', 'kapee-extensions' ) 		=> 'icon-left',
						esc_html__( 'Icon Right', 'kapee-extensions' ) 		=> 'icon-right',						
						esc_html__( 'Boxed Square', 'kapee-extensions' ) 	=> 'box-square',
						esc_html__( 'Boxed Square With Hover Background', 'kapee-extensions' ) 	=> 'box-square-hover-bg',
					),
					'std'				=> 'icon-top',
				),
				array(
					'type'            => 'dropdown',
					'heading'         => esc_html__( 'Alignment', 'kapee-extensions' ),
					'param_name'      => 'align',
					'value' 		=> array(
						esc_html__( 'Center', 'kapee-extensions' ) 		=> 'center',
						esc_html__( 'Left', 'kapee-extensions') 		=> 'left',
						esc_html__( 'Right', 'kapee-extensions' ) 		=> 'right',						
					),
					'std'      => 'center',
					'dependency' 	=> array('element' => 'box_style', 'value' => array('icon-top')),
				),
				array(
					"type"       	=> "kapee_number",
					"param_name" 	=> "box_min_height",
					"heading"    	=> esc_html__("Box Min Height", 'kapee-extensions' ),
					'description'     => esc_html__( 'Select Min Height for Box.', 'kapee-extensions' ),
					'dependency' 	=> array('element' => 'box_style', 'value' => array('box-square')),
				),
				array(
					'type'            => 'dropdown',
					'heading'         => esc_html__( 'Box Border Style', 'kapee-extensions' ),
					'param_name'      => 'box_border_style',
					'value' 		=> array(
						esc_html__('None', 'kapee-extensions') 	=> 'none',
						esc_html__( 'Solid', 'kapee-extensions' ) 	=> 'solid',
						esc_html__( 'Dashed', 'kapee-extensions' ) 	=> 'dashed',						
						esc_html__( 'Dotted', 'kapee-extensions' ) 	=> 'dotted',
						esc_html__( 'Double', 'kapee-extensions' ) 	=> 'double',
						esc_html__( 'Inset', 'kapee-extensions' ) 	=> 'inset',
						esc_html__( 'Outset', 'kapee-extensions' ) 	=> 'outset',
					),
					'std'	=>	'default',
					'description'     => esc_html__( 'Select the border style for icon.', 'kapee-extensions' ),
					'dependency' 	=> array('element' => 'box_style', 'value' => array('box-square')),
				),
				array(
					'type'            => 'kapee_number',
					'heading'         => esc_html__( 'Border Width', 'kapee-extensions' ),
					'param_name'      => 'box_border_width',
					'dependency' 	=> array('element' => 'box_border_style', 'value' => array('solid','dashed','dotted','double','inset','outset')),
				),
				array(
					'type'            => 'colorpicker',
					'heading'         => esc_html__( 'Border Color', 'kapee-extensions' ),
					'param_name'      => 'box_border_color',
					'dependency' 	=> array('element' => 'box_border_style', 'value' => array('solid','dashed','dotted','double','inset','outset')),
				),
				array(
					'type'            => 'dropdown',
					'heading'         => esc_html__( 'Box Color', 'kapee-extensions' ),
					'param_name'      => 'box_color',
					'value' 		=> array(
						esc_html__('Inherit', 'kapee-extensions') 	=> 'inherit',
						esc_html__( 'Light', 'kapee-extensions' ) 	=> 'light',
						esc_html__( 'Dark', 'kapee-extensions' ) 	=> 'dark',
					),
					'std'	=>	'inherit',
				),
				array(
					'type'            => 'colorpicker',
					'heading'         => esc_html__( 'Box Background Color', 'kapee-extensions' ),
					'param_name'      => 'box_bg_color',
					'dependency' 	=> array('element' => 'box_style', 'value' => array('box-square', 'box-square-hover-bg')),
				),
				array(
					'type'            => 'dropdown',
					'heading'         => esc_html__( 'Box Hover Color', 'kapee-extensions' ),
					'param_name'      => 'box_hover_color',
					'value' 		=> array(
						esc_html__('Inherit', 'kapee-extensions') 	=> 'inherit',
						esc_html__( 'Light', 'kapee-extensions' ) 	=> 'light',
						esc_html__( 'Dark', 'kapee-extensions' ) 	=> 'dark',
					),
					'std'	=>	'inherit',
					'dependency' 	=> array('element' => 'box_style', 'value' => array('box-square-hover-bg')),
				),
				array(
					'type'            => 'colorpicker',
					'heading'         => esc_html__( 'Box Background Hover Color', 'kapee-extensions' ),
					'param_name'      => 'box_bg_hover_color',
					'dependency' 	=> array('element' => 'box_style', 'value' => array('box-square-hover-bg')),
				),
				
				array(
					'type' 			=> 'kapee_title',
					'param_name' 	=> 'kapee_title',
					'class' 		=> '',
					'content' 		=> esc_html__( 'Title', 'kapee-extensions' ),
					'group' 		=> esc_html__( 'Title & Description', 'kapee-extensions' )
				),
				array(
					"type"       	=> "textfield",
					"param_name" 	=> "box_title",
					"heading"    	=> esc_html__("Title", 'kapee-extensions' ),
					'admin_label'	=> true,
					'group'      	=> esc_html__( 'Title & Description', 'kapee-extensions' ),
				),
				array(
					'type'            => 'dropdown',
					'heading'         => esc_html__( 'Title Tag', 'kapee-extensions' ),
					'param_name'      => 'title_tag',
					'value' 		=> array(
						esc_html__( 'H1', 'kapee-extensions') 		=> 'h1',
						esc_html__( 'H2', 'kapee-extensions' ) 		=> 'h2',
						esc_html__( 'H3', 'kapee-extensions' ) 		=> 'h3',
						esc_html__( 'H4', 'kapee-extensions' ) 		=> 'h4',
						esc_html__( 'H5', 'kapee-extensions' ) 		=> 'h5',
						esc_html__( 'H6', 'kapee-extensions' ) 		=> 'h6',
						esc_html__( 'Div', 'kapee-extensions' ) 	=> 'div',
						esc_html__( 'P', 'kapee-extensions' ) 		=> 'p',
						esc_html__( 'Span', 'kapee-extensions' )	=> 'span',
					),
					'std'				=> 'h2',
					'description'     => esc_html__( 'Default H2.', 'kapee-extensions' ),
					'group'      	=> esc_html__( 'Title & Description', 'kapee-extensions' ),
				),
				/* array(
					'type' 			=> 'checkbox',
					'heading' 		=> esc_html__( 'Underline', 'kapee-extensions' ),
					'param_name' 	=> 'title_underline',
					'value' 			=> array( esc_html__( 'Yes', 'kapee-extensions' ) => 1 ),
					'std' 				=> 0,
					'group'      	=> esc_html__( 'Title & Description', 'kapee-extensions' ),
					"edit_field_class"	=> "vc_col-sm-4",
				),
				array(
					'type' 			=> 'checkbox',
					'heading' 		=> esc_html__( 'Italic', 'kapee-extensions' ),
					'param_name' 	=> 'title_italic',
					'value' 			=> array( esc_html__( 'Yes', 'kapee-extensions' ) => 1 ),
					'std' 				=> 0,
					'group'      	=> esc_html__( 'Title & Description', 'kapee-extensions' ),
					"edit_field_class"	=> "vc_col-sm-4",
				),
				array(
					'type' 			=> 'checkbox',
					'heading' 		=> esc_html__( 'Bold', 'kapee-extensions' ),
					'param_name' 	=> 'title_bold',
					'value' 			=> array( esc_html__( 'Yes', 'kapee-extensions' ) => 1 ),
					'std' 				=> 0,
					'group'      	=> esc_html__( 'Title & Description', 'kapee-extensions' ),
					"edit_field_class"	=> "vc_col-sm-4",
				),	 */
				array(
					"type"       	=> "kapee_number",
					"param_name" 	=> "title_font_size",
					"heading"    	=> esc_html__("Font Size In Desktop", 'kapee-extensions' ),
					'description' 	=> esc_html__( 'Enter font size(px).', 'kapee-extensions' ),
					'group' 		=> esc_html__( 'Title & Description', 'kapee-extensions' ),
					"edit_field_class"	=> "vc_col-sm-4",
				),
				array(
					"type"       	=> "kapee_number",
					"param_name" 	=> "title_font_size_tablet",
					"heading"    	=> esc_html__("Font Size In Tablet", 'kapee-extensions' ),
					'description' 	=> esc_html__( 'Enter font size(px).', 'kapee-extensions' ),
					'group' 		=> esc_html__( 'Title & Description', 'kapee-extensions' ),
					"edit_field_class"	=> "vc_col-sm-4",
				),
				array(
					"type"       	=> "kapee_number",
					"param_name" 	=> "title_font_size_mobile",
					"heading"    	=> esc_html__("Font Size In Mobile", 'kapee-extensions' ),
					'description' 	=> esc_html__( 'Enter font size(px).', 'kapee-extensions' ),
					'group' 		=> esc_html__( 'Title & Description', 'kapee-extensions' ),
					"edit_field_class"	=> "vc_col-sm-4",
				),
				array(
					"type"       	=> "kapee_number",
					"param_name" 	=> "title_line_height",
					"heading"    	=> esc_html__("Font Line Height", 'kapee-extensions' ),
					'description' 	=> esc_html__( 'Enter line height(px).', 'kapee-extensions' ),
					'group' 		=> esc_html__( 'Title & Description', 'kapee-extensions' ),
					"edit_field_class"	=> "vc_col-sm-4",
				),
				array(
					"type"       	=> "kapee_number",
					"param_name" 	=> "title_line_height_tablet",
					"heading"    	=> esc_html__("Line Height in Tablet", 'kapee-extensions' ),
					'description' 	=> esc_html__( 'Enter line height(px).', 'kapee-extensions' ),
					'group' 		=> esc_html__( 'Title & Description', 'kapee-extensions' ),
					"edit_field_class"	=> "vc_col-sm-4",
				),
				array(
					"type"       	=> "kapee_number",
					"param_name" 	=> "title_line_height_mobile",
					"heading"    	=> esc_html__("Line Height in Mobile", 'kapee-extensions' ),
					'description' 	=> esc_html__( 'Enter line height(px).', 'kapee-extensions' ),
					'group' 		=> esc_html__( 'Title & Description', 'kapee-extensions' ),
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
					'std' 			=> '600',
					'group' 		=> esc_html__( 'Title & Description', 'kapee-extensions' ),
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
					'std' 			=> 'capitalize',
					'group' 		=> esc_html__( 'Title & Description', 'kapee-extensions' ),
					'edit_field_class'	=> 'vc_col-sm-6',
				),
				array(
					'type'            => 'colorpicker',
					'heading'         => esc_html__( 'Color', 'kapee-extensions' ),
					'param_name'      => 'title_font_color',
					'group' 		=> esc_html__( 'Title & Description', 'kapee-extensions' )
				),
				array(
					'type' 			=> 'kapee_title',
					'param_name' 	=> 'kapee_title',
					'class' 		=> '',
					'content' 		=> esc_html__( 'Description', 'kapee-extensions' ),
					'group' 		=> esc_html__( 'Title & Description', 'kapee-extensions' )
				),
				
				array(
					"type"       	=> "textarea",
					"param_name" 	=> "description",
					"heading"    	=> esc_html__("Description", 'kapee-extensions' ),
					'group' 		=> esc_html__( 'Title & Description', 'kapee-extensions' )
				),
				/* array(
					'type' 			=> 'checkbox',
					'heading' 		=> esc_html__( 'Underline', 'kapee-extensions' ),
					'param_name' 	=> 'desc_underline',
					'value' 			=> array( esc_html__( 'Yes', 'kapee-extensions' ) => 1 ),
					'std' 				=> 0,
					'group'      	=> esc_html__( 'Title & Description', 'kapee-extensions' ),
					"edit_field_class"	=> "vc_col-sm-4",
				),
				array(
					'type' 			=> 'checkbox',
					'heading' 		=> esc_html__( 'Italic', 'kapee-extensions' ),
					'param_name' 	=> 'desc_italic',
					'value' 			=> array( esc_html__( 'Yes', 'kapee-extensions' ) => 1 ),
					'std' 				=> 0,
					'group'      	=> esc_html__( 'Title & Description', 'kapee-extensions' ),
					"edit_field_class"	=> "vc_col-sm-4",
				),
				array(
					'type' 			=> 'checkbox',
					'heading' 		=> esc_html__( 'Bold', 'kapee-extensions' ),
					'param_name' 	=> 'desc_bold',
					'value' 			=> array( esc_html__( 'Yes', 'kapee-extensions' ) => 1 ),
					'std' 				=> 0,
					'group'      	=> esc_html__( 'Title & Description', 'kapee-extensions' ),
					"edit_field_class"	=> "vc_col-sm-4",
				), */	
				array(
					"type"       	=> "kapee_number",
					"param_name" 	=> "desc_font_size",
					"heading"    	=> esc_html__("Font Size", 'kapee-extensions' ),
					'description' 	=> esc_html__( 'Enter font size(px).', 'kapee-extensions' ),
					'group' 		=> esc_html__( 'Title & Description', 'kapee-extensions' ),
					"edit_field_class"	=> "vc_col-sm-4",
				),
				array(
					"type"       	=> "kapee_number",
					"param_name" 	=> "desc_font_size_tablet",
					"heading"    	=> esc_html__("Font Size in Tablet", 'kapee-extensions' ),
					'description' 	=> esc_html__( 'Enter font size(px).', 'kapee-extensions' ),
					'group' 		=> esc_html__( 'Title & Description', 'kapee-extensions' ),
					"edit_field_class"	=> "vc_col-sm-4",
				),
				array(
					"type"       	=> "kapee_number",
					"param_name" 	=> "desc_font_size_mobile",
					"heading"    	=> esc_html__("Font Size in Mobile", 'kapee-extensions' ),
					'description' 	=> esc_html__( 'Enter font size(px).', 'kapee-extensions' ),
					'group' 		=> esc_html__( 'Title & Description', 'kapee-extensions' ),
					"edit_field_class"	=> "vc_col-sm-4",
				),
				array(
					"type"       	=> "kapee_number",
					"param_name" 	=> "desc_line_height",
					"heading"    	=> esc_html__("Line Height", 'kapee-extensions' ),
					'description' 	=> esc_html__( 'Enter line height(px).', 'kapee-extensions' ),
					'group' 		=> esc_html__( 'Title & Description', 'kapee-extensions' ),
					"edit_field_class"	=> "vc_col-sm-4",
				),
				array(
					"type"       	=> "kapee_number",
					"param_name" 	=> "desc_line_height_tablet",
					"heading"    	=> esc_html__("Line Height in Tablet", 'kapee-extensions' ),
					'description' 	=> esc_html__( 'Enter line height(px).', 'kapee-extensions' ),
					'group' 		=> esc_html__( 'Title & Description', 'kapee-extensions' ),
					"edit_field_class"	=> "vc_col-sm-4",
				),
				array(
					"type"       	=> "kapee_number",
					"param_name" 	=> "desc_line_height_mobile",
					"heading"    	=> esc_html__("Line Height in Mobile", 'kapee-extensions' ),
					'description' 	=> esc_html__( 'Enter line height(px).', 'kapee-extensions' ),
					'group' 		=> esc_html__( 'Title & Description', 'kapee-extensions' ),
					"edit_field_class"	=> "vc_col-sm-4",
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Font Weight', 'kapee-extensions' ),
					'param_name' 	=> 'desc_font_weight',
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
					'group' 		=> esc_html__( 'Title & Description', 'kapee-extensions' ),
					'edit_field_class'	=> 'vc_col-sm-6',
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Text Transform', 'kapee-extensions' ),
					'param_name' 	=> 'desc_text_transform',
					'value' 		=> array( 
						esc_html__( 'Inherit', 'kapee-extensions' ) 	=> 'inherit',
						esc_html__( 'Uppercase', 'kapee-extensions' ) 	=> 'uppercase',
						esc_html__( 'Capitalize', 'kapee-extensions' ) 	=> 'capitalize',
						esc_html__( 'Lowercase', 'kapee-extensions' ) 	=> 'lowercase',
					),
					'std' 			=> 'capitalize',
					'group' 		=> esc_html__( 'Title & Description', 'kapee-extensions' ),
					'edit_field_class'	=> 'vc_col-sm-6',
				),
				array(
					'type'            => 'colorpicker',
					'heading'         => esc_html__( 'Color', 'kapee-extensions' ),
					'param_name'      => 'desc_font_color',
					'group' 		=> esc_html__( 'Title & Description', 'kapee-extensions' )
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
            'icon_linecons' 			=> 'vc_li vc_li-heart',
            'icon_kapee' 				=> 'pls pls-heart',
			'icon_image' 				=> '',
			'icon_image_size' 			=> 48,
			'icon_size' 				=> 38,
			'icon_size_tablet'			=> '',
			'icon_size_mobile'			=> '',
			'icon_color' 				=> '',
			'icon_style' 				=> 'icon-simple',
			'icon_bg_color' 			=> '',			
			'icon_border_style' 		=> '',			
			'icon_border_color' 		=> '#2370F4',			
			'icon_border_width' 		=> 1,			
			'icon_border_radius' 		=> 500,			
			'icon_bg_size' 				=> 50,			
			'box_title' 				=> '',			
			'title_tag' 				=> 'h2',			
			'description' 				=> '',					
			'apply_to_link' 			=> 'default',			
			'link' 						=> '',			
			'read_more_text' 			=> esc_html__('Read More','kapee-extensions'),			
			'box_style' 				=> 'icon-top',
			'align' 					=> 'center',	
			'box_min_height' 			=> '',			
			'box_border_style' 			=> 'none',			
			'box_border_width' 			=> '',			
			'box_border_color' 			=> '',
			'box_color' 				=> 'inherit',
			'box_bg_color' 				=> '',
			'box_hover_color' 			=> 'inherit',			
			'box_bg_hover_color' 		=> '',
			/* 'title_underline' 			=> 0,			
			'title_italic' 				=> 0,			
			'title_bold' 				=> 0, */			
			'title_font_size' 			=> '',			
			'title_font_size_tablet'	=> '',			
			'title_font_size_mobile'	=> '',			
			'title_line_height'	=> '',			
			'title_line_height_tablet'	=> '',			
			'title_line_height_mobile'	=> '',						
			'title_font_weight'			=> '600',	
			'title_text_transform'		=> 'capitalize',		
			'title_font_color' 			=> '',			
			/* 'desc_underline' 			=> 0,			
			'desc_italic' 				=> 0,			
			'desc_bold' 				=> 0, */			
			'desc_font_size' 			=> '',			
			'desc_font_size_tablet' 			=> '',			
			'desc_font_size_mobile' 			=> '',			
			'desc_line_height' 			=> '',			
			'desc_line_height_tablet' 	=> '',			
			'desc_line_height_mobile' 	=> '',			
			'desc_font_weight'			=> '400',
			'desc_text_transform'		=> 'capitalize',
			'desc_font_color' 			=> '',
			'icon_hover_effet' 			=> 'icon-effect-none',		
			'css_animation' 			=> 'none',	
			'el_class' 					=> '',			
			'css' 						=> '',			
		), $atts );	
		extract( $args );
		$icon_html 				= '';
		$args['id'] 			= kapee_uniqid('kapee-info-box-');
		$class					= array('kapee-element', 'kapee-info-box');
		$class[]				= $icon_hover_effet;
		$class[]				= $icon_style;
		$class[]				= $box_style;
		$class[]				= 'color-scheme-'.$box_color;
		$class[]				= 'hover-color-scheme-'.$box_hover_color;
		$class[]				= ($box_style == 'icon-top') ? 'text-'.$align: '';
		$class[]				= $el_class;
		$class[]				= kapee_get_css_animation($css_animation);
		$css_class 				= vc_shortcode_custom_css_class( $css, ' ' );
		$class[]				= $css_class;
		
		$args['class'] 			= implode(' ',array_filter($class));
		
		if( $icon_type !='' && $icon_display_type!='image' ) {
		   vc_icon_element_fonts_enqueue( $icon_type );
			$iconClass = $args["icon_". $icon_type];			
		}
		$icon_html 			= '';
		if( $icon_display_type !== '' ){
			if ( $icon_display_type == 'image' ) :
				$img = wp_get_attachment_image_src( $icon_image, 'full' );
				if( !empty( $img[0] ) ):
					$icon_html = '<img src=" '. esc_url($img[0]) .' " alt="'.$box_title.'"/>';
				endif;
			else :                    
				$icon_html = '<i class="' .  esc_attr($iconClass).' " aria-hidden="true"></i>';
			endif; //$icon_type == 'image' 

		}	
		$args['icon_html'] = $icon_html;
		$link_attributes = kapee_get_link_attributes($link);
		$link_default = array( 'url'    => '', 'title'  => '', 'target' => '_self' );
		
		if ( function_exists( 'vc_build_link' ) ):
			$link = wp_parse_args( vc_build_link( $link ), $link_default );
		else:
			$link = $link_default;
		endif;
		
		$link_url 						= '';
		// Fix empty target attribute
		if ( trim( $link['url'] ) != '' ) :
			$link_url = $link['url'];
		endif;
		
		$link_target 					= empty($link['target']) ? '_self':$link['target'];
		$link_on_complete_box 			= '';
		$link_on_box_title 				= '';
		if($apply_to_link == 'complete_box'){
			$link_on_complete_box = ' onclick="window.open(\''.$link_url.'\',\''.$link_target.'\')"';
		}
		
		if($apply_to_link == 'box_title'){
			$link_on_box_title = ' onclick="window.open(\''.$link_url.'\',\''.$link_target.'\')"';
		}
		
		$args['link_url'] 				= empty($link_url) ?  'javascript:voide();' : $link_url;
		$args['link_target'] 			= $link_target;
		$args['link_on_complete_box'] 	= $link_on_complete_box;
		$args['link_on_box_title'] 		= $link_on_box_title;
		
		/* Dynamic Css */
		$info_box_css 		= array();
		$style_css			= '';
		$info_box_css['icon'][] 	= !empty($icon_size) ? 'font-size:'.$icon_size.'px' : '' ;
		$info_box_css['tablet']['icon'][] 	= !empty($icon_size_tablet) ? 'font-size:'.$icon_size_tablet.'px' : '' ;
		$info_box_css['mobile']['icon'][] 	= !empty($icon_size_mobile) ? 'font-size:'.$icon_size_mobile.'px' : '' ;
		$info_box_css['icon'][] 	= !empty($icon_color) ? 'color:'.$icon_color : '' ;
		if( $box_style != 'box-square-hover-bg' && $icon_style != 'icon-simple' && ! empty( $icon_bg_color ) ){
			$info_box_css['icon'][] 	= !empty($icon_bg_color) ? 'background-color:'.$icon_bg_color : '' ;
		}
		if($icon_style == 'icon-custom' && !empty($icon_border_style)){
			$info_box_css['icon'][] = 'border-style:'.$icon_border_style;
			$info_box_css['icon'][] = (!empty($icon_border_color)) ? 'border-color:'.$icon_border_color : '';
			$info_box_css['icon'][] = (!empty($icon_border_width)) ? 'border-width:'.$icon_border_width.'px' : '';			
			$info_box_css['icon'][] = (!empty($icon_border_radius)) ? 'border-radius:'.$icon_border_radius.'px' : ''; 			
		}		
		if( $icon_style == 'icon-custom' && ! empty( $icon_bg_size ) ){
			$info_box_css['icon'][] = 'width:'.$icon_bg_size.'px';
			$info_box_css['icon'][] = 'height:'.$icon_bg_size.'px';
			$info_box_css['icon'][] = 'line-height:'.$icon_bg_size.'px';
		}
		
		$info_box_css['img'][] = '';
		if( $icon_display_type == 'image' && ! empty( $icon_image_size ) ){
			$info_box_css['img'][] 	= 'max-width:'.$icon_image_size.'px';
		}
		
		$info_box_css['title'][] = !empty($title_font_size) ? 'font-size:'.$title_font_size.'px' : '' ;
		$info_box_css['tablet']['title'][] = !empty($title_font_size_tablet) ? 'font-size:'.$title_font_size_tablet.'px' : '' ;
		$info_box_css['mobile']['title'][] = !empty($title_font_size_mobile) ? 'font-size:'.$title_font_size_mobile.'px' : '' ;
		$info_box_css['title'][] = !empty($title_line_height) ? 'line-height:'.$title_line_height.'px' : '' ;
		$info_box_css['tablet']['title'][] = !empty($title_line_height_tablet) ? 'line-height:'.$title_line_height_tablet.'px' : '' ;
		$info_box_css['mobile']['title'][] = !empty($title_font_line_height_mobile) ? 'line-height:'.$title_font_line_height_mobile.'px' : '' ;
		$info_box_css['title'][] = ( $title_text_transform ) ? 'text-transform:'.$title_text_transform : '' ;
		$info_box_css['title'][] = ( $title_font_weight ) ? 'font-weight:'.$title_font_weight : '' ;
		$info_box_css['title'][] = !empty($title_font_color) ? 'color:'.$title_font_color : '' ;		
		//$info_box_css['title'][] = ( $title_underline ) ? 'text-decoration: underline' : '';
		//$info_box_css['title'][] = ( $title_italic ) ? 'font-style: italic' : '';
		//$info_box_css['title'][] = ( $title_bold ) ? 'font-weight: bold' : '';
		$info_box_css['title'][] = ( $apply_to_link == 'box_title' ) ? 'cursor: pointer' : '';
		
		$info_box_css['box_wrapper'][] = '';
		if( $box_style == 'box-square-hover-bg' && !empty( $box_bg_color ) ) {
			$info_box_css['box_wrapper'][] =  'background-color:'.$box_bg_color; 
		}
		
		$info_box_css['box_wrap'][] = '';
		if($apply_to_link == 'complete_box'){
			$info_box_css['box_wrap'][] = 'cursor: pointer';
		}

		$info_box_css['box_content'][] = '';
		if( $box_style == 'box-square' && !empty( $box_bg_color ) ) {
			$info_box_css['box_content'][]	=  'background-color:'.$box_bg_color;
		}
		if( $box_style == 'box-square' && $box_border_style != 'none' ) {
			$info_box_css['box_content'][] = 'border-style:'.$box_border_style;			
			$info_box_css['box_content'][] = !empty( $box_border_width ) ? 'border-width:'.$box_border_width.'px' : '';
			$info_box_css['box_content'][] = !empty( $box_border_color ) ? 'border-color:'.$box_border_color : '';
		}
	
		$info_box_css['desc'][] 			= !empty( $desc_font_size ) ? 'font-size:'.$desc_font_size.'px' : '' ;
		$info_box_css['tablet']['desc'][] 	= !empty( $desc_font_size_tablet ) ? 'font-size:'.$desc_font_size_tablet.'px' : '' ;
		$info_box_css['mobile']['desc'][] 	= !empty( $desc_font_size_mobile ) ? 'font-size:'.$desc_font_size_mobile.'px' : '' ;
		$info_box_css['desc'][] 			= !empty( $desc_line_height ) ? 'line-height:'.$desc_line_height.'px' : '' ;
		$info_box_css['tablet']['desc'][] 	= !empty( $desc_line_height_tablet ) ? 'line-height:'.$desc_line_height_tablet.'px' : '' ;
		$info_box_css['mobile']['desc'][] 	= !empty( $desc_line_height_mobile ) ? 'line-height:'.$desc_line_height_mobile.'px' : '' ;
		$info_box_css['desc'][] 			= ( $desc_text_transform ) ? 'text-transform:'.$desc_text_transform : '' ;
		$info_box_css['desc'][] 			= ( $desc_font_weight ) ? 'font-weight:'.$desc_font_weight : '' ;
		$info_box_css['desc'][] 			= !empty( $desc_font_color ) ? 'color:'.$desc_font_color : '' ;		
		//$info_box_css['desc'][] 			= ( $desc_underline ) ? 'text-decoration: underline' : '';
		//$info_box_css['desc'][] 			= ( $desc_italic ) ? 'font-style: italic' : '';
		//$info_box_css['desc'][] 			= ( $desc_bold ) ? 'font-weight: bold' : '';
		
		$info_box_css['box_bg_hover_color'][] = !empty ( $box_bg_hover_color ) ? 'background-color : '.$box_bg_hover_color.'!important;' : '' ;
		
		if( ! empty( array_filter( $info_box_css['box_wrapper'] ) ) ){
			$style_css .= '#'.$args['id'].' {';
			$style_css .=  implode('; ', array_filter($info_box_css['box_wrapper']) );
			$style_css .= '}';
		}
	if( ! empty( array_filter( $info_box_css['box_bg_hover_color'] ) ) ){
			$style_css .= '#'.$args['id'].'.kapee-info-box:hover{';
			$style_css .=  implode('; ', array_filter($info_box_css['box_bg_hover_color']) );
			$style_css .= '}';
		}
		if( ! empty( array_filter( $info_box_css['box_wrap'] ) ) ){
			$style_css .= '#'.$args['id'].'{';
			$style_css .=  implode('; ', array_filter($info_box_css['box_wrap']) );
			$style_css .= '}';
		}
		if( ! empty( array_filter( $info_box_css['icon'] ) ) ){
			$style_css .= '#'.$args['id'].' .info-box-icon {';
			$style_css .=  implode('; ', array_filter($info_box_css['icon']) );
			$style_css .= '}';
		}
		if( ! empty( array_filter( $info_box_css['box_content'] ) ) ){
			$style_css .= '#'.$args['id'].' .info-box-content {';
			$style_css .=  implode('; ', array_filter($info_box_css['box_content']) );
			$style_css .= '}';
		}
		if( ! empty( array_filter( $info_box_css['img'] ) ) ){
			$style_css .= '#'.$args['id'].' .box-icon-wrap img {';
			$style_css .=  implode('; ', array_filter($info_box_css['img']) );
			$style_css .= '}';
		}
		if( ! empty( array_filter( $info_box_css['title'] ) ) ){
			$style_css .= '#'.$args['id'].' .info-box-title > *{';
			$style_css .=  implode('; ', array_filter($info_box_css['title']) );
			$style_css .= '}';
		}
		if( ! empty( array_filter( $info_box_css['desc'] ) ) ){
			$style_css .= '#'.$args['id'].' .info-box-description {';
			$style_css .=  implode('; ', array_filter($info_box_css['desc']) );
			$style_css .= '}';
		}
		if( ! empty( array_filter( $info_box_css['tablet'] ) ) ){
			$style_css .= '@media (max-width:991px){';
			if( !empty( array_filter($info_box_css['tablet']['icon']) ) ){
				$style_css .= '#'.$args['id'].' .info-box-icon {';
				$style_css .=  implode('; ', array_filter( $info_box_css['tablet']['icon'] ) );
				$style_css .= '}';
			}
			if( !empty( array_filter($info_box_css['tablet']['title']) ) ){
				$style_css .= '#'.$args['id'].' .info-box-title > *{';
				$style_css .=  implode('; ', array_filter( $info_box_css['tablet']['title'] ) );
				$style_css .= '}';
			}
			if( !empty( array_filter($info_box_css['tablet']['desc']) ) ){
				$style_css .= '#'.$args['id'].' .info-box-description {';
				$style_css .=  implode('; ', array_filter( $info_box_css['tablet']['desc'] ) );
				$style_css .= '}';
			}
			$style_css .= '}';
		}
		if( ! empty( array_filter( $info_box_css['mobile'] ) ) ){
			$style_css .= '@media (max-width:640px){';
			if( !empty( array_filter($info_box_css['mobile']['icon']) ) ){
				$style_css .= '#'.$args['id'].' .info-box-icon {';
				$style_css .=  implode('; ', array_filter( $info_box_css['mobile']['icon'] ) );
				$style_css .= '}';
			}
			if( !empty( array_filter($info_box_css['mobile']['title']) ) ){
				$style_css .= '#'.$args['id'].' .info-box-title > *{';
				$style_css .=  implode('; ', array_filter( $info_box_css['mobile']['title'] ) );
				$style_css .= '}';
			}
			if( !empty( array_filter($info_box_css['mobile']['desc']) ) ){
				$style_css .= '#'.$args['id'].' .info-box-description {';
				$style_css .=  implode('; ', array_filter( $info_box_css['mobile']['desc'] ) );
				$style_css .= '}';
			}
			$style_css .= '}';
		}
		kapee_add_custom_css( $style_css );
		ob_start();
			kapee_get_pl_templates('shortcodes/info-box',$args );	
		return ob_get_clean();
	}	
}
new vcInfoBox();