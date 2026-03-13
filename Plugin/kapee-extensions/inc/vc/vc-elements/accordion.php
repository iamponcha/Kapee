<?php
/*
Element: Accordion
*/
class vcAccordion extends WPBakeryShortCode {

    function __construct() {
		$this->_mapping();
        add_shortcode( 'kapee_accordion', array( $this, '_html' ) );
	}
	public function _mapping() {
		if ( !defined( 'WPB_VC_VERSION' ) ) { return; }	
		vc_map(
			array(
				'name'                    => esc_html__( 'Kapee: Accordion', 'kapee-extensions' ),
				'base'                    => 'kapee_accordion',
				'icon' 					  => KAPEE_URI.'/inc/admin/assets/images/vc-icon.png',
				'is_container'            => true,
				'show_settings_on_create' => false,
				'as_parent'               => array(
					'only' => 'vc_tta_section',
				),
				'category'                => esc_html__( 'Kapee', 'kapee-extensions' ),
				'description'             => esc_html__( 'Accordion content', 'kapee-extensions' ),
				'params'                  => array(
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
					/* TODO: We will add in future
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
					),*/
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
						'param_name'  		=> 'icon',
						'heading'     		=> esc_html__( 'Icon', 'kapee-extensions' ),
						'description' 		=> esc_html__( 'Select accordion navigation icon.', 'kapee-extensions' ),
						'value'       		=> array(
							'None' 			=> 'none',
							'Chevron' 		=> 'chevron',
							'Plus' 			=> 'plus',
							'Triangle' 		=> 'triangle',
						),
					),
					array(
						'type'        		=> 'dropdown',
						'param_name'  		=> 'icon_position',
						'heading'     		=> esc_html__( 'Position', 'kapee-extensions' ),
						'description' 		=> esc_html__( 'Select accordion navigation icon position.', 'kapee-extensions' ),
						'value'       		=> array(
							'Left' 			=> 'left',
							'Right' 		=> 'right',
						),
						'std'				=> 'right',
					),
					array(
						'type'       		=> 'kapee_number',
						'param_name' 		=> 'active_tab',
						'heading'    		=> esc_html__( 'Active', 'kapee-extensions' ),
						'description'		=> esc_html__( 'Enter active section number (Note: to have all sections closed on initial load enter non-existing number).', 'kapee-extensions' ),
						'std'				=> 1,
					),
					array(
						'type'            	=> 'checkbox',
						'param_name'       	=> 'toggle',
						'heading'          	=> esc_html__( 'Allow Toggle?', 'kapee-extensions' ),
						'value' 			=> array( esc_html__( 'Yes', 'kapee-extensions' ) => 1 ),
						'std' 				=> 0,
						'description'      	=> esc_html__( 'Allow toggle to accordion sections.', 'kapee-extensions' ),
					),
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
						'param_name'       => 'accordion_custom_id',
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
				'js_view'                 => 'VcBackendTtaAccordionView',
				'custom_markup'           => '
					<div class="vc_tta-container" data-vc-action="collapseAll">
						<div class="vc_general vc_tta vc_tta-accordion vc_tta-color-backend-accordion-white vc_tta-style-flat vc_tta-shape-rounded vc_tta-o-shape-group vc_tta-controls-align-left vc_tta-gap-2">
						   <div class="vc_tta-panels vc_clearfix {{container-class}}">
							  {{ content }}
							  <div class="vc_tta-panel vc_tta-section-append">
								 <div class="vc_tta-panel-heading">
									<h4 class="vc_tta-panel-title vc_tta-controls-icon-position-left">
									   <a href="javascript:;" aria-expanded="false" class="vc_tta-backend-add-control">
										   <span class="vc_tta-title-text">' . esc_html__( 'Add Section', 'kapee-extensions' ) . '</span>
											<i class="vc_tta-controls-icon vc_tta-controls-icon-plus"></i>
										</a>
									</h4>
								 </div>
							  </div>
						   </div>
						</div>
					</div>',
				'default_content'         => '
					[vc_tta_section title="' . sprintf( '%s %d', esc_html__( 'Section', 'kapee-extensions' ), 1 ) . '"][/vc_tta_section]
					[vc_tta_section title="' . sprintf( '%s %d', esc_html__( 'Section', 'kapee-extensions' ), 2 ) . '"][/vc_tta_section]
				',
			)
		);
	}
	
	public function _html( $atts, $content ) {
		$args = shortcode_atts( array(
			'style'					=> 'classic',
			'shape'					=> 'square',
			//'spacing'				=> 0,
			//'gap'					=> 0,
			'alignment'				=> 'left',
			'icon'					=> 'none',
			'icon_position'			=> 'right',
			'active_tab'			=> 1,
			'accordion_custom_id'	=> '',
			'collapsible_all'		=> 0,
			'toggle'				=> 0,
			'el_class'				=> '',
			'css'					=> '',
		), $atts );		
		extract($args);
				extract($args);
		
		$class				= array('kapee-element', 'kapee-accordion','panel-group');
		$class[]			= 'accordion-'.$style;
		$class[]			= ( $style == 'pills' || $style == 'outline' ) ? 'shape-'.$shape : '';
		$class[]			= 'align-'.$alignment;
		$class[]			= ( $icon != 'none') ? 'accordion-icon-'.$icon : '';
		$class[]			= ( $icon != 'none') ? 'icon-position-'.$icon_position : '';
		$class[]			= $el_class;		
		$css_class 			= vc_shortcode_custom_css_class( $css, ' ' );
		$class[]			= $css_class;
		$args['class'] 		= implode(' ',array_filter($class));
		$args['id'] 		= kapee_uniqid('kapee-accordion-');	;	
		$sections 			= $this->get_all_attributes( 'vc_tta_section', $content );
		$args['sections'] 	= $sections;
		$data_parent 		= 'data-parent="#'.$args['id'].'"';
		if($toggle){
			$data_parent = '';
		}
		$args['data_parent'] 	= $data_parent;
		//kapee_pre($args);
		ob_start();
			kapee_get_pl_templates('shortcodes/accordion',$args );	
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
new vcAccordion();
?>