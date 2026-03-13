<?php
/*
Element: ProgressBar
*/
class vcProgressBar extends WPBakeryShortCode {

    function __construct() {
        $this->_mapping();
        add_shortcode( 'kapee_progress_bar', array( $this, '_html' ) );
	}
	public function _mapping() {
		if ( !defined( 'WPB_VC_VERSION' ) ) { return; }	
		vc_map( array(
			'name'			=> esc_html__( 'Progress Bar', 'kapee-extensions' ),
			'base'			=> 'kapee_progress_bar',
			'category' 		=> esc_html__( 'Kapee', 'kapee-extensions' ),
			'description' 	=> esc_html__( 'Progress Bar.', 'kapee-extensions' ),
        	'icon' 			=> KAPEE_URI.'/inc/admin/assets/images/vc-icon.png',
			'params' 		=> array(
				//General
				array(
					'type' 			=> 'textfield',
					'heading' 		=> esc_html__( 'Title', 'kapee-extensions' ),
					'param_name' 	=> 'title',
					'description' 	=> esc_html__( 'Enter title.', 'kapee-extensions' ),
					'std' 			=> esc_html__( 'Skill', 'kapee-extensions' ),
					'admin_label'	=> true,
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Style', 'kapee-extensions' ),
					'param_name' 	=> 'style',
					'value' 		=> array( 
						esc_html__( 'Style - 1', 'kapee-extensions' ) => 'style-1',
						esc_html__( 'Style - 2', 'kapee-extensions' ) => 'style-2',
						esc_html__( 'Style - 3', 'kapee-extensions' ) => 'style-3',
					),
					'description' 	=> esc_html__( 'Select style.', 'kapee-extensions' ),
					'admin_label'	=> true,
				),
				//List
				array(
					'type'       	=> 'param_group',
					'param_name' 	=> 'bar_items',
					'heading'      	=> esc_html__( 'Values', 'kapee-extensions' ),
					'params'     	=> array(
						array(
							'type'             => 'textfield',
							'heading'          => esc_html__( 'Label', 'kapee-extensions' ),
							'param_name'       => 'bar_label',
							'tooltip'          => esc_html__( 'Enter text used as title of bar.', 'kapee-extensions' ),
							'admin_label'      => true,
						),
						array(
							'type'             => 'textfield',
							'heading'          => esc_html__( 'Value', 'kapee-extensions' ),
							'param_name'       => 'bar_value',
							'tooltip'          => esc_html__( 'Enter value of bar.', 'kapee-extensions' ),
							'admin_label'      => true,
						),
						array(
							'type'             => 'colorpicker',
							'heading'          => esc_html__( 'Color', 'kapee-extensions' ),
							'param_name'       => 'bar_color',
							'tooltip'          => esc_html__( 'Select single bar background color.', 'kapee-extensions' ),
							'admin_label'      => true,
						),
					),
				),
				array(
					'type' 			=> 'textfield',
					'heading' 		=> esc_html__( 'Units', 'kapee-extensions' ),
					'param_name' 	=> 'units',
					'std' 			=> '%',
					'description' 	=> esc_html__( 'Enter measurement units (Example: %, px, points, etc. Note: graph value and units will be appended to graph title).', 'kapee-extensions' )
				),
				array(
					'type' 			=> 'checkbox',
					'heading' 		=> esc_html__( 'Add stripes', 'kapee-extensions' ),
					'value' 		=> array( esc_html__( 'Yes, please', 'kapee-extensions' ) => 1 ),
					'param_name' 	=> 'stripes',
				),
				array(
					'type' 			=> 'checkbox',
					'heading' 		=> esc_html__( ' Add animation', 'kapee-extensions' ),
					'value' 		=> array( esc_html__( 'Yes, please', 'kapee-extensions' ) => 1 ),
					'param_name' 	=> 'stripe_animation',
					"dependency" => array(
								 "element" => "stripes",
								 "value" => array('1'),
							),
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
	
	public function _html( $atts) {
		$args = shortcode_atts( array(
			'title' 			=> esc_html__( 'Skill', 'kapee-extensions' ),
			'style' 			=> 'style-1',
			'bar_items' 		=> '',
			'units' 			=> '%',
			'stripes' 			=> 0,
			'stripe_animation' 	=> 0,
			'css_animation' 	=> 'none',	
			'el_class' 			=> '',
			'css'				=> '',
		), $atts );		
		extract($args);
		$args['id'] 		= kapee_uniqid('kapee-progress-');
		$class				= array();
		$class[]			= 'kapee-element';
		$class[]			= 'kapee-progress-bar';
		$class[]			= 'bar-'.$style;
		$class[]			= $el_class;
		$class[]			= kapee_get_css_animation($css_animation);
		$css_class 			= vc_shortcode_custom_css_class( $css, ' ' );
		$class[]			= $css_class;
		$args['class'] 		= implode(' ',array_filter($class));
		
		//kapee_pre($args);
		if ( function_exists( 'vc_param_group_parse_atts' ) ) {
			$bar_items = vc_param_group_parse_atts( $bar_items );
		}
		// Return if no bar items found
		if( !is_array( $bar_items ) || empty( $bar_items ) || ( (count($bar_items) == 1) && empty( $bar_items[0] ) ) ) {
			return;
		}
		$args['bar_items'] 	= $bar_items;	
		
		$stripe_class = '';
		if($stripes){
			$stripe_class .= ' progress-bar-striped';
		}
		if($stripes && $stripe_animation){
			$stripe_class .= ' progress-bar-animated';
		}
		$args['stripe_class'] = $stripe_class;
		wp_enqueue_script( 'waypoints' );
		ob_start();
			kapee_get_pl_templates('shortcodes/progress-bar',$args );	
		return ob_get_clean();
	}	
}
new vcProgressBar();
?>