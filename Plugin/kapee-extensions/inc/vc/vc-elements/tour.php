<?php
/**
 * Element: Tour
 */
class vcTour extends WPBakeryShortCode {

    function __construct() {
        $this->_mapping();
        add_shortcode( 'kapee_tour', array( $this, '_html' ) );
	}
	public function _mapping() {
		if ( !defined( 'WPB_VC_VERSION' ) ) { return; }	
		vc_map(
			array(
				'name'                    	=> esc_html__( 'Kapee: Tour', 'kapee-extensions' ),
				'base'                    	=> 'kapee_tour',
				'icon' 						=> KAPEE_URI.'/inc/admin/assets/images/vc-icon.png',
				'is_container'            	=> true,
				'show_settings_on_create' 	=> false,
				'as_parent'               	=> array(
					'only' => 'vc_tta_section',
				),
				'category'                	=> esc_html__( 'Kapee', 'kapee-extensions' ),
				'description'             	=> esc_html__( 'Tour content', 'kapee-extensions' ),
				'params'                  	=> array(
					array(
						'type'        		=> 'dropdown',
						'param_name'  		=> 'style',
						'heading'     		=> esc_html__( 'Style', 'kapee-extensions' ),
						'description' 		=> esc_html__( 'Select tabs style.', 'kapee-extensions' ),
						'value'       		=> array(
							'Classic' 		=> 'classic',
							'Line' 			=> 'line',
							'Pills' 		=> 'pills',
							'Outline' 		=> 'outline',
						),
						'std' 				=> 'classic',							
						'admin_label' 		=> true,							
					),
					array(
						'type'        		=> 'dropdown',
						'param_name'  		=> 'shape',
						'heading'     		=> esc_html__( 'Shape', 'kapee-extensions' ),
						'description' 		=> esc_html__( 'Select tabs shape.', 'kapee-extensions' ),
						'value'       		=> array(
							'Square' 		=> 'square',
							'Rounded' 		=> 'rounded',
							'Round' 		=> 'round',
						),
						'dependency' 		=> array(
							'element' 	=> 'style', 
							'value' 	=> array( 'pills', 'outline' ) 
						),
					),
					array(
						'type'       		=> 'kapee_number',
						'param_name' 		=> 'spacing',
						'heading'    		=> esc_html__( 'Spacing', 'kapee-extensions' ),
						'description' 		=> esc_html__( 'Select tabs spacing.', 'kapee-extensions' ),
					),
					array(
						'type'       		=> 'kapee_number',
						'param_name' 		=> 'gap',
						'heading'    		=> esc_html__( 'Gap', 'kapee-extensions' ),
						'description' 		=> esc_html__( 'Select tabs gap.', 'kapee-extensions' ),
					),
					array(
						'type'        		=> 'dropdown',
						'param_name'  		=> 'position',
						'heading'     		=> esc_html__( 'Position', 'kapee-extensions' ),
						'description' 		=> esc_html__( 'Select tour navigation position.', 'kapee-extensions' ),
						'value'       		=> array(
							'Left' 			=> 'left',							
							'Right' 		=> 'right',
						),
					),
					array(
						'type'        		=> 'dropdown',
						'param_name'  		=> 'alignment',
						'heading'     		=> esc_html__( 'Alignment', 'kapee-extensions' ),
						'description' 		=> esc_html__( 'Select tabs section title alignment.', 'kapee-extensions' ),
						'value'       		=> array(
							'Left' 			=> 'left',
							'Center' 		=> 'center',
							'Right' 		=> 'right',
						),
					),
					array(
						'type'        		=> 'dropdown',
						'param_name'  		=> 'nav_width',
						'heading'     		=> esc_html__( 'Navigation Width', 'kapee-extensions' ),
						'description' 		=> esc_html__( 'Select tour navigation width.', 'kapee-extensions' ),
						'value'       		=> array(
							'Auto' 			=> 'auto',
							'Large' 		=> 'large',
							'Medium' 		=> 'medium',
							'Small' 		=> 'small',
						),
					),					
					array(
						'type'       		=> 'kapee_number',
						'param_name' 		=> 'active_tab',
						'heading'    		=> esc_html__( 'Active', 'kapee-extensions' ),
						'description'		=> esc_html__( 'Enter active section number (Note: to have all sections closed on initial load enter non-existing number).', 'kapee-extensions' ),
						'std'				=> 1,
					),
					
					//@Todo we will be add in future....
					
					/*array(
						'type'          	=> 'colorpicker',
						'param_name'    	=> 'tab_color',
						'heading'       	=> esc_html__( 'Color', 'kapee-extensions' ),
					),
					array(
						'type'          	=> 'colorpicker',
						'param_name'    	=> 'tab_bg_color',
						'heading'       	=> esc_html__( 'Background Color', 'kapee-extensions' ),
					),
					array(
						'type'          	=> 'colorpicker',
						'param_name'   		=> 'tab_acvtive_color',
						'heading'       	=> esc_html__( 'Active Color', 'kapee-extensions' ),
					),
					array(
						'type'          	=> 'colorpicker',
						'param_name'    	=> 'tab_acvtive_bg_color',
						'heading'       	=> esc_html__( 'Active Background Color', 'kapee-extensions' ),
					),
					
					array(
						'type' 				=> 'checkbox',
						'param_name' 		=> 'fill_content',
						'heading' 			=> esc_html__( 'Fill content area?', 'kapee-extensions' ),
						'description'		=> esc_html__( 'Do you want to fill content area with color..', 'kapee-extensions' ),
						'value' 			=> array( esc_html__( 'Yes', 'kapee-extensions' ) => 1 ),
						'std' 				=> 0,
						'group'      		=> esc_html__( 'Tab Content', 'kapee-extensions' ),
					),
					array(
						'type'          	=> 'colorpicker',
						'param_name'   		=> 'content_bg_color',
						'heading'       	=> esc_html__( 'Background Color', 'kapee-extensions' ),
						'group'      		=> esc_html__( 'Tab Content', 'kapee-extensions' ),
					),
					array(
						'type'            	=> 'dropdown',
						'heading'         	=> esc_html__( 'Color', 'kapee-extensions' ),
						'param_name'      	=> 'content_color',
						'value' 			=> array(
							esc_html__('Inherit', 'kapee-extensions') 	=> 'inherit',
							esc_html__('Light', 'kapee-extensions' ) 	=> 'light',
							esc_html__('Dark', 'kapee-extensions' ) 	=> 'dark',
						),
						'std'				=>	'inherit',
						'group'      		=> esc_html__( 'Tab Content', 'kapee-extensions' ),
					),*/
					vc_map_add_css_animation(),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Extra class name', 'kapee-extensions' ),
						'param_name'  => 'el_class',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'kapee-extensions' ),
					),
					array(
						'type'       => 'css_editor',
						'heading'    => esc_html__( 'CSS box', 'kapee-extensions' ),
						'param_name' => 'css',
						'group'      => esc_html__( 'Design Options', 'kapee-extensions' ),
					),
					array(
						'param_name'       => 'tabs_custom_id',
						'heading'          => esc_html__( 'Hidden ID', 'kapee-extensions' ),
						'type'             => 'uniqid',
						'edit_field_class' => 'hidden',
					),
					array(
						'type'             => 'checkbox',
						'param_name'       => 'collapsible_all',
						'heading'          => esc_html__( 'Allow collapse all?', 'kapee-extensions' ),
						'description'      => esc_html__( 'Allow collapse all accordion sections.', 'kapee-extensions' ),
						'edit_field_class' => 'hidden',
					),
				),
				'js_view' => 'VcBackendTtaTourView',
				'custom_markup' => '
			<div class="vc_tta-container" data-vc-action="collapse">
				<div class="vc_general vc_tta vc_tta-tabs vc_tta-color-backend-tabs-white vc_tta-style-flat vc_tta-shape-rounded vc_tta-spacing-1 vc_tta-tabs-position-left vc_tta-controls-align-left">
					<div class="vc_tta-tabs-container">'
								   . '<ul class="vc_tta-tabs-list">'
								   . '<li class="vc_tta-tab" data-vc-tab data-vc-target-model-id="{{ model_id }}"><a href="javascript:;" data-vc-container=".vc_tta" data-vc-target="[data-model-id=\'{{ model_id }}\']" data-vc-target-model-id="{{ model_id }}" data-vc-tabs>{{ section_title }}</a></li>'
								   . '</ul>
					</div>
					<div class="vc_tta-panels {{container-class}}">
					  {{ content }}
					</div>
				</div>
			</div>',
				'default_content' => '
			[vc_tta_section title="' . sprintf( '%s %d', __( 'Section', 'kapee-extensions' ), 1 ) . '"][/vc_tta_section]
			[vc_tta_section title="' . sprintf( '%s %d', __( 'Section', 'kapee-extensions' ), 2 ) . '"][/vc_tta_section]
				',
				'admin_enqueue_js' => array(
					vc_asset_url( 'lib/vc_tabs/vc-tabs.min.js' ),
				),
			)
		);		
	}
	
	public function _html( $atts, $content ) {
		$args = shortcode_atts( array(
			'style'				=> 'classic',
			'shape'				=> 'square',
			'spacing'			=> 0,
			'gap'				=> 0,
			'position'			=> 'left',
			'alignment'			=> 'left',
			'nav_width'			=> 'auto',
			'active_tab'		=> 1,
			'tabs_custom_id'	=> '',
			'collapsible_all'	=> 0,
			'css_animation'		=> 'none',
			'el_class'			=> '',
			'css'				=> '',
		), $atts );		
		extract($args);
		
		$class				= array('kapee-element', 'kapee-tour');
		$class[]			= 'tour-'.$style;
		$class[]			= ( $style == 'pills' || $style == 'outline' ) ? 'shape-'.$shape : '';
		$class[]			= 'align-'.$alignment;
		$class[]			= 'position-'.$position;
		$class[]			= 'nav-width-'.$nav_width;
		$class[]			= $el_class;		
		$class[]			= kapee_get_css_animation($css_animation);
		$css_class 			= vc_shortcode_custom_css_class( $css, ' ' );
		$class[]			= $css_class;
		$args['class'] 		= implode(' ',array_filter($class));
		$args['id'] 		= kapee_uniqid('kapee-tour-');
		$sections 			= $this->get_all_attributes( 'vc_tta_section', $content );
		$args['sections'] 	= $sections;
		
		$nav_tabs_css		= array();
		if( ! empty( $spacing ) ) {
			$nav_tabs_css[]			= 'margin-top:-'.$spacing.'px';
			$nav_tabs_css[]			= 'margin-bottom:-'.$spacing.'px';
		}
		if( $style != 'classic' && $position == 'left' && ! empty( $gap ) ) {
			$nav_tabs_css[]			= 'margin-right:'.$gap.'px';
		}
		if( $style != 'classic' && $position == 'right' && ! empty( $gap ) ) {
			$nav_tabs_css[]			= 'margin-left:'.$gap.'px';
		}
		$args['nav_tabs_css']		= implode('; ', array_filter( $nav_tabs_css ) ) ;
		$args['nav_tabs_css'] 		= !empty( $args['nav_tabs_css'] ) ? 'style="'.$args['nav_tabs_css'].'"' : '';
		
		$nav_item_css		= array();
		if( ! empty( $spacing ) ) {
			$nav_item_css[]			= 'margin-top:'.$spacing.'px' ;
			$nav_item_css[]			= 'margin-bottom:'.$spacing.'px' ;
		}
		$args['nav_item_css']		= implode('; ', array_filter( $nav_item_css ) ) ;
		$args['nav_item_css'] 		= !empty( $args['nav_item_css'] ) ? 'style="'.$args['nav_item_css'].'"' : '';		
		
		ob_start();
			kapee_get_pl_templates('shortcodes/tour',$args );	
		return ob_get_clean();
	}
	
	public function get_all_attributes( $tag, $text ) {
		preg_match_all( '/' . get_shortcode_regex() . '/s', $text, $matches );
		$out               = array();
		$shortcode_content = array();
		if ( isset( $matches[5] ) ) {
			$shortcode_content = $matches[5];
		}
		
		if ( isset( $matches[2] ) ) {
			$i = 0;
			foreach ( (array) $matches[2] as $key => $value ) {
				if ( $tag === $value ) {
					$out[ $i ]            = shortcode_parse_atts( $matches[3][ $key ] );
					$out[ $i ]['content'] = $matches[5][ $key ];
				}
				$i ++;
			}
		}
		return $out;
	}
}
new vcTour();